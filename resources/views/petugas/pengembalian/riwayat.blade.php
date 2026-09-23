@extends('layouts.app')
@section('title', 'Riwayat Pengembalian')
@section('page-title', 'Riwayat Pengembalian')

@section('content')
<div class="space-y-5">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([['Total',$stats['total'],'fa-list','gray'],['Tepat Waktu',$stats['tepat_waktu'],'fa-circle-check','green'],['Terlambat',$stats['terlambat'],'fa-triangle-exclamation','red'],['Buku Dikembalikan',$stats['buku_dikembalikan'],'fa-book','blue']] as $s)
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
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Riwayat Pengembalian</h2>
            <a href="{{ route('petugas.pengembalian.proses') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                <i class="fa fa-rotate-left"></i> Proses Pengembalian
            </a>
        </div>
        <div class="px-5 py-3 border-b border-gray-100">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-48">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari anggota atau kode peminjaman..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm hover:bg-blue-700 transition">Filter</button>
                <a href="{{ route('petugas.pengembalian.riwayat') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm hover:bg-gray-200 transition">Reset</a>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-5 py-3 font-medium">No</th>
                        <th class="px-5 py-3 font-medium">Kode Transaksi</th>
                        <th class="px-5 py-3 font-medium">Anggota</th>
                        <th class="px-5 py-3 font-medium">Buku</th>
                        <th class="px-5 py-3 font-medium">Tgl Pinjam</th>
                        <th class="px-5 py-3 font-medium">Tgl Jatuh Tempo</th>
                        <th class="px-5 py-3 font-medium">Tgl Kembali</th>
                        <th class="px-5 py-3 font-medium">Terlambat</th>
                        <th class="px-5 py-3 font-medium">Denda</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengembalians as $i => $pg)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-500">{{ $pengembalians->firstItem() + $i }}</td>
                        <td class="px-5 py-3 font-mono text-xs text-gray-600">{{ $pg->peminjaman->kode_transaksi ?? '-' }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $pg->peminjaman->anggota->user->name ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $pg->peminjaman->bukus->first()?->judul ?? '-' }}
                            @if(($pg->peminjaman->bukus->count() ?? 0) > 1)<span class="text-xs text-gray-400"> +{{ $pg->peminjaman->bukus->count()-1 }}</span>@endif
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $pg->peminjaman->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $pg->peminjaman->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $pg->tanggal_pengembalian->format('d M Y') }}</td>
                        <td class="px-5 py-3">
                            @if($pg->hari_terlambat > 0)
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">{{ $pg->hari_terlambat }} hari</span>
                            @else
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Tepat Waktu</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 {{ $pg->denda > 0 ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                            Rp {{ number_format($pg->denda, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Selesai</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="px-5 py-10 text-center text-gray-400">Tidak ada riwayat pengembalian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>Menampilkan {{ $pengembalians->firstItem() ?? 0 }}-{{ $pengembalians->lastItem() ?? 0 }} dari {{ $pengembalians->total() }} data</span>
            {{ $pengembalians->links() }}
        </div>
    </div>
</div>
@endsection
