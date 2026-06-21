<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Show the homepage.
     */
    public function home()
    {
        $recentArticles = Article::with('category', 'user')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('public.home', compact('recentArticles'));
    }

    /**
     * Show all articles with filtering and search.
     */
    public function articles(Request $request)
    {
        $query = Article::with('category', 'user')->orderBy('created_at', 'desc');

        // Search filter
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('publisher_name', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $categorySlug = $request->input('kategori');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $articles = $query->paginate(8)->withQueryString();
        $categories = Category::withCount('articles')->get();

        return view('public.articles', compact('articles', 'categories'));
    }

    /**
     * Show article detail page.
     */
    public function articleDetail($slug)
    {
        $article = Article::with('category', 'user')->where('slug', $slug)->firstOrFail();

        // Fetch related articles (same category, excluding current)
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('public.article-detail', compact('article', 'relatedArticles'));
    }

    /**
     * Show about page.
     */
    public function about()
    {
        return view('public.about');
    }
}
