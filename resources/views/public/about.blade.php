@extends('layouts.public')

@section('title', 'Tentang Kami - ' . ($siteSettings['site_title'] ?? 'Portal Artikel'))

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 py-16 text-white text-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Tentang Kami</h1>
        <p class="mt-3 text-slate-400 max-w-xl mx-auto text-sm sm:text-base">
            Mengenal lebih dekat visi, sejarah, dan nilai-nilai yang kami usung.
        </p>
    </div>
</section>

<!-- Content Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Text Content -->
        <div class="space-y-6">
            <span class="inline-flex px-3 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">
                Profil Kami
            </span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Menyajikan Informasi yang Akurat, Edukatif, dan Menginspirasi
            </h2>
            <p class="text-slate-600 leading-relaxed">
                Kami adalah portal artikel independen yang berdedikasi untuk membagikan wawasan terbaru dan tepercaya kepada masyarakat umum. Kami percaya bahwa pengetahuan adalah kekuatan, dan akses terhadap informasi yang berkualitas harus mudah dijangkau oleh semua orang.
            </p>
            <p class="text-slate-600 leading-relaxed">
                Setiap artikel yang diterbitkan melalui platform kami melewati proses tinjauan internal oleh tim admin kami untuk memastikan konten yang disajikan memiliki nilai edukasi, keakuratan data, serta penyampaian yang mudah dipahami.
            </p>
            
            <!-- Core Pillars -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xl flex-shrink-0">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">Konten Akurat</h4>
                        <p class="text-sm text-slate-500 mt-1">Informasi yang kami bagikan berbasis data tepercaya.</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center text-xl flex-shrink-0">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">Pembaruan Cepat</h4>
                        <p class="text-sm text-slate-500 mt-1">Selalu menyajikan tren terhangat secara realtime.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visual Content / Card Mockup -->
        <div class="relative">
            <!-- Background shadow accent -->
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-tr from-primary to-secondary opacity-30 blur-lg"></div>
            
            <div class="relative bg-white border border-slate-100 rounded-3xl p-8 shadow-md space-y-6">
                <div class="h-44 w-full rounded-2xl bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-white">
                    <i class="fa-solid fa-graduation-cap text-6xl opacity-90 animate-bounce"></i>
                </div>
                
                <h3 class="text-xl font-bold text-slate-950">Sejarah Singkat</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Didirikan sebagai wadah berbagi bagi para penulis dan pemerhati isu-isu sosial, teknologi, serta kesehatan, platform ini terus berkembang menjadi portal rujukan ribuan pembaca setiap bulannya.
                </p>
                
                <div class="border-t border-slate-100 pt-6 flex justify-between items-center text-xs text-slate-400">
                    <span>Mulai Sejak 2026</span>
                    <span>10,000+ Pembaca Bulanan</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
