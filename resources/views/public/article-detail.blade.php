@extends('layouts.public')

@section('title', $article->title . ' - ' . ($siteSettings['site_title'] ?? 'Portal Artikel'))
@section('meta_description', Str::limit($article->teaser, 150))

@section('content')
<article class="py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Back Button -->
        <a href="{{ route('public.articles') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-primary mb-8 transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Artikel
        </a>

        <!-- Header -->
        <header class="space-y-4 mb-8">
            @if($article->category)
                <span class="inline-flex px-3 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-semibold tracking-wide">
                    {{ $article->category->name }}
                </span>
            @endif

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 leading-tight">
                {{ $article->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-6 text-sm text-slate-500 pt-2 border-b border-slate-100 pb-6">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                        {{ substr($article->publisher_name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 leading-none">{{ $article->publisher_name }}</p>
                        <p class="text-xs text-slate-400 mt-1">Publisher</p>
                    </div>
                </div>

                <span class="hidden sm:inline w-1.5 h-1.5 rounded-full bg-slate-300"></span>

                <div class="flex items-center gap-1.5">
                    <i class="fa-regular fa-calendar"></i>
                    <span>Diterbitkan {{ $article->created_at->translatedFormat('d F Y \P\u\k\u\l H:i') }}</span>
                </div>
            </div>
        </header>

        <!-- Cover Image -->
        <div class="aspect-[16/9] w-full rounded-3xl overflow-hidden bg-slate-100 shadow-md mb-12">
            @if($article->image_path)
                <img src="{{ str_starts_with($article->image_path, 'http') ? $article->image_path : asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-slate-300 text-7xl">
                    <i class="fa-solid fa-image"></i>
                </div>
            @endif
        </div>

        @php
            $content = $article->content;
            // Clean HTML content (remove &nbsp; and extra spaces)
            $content = str_replace('&nbsp;', ' ', $content);
            $content = preg_replace('/\s+/', ' ', $content);

            $isJson = false;
            if (str_starts_with(trim($content), '{')) {
                $decoded = json_decode($content, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($decoded['blocks'])) {
                    $isJson = true;
                    $blocks = $decoded['blocks'];
                }
            }
        @endphp

        <!-- Article Content -->
        <div class="prose prose-slate prose-lg max-w-none leading-relaxed text-slate-700 space-y-6 text-base sm:text-lg">
            @if($isJson)
                @foreach($blocks as $block)
                    @if($block['type'] === 'paragraph' && isset($block['data']['text']))
                        <p>{!! $block['data']['text'] !!}</p>
                    @elseif($block['type'] === 'header' && isset($block['data']['text']))
                        @php
                            $level = $block['data']['level'] ?? 2;
                        @endphp
                        <h{{ $level }} class="font-extrabold text-slate-900 mt-8 mb-4 tracking-tight leading-snug">{!! $block['data']['text'] !!}</h{{ $level }}>
                    @elseif($block['type'] === 'list' && isset($block['data']['items']))
                        @if(($block['data']['style'] ?? 'unordered') === 'ordered')
                            <ol class="list-decimal pl-6 my-4 space-y-2">
                                @foreach($block['data']['items'] as $item)
                                    <li>{!! $item !!}</li>
                                @endforeach
                            </ol>
                        @else
                            <ul class="list-disc pl-6 my-4 space-y-2">
                                @foreach($block['data']['items'] as $item)
                                    <li>{!! $item !!}</li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                @endforeach
            @elseif(strip_tags($content) !== $content)
                {!! $content !!}
            @else
                {!! nl2br(e($content)) !!}
            @endif
        </div>

        <!-- Author / Share Footer -->
        <div class="border-t border-slate-100 mt-16 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2.5">
                <span class="text-sm text-slate-400 font-medium">Diunggah oleh:</span>
                <span class="text-sm font-semibold text-slate-700 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                    <i class="fa-solid fa-user-shield text-primary mr-1.5"></i>{{ $article->user->name }}
                </span>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-400 font-medium">Bagikan:</span>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" class="w-9 h-9 rounded-xl bg-green-50 hover:bg-green-500 hover:text-white flex items-center justify-center text-green-600 transition-all">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="https://facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-xl bg-blue-50 hover:bg-blue-600 hover:text-white flex items-center justify-center text-blue-600 transition-all">
                    <i class="fa-brands fa-facebook-f text-sm"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-xl bg-sky-50 hover:bg-sky-500 hover:text-white flex items-center justify-center text-sky-600 transition-all">
                    <i class="fa-brands fa-x-twitter text-sm"></i>
                </a>
            </div>
        </div>

    </div>
</article>

<!-- Related Articles Section -->
@if($relatedArticles->isNotEmpty())
    <section class="bg-slate-50 border-t border-slate-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight mb-8">Artikel Terkait</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedArticles as $related)
                    <article class="flex flex-col bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                            @if($related->image_path)
                                <img src="{{ str_starts_with($related->image_path, 'http') ? $related->image_path : asset('storage/' . $related->image_path) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 text-3xl">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <h3 class="font-bold text-slate-900 leading-snug line-clamp-2 hover:text-primary transition-colors">
                                <a href="{{ route('public.article.detail', $related->slug) }}">{{ $related->title }}</a>
                            </h3>
                            <div class="mt-4 flex items-center justify-between text-xs text-slate-400">
                                <span>{{ $related->created_at->translatedFormat('d M Y') }}</span>
                                <span class="font-semibold text-slate-600">{{ $related->publisher_name }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
