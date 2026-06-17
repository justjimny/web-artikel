<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'super_admin') {
            $articles = Article::with('category', 'user')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $articles = Article::with('category', 'user')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url|max:1000',
            'content' => 'required|string',
        ]);

        if (!$request->hasFile('image') && !$request->filled('image_url')) {
            return back()->withErrors(['image' => 'Harap pilih file gambar cover ATAU isi URL gambar cover.'])->withInput();
        }

        $slug = Str::slug($request->title);
        // Ensure slug uniqueness
        if (Article::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        $article = Article::create([
            'title' => $request->title,
            'slug' => $slug,
            'publisher_name' => $request->publisher_name,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'image_path' => $imagePath,
            'content' => $request->content,
        ]);

        ActivityLog::log('Tambah Artikel', "Membuat artikel baru: '{$article->title}'");

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();

        // Prevent unauthorized edit
        if ($user->role !== 'super_admin' && $article->user_id !== $user->id) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk mengedit artikel ini.');
        }

        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();

        // Prevent unauthorized update
        if ($user->role !== 'super_admin' && $article->user_id !== $user->id) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk memperbarui artikel ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url|max:1000',
            'content' => 'required|string',
        ]);

        $slug = $article->slug;
        if ($article->title !== $request->title) {
            $slug = Str::slug($request->title);
            if (Article::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $slug . '-' . time();
            }
        }

        $imagePath = $article->image_path;
        if ($request->hasFile('image')) {
            // Delete old local file if it exists and is not a remote URL
            if ($imagePath && !str_starts_with($imagePath, 'http') && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
        } elseif ($request->filled('image_url')) {
            // Delete old local file if replaced by URL
            if ($imagePath && !str_starts_with($imagePath, 'http') && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->input('image_url');
        }

        $article->update([
            'title' => $request->title,
            'slug' => $slug,
            'publisher_name' => $request->publisher_name,
            'category_id' => $request->category_id,
            'image_path' => $imagePath,
            'content' => $request->content,
        ]);

        ActivityLog::log('Edit Artikel', "Mengubah artikel: '{$article->title}'");

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();

        // Prevent unauthorized delete
        if ($user->role !== 'super_admin' && $article->user_id !== $user->id) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk menghapus artikel ini.');
        }

        // Delete image
        if ($article->image_path && Storage::disk('public')->exists($article->image_path)) {
            Storage::disk('public')->delete($article->image_path);
        }

        $title = $article->title;
        $article->delete();

        ActivityLog::log('Hapus Artikel', "Menghapus artikel: '{$title}'");

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus!');
    }

    /**
     * Backup articles to CSV.
     */
    public function backupCSV()
    {
        $user = auth()->user();
        
        if ($user->role === 'super_admin') {
            $articles = Article::with('category', 'user')->orderBy('created_at', 'desc')->get();
        } else {
            $articles = Article::with('category', 'user')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $filename = "backup-artikel-" . date('Y-m-d-His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Judul', 'Slug', 'Publisher', 'Kategori', 'Penulis (Akun)', 'Dibuat Pada'];

        $callback = function() use($articles, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel alignment
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns);

            foreach ($articles as $article) {
                fputcsv($file, [
                    $article->id,
                    $article->title,
                    $article->slug,
                    $article->publisher_name,
                    $article->category ? $article->category->name : '-',
                    $article->user->name,
                    $article->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        ActivityLog::log('Ekspor Artikel', "Mengekspor artikel ke format CSV.");

        return response()->stream($callback, 200, $headers);
    }
}
