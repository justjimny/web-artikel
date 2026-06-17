<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Show settings panel.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.super.settings', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
            'bg_color' => 'required|string|max:20',
            'font_family' => 'required|string|in:Instrument Sans,Inter,Roboto,Playfair Display,Poppins',
            'layout_columns' => 'required|in:1,2,3,4',
            'footer_text' => 'required|string|max:1000',
            'footer_instagram' => 'nullable|url|max:255',
            'footer_tiktok' => 'nullable|url|max:255',
            'footer_youtube' => 'nullable|url|max:255',
            'banner_active' => 'nullable|in:0,1',
            'banner_text' => 'nullable|required_if:banner_active,1|string|max:1000',
            'seo_meta_title' => 'required|string|max:255',
            'seo_meta_description' => 'required|string|max:1000',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:1000',
            'logo_shape' => 'required|in:circle,rectangle',
            'logo_width' => 'required|integer|min:10|max:500',
            'logo_height' => 'required|integer|min:10|max:500',
            'logo_border_radius' => 'required|integer|min:0|max:100',
        ]);

        // List of keys to save
        $keys = [
            'site_title',
            'primary_color',
            'secondary_color',
            'bg_color',
            'font_family',
            'layout_columns',
            'footer_text',
            'footer_instagram',
            'footer_tiktok',
            'footer_youtube',
            'banner_text',
            'seo_meta_title',
            'seo_meta_description',
            'hero_title',
            'hero_subtitle',
            'logo_shape',
            'logo_width',
            'logo_height',
            'logo_border_radius',
        ];

        // Save normal keys
        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        // Handle banner active checkbox toggle
        Setting::set('banner_active', $request->has('banner_active') ? '1' : '0');

        // Handle site logo upload
        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('site_logo')->store('site', 'public');
            Setting::set('site_logo', $logoPath);
        }

        ActivityLog::log('Ubah Pengaturan', 'Mengubah pengaturan konfigurasi tampilan & informasi website.');

        return back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}
