@extends('layouts.app')
@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman')

@section('content')
<div class="space-y-5">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([['Total',$stats['total'],'fa-list','gray'],['Selesai',$stats['selesai'],'fa-circle-check','green'],['Aktif',$stats['aktif'],'fa-clock','blue'],['Terlambat',$stats['terlambat'],'fa-triangle-exclamation','red']] as $s)
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
            <h2 class="font-semibold text-gray-900">Riwayat Peminjaman</h2>
            <a href="{{ route('petugas.peminjaman.create') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                <i class="fa fa-plus"></i> Peminjaman Baru
            </a>
        </div>

        <div class="px-5 py-3 border-b border-gray-100">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-48">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari anggota, buku, atau kode..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" {{ request('status')==='dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="terlambat" {{ request('status')==='terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="dikembalikan" {{ request('status')==='dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
                <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm hover:bg-blue-700 transition">Filter</button>
                <a href="{{ route('petugas.peminjaman.riwayat') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm hover:bg-gray-200 transition">Reset</a>
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
                        <th class="px-5 py-3 font-medium">Jatuh Tempo</th>
                        <th class="px-5 py-3 font-medium">Tgl Kembali</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjamans as $i => $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-500">{{ $peminjamans->firstItem() + $i }}</td>
                        <td class="px-5 py-3 font-mono text-xs text-gray-600">{{ $p->kode_transaksi }}</td>
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-900">{{ $p->anggota->user->name ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $p->anggota->no_anggota ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3 text-gray-700">{{ $p->bukus->first()?->judul ?? '-' }}
                            @if($p->bukus->count() > 1) <span class="text-xs text-gray-400">+{{ $p->bukus->count()-1 }}</span> @endif
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $p->tanggal_jatuh_tempo->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $p->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                        <td class="px-5 py-3"><span class="badge-status {{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                        <td class="px-5 py-3">
                            <a href="{{ route('petugas.peminjaman.show', $p) }}" class="w-7 h-7 bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-600 rounded-lg flex items-center justify-center transition">
                                <i class="fa fa-eye text-xs"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="px-5 py-10 text-center text-gray-400">Tidak ada data riwayat peminjaman.</td></tr>
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
<style>
.badge-status { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium; }
.badge-status.dipinjam    { @apply bg-blue-100 text-blue-700; }
.badge-status.dikembalikan{ @apply bg-green-100 text-green-700; }
.badge-status.terlambat   { @apply bg-red-100 text-red-700; }
</style>
@endsection
