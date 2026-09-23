@extends('layouts.app')
@section('title', 'Data Buku')
@section('page-title', 'Data Buku')

@section('content')
<div class="space-y-5">
    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([['Total Buku',$stats['total'],'fa-book','blue'],['Tersedia',$stats['tersedia'],'fa-circle-check','green'],['Dipinjam',$stats['dipinjam'],'fa-clock','orange'],['Tidak Tersedia',$stats['tidak_tersedia'],'fa-circle-xmark','red']] as $s)
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-{{ $s[3] }}-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa {{ $s[2] }} text-{{ $s[3] }}-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ number_format($s[1]) }}</p>
                <p class="text-xs text-gray-500">{{ $s[0] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Table card --}}
    <div class="bg-white rounded-2xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-gray-900">Data Buku</h2>
                <p class="text-xs text-gray-500">Kelola data koleksi buku yang tersedia di perpustakaan.</p>
            </div>
            <a href="{{ route('admin.buku.create') }}" class="flex-shrink-0 inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                <i class="fa fa-plus"></i> Tambah Buku
            </a>
        </div>

        {{-- Filters --}}
        <div class="px-5 py-3 border-b border-gray-100">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-48">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, atau ISBN..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <select name="kategori_id" class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="tidak_tersedia" {{ request('status') === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition">Filter</button>
                <a href="{{ route('admin.buku.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium hover:bg-gray-200 transition">Reset</a>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-5 py-3 font-medium">No</th>
                        <th class="px-5 py-3 font-medium">Buku</th>
                        <th class="px-5 py-3 font-medium">Penulis</th>
                        <th class="px-5 py-3 font-medium">Kategori</th>
                        <th class="px-5 py-3 font-medium">ISBN</th>
                        <th class="px-5 py-3 font-medium">Tahun</th>
                        <th class="px-5 py-3 font-medium">Stok</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bukus as $i => $b)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 text-gray-500">{{ $bukus->firstItem() + $i }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-10 bg-blue-100 rounded flex items-center justify-center flex-shrink-0">
                                    <i class="fa fa-book text-blue-600 text-xs"></i>
                                </div>
                                <span class="font-medium text-gray-900 line-clamp-1">{{ $b->judul }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $b->penulis }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $b->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $b->isbn ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $b->tahun_terbit ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-700 font-medium">{{ $b->stok_tersedia }}/{{ $b->stok }}</td>
                        <td class="px-5 py-3">
                            @if($b->status === 'tersedia')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Tersedia</span>
                            @elseif($b->status === 'dipinjam')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">Dipinjam</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Tidak Tersedia</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.buku.show', $b) }}" class="w-7 h-7 bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-600 rounded-lg flex items-center justify-center transition" title="Detail">
                                    <i class="fa fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.buku.edit', $b) }}" class="w-7 h-7 bg-gray-100 hover:bg-yellow-100 text-gray-600 hover:text-yellow-600 rounded-lg flex items-center justify-center transition" title="Edit">
                                    <i class="fa fa-pen text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.buku.destroy', $b) }}" onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-7 h-7 bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 rounded-lg flex items-center justify-center transition" title="Hapus">
                                        <i class="fa fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="px-5 py-10 text-center text-gray-400">Tidak ada data buku ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>Menampilkan {{ $bukus->firstItem() }}-{{ $bukus->lastItem() }} dari {{ $bukus->total() }} data</span>
            {{ $bukus->links() }}
        </div>
    </div>
</div>
@endsection
