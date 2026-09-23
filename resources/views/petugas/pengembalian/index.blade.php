@extends('layouts.app')
@section('title', 'Pengembalian Buku')
@section('page-title', 'Pengembalian Buku')

@section('content')
<div class="space-y-5">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([['Pengembalian Hari Ini',$stats['hari_ini'],'fa-calendar-day','blue'],['Bulan Ini',$stats['bulan_ini'],'fa-calendar','indigo'],['Terlambat',$stats['terlambat'],'fa-triangle-exclamation','red'],['Selesai Hari Ini',$stats['selesai'],'fa-circle-check','green']] as $s)
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-{{ $s[3] }}-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa {{ $s[2] }} text-{{ $s[3] }}-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $s[1] }}</p>
                <p class="text-xs text-gray-500">{{ $s[0] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-gray-900">Pengembalian Buku</h2>
                <p class="text-xs text-gray-500">Kelola proses pengembalian buku dan catat keterlambatan (jika ada).</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('petugas.pengembalian.riwayat') }}" class="inline-flex items-center gap-1.5 border border-blue-600 text-blue-600 text-sm font-semibold px-4 py-2 rounded-xl hover:bg-blue-50 transition">
                    <i class="fa fa-clock-rotate-left"></i> Riwayat
                </a>
                <a href="{{ route('petugas.pengembalian.proses') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                    <i class="fa fa-rotate-left"></i> Proses Pengembalian
                </a>
            </div>
        </div>

        <div class="px-5 py-3 border-b border-gray-100">
            <form method="GET" class="flex flex-wrap gap-3">
                <div class="flex-1 min-w-48">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari anggota atau buku..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm hover:bg-blue-700 transition">Cari</button>
                <a href="{{ route('petugas.pengembalian.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm hover:bg-gray-200 transition">Reset</a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-5 py-3 font-medium">ID Peminjaman</th>
                        <th class="px-5 py-3 font-medium">Anggota</th>
                        <th class="px-5 py-3 font-medium">Buku</th>
                        <th class="px-5 py-3 font-medium">Tgl Pinjam</th>
                        <th class="px-5 py-3 font-medium">Jatuh Tempo</th>
                        <th class="px-5 py-3 font-medium">Terlambat</th>
                        <th class="px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjamans as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-mono text-xs text-gray-600">{{ $p->kode_transaksi }}</td>
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-900">{{ $p->anggota->user->name ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $p->anggota->no_anggota ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3 text-gray-700">{{ $p->bukus->first()?->judul ?? '-' }}
                            @if($p->bukus->count() > 1)<span class="text-xs text-gray-400"> +{{ $p->bukus->count()-1 }}</span>@endif
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                        <td class="px-5 py-3 {{ $p->status==='terlambat' ? 'text-red-600 font-semibold' : 'text-gray-600' }}">{{ $p->tanggal_jatuh_tempo->format('d M Y') }}</td>
                        <td class="px-5 py-3">
                            @if($p->status === 'terlambat')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">{{ $p->hari_terlambat }} hari</span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <a href="{{ route('petugas.pengembalian.proses', ['peminjaman_id' => $p->id]) }}"
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition">
                                <i class="fa fa-rotate-left"></i> Kembalikan
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400">Tidak ada buku yang harus dikembalikan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>Menampilkan {{ $peminjamans->firstItem() ?? 0 }}-{{ $peminjamans->lastItem() ?? 0 }} dari {{ $peminjamans->total() }} data</span>
            {{ $peminjamans->links() }}
        </div>
    </div>
</div>
@endsection
