@extends('layouts.public')

@section('title', ($siteSettings['about_header_title'] ?? 'Tentang Kami') . ' - ' . ($siteSettings['site_title'] ?? 'Portal Artikel'))

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 py-16 text-white text-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $siteSettings['about_header_title'] ?? 'Tentang Kami' }}</h1>
        <p class="mt-3 text-slate-400 max-w-xl mx-auto text-sm sm:text-base">
            {{ $siteSettings['about_header_subtitle'] ?? 'Mengenal lebih dekat visi, sejarah, dan nilai-nilai yang kami usung.' }}
        </p>
    </div>
</section>

<!-- Content Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Text Content -->
        <div class="space-y-6">
            <span class="inline-flex px-3 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">
                {{ $siteSettings['about_section_badge'] ?? 'Profil Kami' }}
            </span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                {{ $siteSettings['about_section_main_heading'] ?? 'Menyajikan Informasi yang Akurat, Edukatif, dan Menginspirasi' }}
            </h2>
            <p class="text-slate-600 leading-relaxed">
                {{ $siteSettings['about_paragraph_1'] ?? 'Kami adalah portal artikel independen yang berdedikasi untuk membagikan wawasan terbaru dan tepercaya kepada masyarakat umum. Kami percaya bahwa pengetahuan adalah kekuatan, dan akses terhadap informasi yang berkualitas harus mudah dijangkau oleh semua orang.' }}
            </p>
            <p class="text-slate-600 leading-relaxed">
                {{ $siteSettings['about_paragraph_2'] ?? 'Setiap artikel yang diterbitkan melalui platform kami melewati proses tinjauan internal oleh tim admin kami untuk memastikan konten yang disajikan memiliki nilai edukasi, keakuratan data, serta penyampaian yang mudah dipahami.' }}
            </p>

            <!-- Core Pillars -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xl flex-shrink-0">
                        <i class="{{ $siteSettings['about_pillar_1_icon'] ?? 'fa-solid fa-circle-check' }}"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">{{ $siteSettings['about_pillar_1_title'] ?? 'Konten Akurat' }}</h4>
                        <p class="text-sm text-slate-500 mt-1">{{ $siteSettings['about_pillar_1_description'] ?? 'Informasi yang kami bagikan berbasis data tepercaya.' }}</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center text-xl flex-shrink-0">
                        <i class="{{ $siteSettings['about_pillar_2_icon'] ?? 'fa-solid fa-bolt' }}"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">{{ $siteSettings['about_pillar_2_title'] ?? 'Pembaruan Cepat' }}</h4>
                        <p class="text-sm text-slate-500 mt-1">{{ $siteSettings['about_pillar_2_description'] ?? 'Selalu menyajikan tren terhangat secara realtime.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visual Content / Card Mockup -->
        <div class="relative">
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-tr from-primary to-secondary opacity-30 blur-lg"></div>
            <div class="relative bg-white border border-slate-100 rounded-3xl p-8 shadow-md space-y-6">
                <div class="rounded-3xl overflow-hidden bg-slate-100 mb-5">
                    <img id="about-page-card-image" src="{{ !empty($siteSettings['about_card_image']) ? asset('storage/' . $siteSettings['about_card_image']) : '' }}" alt="Ilustrasi Tentang" class="w-full object-cover {{ empty($siteSettings['about_card_image']) ? 'hidden' : '' }}" style="max-height:240px;">
                    <div id="about-page-card-icon" class="flex items-center justify-center h-44 text-primary text-6xl {{ !empty($siteSettings['about_card_image']) ? 'hidden' : 'block' }}">
                        <i class="{{ $siteSettings['about_card_icon'] ?? 'fa-solid fa-graduation-cap' }}"></i>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-slate-950">{{ $siteSettings['about_card_title'] ?? 'Sejarah Singkat' }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    {{ $siteSettings['about_card_description'] ?? 'Didirikan sebagai wadah berbagi bagi para penulis dan pemerhati isu-isu sosial, teknologi, serta kesehatan, platform ini terus berkembang menjadi portal rujukan ribuan pembaca setiap bulannya.' }}
                </p>

                <div class="border-t border-slate-100 pt-6 grid grid-cols-2 gap-4 text-sm text-slate-500">
                    <div class="rounded-2xl bg-slate-50 p-4 text-center">
                        <span class="font-bold text-slate-900">{{ $siteSettings['about_card_stat_1'] ?? 'Mulai Sejak 2026' }}</span>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 text-center">
                        <span class="font-bold text-slate-900">{{ $siteSettings['about_card_stat_2'] ?? '10,000+ Pembaca Bulanan' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
