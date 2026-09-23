@extends('layouts.app')
@section('title', 'Koleksi Buku')
@section('page-title', 'Koleksi Buku')

@section('content')
<div class="space-y-5">
    <div class="bg-white rounded-2xl border border-gray-200 p-5">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-64">
                <label class="block text-xs font-medium text-gray-700 mb-1">Cari Buku</label>
                <div class="relative">
                    <i class="fa fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, atau ISBN..."
                        class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori_id" class="px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition">Cari</button>
            <a href="{{ route('anggota.buku.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 transition">Reset</a>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($bukus as $b)
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-md transition group">
            <div class="h-32 bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                @if($b->sampul)
                    <img src="{{ asset('storage/'.$b->sampul) }}" class="h-full w-full object-cover">
                @else
                    <i class="fa fa-book text-blue-300 text-4xl group-hover:scale-110 transition"></i>
                @endif
            </div>
            <div class="p-4">
                <p class="font-semibold text-gray-900 text-sm leading-tight mb-1 line-clamp-2">{{ $b->judul }}</p>
                <p class="text-xs text-gray-500 mb-2">{{ $b->penulis }}</p>
                <div class="flex items-center justify-between">
                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">{{ $b->kategori->nama_kategori ?? '-' }}</span>
                    @if($b->stok_tersedia > 0)
                        <span class="inline-flex items-center gap-1 text-xs text-green-600 font-semibold">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> {{ $b->stok_tersedia }} tersedia
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-xs text-red-600 font-semibold">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Habis
                        </span>
                    @endif
                </div>
                <a href="{{ route('anggota.buku.show', $b) }}" class="mt-3 block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-1.5 rounded-xl text-xs font-semibold transition">
                    Lihat Detail
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-gray-400">
            <i class="fa fa-book text-4xl mb-3 block text-gray-200"></i>
            <p>Tidak ada buku ditemukan.</p>
        </div>
        @endforelse
    </div>

    <div class="flex justify-center">{{ $bukus->links() }}</div>
</div>
@endsection
