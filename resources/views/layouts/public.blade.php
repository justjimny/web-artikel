<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteSettings['seo_meta_title'] ?? 'Portal Artikel')</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['seo_meta_description'] ?? 'Kumpulan artikel menarik.')">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@php
    $primaryColor = $siteSettings['primary_color'] ?? '#2563eb';
    $secondaryColor = $siteSettings['secondary_color'] ?? '#10b981';
    
    // Slight transparency hover color
    $primaryHover = $primaryColor . 'dd';
    
    // Function to calculate contrast (returns white or dark slate)
    $getContrastColor = function($hexColor) {
        $hex = str_replace('#', '', $hexColor);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else if (strlen($hex) == 6) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        } else {
            return '#ffffff';
        }
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($yiq >= 170) ? '#0f172a' : '#ffffff';
    };
    
    // Function to darken color if it is too light for text
    $getReadableTextColor = function($hexColor) {
        $hex = str_replace('#', '', $hexColor);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else if (strlen($hex) == 6) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        } else {
            return '#2563eb';
        }
        
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        
        if ($yiq >= 130) {
            // Darken component colors significantly
            $r = max(0, min(255, (int)($r * 0.45)));
            $g = max(0, min(255, (int)($g * 0.45)));
            $b = max(0, min(255, (int)($b * 0.45)));
            return sprintf("#%02x%02x%02x", $r, $g, $b);
        }
        
        return '#' . $hex;
    };
    
    // Helper to get RGB
    $getRGB = function($hexColor) {
        $hex = str_replace('#', '', $hexColor);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else if (strlen($hex) == 6) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        } else {
            $r = 0; $g = 0; $b = 0;
        }
        return "$r, $g, $b";
    };
    
    $primaryRGB = $getRGB($primaryColor);
    $secondaryRGB = $getRGB($secondaryColor);
    
    $primaryContrast = $getContrastColor($primaryColor);
    $secondaryContrast = $getContrastColor($secondaryColor);
    
    $textPrimary = $getReadableTextColor($primaryColor);
    $textSecondary = $getReadableTextColor($secondaryColor);
