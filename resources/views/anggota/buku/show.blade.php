@extends('layouts.app')
@section('title', $buku->judul)
@section('page-title', 'Detail Buku')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('anggota.buku.index') }}" class="hover:text-blue-600">Koleksi Buku</a>
            <span class="mx-1">/</span><span class="text-gray-800 line-clamp-1">{{ $buku->judul }}</span>
        </nav>
        <a href="{{ route('anggota.buku.index') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row gap-6">
            <div class="flex-shrink-0 flex justify-center">
                @if($buku->sampul)
                    <img src="{{ asset('storage/'.$buku->sampul) }}" class="w-32 h-44 object-cover rounded-xl border border-gray-100 shadow-sm">
                @else
                    <div class="w-32 h-44 bg-blue-50 rounded-xl border border-blue-100 flex items-center justify-center">
                        <i class="fa fa-book text-blue-300 text-4xl"></i>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $buku->judul }}</h2>
                <p class="text-gray-600 mb-3">{{ $buku->penulis }}</p>

                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">{{ $buku->kategori->nama_kategori ?? '-' }}</span>
                    @if($buku->stok_tersedia > 0)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Tersedia ({{ $buku->stok_tersedia }})
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Tidak Tersedia
                        </span>
                    @endif
                </div>

                <dl class="grid grid-cols-2 gap-3 text-sm mb-4">
                    @foreach([['Penerbit',$buku->penerbit??'-'],['Tahun Terbit',$buku->tahun_terbit??'-'],['ISBN',$buku->isbn??'-'],['Lokasi Rak',$buku->lokasi_rak??'-']] as $item)
                    <div>
                        <dt class="text-xs text-gray-500 mb-0.5">{{ $item[0] }}</dt>
                        <dd class="font-medium text-gray-900">{{ $item[1] }}</dd>
                    </div>
                    @endforeach
                </dl>

                @if($buku->deskripsi)
                <p class="text-sm text-gray-600">{{ $buku->deskripsi }}</p>
                @endif

                <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-xl text-xs text-blue-700">
                    <i class="fa fa-circle-info mr-1"></i>
                    Untuk meminjam buku, silakan hubungi petugas perpustakaan dengan menyebutkan judul buku dan nomor anggota Anda (<strong>{{ auth()->user()->anggota?->no_anggota }}</strong>).
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
