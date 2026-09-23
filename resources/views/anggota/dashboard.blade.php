@extends('layouts.app')
@section('title', 'Dashboard Anggota')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-6 text-white">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fa fa-user text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold">Halo, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-blue-100 text-sm">No. Anggota: {{ $anggota->no_anggota }} · {{ ucfirst($anggota->jenis_anggota) }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([['Total Pinjam',$totalPinjam,'fa-book','blue'],['Aktif',$peminjamanAktif->count(),'fa-clock','orange'],['Selesai',$totalPinjam-$peminjamanAktif->count(),'fa-circle-check','green'],['Total Denda','Rp '.number_format($totalDenda,0,',','.'),'fa-coins','red']] as $s)
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-{{ $s[3] }}-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa {{ $s[2] }} text-{{ $s[3] }}-600"></i>
            </div>
            <div>
                <p class="text-lg font-bold text-gray-900">{{ $s[1] }}</p>
                <p class="text-xs text-gray-500">{{ $s[0] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    @if($peminjamanAktif->count())
    <div class="bg-white rounded-2xl border border-gray-200 p-5">
        <h3 class="font-semibold text-gray-900 mb-4">Buku Sedang Dipinjam</h3>
        <div class="space-y-3">
            @foreach($peminjamanAktif as $p)
            <div class="p-4 rounded-xl border {{ $p->status === 'terlambat' ? 'border-red-200 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">
                            {{ $p->bukus->pluck('judul')->implode(', ') }}
                        </p>
                        <div class="flex items-center gap-4 mt-1 text-xs text-gray-500">
                            <span><i class="fa fa-calendar mr-1"></i>Pinjam: {{ $p->tanggal_pinjam->format('d M Y') }}</span>
                            <span class="{{ $p->status === 'terlambat' ? 'text-red-600 font-semibold' : '' }}">
                                <i class="fa fa-clock mr-1"></i>Tempo: {{ $p->tanggal_jatuh_tempo->format('d M Y') }}
                            </span>
                        </div>
                        @if($p->status === 'terlambat')
                        <p class="text-xs text-red-600 font-semibold mt-1">
                            <i class="fa fa-triangle-exclamation mr-1"></i>Terlambat {{ $p->hari_terlambat }} hari · Denda: Rp {{ number_format($p->denda, 0, ',', '.') }}
                        </p>
                        @endif
                    </div>
                    <span class="badge-status {{ $p->status }} ml-3">{{ ucfirst($p->status) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Riwayat Peminjaman Terbaru</h3>
            <a href="{{ route('anggota.riwayat') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        @forelse($riwayat as $p)
        <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0 text-sm">
            <div>
                <p class="font-medium text-gray-900">{{ $p->bukus->first()?->judul ?? '-' }}
                    @if($p->bukus->count() > 1)<span class="text-xs text-gray-400"> +{{ $p->bukus->count()-1 }}</span>@endif
                </p>
                <p class="text-xs text-gray-500">{{ $p->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <span class="badge-status {{ $p->status }}">{{ ucfirst($p->status) }}</span>
        </div>
        @empty
        <p class="text-sm text-gray-400 text-center py-6">Belum ada riwayat peminjaman.</p>
        @endforelse
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('anggota.buku.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-2xl p-5 flex items-center gap-4 transition group">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fa fa-book-open text-2xl group-hover:scale-110 transition"></i>
            </div>
            <div>
                <p class="font-bold">Cari Buku</p>
                <p class="text-blue-100 text-sm">Temukan koleksi buku perpustakaan</p>
            </div>
        </a>
        <a href="{{ route('anggota.riwayat') }}" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-2xl p-5 flex items-center gap-4 transition group">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fa fa-clock-rotate-left text-blue-600 text-2xl group-hover:scale-110 transition"></i>
            </div>
            <div>
                <p class="font-bold text-gray-900">Riwayat Pinjam</p>
                <p class="text-gray-500 text-sm">Lihat semua aktivitas peminjaman</p>
            </div>
        </a>
    </div>
</div>
<style>
.badge-status { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium; }
.badge-status.dipinjam    { @apply bg-blue-100 text-blue-700; }
.badge-status.dikembalikan{ @apply bg-green-100 text-green-700; }
.badge-status.terlambat   { @apply bg-red-100 text-red-700; }
</style>
@endsection
