<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - {{ $siteSettings['site_title'] ?? 'Portal Artikel' }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@php
    $primaryColor = $siteSettings['primary_color'] ?? '#2563eb';
    
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
    
    // Parse RGB to allow custom alpha channel in CSS variables
    $hex = str_replace('#', '', $primaryColor);
    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else if (strlen($hex) == 6) {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    } else {
        $r = 37; $g = 99; $b = 235;
    }
    
    $primaryContrast = $getContrastColor($primaryColor);
    $textPrimary = $getReadableTextColor($primaryColor);
@endphp

    <!-- CSS Variables for Dynamic Customization -->
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --primary-color-rgb: {{ $r }}, {{ $g }}, {{ $b }};
            --primary-hover: {{ $primaryHover }};
            --primary-contrast: {{ $primaryContrast }};
            --text-primary: {{ $textPrimary }};
            --bg-color: #f8fafc;
            --font-family: 'Instrument Sans', sans-serif;

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
        .bg-primary\/10 {
            background-color: rgba(var(--primary-color-rgb), 0.1) !important;
        }
        .bg-primary\/5 {
            background-color: rgba(var(--primary-color-rgb), 0.05) !important;
        }
        .hover\:bg-primary\/5:hover {
            background-color: rgba(var(--primary-color-rgb), 0.05) !important;
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
    </style>

    <!-- Tailwind CSS v4 Browser Engine -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <!-- Configure Tailwind v4 Theme Variables -->
    <style type="tailwindcss">
        @theme {
            --color-primary: var(--primary-color);
            --color-primary-hover: var(--primary-hover);
            --font-site: var(--font-family);
        }
        body {
            font-family: var(--font-site);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex min-h-screen">

    <!-- Sidebar Wrapper -->
    <aside class="hidden lg:flex flex-col w-64 border-r border-slate-200 bg-white sticky top-0 h-screen flex-shrink-0 z-40">
        <!-- Sidebar Brand Title -->
        <div class="h-20 flex items-center px-6 border-b border-slate-100">
            <a href="{{ route('public.home') }}" class="flex items-center gap-2.5 group" target="_blank">
                @if(!empty($siteSettings['site_logo']))
                    <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Logo" class="logo-custom">
                @else
                    <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-primary to-emerald-400 flex items-center justify-center text-white font-bold text-base shadow-md">
                        {{ substr($siteSettings['site_title'] ?? 'WA', 0, 2) }}
                    </div>
                    <span class="font-bold text-lg tracking-tight text-slate-900 truncate">
                        {{ $siteSettings['site_title'] ?? 'Web Artikel' }}
                    </span>
                @endif
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity ml-1.5"></i>
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-grow p-4 space-y-7 overflow-y-auto text-sm font-semibold tracking-wide">
            
            <!-- Super Admin Section -->
            @if(auth()->user()->role === 'super_admin')
                <div class="space-y-1.5">
                    <span class="px-3 text-2xs uppercase tracking-widest text-slate-400 font-extrabold block mb-2">Super Admin</span>
                    <a href="{{ route('admin.super.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::routeIs('admin.super.index') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-chart-line w-5 text-center"></i> Analitik & Ringkasan
                    </a>
                    <a href="{{ route('admin.super.settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::routeIs('admin.super.settings') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-sliders w-5 text-center"></i> Pengaturan Website
                    </a>
                    <a href="{{ route('admin.super.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::routeIs('admin.super.users.index') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-users-gear w-5 text-center"></i> Manajemen Admin
                    </a>
                    <a href="{{ route('admin.super.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::routeIs('admin.super.categories.index') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-tags w-5 text-center"></i> Kategori Artikel
                    </a>
                    <a href="{{ route('admin.super.logs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::routeIs('admin.super.logs.index') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i> Log Aktivitas
                    </a>
                </div>
            @endif

            <!-- Admin Artikel Section -->
            <div class="space-y-1.5">
                <span class="px-3 text-2xs uppercase tracking-widest text-slate-400 font-extrabold block mb-2">Manajemen Konten</span>
                <a href="{{ route('admin.artikel.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::routeIs('admin.artikel.index') || Request::is('admin/artikel/*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                    <i class="fa-regular fa-newspaper w-5 text-center"></i> Kelola Artikel
                </a>
                <a href="{{ route('admin.artikel.export') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 transition-all">
                    <i class="fa-solid fa-file-csv w-5 text-center"></i> Ekspor Artikel (CSV)
                </a>
            </div>
        </nav>

        <!-- Sidebar User Footer Card -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <div class="flex items-center justify-between mb-4">
                <div class="truncate">
                    <h5 class="font-bold text-slate-800 text-sm truncate leading-tight">{{ auth()->user()->name }}</h5>
                    <span class="inline-flex px-2 py-0.5 rounded-md bg-primary/10 text-primary text-3xs font-extrabold uppercase mt-1">
                        {{ auth()->user()->role === 'super_admin' ? 'Super Admin' : 'Admin Artikel' }}
                    </span>
                </div>
            </div>
            
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-red-600 hover:border-red-200 hover:bg-red-50 text-xs font-bold transition-all cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Container -->
    <div class="flex-grow flex flex-col min-w-0 min-h-screen">
        <!-- Dashboard Top Header (Mobile & Topbar) -->
        <header class="h-20 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <!-- Mobile sidebar toggler -->
                <button id="sidebar-toggle" type="button" class="lg:hidden p-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 cursor-pointer">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">@yield('page_title', 'Dashboard')</h2>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('public.home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:text-primary hover:border-primary text-xs font-bold transition-all">
                    <i class="fa-solid fa-globe"></i> Kunjungi Website
                </a>
            </div>
        </header>

        <!-- Mobile Drawer Navigation -->
        <div id="mobile-sidebar" class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs lg:hidden transition-all duration-300">
            <div class="w-64 bg-white h-screen flex flex-col shadow-2xl relative animate-slide-in">
                <!-- Close Button -->
                <button id="close-sidebar" class="absolute top-6 right-6 text-slate-500 hover:text-slate-800 text-lg cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                
                <div class="h-20 flex items-center px-6 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        @if(!empty($siteSettings['site_logo']))
                            <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Logo" class="logo-custom">
                        @else
                            <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-primary to-emerald-400 flex items-center justify-center text-white font-bold text-base shadow-md">
                                {{ substr($siteSettings['site_title'] ?? 'WA', 0, 2) }}
                            </div>
                            <span class="font-bold text-base text-slate-900 truncate">
                                {{ $siteSettings['site_title'] ?? 'Web Artikel' }}
                            </span>
                        @endif
                    </div>
                </div>

                <nav class="flex-grow p-4 space-y-6 overflow-y-auto text-sm font-semibold tracking-wide">
                    @if(auth()->user()->role === 'super_admin')
                        <div class="space-y-1">
                            <span class="px-3 text-3xs uppercase tracking-widest text-slate-400 font-extrabold block mb-1">Super Admin</span>
                            <a href="{{ route('admin.super.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ Request::routeIs('admin.super.index') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-chart-line w-5 text-center"></i> Analitik & Ringkasan
                            </a>
                            <a href="{{ route('admin.super.settings') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ Request::routeIs('admin.super.settings') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-sliders w-5 text-center"></i> Pengaturan Website
                            </a>
                            <a href="{{ route('admin.super.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ Request::routeIs('admin.super.users.index') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-users-gear w-5 text-center"></i> Manajemen Admin
                            </a>
                            <a href="{{ route('admin.super.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ Request::routeIs('admin.super.categories.index') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-tags w-5 text-center"></i> Kategori Artikel
                            </a>
                            <a href="{{ route('admin.super.logs.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ Request::routeIs('admin.super.logs.index') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i> Log Aktivitas
                            </a>
                        </div>
                    @endif

                    <div class="space-y-1">
                        <span class="px-3 text-3xs uppercase tracking-widest text-slate-400 font-extrabold block mb-1">Manajemen Konten</span>
                        <a href="{{ route('admin.artikel.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ Request::routeIs('admin.artikel.index') || Request::is('admin/artikel/*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                            <i class="fa-regular fa-newspaper w-5 text-center"></i> Kelola Artikel
                        </a>
                        <a href="{{ route('admin.artikel.export') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-50">
                            <i class="fa-solid fa-file-csv w-5 text-center"></i> Ekspor Artikel (CSV)
                        </a>
                    </div>
                </nav>

                <div class="p-4 border-t border-slate-100 bg-slate-50">
                    <h5 class="font-bold text-slate-800 text-sm truncate leading-tight">{{ auth()->user()->name }}</h5>
                    <span class="inline-flex px-2 py-0.5 rounded-md bg-primary/10 text-primary text-3xs font-extrabold uppercase mt-1 mb-4">
                        {{ auth()->user()->role === 'super_admin' ? 'Super Admin' : 'Admin Artikel' }}
                    </span>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-red-600 hover:border-red-200 hover:bg-red-50 text-xs font-bold transition-all cursor-pointer">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Frame -->
        <main class="flex-grow p-6 sm:p-8 overflow-y-auto">
            <!-- Toast Notifications -->
            @if(session('success'))
                <div id="toast-success" class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-between text-sm shadow-sm transition-all duration-300">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="document.getElementById('toast-success').style.display='none'" class="text-emerald-500 hover:text-emerald-800 cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div id="toast-error" class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl flex items-center justify-between text-sm shadow-sm transition-all duration-300">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-exclamation text-base text-red-500"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="document.getElementById('toast-error').style.display='none'" class="text-red-500 hover:text-red-800 cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Mobile Drawer Side toggler script -->
    <script>
        const sidebar = document.getElementById('mobile-sidebar');
        const openBtn = document.getElementById('sidebar-toggle');
        const closeBtn = document.getElementById('close-sidebar');

        openBtn.addEventListener('click', () => {
            sidebar.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.add('hidden');
        });

        // Close when clicking outside drawer
        sidebar.addEventListener('click', (e) => {
            if (e.target === sidebar) {
                sidebar.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
