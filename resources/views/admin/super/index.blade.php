@extends('layouts.admin')

@section('title', 'Super Admin Dashboard')
@section('page_title', 'Ringkasan Sistem')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Articles Stats -->
        <div class="bg-white border border-slate-200/60 p-6 rounded-3xl shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 block">Total Artikel</span>
                <span class="text-2xl font-extrabold text-slate-800 block mt-0.5">{{ $stats['articles_count'] }}</span>
            </div>
        </div>

        <!-- Categories Stats -->
        <div class="bg-white border border-slate-200/60 p-6 rounded-3xl shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 block">Kategori</span>
                <span class="text-2xl font-extrabold text-slate-800 block mt-0.5">{{ $stats['categories_count'] }}</span>
            </div>
        </div>

        <!-- Admins Stats -->
        <div class="bg-white border border-slate-200/60 p-6 rounded-3xl shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-users-gear"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 block">Akun Admin</span>
                <span class="text-2xl font-extrabold text-slate-800 block mt-0.5">{{ $stats['admins_count'] }}</span>
            </div>
        </div>

        <!-- Logs Stats -->
        <div class="bg-white border border-slate-200/60 p-6 rounded-3xl shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 block">Log Aktivitas</span>
                <span class="text-2xl font-extrabold text-slate-800 block mt-0.5">{{ $stats['logs_count'] }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Logs & Articles Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Activity Logs -->
        <div class="bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="font-extrabold text-base text-slate-900 tracking-tight">Log Aktivitas Terbaru</h3>
                <a href="{{ route('admin.super.logs.index') }}" class="text-xs font-semibold text-primary hover:underline">Lihat Semua</a>
            </div>

            @if($recentLogs->isEmpty())
                <p class="text-sm text-slate-400 text-center py-6">Belum ada riwayat aktivitas.</p>
            @else
                <div class="relative pl-6 border-l border-slate-100 space-y-6">
                    @foreach($recentLogs as $log)
                        <div class="relative">
                            <!-- Bullet Indicator -->
                            <span class="absolute -left-[30px] top-1.5 w-2.5 h-2.5 rounded-full border-2 border-white bg-primary shadow-xs"></span>
                            
                            <div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-slate-700">
                                        {{ $log->user ? $log->user->name : 'System' }}
                                    </span>
                                    <span class="text-slate-400 font-medium">
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 mt-1">{{ $log->action }}</h4>
                                <p class="text-xs text-slate-500 mt-1 font-medium leading-relaxed">{{ $log->details }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Articles -->
        <div class="bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="font-extrabold text-base text-slate-900 tracking-tight">Artikel Terbit Terbaru</h3>
                <a href="{{ route('admin.artikel.index') }}" class="text-xs font-semibold text-primary hover:underline">Kelola Semua</a>
            </div>

            @if($recentArticles->isEmpty())
                <p class="text-sm text-slate-400 text-center py-6">Belum ada artikel diterbitkan.</p>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($recentArticles as $article)
                        <div class="py-4.5 first:pt-0 last:pb-0 flex items-center gap-4">
                            <!-- Image Cover -->
                            <div class="w-14 aspect-[16/10] rounded-lg overflow-hidden bg-slate-100 flex-shrink-0 border border-slate-100">
                                @if($article->image_path)
                                    <img src="{{ str_starts_with($article->image_path, 'http') ? $article->image_path : asset('storage/' . $article->image_path) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Title & Info -->
                            <div class="min-w-0 flex-grow">
                                <h4 class="font-bold text-slate-900 text-sm truncate hover:text-primary transition-colors">
                                    <a href="{{ route('public.article.detail', $article->slug) }}" target="_blank">{{ $article->title }}</a>
                                </h4>
                                <div class="flex items-center gap-2 text-2xs text-slate-400 mt-1 font-medium">
                                    <span>Oleh: <strong class="text-slate-500 font-semibold">{{ $article->publisher_name }}</strong></span>
                                    <span>&bull;</span>
                                    <span>{{ $article->created_at->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
