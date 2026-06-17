<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - {{ $siteSettings['site_title'] ?? 'Portal Artikel' }}</title>
    
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
            --bg-color: #f1f5f9;
            --font-family: 'Instrument Sans', sans-serif;
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
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">

    <div class="w-full max-w-md">
        <!-- Back to Home -->
        <a href="{{ route('public.home') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-primary mb-6 transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Website
        </a>

        <!-- Login Card -->
        <div class="bg-white border border-slate-200/60 rounded-3xl p-8 shadow-xl shadow-slate-200/80">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-primary to-emerald-400 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-primary/25 mx-auto mb-4">
                    {{ substr($siteSettings['site_title'] ?? 'WA', 0, 2) }}
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Login Administrator</h1>
                <p class="text-sm text-slate-400 mt-2">Masuk untuk mengelola artikel dan tampilan website.</p>
            </div>

            <!-- Error Messages -->
            @if(session('error'))
                <div class="mb-5 p-4 bg-red-50 border border-red-100 rounded-2xl text-xs sm:text-sm text-red-600 flex items-start gap-2.5 animate-shake">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @if(session('success'))
                <div class="mb-5 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-xs sm:text-sm text-emerald-600 flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check mt-0.5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Username -->
                <div class="space-y-2">
                    <label for="username" class="text-sm font-bold text-slate-700">Username</label>
                    <div class="relative">
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required placeholder="Masukkan username Anda" class="w-full pl-10 pr-4 py-3 rounded-xl border @error('username') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-primary @enderror focus:outline-none text-sm transition-all">
                        <div class="absolute left-3.5 top-3.5 text-slate-400 text-sm">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    @error('username')
                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label for="password" class="text-sm font-bold text-slate-700">Password</label>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="Masukkan password Anda" class="w-full pl-10 pr-10 py-3 rounded-xl border @error('password') border-red-300 focus:border-red-500 @else border-slate-200 focus:border-primary @enderror focus:outline-none text-sm transition-all">
                        <div class="absolute left-3.5 top-3.5 text-slate-400 text-sm">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <button type="button" id="toggle-password" class="absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-600 text-sm">
                            <i id="password-icon" class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4.5 h-4.5 text-primary rounded border-slate-300 focus:ring-primary/20 accent-primary cursor-pointer">
                    <label for="remember" class="text-xs sm:text-sm text-slate-500 ml-2 select-none cursor-pointer">Ingat saya di perangkat ini</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 rounded-xl bg-primary text-white font-bold text-sm shadow-lg shadow-primary/20 hover:bg-primary-hover transition-all">
                    Masuk Sekarang <i class="fa-solid fa-arrow-right-to-bracket ml-1.5"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Password visibility toggle script -->
    <script>
        const passwordField = document.getElementById('password');
        const toggleBtn = document.getElementById('toggle-password');
        const icon = document.getElementById('password-icon');

        toggleBtn.addEventListener('click', () => {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            if (type === 'text') {
                icon.className = 'fa-solid fa-eye';
            } else {
                icon.className = 'fa-solid fa-eye-slash';
            }
        });
    </script>
</body>
</html>
