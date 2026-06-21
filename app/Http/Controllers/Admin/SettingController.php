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
            'site_logo_secondary_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'site_logo_secondary_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:1000',
            'logo_shape' => 'required|in:circle,rectangle',
            'logo_primary_width' => 'required|integer|min:10|max:500',
            'logo_primary_height' => 'required|integer|min:10|max:500',
            'logo_secondary_1_width' => 'required|integer|min:10|max:500',
            'logo_secondary_1_height' => 'required|integer|min:10|max:500',
            'logo_secondary_2_width' => 'required|integer|min:10|max:500',
            'logo_secondary_2_height' => 'required|integer|min:10|max:500',
            'logo_border_radius' => 'required|integer|min:0|max:100',
            'about_header_title' => 'nullable|string|max:255',
            'about_header_subtitle' => 'nullable|string|max:1000',
            'about_section_badge' => 'nullable|string|max:255',
            'about_section_main_heading' => 'nullable|string|max:255',
            'about_paragraph_1' => 'nullable|string|max:2000',
            'about_paragraph_2' => 'nullable|string|max:2000',
            'about_pillar_1_icon' => 'nullable|string|max:255',
            'about_pillar_1_title' => 'nullable|string|max:255',
            'about_pillar_1_description' => 'nullable|string|max:1000',
            'about_pillar_2_icon' => 'nullable|string|max:255',
            'about_pillar_2_title' => 'nullable|string|max:255',
            'about_pillar_2_description' => 'nullable|string|max:1000',
            'about_card_title' => 'nullable|string|max:255',
            'about_card_description' => 'nullable|string|max:2000',
            'about_card_icon' => 'nullable|string|max:255',
            'about_card_stat_1' => 'nullable|string|max:255',
            'about_card_stat_2' => 'nullable|string|max:255',
            'about_card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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
            'logo_primary_width',
            'logo_primary_height',
            'logo_secondary_1_width',
            'logo_secondary_1_height',
            'logo_secondary_2_width',
            'logo_secondary_2_height',
            'logo_border_radius',
            'about_header_title',
            'about_header_subtitle',
            'about_section_badge',
            'about_section_main_heading',
            'about_paragraph_1',
            'about_paragraph_2',
            'about_pillar_1_icon',
            'about_pillar_1_title',
            'about_pillar_1_description',
            'about_pillar_2_icon',
            'about_pillar_2_title',
            'about_pillar_2_description',
            'about_card_title',
            'about_card_description',
            'about_card_icon',
            'about_card_stat_1',
            'about_card_stat_2',
        ];

        // Save normal keys
        foreach ($keys as $key) {
            if ($request->exists($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        // Handle banner active checkbox toggle
        Setting::set('banner_active', $request->has('banner_active') ? '1' : '0');

        // Handle site logo upload
        $logoKeys = ['site_logo', 'site_logo_secondary_1', 'site_logo_secondary_2'];
        foreach ($logoKeys as $logoKey) {
            if ($request->hasFile($logoKey)) {
                $oldLogo = Setting::get($logoKey);
                if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                    Storage::disk('public')->delete($oldLogo);
                }
                $logoPath = $request->file($logoKey)->store('site', 'public');
                Setting::set($logoKey, $logoPath);
            }
        }

        ActivityLog::log('Ubah Pengaturan', 'Mengubah pengaturan konfigurasi tampilan & informasi website.');

        return back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}
