@extends('layouts.admin')

@section('title', 'Manajemen Pengguna Admin')
@section('page_title', 'Manajemen Pengguna Admin')

@section('content')
@php
    $editUser = null;
    if(request()->filled('edit')) {
        $editUser = $users->where('id', request('edit'))->first();
    }
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <!-- Left Pane: Users Table List -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-slate-200/60 rounded-3xl overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-extrabold text-base text-slate-900 tracking-tight">Daftar Akun Administrator</h3>
                <p class="text-xs text-slate-400 mt-1">Mengatur hak akses dan kredensial login admin.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-400 font-extrabold text-xs uppercase tracking-wider">
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">Username</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4 text-right w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-slate-500 font-mono text-xs">{{ $user->username }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-0.5 rounded-md text-3xs font-extrabold uppercase {{ $user->role === 'super_admin' ? 'bg-primary/10 text-primary' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $user->role === 'super_admin' ? 'Super Admin' : 'Admin Artikel' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 font-medium">{{ $user->email ?? '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2.5">
                                        <a href="{{ route('admin.super.users.index', ['edit' => $user->id]) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:text-primary hover:border-primary hover:bg-primary/5 transition-all" title="Edit Akun">
                                            <i class="fa-solid fa-pen text-2xs"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.super.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all cursor-pointer" title="Hapus Akun">
                                                <i class="fa-solid fa-trash-can text-2xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Pane: Add / Edit Context-aware Form -->
    <div class="bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm sticky top-24 space-y-6">
        <div>
            <h3 class="font-extrabold text-base text-slate-900 tracking-tight">
                {{ $editUser ? 'Edit Akun Admin' : 'Tambah Akun Admin Baru' }}
            </h3>
            <p class="text-xs text-slate-400 mt-1">
                {{ $editUser ? 'Mengubah detail atau password akun administrator.' : 'Membuat akun administrator baru untuk berkontribusi.' }}
            </p>
        </div>

        <form action="{{ $editUser ? route('admin.super.users.update', $editUser->id) : route('admin.super.users.store') }}" method="POST" class="space-y-4">
            @csrf
            @if($editUser)
                @method('PUT')
            @endif

            <!-- Full Name -->
            <div class="space-y-1.5">
                <label for="name" class="text-xs font-bold text-slate-700">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $editUser->name ?? '') }}" required placeholder="Nama lengkap admin" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                @error('name')
                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div class="space-y-1.5">
                <label for="username" class="text-xs font-bold text-slate-700">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username', $editUser->username ?? '') }}" required placeholder="Username untuk login" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm font-mono transition-all">
                @error('username')
                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (Optional) -->
            <div class="space-y-1.5">
                <label for="email" class="text-xs font-bold text-slate-700">Email (Opsional)</label>
                <input type="email" id="email" name="email" value="{{ old('email', $editUser->email ?? '') }}" placeholder="admin@example.com" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                @error('email')
                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role selection -->
            <div class="space-y-1.5">
                <label for="role" class="text-xs font-bold text-slate-700">Role Pengguna</label>
                <select id="role" name="role" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm bg-white cursor-pointer transition-all">
                    <option value="admin" {{ old('role', $editUser->role ?? '') === 'admin' ? 'selected' : '' }}>Admin Artikel (CRUD Artikel)</option>
                    <option value="super_admin" {{ old('role', $editUser->role ?? '') === 'super_admin' ? 'selected' : '' }}>Super Admin (Kontrol Penuh)</option>
                </select>
                @error('role')
                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="text-xs font-bold text-slate-700">Password</label>
                <input type="password" id="password" name="password" {{ $editUser ? '' : 'required' }} placeholder="{{ $editUser ? 'Biarkan kosong untuk mempertahankan password' : 'Maksimal 6 karakter atau lebih' }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-primary text-sm transition-all">
                @error('password')
                    <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="border-t border-slate-100 pt-4 flex gap-2 font-semibold text-xs justify-end">
                @if($editUser)
                    <a href="{{ route('admin.super.users.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all">
                        Batal
                    </a>
                @endif
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary text-white hover:bg-primary-hover shadow-md transition-all cursor-pointer">
                    {{ $editUser ? 'Simpan Perubahan' : 'Buat Akun' }}
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
