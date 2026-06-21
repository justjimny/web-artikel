@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page_title', 'Pengaturan Website')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm">
        <div class="flex flex-wrap gap-2 mb-6 border-b border-slate-200 pb-4">
            <button type="button" data-tab="general" class="tab-button px-4 py-2 rounded-2xl border text-sm font-semibold transition-all bg-primary text-white border-primary">Umum</button>
            <button type="button" data-tab="home" class="tab-button px-4 py-2 rounded-2xl border text-sm font-semibold transition-all border-slate-200 text-slate-600 hover:bg-slate-100">Beranda</button>
            <button type="button" data-tab="about" class="tab-button px-4 py-2 rounded-2xl border text-sm font-semibold transition-all border-slate-200 text-slate-600 hover:bg-slate-100">Tentang</button>
            <button type="button" data-tab="footer" class="tab-button px-4 py-2 rounded-2xl border text-sm font-semibold transition-all border-slate-200 text-slate-600 hover:bg-slate-100">Footer</button>
            <button type="button" data-tab="seo" class="tab-button px-4 py-2 rounded-2xl border text-sm font-semibold transition-all border-slate-200 text-slate-600 hover:bg-slate-100">SEO</button>
        </div>

        <form action="{{ route('admin.super.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div id="tab-general" class="tab-pane space-y-8">
                <div class="space-y-4">
                    <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-primary"></i> Identitas & Logo
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="site_title" class="text-xs font-bold text-slate-700">Nama/Judul Website</label>
                            <input type="text" id="site_title" name="site_title" value="{{ old('site_title', $settings['site_title'] ?? '') }}" required placeholder="Contoh: Portal Artikel Keren" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                            @error('site_title')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5 md:col-span-3">
                            <label class="text-xs font-bold text-slate-700 block">Logo Website (Realtime Preview)</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="bg-slate-50 border border-slate-200 flex flex-col items-center justify-center p-4 rounded-3xl">
                                    <span class="text-sm font-semibold text-slate-700 mb-3">Logo 1</span>
                                    <div id="logo-preview-container" class="bg-white flex items-center justify-center p-2 overflow-hidden rounded-3xl">
                                        @if(!empty($settings['site_logo']))
                                            <img id="logo-preview" src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo 1" class="object-cover" style="width: {{ $settings['logo_primary_width'] ?? $settings['logo_width'] ?? '120' }}px; height: {{ $settings['logo_primary_height'] ?? $settings['logo_height'] ?? '40' }}px; border-radius: {{ ($settings['logo_shape'] ?? 'rectangle') === 'circle' ? '9999px' : ($settings['logo_border_radius'] ?? '8') . 'px' }};">
                                        @else
                                            <div id="logo-text-placeholder" class="h-8 w-8 rounded bg-primary/10 text-primary flex items-center justify-center text-xs font-bold font-mono">
                                                {{ substr($settings['site_title'] ?? 'WA', 0, 2) }}
                                            </div>
                                            <img id="logo-preview" src="#" alt="Logo 1" class="hidden object-cover" style="width: {{ $settings['logo_primary_width'] ?? $settings['logo_width'] ?? '120' }}px; height: {{ $settings['logo_primary_height'] ?? $settings['logo_height'] ?? '40' }}px; border-radius: {{ ($settings['logo_shape'] ?? 'rectangle') === 'circle' ? '9999px' : ($settings['logo_border_radius'] ?? '8') . 'px' }};">
                                        @endif
                                    </div>
                                    <input type="file" id="site_logo" name="site_logo" accept="image/*" class="hidden">
                                    <label for="site_logo" class="inline-flex px-3 py-2 rounded-xl border border-slate-200 text-slate-600 hover:text-primary hover:bg-slate-50 text-xs font-bold cursor-pointer transition-all mt-3">
                                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Unggah Logo 1
                                    </label>
                                    @error('site_logo')
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="bg-slate-50 border border-slate-200 flex flex-col items-center justify-center p-4 rounded-3xl">
                                    <span class="text-sm font-semibold text-slate-700 mb-3">Logo 2</span>
                                    <div class="bg-white flex items-center justify-center p-2 overflow-hidden rounded-3xl" style="min-height: 84px;">
                                        @if(!empty($settings['site_logo_secondary_1']))
                                            <img id="logo-secondary-1-preview" src="{{ asset('storage/' . $settings['site_logo_secondary_1']) }}" alt="Logo 2" class="object-contain" style="width: {{ $settings['logo_secondary_1_width'] ?? $settings['logo_width'] ?? '120' }}px; height: {{ $settings['logo_secondary_1_height'] ?? $settings['logo_height'] ?? '40' }}px; border-radius: {{ ($settings['logo_shape'] ?? 'rectangle') === 'circle' ? '9999px' : ($settings['logo_border_radius'] ?? '8') . 'px' }};">
                                            <div id="logo-secondary-1-placeholder" class="hidden h-10 w-10 rounded bg-slate-100 flex items-center justify-center text-slate-400 text-xs">Preview</div>
                                        @else
                                            <img id="logo-secondary-1-preview" src="#" alt="Logo 2" class="hidden object-contain" style="width: {{ $settings['logo_secondary_1_width'] ?? $settings['logo_width'] ?? '120' }}px; height: {{ $settings['logo_secondary_1_height'] ?? $settings['logo_height'] ?? '40' }}px; border-radius: {{ ($settings['logo_shape'] ?? 'rectangle') === 'circle' ? '9999px' : ($settings['logo_border_radius'] ?? '8') . 'px' }};">
                                            <div id="logo-secondary-1-placeholder" class="h-10 w-10 rounded bg-slate-100 flex items-center justify-center text-slate-400 text-xs">Preview</div>
                                        @endif
                                    </div>
                                    <input type="file" id="site_logo_secondary_1" name="site_logo_secondary_1" accept="image/*" class="hidden">
                                    <label for="site_logo_secondary_1" class="inline-flex px-3 py-2 rounded-xl border border-slate-200 text-slate-600 hover:text-primary hover:bg-slate-50 text-xs font-bold cursor-pointer transition-all mt-3">
                                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Unggah Logo 2
                                    </label>
                                    @error('site_logo_secondary_1')
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="bg-slate-50 border border-slate-200 flex flex-col items-center justify-center p-4 rounded-3xl">
                                    <span class="text-sm font-semibold text-slate-700 mb-3">Logo 3</span>
                                    <div class="bg-white flex items-center justify-center p-2 overflow-hidden rounded-3xl" style="min-height: 84px;">
                                        @if(!empty($settings['site_logo_secondary_2']))
                                            <img id="logo-secondary-2-preview" src="{{ asset('storage/' . $settings['site_logo_secondary_2']) }}" alt="Logo 3" class="object-contain" style="width: {{ $settings['logo_secondary_2_width'] ?? $settings['logo_width'] ?? '120' }}px; height: {{ $settings['logo_secondary_2_height'] ?? $settings['logo_height'] ?? '40' }}px; border-radius: {{ ($settings['logo_shape'] ?? 'rectangle') === 'circle' ? '9999px' : ($settings['logo_border_radius'] ?? '8') . 'px' }};">
                                            <div id="logo-secondary-2-placeholder" class="hidden h-10 w-10 rounded bg-slate-100 flex items-center justify-center text-slate-400 text-xs">Preview</div>
                                        @else
                                            <img id="logo-secondary-2-preview" src="#" alt="Logo 3" class="hidden object-contain" style="width: {{ $settings['logo_secondary_2_width'] ?? $settings['logo_width'] ?? '120' }}px; height: {{ $settings['logo_secondary_2_height'] ?? $settings['logo_height'] ?? '40' }}px; border-radius: {{ ($settings['logo_shape'] ?? 'rectangle') === 'circle' ? '9999px' : ($settings['logo_border_radius'] ?? '8') . 'px' }};">
                                            <div id="logo-secondary-2-placeholder" class="h-10 w-10 rounded bg-slate-100 flex items-center justify-center text-slate-400 text-xs">Preview</div>
                                        @endif
                                    </div>
                                    <input type="file" id="site_logo_secondary_2" name="site_logo_secondary_2" accept="image/*" class="hidden">
                                    <label for="site_logo_secondary_2" class="inline-flex px-3 py-2 rounded-xl border border-slate-200 text-slate-600 hover:text-primary hover:bg-slate-50 text-xs font-bold cursor-pointer transition-all mt-3">
                                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Unggah Logo 3
                                    </label>
                                    @error('site_logo_secondary_2')
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-5 space-y-4">
                                    <h4 class="text-sm font-semibold text-slate-800">Logo 1</h4>
                                    <div class="space-y-1.5">
                                        <label for="logo_primary_width" class="text-xs font-bold text-slate-700">Lebar (px)</label>
                                        <input type="number" id="logo_primary_width" name="logo_primary_width" value="{{ old('logo_primary_width', $settings['logo_primary_width'] ?? $settings['logo_width'] ?? '120') }}" required min="10" max="500" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                        @error('logo_primary_width')
                                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label for="logo_primary_height" class="text-xs font-bold text-slate-700">Tinggi (px)</label>
                                        <input type="number" id="logo_primary_height" name="logo_primary_height" value="{{ old('logo_primary_height', $settings['logo_primary_height'] ?? $settings['logo_height'] ?? '40') }}" required min="10" max="500" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                        @error('logo_primary_height')
                                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-5 space-y-4">
                                    <h4 class="text-sm font-semibold text-slate-800">Logo 2</h4>
                                    <div class="space-y-1.5">
                                        <label for="logo_secondary_1_width" class="text-xs font-bold text-slate-700">Lebar (px)</label>
                                        <input type="number" id="logo_secondary_1_width" name="logo_secondary_1_width" value="{{ old('logo_secondary_1_width', $settings['logo_secondary_1_width'] ?? $settings['logo_width'] ?? '120') }}" required min="10" max="500" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                        @error('logo_secondary_1_width')
                                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label for="logo_secondary_1_height" class="text-xs font-bold text-slate-700">Tinggi (px)</label>
                                        <input type="number" id="logo_secondary_1_height" name="logo_secondary_1_height" value="{{ old('logo_secondary_1_height', $settings['logo_secondary_1_height'] ?? $settings['logo_height'] ?? '40') }}" required min="10" max="500" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                        @error('logo_secondary_1_height')
                                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-5 space-y-4">
                                    <h4 class="text-sm font-semibold text-slate-800">Logo 3</h4>
                                    <div class="space-y-1.5">
                                        <label for="logo_secondary_2_width" class="text-xs font-bold text-slate-700">Lebar (px)</label>
                                        <input type="number" id="logo_secondary_2_width" name="logo_secondary_2_width" value="{{ old('logo_secondary_2_width', $settings['logo_secondary_2_width'] ?? $settings['logo_width'] ?? '120') }}" required min="10" max="500" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                        @error('logo_secondary_2_width')
                                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label for="logo_secondary_2_height" class="text-xs font-bold text-slate-700">Tinggi (px)</label>
                                        <input type="number" id="logo_secondary_2_height" name="logo_secondary_2_height" value="{{ old('logo_secondary_2_height', $settings['logo_secondary_2_height'] ?? $settings['logo_height'] ?? '40') }}" required min="10" max="500" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                        @error('logo_secondary_2_height')
                                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-4">
                                <div class="space-y-1.5">
                                    <label for="logo-shape" class="text-xs font-bold text-slate-700">Bentuk Logo</label>
                                    <select id="logo-shape" name="logo_shape" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm bg-white cursor-pointer transition-all">
                                        <option value="rectangle" {{ (old('logo_shape', $settings['logo_shape'] ?? '') === 'rectangle') ? 'selected' : '' }}>Persegi / Rektangular</option>
                                        <option value="circle" {{ (old('logo_shape', $settings['logo_shape'] ?? '') === 'circle') ? 'selected' : '' }}>Lingkaran</option>
                                    </select>
                                    @error('logo_shape')
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5" id="logo-radius-container">
                                <label for="logo-border-radius" class="text-xs font-bold text-slate-700">Border Radius (px)</label>
                                <input type="number" id="logo-border-radius" name="logo_border_radius" value="{{ old('logo_border_radius', $settings['logo_border_radius'] ?? '8') }}" required min="0" max="100" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                @error('logo_border_radius')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="md:col-span-3 text-2xs text-slate-400 font-semibold leading-relaxed">
                            <i class="fa-solid fa-circle-info text-primary/70"></i> *Tips: Untuk bentuk <strong>Lingkaran (Circle)</strong>, gunakan lebar & tinggi yang sama agar bulat presisi. Input border radius akan dinonaktifkan otomatis.
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-palette text-primary"></i> Skema Warna & Tata Letak
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div class="space-y-1.5">
                            <label for="primary_color" class="text-xs font-bold text-slate-700 block">Warna Utama (Primary)</label>
                            <div class="flex items-center gap-2">
                                <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', $settings['primary_color'] ?? '#2563eb') }}" class="w-10 h-10 border border-slate-200 rounded-xl cursor-pointer p-0.5 bg-transparent">
                                <input type="text" id="primary_color_text" value="{{ $settings['primary_color'] ?? '#2563eb' }}" readonly class="w-24 px-2.5 py-2.5 bg-slate-50 text-slate-500 text-xs font-mono font-bold rounded-xl border border-slate-100 outline-none">
                            </div>
                            @error('primary_color')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="secondary_color" class="text-xs font-bold text-slate-700 block">Warna Sekunder</label>
                            <div class="flex items-center gap-2">
                                <input type="color" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', $settings['secondary_color'] ?? '#10b981') }}" class="w-10 h-10 border border-slate-200 rounded-xl cursor-pointer p-0.5 bg-transparent">
                                <input type="text" id="secondary_color_text" value="{{ $settings['secondary_color'] ?? '#10b981' }}" readonly class="w-24 px-2.5 py-2.5 bg-slate-50 text-slate-500 text-xs font-mono font-bold rounded-xl border border-slate-100 outline-none">
                            </div>
                            @error('secondary_color')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="bg_color" class="text-xs font-bold text-slate-700 block">Warna Background Web</label>
                            <div class="flex items-center gap-2">
                                <input type="color" id="bg_color" name="bg_color" value="{{ old('bg_color', $settings['bg_color'] ?? '#f8fafc') }}" class="w-10 h-10 border border-slate-200 rounded-xl cursor-pointer p-0.5 bg-transparent">
                                <input type="text" id="bg_color_text" value="{{ $settings['bg_color'] ?? '#f8fafc' }}" readonly class="w-24 px-2.5 py-2.5 bg-slate-50 text-slate-500 text-xs font-mono font-bold rounded-xl border border-slate-100 outline-none">
                            </div>
                            @error('bg_color')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="font_family" class="text-xs font-bold text-slate-700">Jenis Font (Typography)</label>
                            <select id="font_family" name="font_family" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm bg-white cursor-pointer transition-all">
                                <option value="Instrument Sans" {{ (old('font_family', $settings['font_family'] ?? '') === 'Instrument Sans') ? 'selected' : '' }}>Instrument Sans (Sans-serif Modern)</option>
                                <option value="Inter" {{ (old('font_family', $settings['font_family'] ?? '') === 'Inter') ? 'selected' : '' }}>Inter (Profesional & Bersih)</option>
                                <option value="Roboto" {{ (old('font_family', $settings['font_family'] ?? '') === 'Roboto') ? 'selected' : '' }}>Roboto (Klasik & Jelas)</option>
                                <option value="Poppins" {{ (old('font_family', $settings['font_family'] ?? '') === 'Poppins') ? 'selected' : '' }}>Poppins (Kreatif & Bulat)</option>
                                <option value="Playfair Display" {{ (old('font_family', $settings['font_family'] ?? '') === 'Playfair Display') ? 'selected' : '' }}>Playfair Display (Serif Elegis)</option>
                            </select>
                            @error('font_family')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="layout_columns" class="text-xs font-bold text-slate-700">Kolom Grid Artikel (Daftar)</label>
                            <select id="layout_columns" name="layout_columns" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm bg-white cursor-pointer transition-all">
                                <option value="1" {{ (old('layout_columns', $settings['layout_columns'] ?? '') === '1') ? 'selected' : '' }}>1 Kolom (List Vertikal)</option>
                                <option value="2" {{ (old('layout_columns', $settings['layout_columns'] ?? '') === '2') ? 'selected' : '' }}>2 Kolom (Sedang)</option>
                                <option value="3" {{ (old('layout_columns', $settings['layout_columns'] ?? '') === '3') ? 'selected' : '' }}>3 Kolom (Standar)</option>
                                <option value="4" {{ (old('layout_columns', $settings['layout_columns'] ?? '') === '4') ? 'selected' : '' }}>4 Kolom (Padat)</option>
                            </select>
                            @error('layout_columns')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-home" class="tab-pane hidden space-y-8">
                <div class="space-y-4">
                    <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-heading text-primary"></i> Konten Hero Halaman Utama
                    </h3>

                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <label for="hero_title" class="text-xs font-bold text-slate-700">Judul Hero (Sebelum Nama Website)</label>
                            <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}" required placeholder="Contoh: Temukan Wawasan & Inspirasi Terbaru di" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                            @error('hero_title')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="hero_subtitle" class="text-xs font-bold text-slate-700">Sub-judul / Deskripsi Hero</label>
                            <textarea id="hero_subtitle" name="hero_subtitle" rows="3" required placeholder="Tuliskan sub-judul atau deskripsi singkat hero di sini..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                            @error('hero_subtitle')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-primary"></i> Banner Pengumuman
                    </h3>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="banner_active" name="banner_active" value="1" {{ (old('banner_active', $settings['banner_active'] ?? '0') === '1') ? 'checked' : '' }} class="w-4.5 h-4.5 text-primary rounded border-slate-300 focus:ring-primary/20 accent-primary cursor-pointer">
                            <label for="banner_active" class="text-xs sm:text-sm font-bold text-slate-700 ml-2 cursor-pointer select-none">Aktifkan Banner Pengumuman di Atas Website</label>
                        </div>

                        <div id="banner-text-container" class="space-y-1.5 {{ (old('banner_active', $settings['banner_active'] ?? '0') === '1') ? '' : 'opacity-50' }}">
                            <label for="banner_text" class="text-xs text-slate-700 font-bold">Teks Pengumuman</label>
                            <textarea id="banner_text" name="banner_text" rows="3" placeholder="Contoh: Selamat datang di website artikel resmi kami! Dapatkan info terbaru hari ini." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('banner_text', $settings['banner_text'] ?? '') }}</textarea>
                            @error('banner_text')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-about" class="tab-pane hidden space-y-8">
                <div class="space-y-4">
                    <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-file-lines text-primary"></i> Konten Halaman Tentang
                    </h3>

                    <div class="grid grid-cols-1 xl:grid-cols-[1fr_420px] gap-6">
                        <div class="space-y-6">
                            <div class="space-y-1.5">
                                <label for="about_header_title" class="text-xs font-bold text-slate-700">Judul Halaman</label>
                                <input type="text" id="about_header_title" name="about_header_title" value="{{ old('about_header_title', $settings['about_header_title'] ?? 'Tentang Kami') }}" placeholder="Judul utama halaman tentang" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                @error('about_header_title')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="about_header_subtitle" class="text-xs font-bold text-slate-700">Subjudul / Deskripsi Header</label>
                                <textarea id="about_header_subtitle" name="about_header_subtitle" rows="3" placeholder="Teks deskripsi kecil di bawah judul" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('about_header_subtitle', $settings['about_header_subtitle'] ?? 'Mengenal lebih dekat visi, sejarah, dan nilai-nilai yang kami usung.') }}</textarea>
                                @error('about_header_subtitle')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="about_section_badge" class="text-xs font-bold text-slate-700">Label Badge Profil</label>
                                <input type="text" id="about_section_badge" name="about_section_badge" value="{{ old('about_section_badge', $settings['about_section_badge'] ?? 'Profil Kami') }}" placeholder="Contoh: Profil Kami" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                @error('about_section_badge')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="about_section_main_heading" class="text-xs font-bold text-slate-700">Judul Utama Seksi</label>
                                <input type="text" id="about_section_main_heading" name="about_section_main_heading" value="{{ old('about_section_main_heading', $settings['about_section_main_heading'] ?? 'Menyajikan Informasi yang Akurat, Edukatif, dan Menginspirasi') }}" placeholder="Judul besar untuk konten profil" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                @error('about_section_main_heading')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="about_paragraph_1" class="text-xs font-bold text-slate-700">Paragraf 1</label>
                                <textarea id="about_paragraph_1" name="about_paragraph_1" rows="4" placeholder="Paragraf pertama tentang visi dan misi" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('about_paragraph_1', $settings['about_paragraph_1'] ?? 'Kami adalah portal artikel independen yang berdedikasi untuk membagikan wawasan terbaru dan tepercaya kepada masyarakat umum. Kami percaya bahwa pengetahuan adalah kekuatan, dan akses terhadap informasi yang berkualitas harus mudah dijangkau oleh semua orang.') }}</textarea>
                                @error('about_paragraph_1')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="about_paragraph_2" class="text-xs font-bold text-slate-700">Paragraf 2</label>
                                <textarea id="about_paragraph_2" name="about_paragraph_2" rows="4" placeholder="Paragraf kedua tentang proses dan kualitas konten" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('about_paragraph_2', $settings['about_paragraph_2'] ?? 'Setiap artikel yang diterbitkan melalui platform kami melewati proses tinjauan internal oleh tim admin kami untuk memastikan konten yang disajikan memiliki nilai edukasi, keakuratan data, serta penyampaian yang mudah dipahami.') }}</textarea>
                                @error('about_paragraph_2')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label for="about_pillar_1_icon" class="text-xs font-bold text-slate-700">Ikon Pilar 1</label>
                                    <input type="text" id="about_pillar_1_icon" name="about_pillar_1_icon" value="{{ old('about_pillar_1_icon', $settings['about_pillar_1_icon'] ?? 'fa-solid fa-circle-check') }}" placeholder="Contoh: fa-solid fa-circle-check" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                    @error('about_pillar_1_icon')
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label for="about_pillar_1_title" class="text-xs font-bold text-slate-700">Judul Pilar 1</label>
                                    <input type="text" id="about_pillar_1_title" name="about_pillar_1_title" value="{{ old('about_pillar_1_title', $settings['about_pillar_1_title'] ?? 'Konten Akurat') }}" placeholder="Judul pilar pertama" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                    @error('about_pillar_1_title')
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label for="about_pillar_1_description" class="text-xs font-bold text-slate-700">Deskripsi Pilar 1</label>
                                <textarea id="about_pillar_1_description" name="about_pillar_1_description" rows="3" placeholder="Deskripsi pilar pertama" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('about_pillar_1_description', $settings['about_pillar_1_description'] ?? 'Informasi yang kami bagikan berbasis data tepercaya.') }}</textarea>
                                @error('about_pillar_1_description')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label for="about_pillar_2_icon" class="text-xs font-bold text-slate-700">Ikon Pilar 2</label>
                                    <input type="text" id="about_pillar_2_icon" name="about_pillar_2_icon" value="{{ old('about_pillar_2_icon', $settings['about_pillar_2_icon'] ?? 'fa-solid fa-bolt') }}" placeholder="Contoh: fa-solid fa-bolt" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                    @error('about_pillar_2_icon')
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label for="about_pillar_2_title" class="text-xs font-bold text-slate-700">Judul Pilar 2</label>
                                    <input type="text" id="about_pillar_2_title" name="about_pillar_2_title" value="{{ old('about_pillar_2_title', $settings['about_pillar_2_title'] ?? 'Pembaruan Cepat') }}" placeholder="Judul pilar kedua" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                    @error('about_pillar_2_title')
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label for="about_pillar_2_description" class="text-xs font-bold text-slate-700">Deskripsi Pilar 2</label>
                                <textarea id="about_pillar_2_description" name="about_pillar_2_description" rows="3" placeholder="Deskripsi pilar kedua" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('about_pillar_2_description', $settings['about_pillar_2_description'] ?? 'Selalu menyajikan tren terhangat secara realtime.') }}</textarea>
                                @error('about_pillar_2_description')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="about_card_title" class="text-xs font-bold text-slate-700">Judul Kartu Visual</label>
                                <input type="text" id="about_card_title" name="about_card_title" value="{{ old('about_card_title', $settings['about_card_title'] ?? 'Sejarah Singkat') }}" placeholder="Judul kartu kanan" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                @error('about_card_title')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="about_card_description" class="text-xs font-bold text-slate-700">Deskripsi Kartu</label>
                                <textarea id="about_card_description" name="about_card_description" rows="4" placeholder="Deskripsi pada kartu visual" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('about_card_description', $settings['about_card_description'] ?? 'Didirikan sebagai wadah berbagi bagi para penulis dan pemerhati isu-isu sosial, teknologi, serta kesehatan, platform ini terus berkembang menjadi portal rujukan ribuan pembaca setiap bulannya.') }}</textarea>
                                @error('about_card_description')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label for="about_card_stat_1" class="text-xs font-bold text-slate-700">Stat 1</label>
                                    <input type="text" id="about_card_stat_1" name="about_card_stat_1" value="{{ old('about_card_stat_1', $settings['about_card_stat_1'] ?? 'Mulai Sejak 2026') }}" placeholder="Contoh: Mulai Sejak 2026" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                    @error('about_card_stat_1')
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label for="about_card_stat_2" class="text-xs font-bold text-slate-700">Stat 2</label>
                                    <input type="text" id="about_card_stat_2" name="about_card_stat_2" value="{{ old('about_card_stat_2', $settings['about_card_stat_2'] ?? '10,000+ Pembaca Bulanan') }}" placeholder="Contoh: 10,000+ Pembaca Bulanan" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                    @error('about_card_stat_2')
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label for="about_card_icon" class="text-xs font-bold text-slate-700">Ikon Kartu</label>
                                <input type="text" id="about_card_icon" name="about_card_icon" value="{{ old('about_card_icon', $settings['about_card_icon'] ?? 'fa-solid fa-graduation-cap') }}" placeholder="Contoh: fa-solid fa-graduation-cap" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                @error('about_card_icon')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700 block">Gambar Kartu Halaman Tentang</label>
                                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3 flex items-center justify-center min-h-[150px]">
                                    @if(!empty($settings['about_card_image']))
                                        <img id="about-card-image-preview" src="{{ asset('storage/' . $settings['about_card_image']) }}" alt="Gambar Tentang" class="object-cover rounded-3xl max-h-40">
                                    @else
                                        <div id="about-card-icon-preview" class="text-4xl text-primary">
                                            <i class="{{ $settings['about_card_icon'] ?? 'fa-solid fa-graduation-cap' }}"></i>
                                        </div>
                                        <img id="about-card-image-preview" src="#" alt="Gambar Tentang" class="hidden object-cover rounded-3xl max-h-40">
                                    @endif
                                </div>
                                <input type="file" id="about_card_image" name="about_card_image" accept="image/*" class="hidden">
                                <label for="about_card_image" class="inline-flex px-3 py-2 rounded-xl border border-slate-200 text-slate-600 hover:text-primary hover:bg-slate-50 text-xs font-bold cursor-pointer transition-all">
                                    <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Unggah Gambar Kartu
                                </label>
                                @error('about_card_image')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-4 bg-slate-50 border border-slate-200 rounded-3xl p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Pratinjau Halaman Tentang</h4>
                                    <p class="text-xs text-slate-500">Perbarui teks dan ikon untuk melihat preview langsung.</p>
                                </div>
                            </div>

                            <div class="space-y-5">
                                <div class="rounded-3xl bg-slate-950 text-white p-6 text-center">
                                    <p id="preview-about-header-title" class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ $settings['about_header_title'] ?? 'Tentang Kami' }}</p>
                                    <p id="preview-about-header-subtitle" class="mt-3 text-sm text-slate-300">{{ $settings['about_header_subtitle'] ?? 'Mengenal lebih dekat visi, sejarah, dan nilai-nilai yang kami usung.' }}</p>
                                </div>

                                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                                    <span id="preview-about-section-badge" class="inline-flex px-3 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">{{ $settings['about_section_badge'] ?? 'Profil Kami' }}</span>
                                    <h3 id="preview-about-main-heading" class="mt-4 text-xl font-extrabold text-slate-900">{{ $settings['about_section_main_heading'] ?? 'Menyajikan Informasi yang Akurat, Edukatif, dan Menginspirasi' }}</h3>
                                    <p id="preview-about-paragraph-1" class="mt-3 text-sm leading-relaxed text-slate-600">{{ $settings['about_paragraph_1'] ?? 'Kami adalah portal artikel independen yang berdedikasi untuk membagikan wawasan terbaru dan tepercaya kepada masyarakat umum. Kami percaya bahwa pengetahuan adalah kekuatan, dan akses terhadap informasi yang berkualitas harus mudah dijangkau oleh semua orang.' }}</p>
                                    <p id="preview-about-paragraph-2" class="mt-3 text-sm leading-relaxed text-slate-600">{{ $settings['about_paragraph_2'] ?? 'Setiap artikel yang diterbitkan melalui platform kami melewati proses tinjauan internal oleh tim admin kami untuk memastikan konten yang disajikan memiliki nilai edukasi, keakuratan data, serta penyampaian yang mudah dipahami.' }}</p>
                                </div>

                                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="flex gap-4 items-start">
                                            <div id="preview-pillar-1-icon" class="rounded-2xl bg-primary/10 text-primary p-4 text-2xl">
                                                <i class="{{ $settings['about_pillar_1_icon'] ?? 'fa-solid fa-circle-check' }}"></i>
                                            </div>
                                            <div>
                                                <h4 id="preview-pillar-1-title" class="font-bold text-slate-900">{{ $settings['about_pillar_1_title'] ?? 'Konten Akurat' }}</h4>
                                                <p id="preview-pillar-1-description" class="text-sm text-slate-500 mt-1">{{ $settings['about_pillar_1_description'] ?? 'Informasi yang kami bagikan berbasis data tepercaya.' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-4 items-start">
                                            <div id="preview-pillar-2-icon" class="rounded-2xl bg-secondary/10 text-secondary p-4 text-2xl">
                                                <i class="{{ $settings['about_pillar_2_icon'] ?? 'fa-solid fa-bolt' }}"></i>
                                            </div>
                                            <div>
                                                <h4 id="preview-pillar-2-title" class="font-bold text-slate-900">{{ $settings['about_pillar_2_title'] ?? 'Pembaruan Cepat' }}</h4>
                                                <p id="preview-pillar-2-description" class="text-sm text-slate-500 mt-1">{{ $settings['about_pillar_2_description'] ?? 'Selalu menyajikan tren terhangat secara realtime.' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                                    <div class="rounded-3xl overflow-hidden bg-slate-100 mb-5">
                                        <img id="preview-card-image" src="{{ !empty($settings['about_card_image']) ? asset('storage/' . $settings['about_card_image']) : '' }}" alt="Gambar Tentang" class="w-full object-cover {{ empty($settings['about_card_image']) ? 'hidden' : '' }}" style="max-height:240px;">
                                        <div id="preview-card-icon" class="flex items-center justify-center h-40 text-primary text-5xl {{ !empty($settings['about_card_image']) ? 'hidden' : 'block' }}">
                                            <i class="{{ $settings['about_card_icon'] ?? 'fa-solid fa-graduation-cap' }}"></i>
                                        </div>
                                    </div>
                                    <h4 id="preview-card-title" class="text-xl font-bold text-slate-900">{{ $settings['about_card_title'] ?? 'Sejarah Singkat' }}</h4>
                                    <p id="preview-card-description" class="mt-3 text-sm text-slate-500 leading-relaxed">{{ $settings['about_card_description'] ?? 'Didirikan sebagai wadah berbagi bagi para penulis dan pemerhati isu-isu sosial, teknologi, serta kesehatan, platform ini terus berkembang menjadi portal rujukan ribuan pembaca setiap bulannya.' }}</p>
                                    <div class="mt-6 border-t border-slate-100 pt-4 grid grid-cols-2 gap-4 text-sm text-slate-500">
                                        <div class="rounded-2xl bg-slate-50 p-4 text-center">
                                            <span id="preview-card-stat-1" class="font-bold text-slate-900">{{ $settings['about_card_stat_1'] ?? 'Mulai Sejak 2026' }}</span>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 p-4 text-center">
                                            <span id="preview-card-stat-2" class="font-bold text-slate-900">{{ $settings['about_card_stat_2'] ?? '10,000+ Pembaca Bulanan' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-footer" class="tab-pane hidden space-y-8">
                <div class="space-y-4">
                    <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-shoe-prints text-primary rotate-270"></i> Informasi Footer & Media Sosial
                    </h3>

                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <label for="footer_text" class="text-xs font-bold text-slate-700">Deskripsi Singkat Footer</label>
                            <textarea id="footer_text" name="footer_text" rows="3" required placeholder="Tuliskan deskripsi singkat tentang website atau organisasi Anda di sini..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('footer_text', $settings['footer_text'] ?? '') }}</textarea>
                            @error('footer_text')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div class="space-y-1.5">
                                <label for="footer_instagram" class="text-xs font-bold text-slate-700"><i class="fa-brands fa-instagram text-pink-500 mr-1"></i> Link Instagram</label>
                                <input type="url" id="footer_instagram" name="footer_instagram" value="{{ old('footer_instagram', $settings['footer_instagram'] ?? '') }}" placeholder="https://instagram.com/akun" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                @error('footer_instagram')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="footer_tiktok" class="text-xs font-bold text-slate-700"><i class="fa-brands fa-tiktok text-slate-950 mr-1"></i> Link TikTok</label>
                                <input type="url" id="footer_tiktok" name="footer_tiktok" value="{{ old('footer_tiktok', $settings['footer_tiktok'] ?? '') }}" placeholder="https://tiktok.com/@akun" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                @error('footer_tiktok')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="footer_youtube" class="text-xs font-bold text-slate-700"><i class="fa-brands fa-youtube text-red-600 mr-1"></i> Link YouTube</label>
                                <input type="url" id="footer_youtube" name="footer_youtube" value="{{ old('footer_youtube', $settings['footer_youtube'] ?? '') }}" placeholder="https://youtube.com/c/channel" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                                @error('footer_youtube')
                                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-seo" class="tab-pane hidden space-y-8">
                <div class="space-y-4">
                    <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass-chart text-primary"></i> Pengaturan SEO Global
                    </h3>

                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <label for="seo_meta_title" class="text-xs font-bold text-slate-700">Default Meta Title</label>
                            <input type="text" id="seo_meta_title" name="seo_meta_title" value="{{ old('seo_meta_title', $settings['seo_meta_title'] ?? '') }}" required placeholder="Meta title bawaan pencarian" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                            @error('seo_meta_title')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="seo_meta_description" class="text-xs font-bold text-slate-700">Default Meta Description</label>
                            <textarea id="seo_meta_description" name="seo_meta_description" rows="3" required placeholder="Deskripsi meta bawaan untuk optimasi pencarian Google..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('seo_meta_description', $settings['seo_meta_description'] ?? '') }}</textarea>
                            @error('seo_meta_description')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-6 flex justify-end font-semibold text-sm">
                <button type="submit" class="px-6 py-3 rounded-xl bg-primary text-white shadow-md shadow-primary/20 hover:bg-primary-hover hover:shadow-lg transition-all cursor-pointer">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Konfigurasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const tabButtons = document.querySelectorAll('[data-tab]');
    const tabPanes = document.querySelectorAll('.tab-pane');

    function activateTab(tabName) {
        tabPanes.forEach(pane => {
            pane.classList.toggle('hidden', pane.id !== `tab-${tabName}`);
        });
        tabButtons.forEach(button => {
            if (button.dataset.tab === tabName) {
                button.classList.add('bg-primary', 'text-white', 'border-primary');
                button.classList.remove('text-slate-600', 'border-slate-200');
            } else {
                button.classList.remove('bg-primary', 'text-white', 'border-primary');
                button.classList.add('text-slate-600', 'border-slate-200');
            }
        });
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', () => activateTab(button.dataset.tab));
    });

    activateTab('general');

    const logoInput = document.getElementById('site_logo');
    const logoPreview = document.getElementById('logo-preview');
    const textPlaceholder = document.getElementById('logo-text-placeholder');

    const logoShape = document.getElementById('logo-shape');
    const logoPrimaryWidth = document.getElementById('logo_primary_width');
    const logoPrimaryHeight = document.getElementById('logo_primary_height');
    const logoSecondary1Width = document.getElementById('logo_secondary_1_width');
    const logoSecondary1Height = document.getElementById('logo_secondary_1_height');
    const logoSecondary2Width = document.getElementById('logo_secondary_2_width');
    const logoSecondary2Height = document.getElementById('logo_secondary_2_height');
    const logoRadius = document.getElementById('logo-border-radius');
    const radiusContainer = document.getElementById('logo-radius-container');

    const logoSecondary1Input = document.getElementById('site_logo_secondary_1');
    const logoSecondary2Input = document.getElementById('site_logo_secondary_2');
    const logoSecondary1Preview = document.getElementById('logo-secondary-1-preview');
    const logoSecondary2Preview = document.getElementById('logo-secondary-2-preview');
    const logoSecondary1Placeholder = document.getElementById('logo-secondary-1-placeholder');
    const logoSecondary2Placeholder = document.getElementById('logo-secondary-2-placeholder');

    function updateImagePreview(file, previewElement, placeholderElement, widthInput, heightInput) {
        if (!previewElement || !file) return;

        const reader = new FileReader();
        reader.onload = function(event) {
            previewElement.src = event.target.result;
            previewElement.classList.remove('hidden');
            previewElement.style.display = 'inline-block';
            previewElement.style.objectFit = 'contain';

            if (placeholderElement) {
                placeholderElement.classList.add('hidden');
            }

            const width = widthInput ? widthInput.value : 120;
            const height = heightInput ? heightInput.value : 40;
            const radius = (logoShape && logoShape.value === 'circle') ? '9999px' : (logoRadius ? logoRadius.value + 'px' : '8px');

            previewElement.style.width = width + 'px';
            previewElement.style.height = height + 'px';
            previewElement.style.borderRadius = radius;
        };
        reader.readAsDataURL(file);
    }

    if (logoInput) {
        logoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                updateImagePreview(file, logoPreview, textPlaceholder, logoPrimaryWidth, logoPrimaryHeight);
            }
        });
    }

    if (logoSecondary1Input) {
        logoSecondary1Input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                updateImagePreview(file, logoSecondary1Preview, logoSecondary1Placeholder, logoSecondary1Width, logoSecondary1Height);
            }
        });
    }

    if (logoSecondary2Input) {
        logoSecondary2Input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                updateImagePreview(file, logoSecondary2Preview, logoSecondary2Placeholder, logoSecondary2Width, logoSecondary2Height);
            }
        });
    }

    function updatePreviewStyles(previewElement, widthInput, heightInput) {
        if (!previewElement || !widthInput || !heightInput) return;

        const width = widthInput.value + 'px';
        const height = heightInput.value + 'px';
        const radius = (logoShape && logoShape.value === 'circle') ? '9999px' : (logoRadius ? logoRadius.value + 'px' : '8px');

        previewElement.style.width = width;
        previewElement.style.height = height;
        previewElement.style.borderRadius = radius;
    }

    [logoPrimaryWidth, logoPrimaryHeight, logoSecondary1Width, logoSecondary1Height, logoSecondary2Width, logoSecondary2Height, logoShape, logoRadius].forEach(el => {
        if (!el) return;
        el.addEventListener('input', () => {
            updatePreviewStyles(logoPreview, logoPrimaryWidth, logoPrimaryHeight);
            updatePreviewStyles(logoSecondary1Preview, logoSecondary1Width, logoSecondary1Height);
            updatePreviewStyles(logoSecondary2Preview, logoSecondary2Width, logoSecondary2Height);
            const radius = (logoShape && logoShape.value === 'circle') ? '9999px' : (logoRadius ? logoRadius.value + 'px' : '8px');
            if (textPlaceholder) textPlaceholder.style.borderRadius = radius;
            if (logoSecondary1Placeholder) logoSecondary1Placeholder.style.borderRadius = radius;
            if (logoSecondary2Placeholder) logoSecondary2Placeholder.style.borderRadius = radius;
            if (logoShape && logoShape.value === 'circle') {
                logoRadius.setAttribute('disabled', 'true');
                if (radiusContainer) radiusContainer.classList.add('opacity-50');
            } else {
                logoRadius.removeAttribute('disabled');
                if (radiusContainer) radiusContainer.classList.remove('opacity-50');
            }
        });
    });

    function updateLogoPreviewStyles() {
        if (!logoPreview || !logoShape || !logoPrimaryWidth || !logoPrimaryHeight || !logoRadius) return;

        const shape = logoShape.value;
        const width = logoPrimaryWidth.value + 'px';
        const height = logoPrimaryHeight.value + 'px';
        const radius = shape === 'circle' ? '9999px' : logoRadius.value + 'px';

        logoPreview.style.width = width;
        logoPreview.style.height = height;
        logoPreview.style.borderRadius = radius;

        if (textPlaceholder) {
            textPlaceholder.style.borderRadius = radius;
        }

        if (shape === 'circle') {
            logoRadius.setAttribute('disabled', 'true');
            if (radiusContainer) radiusContainer.classList.add('opacity-50');
        } else {
            logoRadius.removeAttribute('disabled');
            if (radiusContainer) radiusContainer.classList.remove('opacity-50');
        }
    }

    [logoShape, logoPrimaryWidth, logoPrimaryHeight, logoRadius].forEach(el => {
        if (el) el.addEventListener('input', updateLogoPreviewStyles);
    });

    updateLogoPreviewStyles();

    const colors = ['primary_color', 'secondary_color', 'bg_color'];
    colors.forEach(col => {
        const input = document.getElementById(col);
        const text = document.getElementById(col + '_text');
        if (!input || !text) return;
        input.addEventListener('input', function() {
            text.value = this.value;
        });
    });

    const bannerActive = document.getElementById('banner_active');
    const bannerContainer = document.getElementById('banner-text-container');
    const bannerTextarea = document.getElementById('banner_text');

    if (bannerActive && bannerTextarea && bannerContainer) {
        bannerActive.addEventListener('change', function() {
            if (this.checked) {
                bannerContainer.classList.remove('opacity-50');
                bannerTextarea.removeAttribute('disabled');
            } else {
                bannerContainer.classList.add('opacity-50');
                bannerTextarea.setAttribute('disabled', 'true');
            }
        });

        if (!bannerActive.checked) {
            bannerTextarea.setAttribute('disabled', 'true');
        }
    }

    const aboutInputs = [
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
        'about_card_icon',
        'about_card_title',
        'about_card_description',
        'about_card_stat_1',
        'about_card_stat_2'
    ];

    function updateAboutPreview() {
        const mappings = {
            'about_header_title': 'preview-about-header-title',
            'about_header_subtitle': 'preview-about-header-subtitle',
            'about_section_badge': 'preview-about-section-badge',
            'about_section_main_heading': 'preview-about-main-heading',
            'about_paragraph_1': 'preview-about-paragraph-1',
            'about_paragraph_2': 'preview-about-paragraph-2',
            'about_pillar_1_title': 'preview-pillar-1-title',
            'about_pillar_1_description': 'preview-pillar-1-description',
            'about_pillar_2_title': 'preview-pillar-2-title',
            'about_pillar_2_description': 'preview-pillar-2-description',
            'about_card_title': 'preview-card-title',
            'about_card_description': 'preview-card-description',
            'about_card_stat_1': 'preview-card-stat-1',
            'about_card_stat_2': 'preview-card-stat-2'
        };

        aboutInputs.forEach(inputId => {
            const input = document.getElementById(inputId);
            const target = document.getElementById(mappings[inputId]);
            if (!input || !target) return;
            target.textContent = input.value || target.textContent;
        });

        const pillar1Icon = document.getElementById('about_pillar_1_icon');
        const pillar2Icon = document.getElementById('about_pillar_2_icon');
        const cardIcon = document.getElementById('about_card_icon');
        const previewPillar1Icon = document.getElementById('preview-pillar-1-icon');
        const previewPillar2Icon = document.getElementById('preview-pillar-2-icon');
        const previewCardIcon = document.getElementById('preview-card-icon');

        if (pillar1Icon && previewPillar1Icon) {
            previewPillar1Icon.innerHTML = `<i class="${pillar1Icon.value || 'fa-solid fa-circle-check'}"></i>`;
        }
        if (pillar2Icon && previewPillar2Icon) {
            previewPillar2Icon.innerHTML = `<i class="${pillar2Icon.value || 'fa-solid fa-bolt'}"></i>`;
        }
        if (cardIcon && previewCardIcon) {
            previewCardIcon.innerHTML = `<i class="${cardIcon.value || 'fa-solid fa-graduation-cap'}"></i>`;
        }
    }

    aboutInputs.forEach(id => {
        const input = document.getElementById(id);
        if (!input) return;
        input.addEventListener('input', updateAboutPreview);
    });

    const aboutCardImageInput = document.getElementById('about_card_image');
    const aboutCardImagePreview = document.getElementById('about-card-image-preview');
    const aboutCardIconPreview = document.getElementById('about-card-icon-preview');
    const previewCardImage = document.getElementById('preview-card-image');
    const previewCardIcon = document.getElementById('preview-card-icon');

    if (aboutCardImageInput) {
        aboutCardImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    if (aboutCardImagePreview) {
                        aboutCardImagePreview.src = this.result;
                        aboutCardImagePreview.classList.remove('hidden');
                    }
                    if (aboutCardIconPreview) {
                        aboutCardIconPreview.classList.add('hidden');
                    }
                    if (previewCardImage) {
                        previewCardImage.src = this.result;
                        previewCardImage.classList.remove('hidden');
                    }
                    if (previewCardIcon) {
                        previewCardIcon.classList.add('hidden');
                    }
                });
                reader.readAsDataURL(file);
            }
        });
    }

    updateAboutPreview();
</script>
@endsection
