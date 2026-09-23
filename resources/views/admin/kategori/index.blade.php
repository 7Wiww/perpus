@extends('layouts.app')
@section('title', 'Kategori Buku')
@section('page-title', 'Kategori Buku')

@section('content')
<div class="space-y-5">
    <div class="bg-white rounded-2xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-gray-900">Kategori Buku</h2>
                <p class="text-xs text-gray-500">Kelola kategori koleksi buku perpustakaan.</p>
            </div>
            <a href="{{ route('admin.kategori.create') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                <i class="fa fa-plus"></i> Tambah Kategori
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-5 py-3 font-medium">No</th>
                        <th class="px-5 py-3 font-medium">Nama Kategori</th>
                        <th class="px-5 py-3 font-medium">Deskripsi</th>
                        <th class="px-5 py-3 font-medium">Jumlah Buku</th>
                        <th class="px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kategoris as $i => $k)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-500">{{ $kategoris->firstItem() + $i }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $k->nama_kategori }}</td>
                        <td class="px-5 py-3 text-gray-500 max-w-xs truncate">{{ $k->deskripsi ?? '-' }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">{{ $k->bukus_count }} buku</span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.kategori.edit', $k) }}" class="w-7 h-7 bg-gray-100 hover:bg-yellow-100 text-gray-600 hover:text-yellow-600 rounded-lg flex items-center justify-center transition">
                                    <i class="fa fa-pen text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.kategori.destroy', $k) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-7 h-7 bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 rounded-lg flex items-center justify-center transition">
                                        <i class="fa fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 text-sm text-gray-500">
            Menampilkan {{ $kategoris->firstItem() }}-{{ $kategoris->lastItem() }} dari {{ $kategoris->total() }} data
            <span class="float-right">{{ $kategoris->links() }}</span>
        </div>
    </div>
</div>
@endsection
