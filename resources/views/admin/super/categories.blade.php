@extends('layouts.admin')

@section('title', 'Kategori Artikel')
@section('page_title', 'Kategori Artikel')

@section('content')
@php
    $editCat = null;
    if(request()->filled('edit')) {
        $editCat = $categories->where('id', request('edit'))->first();
    }
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <!-- Left Pane: Categories Table List -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-slate-200/60 rounded-3xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-extrabold text-base text-slate-900 tracking-tight">Daftar Kategori</h3>
                <p class="text-xs text-slate-400 mt-1">Mengelompokkan tulisan artikel berdasarkan topik.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-400 font-extrabold text-xs uppercase tracking-wider">
                            <th class="px-6 py-4">Nama Kategori</th>
                            <th class="px-6 py-4">Slug URL</th>
                            <th class="px-6 py-4 text-center">Jumlah Artikel</th>
                            <th class="px-6 py-4 text-right w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                        @if($categories->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center py-12 text-slate-400 font-medium">Belum ada kategori yang ditambahkan.</td>
                            </tr>
                        @else
                            @foreach($categories as $category)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $category->name }}</td>
                                    <td class="px-6 py-4 text-slate-500 font-mono text-xs">/{{ $category->slug }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">
                                            {{ $category->articles_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2.5">
                                            <a href="{{ route('admin.super.categories.index', ['edit' => $category->id]) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:text-primary hover:border-primary hover:bg-primary/5 transition-all" title="Edit Kategori">
                                                <i class="fa-solid fa-pen text-2xs"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.super.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua artikel yang terikat akan diubah kategorinya menjadi Kosong.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all cursor-pointer" title="Hapus Kategori">
                                                    <i class="fa-solid fa-trash-can text-2xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Pane: Add / Edit Category Form -->
    <div class="bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm sticky top-24 space-y-6">
        <div>
            <h3 class="font-extrabold text-base text-slate-900 tracking-tight">
                {{ $editCat ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
            </h3>
            <p class="text-xs text-slate-400 mt-1">
                {{ $editCat ? 'Mengubah nama dan slug url kategori artikel.' : 'Membuat kategori baru untuk pengelompokan artikel.' }}
            </p>
        </div>

        <form action="{{ $editCat ? route('admin.super.categories.update', $editCat->id) : route('admin.super.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            @if($editCat)
                @method('PUT')
            @endif

            <!-- Category Name -->
            <div class="space-y-1.5">
                <label for="name" class="text-xs font-bold text-slate-700">Nama Kategori</label>
                <input type="text" id="name" name="name" value="{{ old('name', $editCat->name ?? '') }}" required placeholder="Contoh: Otomotif, Gaya Hidup" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                @error('name')
                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="border-t border-slate-100 pt-4 flex gap-2 font-semibold text-xs justify-end">
                @if($editCat)
                    <a href="{{ route('admin.super.categories.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all">
                        Batal
                    </a>
                @endif
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary text-white hover:bg-primary-hover shadow-md transition-all cursor-pointer">
                    {{ $editCat ? 'Simpan Kategori' : 'Tambah Kategori' }}
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
