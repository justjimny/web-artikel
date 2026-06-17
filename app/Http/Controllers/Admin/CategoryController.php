<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::withCount('articles')->orderBy('name', 'asc')->get();
        return view('admin.super.categories', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        ActivityLog::log('Tambah Kategori', "Membuat kategori baru: '{$category->name}'");

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => "required|string|max:255|unique:categories,name,{$id}",
        ]);

        $oldName = $category->name;
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        ActivityLog::log('Edit Kategori', "Mengubah kategori dari '{$oldName}' menjadi '{$category->name}'");

        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();

        ActivityLog::log('Hapus Kategori', "Menghapus kategori: '{$name}'");

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
