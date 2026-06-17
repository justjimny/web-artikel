<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    /**
     * Show activity logs.
     */
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.super.logs', compact('logs'));
    }
}
