@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page_title', 'Pengaturan Website')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-white border border-slate-200/60 rounded-3xl p-8 shadow-sm">
        
        <form action="{{ route('admin.super.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- SECTION 1: Identitas & Logo -->
            <div class="space-y-4">
                <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-primary"></i> Identitas & Logo
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                    <!-- Title Input -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label for="site_title" class="text-xs font-bold text-slate-700">Nama/Judul Website</label>
                        <input type="text" id="site_title" name="site_title" value="{{ old('site_title', $settings['site_title'] ?? '') }}" required placeholder="Contoh: Portal Artikel Keren" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                        @error('site_title')
                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Logo Upload -->
                    <div class="space-y-1.5 md:col-span-3">
                        <label class="text-xs font-bold text-slate-700 block">Logo Website (Realtime Preview)</label>
                        <div class="flex items-start gap-4 flex-wrap">
                            <div id="logo-preview-container" class="bg-slate-50 border border-slate-200 flex items-center justify-center p-1.5 overflow-hidden flex-shrink-0 rounded-xl">
                                @if(!empty($settings['site_logo']))
                                    <img id="logo-preview" src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" class="object-cover" style="width: {{ $settings['logo_width'] ?? '120' }}px; height: {{ $settings['logo_height'] ?? '40' }}px; border-radius: {{ ($settings['logo_shape'] ?? 'rectangle') === 'circle' ? '9999px' : ($settings['logo_border_radius'] ?? '8') . 'px' }};">
                                @else
                                    <div id="logo-text-placeholder" class="h-8 w-8 rounded bg-primary/10 text-primary flex items-center justify-center text-xs font-bold font-mono">
                                        {{ substr($settings['site_title'] ?? 'WA', 0, 2) }}
                                    </div>
                                    <img id="logo-preview" src="#" alt="Logo" class="hidden object-cover">
                                @endif
                            </div>
                            
                            <div class="flex-grow min-w-[150px]">
                                <input type="file" id="site_logo" name="site_logo" accept="image/*" class="hidden">
                                <label for="site_logo" class="inline-flex px-3 py-2 rounded-xl border border-slate-200 text-slate-600 hover:text-primary hover:bg-slate-50 text-xs font-bold cursor-pointer transition-all">
                                    <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Unggah File Logo
                                </label>
                            </div>
                        </div>
                        @error('site_logo')
                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Logo Styling configurations -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 md:col-span-3 pt-4 border-t border-slate-100/60">
                        <!-- Shape -->
                        <div class="space-y-1.5">
                            <label for="logo-shape" class="text-xs font-bold text-slate-700">Bentuk Logo</label>
                            <select id="logo-shape" name="logo_shape" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm bg-white cursor-pointer transition-all">
                                <option value="rectangle" {{ (old('logo_shape', $settings['logo_shape'] ?? '') === 'rectangle') ? 'selected' : '' }}>Persegi Panjang (Rectangle)</option>
                                <option value="circle" {{ (old('logo_shape', $settings['logo_shape'] ?? '') === 'circle') ? 'selected' : '' }}>Lingkaran (Circle)</option>
                            </select>
                            @error('logo_shape')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Width -->
                        <div class="space-y-1.5">
                            <label for="logo-width" class="text-xs font-bold text-slate-700">Lebar Logo (px)</label>
                            <input type="number" id="logo-width" name="logo_width" value="{{ old('logo_width', $settings['logo_width'] ?? '120') }}" required min="10" max="500" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                            @error('logo_width')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Height -->
                        <div class="space-y-1.5">
                            <label for="logo-height" class="text-xs font-bold text-slate-700">Tinggi Logo (px)</label>
                            <input type="number" id="logo-height" name="logo_height" value="{{ old('logo_height', $settings['logo_height'] ?? '40') }}" required min="10" max="500" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                            @error('logo_height')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Radius -->
                        <div class="space-y-1.5" id="logo-radius-container">
                            <label for="logo-border-radius" class="text-xs font-bold text-slate-700">Border Radius (px)</label>
                            <input type="number" id="logo-border-radius" name="logo_border_radius" value="{{ old('logo_border_radius', $settings['logo_border_radius'] ?? '8') }}" required min="0" max="100" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                            @error('logo_border_radius')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="md:col-span-3 text-2xs text-slate-400 font-semibold leading-relaxed">
                        <i class="fa-solid fa-circle-info text-primary/70"></i> *Tips: Untuk bentuk <strong>Lingkaran (Circle)</strong>, gunakan lebar & tinggi yang sama agar bulat presisi. Input border radius dinonaktifkan otomatis.
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Tema & Tampilan -->
            <div class="space-y-4">
                <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-palette text-primary"></i> Skema Warna & Tata Letak
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <!-- Primary Color -->
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

                    <!-- Secondary Color -->
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

                    <!-- Background Color -->
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

                    <!-- Font Family selection -->
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

                    <!-- Layout Column Grid for articles -->
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

            <!-- SECTION 2.5: Konten Hero (Halaman Utama) -->
            <div class="space-y-4">
                <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-heading text-primary"></i> Konten Hero Halaman Utama
                </h3>
                
                <div class="space-y-4">
                    <!-- Hero Title -->
                    <div class="space-y-1.5">
                        <label for="hero_title" class="text-xs font-bold text-slate-700">Judul Hero (Sebelum Nama Website)</label>
                        <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}" required placeholder="Contoh: Temukan Wawasan & Inspirasi Terbaru di" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                        @error('hero_title')
                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hero Subtitle -->
                    <div class="space-y-1.5">
                        <label for="hero_subtitle" class="text-xs font-bold text-slate-700">Sub-judul / Deskripsi Hero</label>
                        <textarea id="hero_subtitle" name="hero_subtitle" rows="3" required placeholder="Tuliskan sub-judul atau deskripsi singkat hero di sini..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                        @error('hero_subtitle')
                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Banner/Pengumuman -->
            <div class="space-y-4">
                <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-primary"></i> Banner Pengumuman
                </h3>
                
                <div class="space-y-4">
                    <!-- Toggle Switch -->
                    <div class="flex items-center">
                        <input type="checkbox" id="banner_active" name="banner_active" value="1" {{ (old('banner_active', $settings['banner_active'] ?? '0') === '1') ? 'checked' : '' }} class="w-4.5 h-4.5 text-primary rounded border-slate-300 focus:ring-primary/20 accent-primary cursor-pointer">
                        <label for="banner_active" class="text-xs sm:text-sm font-bold text-slate-700 ml-2 cursor-pointer select-none">Aktifkan Banner Pengumuman di Atas Website</label>
                    </div>

                    <!-- Announcement Text -->
                    <div id="banner-text-container" class="space-y-1.5 {{ (old('banner_active', $settings['banner_active'] ?? '0') === '1') ? '' : 'opacity-50' }}">
                        <label for="banner_text" class="text-xs font-bold text-slate-700">Teks Pengumuman</label>
                        <textarea id="banner_text" name="banner_text" rows="3" placeholder="Contoh: Selamat datang di website artikel resmi kami! Dapatkan info terbaru hari ini." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('banner_text', $settings['banner_text'] ?? '') }}</textarea>
                        @error('banner_text')
                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION 4: Informasi Footer -->
            <div class="space-y-4">
                <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-shoe-prints text-primary rotate-270"></i> Informasi Footer & Media Sosial
                </h3>
                
                <div class="space-y-4">
                    <!-- Footer description -->
                    <div class="space-y-1.5">
                        <label for="footer_text" class="text-xs font-bold text-slate-700">Deskripsi Singkat Footer</label>
                        <textarea id="footer_text" name="footer_text" rows="3" required placeholder="Tuliskan deskripsi singkat tentang website atau organisasi Anda di sini..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('footer_text', $settings['footer_text'] ?? '') }}</textarea>
                        @error('footer_text')
                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <!-- Instagram -->
                        <div class="space-y-1.5">
                            <label for="footer_instagram" class="text-xs font-bold text-slate-700"><i class="fa-brands fa-instagram text-pink-500 mr-1"></i> Link Instagram</label>
                            <input type="url" id="footer_instagram" name="footer_instagram" value="{{ old('footer_instagram', $settings['footer_instagram'] ?? '') }}" placeholder="https://instagram.com/akun" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                            @error('footer_instagram')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- TikTok -->
                        <div class="space-y-1.5">
                            <label for="footer_tiktok" class="text-xs font-bold text-slate-700"><i class="fa-brands fa-tiktok text-slate-950 mr-1"></i> Link TikTok</label>
                            <input type="url" id="footer_tiktok" name="footer_tiktok" value="{{ old('footer_tiktok', $settings['footer_tiktok'] ?? '') }}" placeholder="https://tiktok.com/@akun" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                            @error('footer_tiktok')
                                <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- YouTube -->
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

            <!-- SECTION 5: Pengaturan SEO -->
            <div class="space-y-4">
                <h3 class="font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass-chart text-primary"></i> Pengaturan SEO Global
                </h3>
                
                <div class="space-y-4">
                    <!-- Meta Title -->
                    <div class="space-y-1.5">
                        <label for="seo_meta_title" class="text-xs font-bold text-slate-700">Default Meta Title</label>
                        <input type="text" id="seo_meta_title" name="seo_meta_title" value="{{ old('seo_meta_title', $settings['seo_meta_title'] ?? '') }}" required placeholder="Meta title bawaan pencarian" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                        @error('seo_meta_title')
                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Meta Description -->
                    <div class="space-y-1.5">
                        <label for="seo_meta_description" class="text-xs font-bold text-slate-700">Default Meta Description</label>
                        <textarea id="seo_meta_description" name="seo_meta_description" rows="3" required placeholder="Deskripsi meta bawaan untuk optimasi pencarian Google..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all leading-relaxed">{{ old('seo_meta_description', $settings['seo_meta_description'] ?? '') }}</textarea>
                        @error('seo_meta_description')
                            <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="border-t border-slate-100 pt-6 flex justify-end font-semibold text-sm">
                <button type="submit" class="px-6 py-3 rounded-xl bg-primary text-white shadow-md shadow-primary/20 hover:bg-primary-hover hover:shadow-lg transition-all cursor-pointer">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Konfigurasi
                </button>
            </div>

        </form>
    </div>
