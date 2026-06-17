@extends('layouts.public')

@section('title', ($siteSettings['seo_meta_title'] ?? 'Portal Artikel') . ' - Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-b from-white to-slate-50 py-20 lg:py-28">
    <div class="absolute inset-0 z-0 opacity-40">
        <!-- Abstract grid/blob styling -->
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-primary/20 blur-3xl"></div>
        <div class="absolute top-60 -left-20 w-80 h-80 rounded-full bg-secondary/20 blur-3xl"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-semibold tracking-wider uppercase mb-6 animate-fade-in">
            <i class="fa-solid fa-star"></i> Info Terpercaya
        </span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight max-w-4xl mx-auto">
            {{ $siteSettings['hero_title'] ?? 'Temukan Wawasan & Inspirasi Terbaru di' }} <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">{{ $siteSettings['site_title'] ?? 'Web Artikel' }}</span>
        </h1>
        <p class="mt-6 text-lg sm:text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">
            {{ $siteSettings['hero_subtitle'] ?? 'Dapatkan akses instan ke artikel-artikel informatif yang ditulis oleh para admin terbaik kami mengenai teknologi, gaya hidup, kesehatan, dan banyak lagi.' }}
        </p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('public.articles') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-primary text-white text-base font-semibold shadow-lg shadow-primary/25 hover:bg-primary-hover hover:-translate-y-0.5 transition-all">
                Mulai Membaca <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="{{ route('public.about') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 hover:border-slate-300 hover:-translate-y-0.5 transition-all">
                Tentang Kami
            </a>
        </div>
    </div>
</section>

<!-- Recent Articles Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Artikel Terbaru</h2>
            <p class="mt-2 text-slate-500">Tulisan terbaru kami yang paling hangat dan penuh wawasan.</p>
        </div>
        <a href="{{ route('public.articles') }}" class="group mt-4 md:mt-0 inline-flex items-center gap-1.5 text-primary font-semibold hover:text-primary-hover transition-colors">
            Lihat Semua Artikel <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
        </a>
    </div>

    @if($recentArticles->isEmpty())
        <div class="text-center py-16 bg-white border border-slate-100 rounded-3xl shadow-sm">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-400 text-2xl mb-4">
                <i class="fa-regular fa-newspaper"></i>
            </div>
            <p class="text-slate-400 font-medium">Belum ada artikel yang dipublikasikan.</p>
        </div>
    @else
        <!-- Grid layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($recentArticles as $article)
                <article class="flex flex-col bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <!-- Thumbnail -->
                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                        @if($article->image_path)
                            <img src="{{ str_starts_with($article->image_path, 'http') ? $article->image_path : asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300 text-5xl">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif
                        
                        @if($article->category)
                            <span class="absolute top-4 left-4 inline-flex px-3 py-1.5 rounded-full bg-black/50 backdrop-blur-md text-white text-xs font-semibold tracking-wide">
                                {{ $article->category->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="flex-grow p-6 flex flex-col justify-between">
                        <div class="space-y-3">
                            <span class="text-xs text-slate-400 font-medium flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar"></i> {{ $article->created_at->translatedFormat('d F Y') }}
                            </span>
                            <h3 class="text-xl font-bold text-slate-900 leading-snug hover:text-primary transition-colors">
                                <a href="{{ route('public.article.detail', $article->slug) }}">{{ $article->title }}</a>
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed line-clamp-3">
                                {{ Str::limit($article->teaser, 150) }}
                            </p>
                        </div>
                        
                        <div class="border-t border-slate-100 mt-6 pt-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                    {{ substr($article->publisher_name, 0, 1) }}
                                </div>
                                <span class="text-xs font-semibold text-slate-700">{{ $article->publisher_name }}</span>
                            </div>
                            <a href="{{ route('public.article.detail', $article->slug) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 text-slate-600 hover:bg-primary hover:text-white transition-all">
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</section>
@endsection
