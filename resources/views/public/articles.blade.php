@extends('layouts.public')

@section('title', ($siteSettings['seo_meta_title'] ?? 'Portal Artikel') . ' - Daftar Artikel')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 py-16 text-white text-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Semua Artikel</h1>
        <p class="mt-3 text-slate-400 max-w-xl mx-auto text-sm sm:text-base">
            Temukan kumpulan gagasan, artikel edukatif, panduan, dan opini dari penulis terpercaya kami.
        </p>
    </div>
</section>

<!-- Main Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Search and Filter Panel -->
    <div class="flex flex-col lg:flex-row gap-8 items-start">
        
        <!-- Sidebar Filters (Desktop) -->
        <aside class="w-full lg:w-64 flex-shrink-0 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm sticky top-24">
            <!-- Search Form -->
            <form action="{{ route('public.articles') }}" method="GET" class="mb-6">
                @if(request()->filled('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <label for="search-input" class="sr-only">Cari Artikel</label>
                <div class="relative">
                    <input type="text" id="search-input" name="q" value="{{ request('q') }}" placeholder="Cari artikel..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                    <div class="absolute left-3.5 top-3.5 text-slate-400 text-sm">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
            </form>

            <!-- Categories Section -->
            <div>
                <h3 class="font-extrabold text-slate-950 text-sm uppercase tracking-wider mb-4">Kategori</h3>
                <div class="flex flex-wrap lg:flex-col gap-2">
                    <a href="{{ route('public.articles', request()->only(['q'])) }}" class="px-4 py-2 rounded-xl text-sm font-semibold flex items-center justify-between transition-all {{ !request()->filled('kategori') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                        <span><i class="fa-solid fa-border-all mr-2"></i> Semua</span>
                        <span class="inline-flex px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-xs font-semibold">
                            {{ \App\Models\Article::count() }}
                        </span>
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('public.articles', array_merge(request()->only(['q']), ['kategori' => $category->slug])) }}" class="px-4 py-2 rounded-xl text-sm font-semibold flex items-center justify-between transition-all {{ request('kategori') === $category->slug ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span class="truncate"><i class="fa-regular fa-folder mr-2"></i> {{ $category->name }}</span>
                            <span class="inline-flex px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-xs font-semibold">
                                {{ $category->articles_count }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- Articles Grid Container -->
        <div class="flex-grow w-full">
            <!-- Search status indicators -->
            @if(request()->filled('q') || request()->filled('kategori'))
                <div class="mb-8 p-4 bg-slate-50 rounded-2xl flex items-center justify-between text-sm text-slate-600">
                    <div>
                        Menampilkan hasil untuk: 
                        @if(request()->filled('q'))
                            Pencarian "<span class="font-bold text-slate-800">{{ request('q') }}</span>"
                        @endif
                        @if(request()->filled('kategori'))
                            @if(request()->filled('q')) dan @endif
                            Kategori "<span class="font-bold text-slate-800">{{ $categories->where('slug', request('kategori'))->first()->name ?? request('kategori') }}</span>"
                        @endif
                    </div>
                    <a href="{{ route('public.articles') }}" class="text-primary hover:underline font-semibold">
                        Reset Filter
                    </a>
                </div>
            @endif

            @if($articles->isEmpty())
                <div class="text-center py-20 bg-white border border-slate-100 rounded-3xl shadow-sm">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-400 text-2xl mb-4">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <p class="text-slate-500 font-medium text-lg">Tidak ada artikel yang cocok dengan kriteria pencarian Anda.</p>
                </div>
            @else
                <!-- Dynamic grid based on settings layout_columns -->
                <div class="grid gap-8 
                    @if(($siteSettings['layout_columns'] ?? '3') == '1')
                        grid-cols-1 max-w-2xl mx-auto
                    @elseif(($siteSettings['layout_columns'] ?? '3') == '2')
                        grid-cols-1 md:grid-cols-2
                    @elseif(($siteSettings['layout_columns'] ?? '4') == '4')
                        grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4
                    @else
                        grid-cols-1 md:grid-cols-2 lg:grid-cols-3
                    @endif
                ">
                    @foreach($articles as $article)
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

                            <!-- Body -->
                            <div class="flex-grow p-6 flex flex-col justify-between">
                                <div class="space-y-3">
                                    <span class="text-xs text-slate-400 font-medium flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar"></i> {{ $article->created_at->translatedFormat('d F Y') }}
                                    </span>
                                    <h3 class="text-lg font-bold text-slate-900 leading-snug hover:text-primary transition-colors line-clamp-2">
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

                <!-- Pagination links -->
                <div class="mt-12">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
