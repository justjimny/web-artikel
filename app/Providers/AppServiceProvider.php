<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            // Check database connection and table existence safely
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::pluck('value', 'key')->all();
                \Illuminate\Support\Facades\View::share('siteSettings', $settings);
            } else {
                \Illuminate\Support\Facades\View::share('siteSettings', []);
            }
        } catch (\Exception $e) {
            // Fallback to empty array if database is not reachable yet
            \Illuminate\Support\Facades\View::share('siteSettings', []);
        }
    }
}
