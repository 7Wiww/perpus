@extends('layouts.app')
@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('petugas.peminjaman.index') }}" class="hover:text-blue-600">Peminjaman</a>
            <span class="mx-1">/</span><span class="text-gray-800">{{ $peminjaman->kode_transaksi }}</span>
        </nav>
        <a href="{{ route('petugas.peminjaman.index') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Info peminjaman --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="font-semibold text-gray-900">Detail Peminjaman</h3>
                        <p class="text-xs font-mono text-gray-500 mt-0.5">{{ $peminjaman->kode_transaksi }}</p>
                    </div>
                    <span class="badge-status {{ $peminjaman->status }}">{{ ucfirst($peminjaman->status) }}</span>
                </div>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">Tanggal Pinjam</dt>
                        <dd class="font-medium text-gray-900">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">Jatuh Tempo</dt>
                        <dd class="font-medium {{ $peminjaman->status==='terlambat' ? 'text-red-600' : 'text-gray-900' }}">{{ $peminjaman->tanggal_jatuh_tempo->format('d M Y') }}</dd>
                    </div>
                    @if($peminjaman->tanggal_kembali)
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">Tanggal Dikembalikan</dt>
                        <dd class="font-medium text-gray-900">{{ $peminjaman->tanggal_kembali->format('d M Y') }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">Petugas</dt>
                        <dd class="font-medium text-gray-900">{{ $peminjaman->petugas->name ?? '-' }}</dd>
                    </div>
                    @if($peminjaman->status === 'terlambat')
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">Hari Terlambat</dt>
                        <dd class="font-semibold text-red-600">{{ $peminjaman->hari_terlambat }} hari</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">Estimasi Denda</dt>
                        <dd class="font-semibold text-red-600">Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</dd>
                    </div>
                    @endif
                </dl>
                @if($peminjaman->keterangan)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Keterangan</p>
                    <p class="text-sm text-gray-700">{{ $peminjaman->keterangan }}</p>
                </div>
                @endif
            </div>

            {{-- Buku dipinjam --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Daftar Buku yang Dipinjam ({{ $peminjaman->bukus->count() }})</h3>
                <div class="space-y-3">
                    @foreach($peminjaman->bukus as $b)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <div class="w-9 h-12 bg-blue-100 rounded flex items-center justify-center flex-shrink-0">
                            <i class="fa fa-book text-blue-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $b->judul }}</p>
                            <p class="text-xs text-gray-500">{{ $b->penulis }} · {{ $b->isbn ?? '-' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Pengembalian (jika sudah dikembalikan) --}}
            @if($peminjaman->pengembalian)
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Data Pengembalian</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">Tanggal Pengembalian</dt>
                        <dd class="font-medium text-gray-900">{{ $peminjaman->pengembalian->tanggal_pengembalian->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">Kondisi Buku</dt>
                        <dd class="font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $peminjaman->pengembalian->kondisi_buku) }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">Hari Terlambat</dt>
                        <dd class="font-medium {{ $peminjaman->pengembalian->hari_terlambat > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $peminjaman->pengembalian->hari_terlambat }} hari {{ $peminjaman->pengembalian->hari_terlambat === 0 ? '(Tepat Waktu)' : '' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">Denda</dt>
                        <dd class="font-medium {{ $peminjaman->pengembalian->denda > 0 ? 'text-red-600' : 'text-gray-900' }}">
                            Rp {{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}
                        </dd>
                    </div>
                </dl>
            </div>
            @endif
        </div>

        {{-- Info anggota --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-gray-200 p-5 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fa fa-user text-blue-600 text-xl"></i>
                </div>
                <h4 class="font-bold text-gray-900">{{ $peminjaman->anggota->user->name ?? '-' }}</h4>
                <p class="text-gray-500 text-sm">{{ $peminjaman->anggota->no_anggota ?? '' }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ $peminjaman->anggota->program_studi ?? '-' }}</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 mt-2 capitalize">{{ $peminjaman->anggota->status }}</span>
            </div>

            @if(in_array($peminjaman->status, ['dipinjam','terlambat']))
            <a href="{{ route('petugas.pengembalian.proses', ['peminjaman_id' => $peminjaman->id]) }}"
                class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2.5 rounded-xl text-sm font-semibold transition">
                <i class="fa fa-rotate-left mr-1"></i> Proses Pengembalian
            </a>
            @endif
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
