<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', [PublicController::class, 'home'])->name('public.home');
Route::get('/artikel', [PublicController::class, 'articles'])->name('public.articles');
Route::get('/artikel/{slug}', [PublicController::class, 'articleDetail'])->name('public.article.detail');
Route::get('/tentang', [PublicController::class, 'about'])->name('public.about');

// --- Auth Routes ---
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// --- Admin Protected Routes ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Redirect /admin to corresponding dashboard
    Route::get('/', function () {
        $user = auth()->user();
        if ($user->role === 'super_admin') {
            return redirect()->route('admin.super.index');
        }
        return redirect()->route('admin.artikel.index');
    })->name('admin.index');

    // --- Admin Artikel Routes (Accessible by Admin & Super Admin) ---
    Route::middleware(['role:admin,super_admin'])->group(function () {
        // Articles Export
        Route::get('/artikel/export', [ArticleController::class, 'backupCSV'])->name('admin.artikel.export');
        
        // Articles CRUD Resource
        Route::resource('/artikel', ArticleController::class, [
            'names' => [
                'index'   => 'admin.artikel.index',
                'create'  => 'admin.artikel.create',
                'store'   => 'admin.artikel.store',
                'edit'    => 'admin.artikel.edit',
                'update'  => 'admin.artikel.update',
                'destroy' => 'admin.artikel.destroy',
            ]
        ])->except(['show']);
    });

    // --- Super Admin Routes (Accessible by Super Admin only) ---
    Route::middleware(['role:super_admin'])->prefix('super')->group(function () {
        // Dashboard Stats
        Route::get('/', [DashboardController::class, 'superIndex'])->name('admin.super.index');

        // Central customization settings
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.super.settings');
        Route::post('/settings', [SettingController::class, 'update'])->name('admin.super.settings.update');

        // Users administration
        Route::resource('/users', UserController::class, [
            'names' => [
                'index'   => 'admin.super.users.index',
                'store'   => 'admin.super.users.store',
                'update'  => 'admin.super.users.update',
                'destroy' => 'admin.super.users.destroy',
            ]
        ])->only(['index', 'store', 'update', 'destroy']);

        // Categories management
        Route::resource('/categories', CategoryController::class, [
            'names' => [
                'index'   => 'admin.super.categories.index',
                'store'   => 'admin.super.categories.store',
                'update'  => 'admin.super.categories.update',
                'destroy' => 'admin.super.categories.destroy',
            ]
        ])->only(['index', 'store', 'update', 'destroy']);

        // Audit Logs
        Route::get('/logs', [ActivityLogController::class, 'index'])->name('admin.super.logs.index');
    });
});
