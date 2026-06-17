<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    /**
     * Show Super Admin dashboard.
     */
    public function superIndex()
    {
        $stats = [
            'articles_count' => Article::count(),
            'categories_count' => Category::count(),
            'admins_count' => User::where('role', 'admin')->count(),
            'logs_count' => ActivityLog::count(),
        ];

        // Fetch recent logs
        $recentLogs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Fetch recent articles
        $recentArticles = Article::with('category', 'user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.super.index', compact('stats', 'recentLogs', 'recentArticles'));
    }
}