@endphp

    <!-- CSS Variables for Dynamic Customization -->
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --primary-color-rgb: {{ $primaryRGB }};
            --primary-hover: {{ $primaryHover }};
            --primary-contrast: {{ $primaryContrast }};
            --text-primary: {{ $textPrimary }};
            
            --secondary-color: {{ $secondaryColor }};
            --secondary-color-rgb: {{ $secondaryRGB }};
            --secondary-contrast: {{ $secondaryContrast }};
            --text-secondary: {{ $textSecondary }};
            
            --bg-color: {{ $siteSettings['bg_color'] ?? '#f8fafc' }};
            --font-family: '{{ $siteSettings['font_family'] ?? 'Instrument Sans' }}', sans-serif;

            /* Logo customization settings variables */
            --logo-width: {{ $siteSettings['logo_width'] ?? '120' }}px;
            --logo-height: {{ $siteSettings['logo_height'] ?? '40' }}px;
            --logo-border-radius: {{ ($siteSettings['logo_shape'] ?? 'rectangle') === 'circle' ? '9999px' : ($siteSettings['logo_border_radius'] ?? '8') . 'px' }};
        }

        .logo-custom {
            width: var(--logo-width) !important;
            height: var(--logo-height) !important;
            border-radius: var(--logo-border-radius) !important;
            object-fit: cover !important;
        }

        /* Direct CSS fallback overrides to bypass Tailwind compilation inside container */
        .bg-primary {
            background-color: var(--primary-color) !important;
            color: var(--primary-contrast) !important;
        }
        .bg-primary * {
            color: inherit !important;
        }
        .hover\:bg-primary-hover:hover {
            background-color: var(--primary-hover) !important;
            color: var(--primary-contrast) !important;
        }
        .text-primary {
            color: var(--text-primary) !important;
        }
        .hover\:text-primary:hover {
            color: var(--text-primary) !important;
        }
        .border-primary {
            border-color: var(--primary-color) !important;
        }
        .hover\:border-primary:hover {
            border-color: var(--primary-color) !important;
        }
        .focus\:border-primary:focus {
            border-color: var(--primary-color) !important;
        }
        
        .bg-secondary {
            background-color: var(--secondary-color) !important;
            color: var(--secondary-contrast) !important;
        }
        .bg-secondary * {
            color: inherit !important;
        }
        .text-secondary {
            color: var(--text-secondary) !important;
        }
        .hover\:text-secondary:hover {
            color: var(--text-secondary) !important;
        }
        
        .bg-primary\/10 {
            background-color: rgba(var(--primary-color-rgb), 0.1) !important;
        }
        .bg-primary\/5 {
            background-color: rgba(var(--primary-color-rgb), 0.05) !important;
        }
        .hover\:bg-primary\/5:hover {
            background-color: rgba(var(--primary-color-rgb), 0.05) !important;
        }
        .bg-secondary\/10 {
            background-color: rgba(var(--secondary-color-rgb), 0.1) !important;
        }
        
        .shadow-primary\/20 {
            box-shadow: 0 4px 6px -1px rgba(var(--primary-color-rgb), 0.2), 0 2px 4px -2px rgba(var(--primary-color-rgb), 0.2) !important;
        }
        .shadow-primary\/25 {
            box-shadow: 0 10px 15px -3px rgba(var(--primary-color-rgb), 0.25), 0 4px 6px -4px rgba(var(--primary-color-rgb), 0.25) !important;
        }
        .bg-gradient-to-br.from-primary.to-emerald-400 {
            background-image: linear-gradient(135deg, var(--primary-color), #34d399) !important;
        }
        .bg-gradient-to-br.from-primary.to-secondary {
            background-image: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        }
        .bg-gradient-to-tr.from-primary.to-secondary {
            background-image: linear-gradient(to top right, var(--primary-color), var(--secondary-color)) !important;
        }
        .bg-gradient-to-r.from-primary.to-secondary {
            background-image: linear-gradient(to right, var(--primary-color), var(--secondary-color)) !important;
        }
        .bg-clip-text.text-transparent {
            background-clip: text !important;
            -webkit-background-clip: text !important;
            color: transparent !important;
        }

        /* Premium Dark Mode Styling Overrides */
        body.dark {
            background-color: #0f172a !important; /* slate-900 */
            color: #e2e8f0 !important; /* slate-200 */
        }
        body.dark header {
            background-color: rgba(15, 23, 42, 0.85) !important;
            border-color: #1e293b !important;
        }
        body.dark #mobile-menu {
            background-color: rgba(15, 23, 42, 0.95) !important;
            border-color: #1e293b !important;
        }
        body.dark footer {
            background-color: #020617 !important;
            border-color: #0f172a !important;
        }
        body.dark .bg-white {
            background-color: #1e293b !important; /* slate-800 */
            border-color: #334155 !important;
        }
        body.dark .bg-slate-50 {
            background-color: #0f172a !important;
        }
        body.dark .bg-slate-50\/50 {
            background-color: #1e293b !important;
        }
        body.dark .text-slate-900, 
        body.dark .text-slate-950, 
        body.dark .text-slate-800 {
            color: #f8fafc !important;
        }
        body.dark .text-slate-500, 
        body.dark .text-slate-600 {
            color: #94a3b8 !important; /* slate-400 */
        }
        body.dark .border-slate-100, 
        body.dark .border-slate-200 {
            border-color: #334155 !important;
        }
        body.dark input, 
        body.dark select, 
        body.dark textarea {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        body.dark .bg-gradient-to-b.from-white.to-slate-50 {
            background-image: linear-gradient(to bottom, #1e293b, #0f172a) !important;
        }
        body.dark #theme-toggle,
        body.dark #theme-toggle-mobile {
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        body.dark #theme-toggle:hover,
        body.dark #theme-toggle-mobile:hover {
            background-color: #1e293b !important;
        }
        body.dark a.border-transparent {
            color: #94a3b8 !important;
        }
        body.dark a.border-transparent:hover {
            color: var(--primary-color) !important;
        }
    </style>

    <!-- Tailwind CSS v4 Browser Engine -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <!-- Configure Tailwind v4 Theme Variables -->
    <style type="tailwindcss">
        @theme {
            --color-primary: var(--primary-color);
            --color-primary-hover: var(--primary-hover);
            --color-secondary: var(--secondary-color);
            --color-bg-site: var(--bg-color);
            --font-site: var(--font-family);
        }
        body {
            font-family: var(--font-site);
            background-color: var(--color-bg-site);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen text-slate-800 transition-colors duration-300">

    <!-- Announcement Banner -->
    @if(($siteSettings['banner_active'] ?? '0') === '1')
        <div class="bg-secondary text-white py-2.5 px-4 text-center text-sm font-medium tracking-wide shadow-sm flex items-center justify-center gap-2">
            <span class="inline-flex items-center justify-center bg-white/20 text-white rounded-full p-1 w-5 h-5 text-xs animate-pulse">
                <i class="fa-solid fa-bullhorn"></i>
            </span>
            <span>{{ $siteSettings['banner_text'] ?? '' }}</span>
        </div>
    @endif

    <!-- Navbar Header -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/80 border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo / Brand Title -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('public.home') }}" class="flex items-center gap-2.5 group">
                        @if(!empty($siteSettings['site_logo']))
                            <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Logo" class="logo-custom transition-transform group-hover:scale-105">
                        @else
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-xl shadow-md shadow-primary/20 transition-transform group-hover:rotate-6">
                                {{ substr($siteSettings['site_title'] ?? 'WA', 0, 2) }}
                            </div>
                            <span class="font-extrabold text-2xl tracking-tight bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent group-hover:opacity-95 transition-opacity">
                                {{ $siteSettings['site_title'] ?? 'Web Artikel' }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Navigation links -->
                <nav class="hidden md:flex space-x-8 text-sm font-semibold tracking-wide">
                    <a href="{{ route('public.home') }}" class="px-1 py-2 border-b-2 {{ Request::routeIs('public.home') ? 'border-primary text-primary' : 'border-transparent text-slate-600 hover:text-primary hover:border-slate-300' }} transition-all">
                        Beranda
                    </a>
                    <a href="{{ route('public.articles') }}" class="px-1 py-2 border-b-2 {{ Request::routeIs('public.articles') || Request::is('artikel/*') ? 'border-primary text-primary' : 'border-transparent text-slate-600 hover:text-primary hover:border-slate-300' }} transition-all">
                        Artikel
                    </a>
                    <a href="{{ route('public.about') }}" class="px-1 py-2 border-b-2 {{ Request::routeIs('public.about') ? 'border-primary text-primary' : 'border-transparent text-slate-600 hover:text-primary hover:border-slate-300' }} transition-all">
                        Tentang
                    </a>
                </nav>

                <!-- Theme Toggle & Admin Access Button -->
                <div class="hidden md:flex items-center gap-4">
                    <button id="theme-toggle" type="button" class="p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 transition-all cursor-pointer" aria-label="Toggle Theme">
                        <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
                    </button>
                    @auth
                        <a href="{{ route('admin.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold shadow-md shadow-primary/20 hover:bg-primary-hover hover:shadow-lg hover:shadow-primary/30 transition-all">
                            <i class="fa-solid fa-chart-line"></i> Dashboard
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center gap-2">
                    <button id="theme-toggle-mobile" type="button" class="p-2 rounded-xl border border-slate-200 text-slate-600 cursor-pointer" aria-label="Toggle Theme">
                        <i id="theme-toggle-icon-mobile" class="fa-solid fa-moon"></i>
                    </button>
                    <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-600 hover:text-primary hover:bg-slate-50 focus:outline-none transition-all">
                        <i id="menu-icon" class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-b border-slate-100 bg-white/95 backdrop-blur-md">
            <div class="px-2 pt-2 pb-4 space-y-1 sm:px-3 text-base font-semibold">
                <a href="{{ route('public.home') }}" class="block px-4 py-3 rounded-xl {{ Request::routeIs('public.home') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }} transition-all">
                    <i class="fa-solid fa-house w-6 text-center"></i> Beranda
                </a>
                <a href="{{ route('public.articles') }}" class="block px-4 py-3 rounded-xl {{ Request::routeIs('public.articles') || Request::is('artikel/*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }} transition-all">
                    <i class="fa-solid fa-newspaper w-6 text-center"></i> Artikel
                </a>
                <a href="{{ route('public.about') }}" class="block px-4 py-3 rounded-xl {{ Request::routeIs('public.about') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }} transition-all">
                    <i class="fa-solid fa-circle-info w-6 text-center"></i> Tentang
                </a>
                @auth
                    <div class="border-t border-slate-100 my-2 pt-2">
                        <a href="{{ route('admin.index') }}" class="block px-4 py-3 rounded-xl bg-primary text-white text-center shadow-md transition-all">
                            <i class="fa-solid fa-chart-line mr-1"></i> Dashboard Admin
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-12">
                <!-- Branding section -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        @if(!empty($siteSettings['site_logo']))
                            <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Logo" class="logo-custom">
                        @else
                            <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-base shadow-md">
                                {{ substr($siteSettings['site_title'] ?? 'WA', 0, 2) }}
                            </div>
                            <span class="font-bold text-xl tracking-tight text-white">
                                {{ $siteSettings['site_title'] ?? 'Web Artikel' }}
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                        {{ $siteSettings['footer_text'] ?? 'Portal Informasi Artikel Terkini dan Terpercaya.' }}
                    </p>
                </div>

                <!-- Navigation link index -->
                <div class="space-y-4">
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('public.home') }}" class="hover:text-primary transition-colors">Beranda</a></li>
                        <li><a href="{{ route('public.articles') }}" class="hover:text-primary transition-colors">Semua Artikel</a></li>
                        <li><a href="{{ route('public.about') }}" class="hover:text-primary transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- Social media integration -->
                <div class="space-y-4">
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider">Sosial Media</h3>
                    <div class="flex gap-4">
                        @if(!empty($siteSettings['footer_instagram']))
                            <a href="{{ $siteSettings['footer_instagram'] }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-primary hover:text-white flex items-center justify-center text-lg transition-all" aria-label="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        @endif
                        @if(!empty($siteSettings['footer_tiktok']))
                            <a href="{{ $siteSettings['footer_tiktok'] }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-primary hover:text-white flex items-center justify-center text-lg transition-all" aria-label="TikTok">
                                <i class="fa-brands fa-tiktok"></i>
                            </a>
                        @endif
                        @if(!empty($siteSettings['footer_youtube']))
                            <a href="{{ $siteSettings['footer_youtube'] }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-primary hover:text-white flex items-center justify-center text-lg transition-all" aria-label="YouTube">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        @endif
                        
                        <!-- Custom links dynamically added by super admin if any -->
                        @foreach($siteSettings as $key => $value)
                            @if(str_starts_with($key, 'footer_custom_name_') && !empty($value))
                                @php 
                                    $index = substr($key, strlen('footer_custom_name_'));
                                    $customUrl = $siteSettings['footer_custom_url_' . $index] ?? '#';
                                    $customIcon = $siteSettings['footer_custom_icon_' . $index] ?? 'fa-solid fa-link';
                                @endphp
                                <a href="{{ $customUrl }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-primary hover:text-white flex items-center justify-center text-lg transition-all" aria-label="{{ $value }}">
                                    <i class="{{ $customIcon }}"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} {{ $siteSettings['site_title'] ?? 'Web Artikel' }}. All rights reserved.</p>
                <p>Created by Admin & Super Admin</p>
            </div>
        </div>
    </footer>

    <!-- Scripts for menu and theme toggles -->
    <script>
        // Mobile menu toggle
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            if (menu.classList.contains('hidden')) {
                icon.className = 'fa-solid fa-bars text-xl';
            } else {
                icon.className = 'fa-solid fa-xmark text-xl';
            }
        });

        // Dark Mode Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleBtnMobile = document.getElementById('theme-toggle-mobile');
        const themeIcon = document.getElementById('theme-toggle-icon');
        const themeIconMobile = document.getElementById('theme-toggle-icon-mobile');

        // Check local storage or media query
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.body.classList.add('dark');
            if(themeIcon) themeIcon.className = 'fa-solid fa-sun text-lg';
            if(themeIconMobile) themeIconMobile.className = 'fa-solid fa-sun text-lg';
        } else {
            document.body.classList.remove('dark');
            if(themeIcon) themeIcon.className = 'fa-solid fa-moon text-lg';
            if(themeIconMobile) themeIconMobile.className = 'fa-solid fa-moon text-lg';
        }

        function toggleTheme() {
            if (document.body.classList.contains('dark')) {
                document.body.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                if(themeIcon) themeIcon.className = 'fa-solid fa-moon text-lg';
                if(themeIconMobile) themeIconMobile.className = 'fa-solid fa-moon text-lg';
            } else {
                document.body.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                if(themeIcon) themeIcon.className = 'fa-solid fa-sun text-lg';
                if(themeIconMobile) themeIconMobile.className = 'fa-solid fa-sun text-lg';
            }
        }

        if(themeToggleBtn) themeToggleBtn.addEventListener('click', toggleTheme);
        if(themeToggleBtnMobile) themeToggleBtnMobile.addEventListener('click', toggleTheme);
    </script>
</body>
</html>
