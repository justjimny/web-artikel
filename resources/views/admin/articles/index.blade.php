@extends('layouts.admin')

@section('title', 'Daftar Artikel')
@section('page_title', 'Daftar Artikel')

@section('content')
<div class="space-y-6">
    <!-- Action Cards -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white border border-slate-200/60 p-6 rounded-3xl shadow-sm">
        <div>
            <h3 class="font-extrabold text-lg text-slate-900 tracking-tight">Manajemen Artikel</h3>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Daftar semua artikel yang dipublikasikan di website.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.artikel.export') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 text-sm font-semibold transition-all">
                <i class="fa-solid fa-file-csv text-emerald-500"></i> Ekspor CSV
            </a>
            <a href="{{ route('admin.artikel.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold shadow-md shadow-primary/20 hover:bg-primary-hover hover:shadow-lg transition-all">
                <i class="fa-solid fa-plus"></i> Tambah Artikel Baru
            </a>
        </div>
    </div>

    <!-- Table Container -->
    @if($articles->isEmpty())
        <div class="text-center py-20 bg-white border border-slate-200/60 rounded-3xl shadow-sm">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-400 text-2xl mb-4">
                <i class="fa-regular fa-newspaper"></i>
            </div>
            <h4 class="font-bold text-slate-700">Belum Ada Artikel</h4>
            <p class="text-sm text-slate-400 mt-1.5 max-w-xs mx-auto">Silakan buat artikel pertama Anda dengan menekan tombol Tambah Artikel Baru.</p>
        </div>
    @else
        <div class="bg-white border border-slate-200/60 rounded-3xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-400 font-extrabold text-xs uppercase tracking-wider">
                            <th class="px-6 py-4.5 w-24">Cover</th>
                            <th class="px-6 py-4.5">Judul Artikel</th>
                            <th class="px-6 py-4.5">Kategori</th>
                            <th class="px-6 py-4.5">Publisher</th>
                            @if(auth()->user()->role === 'super_admin')
                                <th class="px-6 py-4.5">Akun Penulis</th>
                            @endif
                            <th class="px-6 py-4.5">Tanggal</th>
                            <th class="px-6 py-4.5 text-right w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                        @foreach($articles as $article)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <!-- Image Cover -->
                                <td class="px-6 py-4.5">
                                    <div class="w-14 aspect-[16/10] rounded-lg overflow-hidden bg-slate-100 shadow-2xs border border-slate-100 flex-shrink-0">
                                        @if($article->image_path)
                                            <img src="{{ str_starts_with($article->image_path, 'http') ? $article->image_path : asset('storage/' . $article->image_path) }}" alt="Thumbnail" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i class="fa-solid fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                
                                <!-- Title -->
                                <td class="px-6 py-4.5">
                                    <div class="max-w-md">
                                        <a href="{{ route('public.article.detail', $article->slug) }}" target="_blank" class="text-slate-900 hover:text-primary transition-colors font-bold line-clamp-2">
                                            {{ $article->title }}
                                        </a>
                                        <span class="text-2xs text-slate-400 font-medium font-mono block mt-1">slug: /{{ $article->slug }}</span>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td class="px-6 py-4.5">
                                    @if($article->category)
                                        <span class="inline-flex px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">
                                            {{ $article->category->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Publisher -->
                                <td class="px-6 py-4.5 font-bold text-slate-800">
                                    {{ $article->publisher_name }}
                                </td>

                                <!-- Author Account (Super Admin only) -->
                                @if(auth()->user()->role === 'super_admin')
                                    <td class="px-6 py-4.5">
                                        <div class="flex items-center gap-1.5">
                                            <span class="inline-flex px-2 py-0.5 rounded bg-primary/10 text-primary text-3xs font-extrabold uppercase">
                                                {{ $article->user->role }}
                                            </span>
                                            <span class="text-xs text-slate-500 font-semibold">{{ $article->user->name }}</span>
                                        </div>
                                    </td>
                                @endif

                                <!-- Date -->
                                <td class="px-6 py-4.5 text-xs text-slate-400 font-medium">
                                    {{ $article->created_at->format('d/m/Y') }}
                                    <span class="block text-3xs mt-0.5 text-slate-300 font-normal">{{ $article->created_at->format('H:i') }} WIB</span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4.5 text-right">
                                    <div class="flex justify-end gap-2.5">
                                        <a href="{{ route('admin.artikel.edit', $article->id) }}" class="inline-flex items-center justify-center w-8.5 h-8.5 rounded-xl border border-slate-200 text-slate-500 hover:text-primary hover:border-primary hover:bg-primary/5 transition-all" title="Edit Artikel">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.artikel.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-8.5 h-8.5 rounded-xl border border-slate-200 text-slate-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all cursor-pointer" title="Hapus Artikel">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Footer -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $articles->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
