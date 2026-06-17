@extends('layouts.admin')

@section('title', 'Log Aktivitas Admin')
@section('page_title', 'Log Aktivitas Admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white border border-slate-200/60 rounded-3xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-extrabold text-base text-slate-900 tracking-tight">Audit Trail / Log Aktivitas</h3>
            <p class="text-xs text-slate-400 mt-1">Daftar riwayat lengkap tindakan administratif yang dilakukan oleh seluruh admin.</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-400 font-extrabold text-xs uppercase tracking-wider">
                        <th class="px-6 py-4.5 w-16">ID</th>
                        <th class="px-6 py-4.5 w-48">Tanggal & Waktu</th>
                        <th class="px-6 py-4.5 w-44">Pengguna</th>
                        <th class="px-6 py-4.5 w-40">Tindakan</th>
                        <th class="px-6 py-4.5">Detail Aktivitas</th>
                        <th class="px-6 py-4.5 w-32">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                    @if($logs->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400 font-medium">Belum ada riwayat aktivitas yang tercatat.</td>
                        </tr>
                    @else
                        @foreach($logs as $log)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-xs font-mono text-slate-400">#{{ $log->id }}</td>
                                <td class="px-6 py-4 text-xs text-slate-500 font-medium">
                                    {{ $log->created_at->format('d M Y - H:i:s') }} WIB
                                </td>
                                <td class="px-6 py-4">
                                    @if($log->user)
                                        <div class="flex items-center gap-1.5">
                                            <span class="inline-flex px-1.5 py-0.5 rounded text-4xs font-extrabold uppercase {{ $log->user->role === 'super_admin' ? 'bg-primary/10 text-primary' : 'bg-slate-100 text-slate-600' }}">
                                                {{ $log->user->role === 'super_admin' ? 'SA' : 'AD' }}
                                            </span>
                                            <span class="text-xs text-slate-800">{{ $log->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-slate-400 text-xs italic">System</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-50 border border-slate-100 text-slate-700">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 text-xs sm:text-sm font-medium leading-relaxed">
                                    {{ $log->details ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-xs font-mono text-slate-400">
                                    {{ $log->ip_address ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
