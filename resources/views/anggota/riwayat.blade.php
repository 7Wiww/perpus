@extends('layouts.app')
@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman')

@section('content')
<div class="space-y-5">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([['Total',$stats['total'],'fa-list','gray'],['Aktif',$stats['aktif'],'fa-clock','blue'],['Selesai',$stats['selesai'],'fa-circle-check','green'],['Terlambat',$stats['terlambat'],'fa-triangle-exclamation','red']] as $s)
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
            <div>
                <h2 class="font-semibold text-gray-900">Riwayat Peminjaman Saya</h2>
                <p class="text-xs text-gray-500">No. Anggota: {{ $anggota->no_anggota }}</p>
            </div>
        </div>

        <div class="px-5 py-3 border-b border-gray-100">
            <form method="GET" class="flex gap-3">
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" {{ request('status')==='dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="terlambat" {{ request('status')==='terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="dikembalikan" {{ request('status')==='dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm hover:bg-blue-700 transition">Filter</button>
                <a href="{{ route('anggota.riwayat') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm hover:bg-gray-200 transition">Reset</a>
            </form>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($peminjamans as $p)
            <div class="p-5 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-mono text-xs text-gray-500">{{ $p->kode_transaksi }}</span>
                            <span class="badge-status {{ $p->status }}">{{ ucfirst($p->status) }}</span>
                        </div>
                        <div class="space-y-1">
                            @foreach($p->bukus as $b)
                            <p class="font-semibold text-gray-900">{{ $b->judul }}</p>
                            @endforeach
                        </div>
                        <div class="flex flex-wrap gap-4 mt-2 text-xs text-gray-500">
                            <span><i class="fa fa-calendar mr-1"></i>Pinjam: {{ $p->tanggal_pinjam->format('d M Y') }}</span>
                            <span class="{{ $p->status === 'terlambat' ? 'text-red-600 font-semibold' : '' }}">
                                <i class="fa fa-clock mr-1"></i>Tempo: {{ $p->tanggal_jatuh_tempo->format('d M Y') }}
                            </span>
                            @if($p->tanggal_kembali)
                            <span><i class="fa fa-rotate-left mr-1"></i>Kembali: {{ $p->tanggal_kembali->format('d M Y') }}</span>
                            @endif
                        </div>
                        @if($p->pengembalian && $p->pengembalian->denda > 0)
                        <div class="mt-2 inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-semibold">
                            <i class="fa fa-coins"></i> Denda: Rp {{ number_format($p->pengembalian->denda, 0, ',', '.') }}
                        </div>
                        @endif
                        @if($p->status === 'terlambat')
                        <div class="mt-2 inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-semibold">
                            <i class="fa fa-triangle-exclamation"></i> Terlambat {{ $p->hari_terlambat }} hari · Est. Denda: Rp {{ number_format($p->denda, 0, ',', '.') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center text-gray-400">
                <i class="fa fa-book text-4xl mb-3 block text-gray-200"></i>
                <p class="font-medium">Belum ada riwayat peminjaman</p>
                <p class="text-sm mt-1">Kunjungi perpustakaan dan pinjam buku pertama Anda!</p>
                <a href="{{ route('anggota.buku.index') }}" class="mt-4 inline-flex items-center gap-1.5 bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                    <i class="fa fa-book-open"></i> Lihat Koleksi Buku
                </a>
            </div>
            @endforelse
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
