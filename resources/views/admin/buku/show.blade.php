@extends('layouts.app')
@section('title', 'Detail Buku')
@section('page-title', 'Detail Buku')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('admin.buku.index') }}" class="hover:text-blue-600">Data Buku</a>
            <span class="mx-1">/</span><span class="text-gray-800">{{ $buku->judul }}</span>
        </nav>
        <a href="{{ route('admin.buku.index') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 flex flex-col items-center text-center">
            @if($buku->sampul)
                <img src="{{ asset('storage/'.$buku->sampul) }}" class="w-36 h-48 object-contain rounded-xl border border-gray-100 mb-4">
            @else
                <div class="w-36 h-48 bg-blue-50 rounded-xl border border-blue-100 flex items-center justify-center mb-4">
                    <i class="fa fa-book text-blue-300 text-4xl"></i>
                </div>
            @endif
            <h2 class="font-bold text-gray-900 text-lg">{{ $buku->judul }}</h2>
            <p class="text-gray-500 text-sm">{{ $buku->penulis }}</p>
            <div class="mt-3">
                @if($buku->status === 'tersedia')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Tersedia</span>
                @elseif($buku->status === 'dipinjam')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">Dipinjam</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Tidak Tersedia</span>
                @endif
            </div>
            <div class="mt-4 w-full flex gap-2">
                <a href="{{ route('admin.buku.edit', $buku) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl text-sm font-medium transition">Edit</a>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi Buku</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    @foreach([['Penerbit',$buku->penerbit??'-'],['ISBN',$buku->isbn??'-'],['Tahun Terbit',$buku->tahun_terbit??'-'],['Kategori',$buku->kategori->nama_kategori??'-'],['Lokasi Rak',$buku->lokasi_rak??'-'],['Stok Total',$buku->stok],['Stok Tersedia',$buku->stok_tersedia],['Ditambahkan',$buku->created_at->format('d M Y')]] as $item)
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">{{ $item[0] }}</dt>
                        <dd class="font-medium text-gray-900">{{ $item[1] }}</dd>
                    </div>
                    @endforeach
                </dl>
                @if($buku->deskripsi)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                    <p class="text-sm text-gray-700">{{ $buku->deskripsi }}</p>
                </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Riwayat Peminjaman</h3>
                @if($buku->detailPeminjamans->count())
                <div class="space-y-2">
                    @foreach($buku->detailPeminjamans->take(5) as $d)
                    <div class="flex items-center justify-between text-sm py-2 border-b border-gray-50">
                        <span class="text-gray-700">{{ $d->peminjaman->anggota->user->name ?? '-' }}</span>
                        <span class="text-gray-500">{{ $d->peminjaman->tanggal_pinjam?->format('d M Y') }}</span>
                        <span class="badge-status {{ $d->peminjaman->status }}">{{ ucfirst($d->peminjaman->status) }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-gray-400">Belum ada riwayat peminjaman</p>
                @endif
            </div>
        </div>
    </div>
</div>
<style>
.badge-status { @apply inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium; }
.badge-status.dipinjam    { @apply bg-blue-100 text-blue-700; }
.badge-status.dikembalikan{ @apply bg-green-100 text-green-700; }
.badge-status.terlambat   { @apply bg-red-100 text-red-700; }
</style>
@endsection