</div>

<!-- Scripts for interactive changes -->
<script>
    // Logo Upload Preview
    const logoInput = document.getElementById('site_logo');
    const logoPreview = document.getElementById('logo-preview');
    const textPlaceholder = document.getElementById('logo-text-placeholder');

    logoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', function() {
                logoPreview.setAttribute('src', this.result);
                logoPreview.classList.remove('hidden');
                if (textPlaceholder) {
                    textPlaceholder.classList.add('hidden');
                }
            });
            reader.readAsDataURL(file);
        }
    });

    // Sync Logo settings real-time preview
    const logoShape = document.getElementById('logo-shape');
    const logoWidth = document.getElementById('logo-width');
    const logoHeight = document.getElementById('logo-height');
    const logoRadius = document.getElementById('logo-border-radius');
    const radiusContainer = document.getElementById('logo-radius-container');

    function updateLogoPreviewStyles() {
        if (!logoPreview) return;
        
        const shape = logoShape.value;
        const width = logoWidth.value + 'px';
        const height = logoHeight.value + 'px';
        const radius = shape === 'circle' ? '9999px' : logoRadius.value + 'px';
        
        logoPreview.style.width = width;
        logoPreview.style.height = height;
        logoPreview.style.borderRadius = radius;
        
        const textPlaceholder = document.getElementById('logo-text-placeholder');
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

    [logoShape, logoWidth, logoHeight, logoRadius].forEach(el => {
        if (el) el.addEventListener('input', updateLogoPreviewStyles);
    });

    // Run initial preview styling
    updateLogoPreviewStyles();

    // Sync HTML5 Color inputs with read-only hex boxes
    const colors = ['primary_color', 'secondary_color', 'bg_color'];
    colors.forEach(col => {
        const input = document.getElementById(col);
        const text = document.getElementById(col + '_text');
        
        input.addEventListener('input', function() {
            text.value = this.value;
        });
    });

    // Banner Text Toggle Opacity
    const bannerActive = document.getElementById('banner_active');
    const bannerContainer = document.getElementById('banner-text-container');
    const bannerTextarea = document.getElementById('banner_text');

    bannerActive.addEventListener('change', function() {
        if (this.checked) {
            bannerContainer.classList.remove('opacity-50');
            bannerTextarea.removeAttribute('disabled');
        } else {
            bannerContainer.classList.add('opacity-50');
            bannerTextarea.setAttribute('disabled', 'true');
        }
    });
    
    // Set initial disabled state if unchecked
    if (!bannerActive.checked) {
        bannerTextarea.setAttribute('disabled', 'true');
    }
</script>
@endsection
