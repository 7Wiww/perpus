@extends('layouts.app')
@section('title', 'Data Anggota')
@section('page-title', 'Data Anggota')

@section('content')
<div class="space-y-5">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([['Total Anggota',$stats['total'],'fa-users','blue'],['Aktif',$stats['aktif'],'fa-circle-check','green'],['Nonaktif',$stats['nonaktif'],'fa-circle-minus','gray'],['Diblokir',$stats['diblokir'],'fa-ban','red']] as $s)
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-{{ $s[3] }}-100 rounded-xl flex items-center justify-center">
                <i class="fa {{ $s[2] }} text-{{ $s[3] }}-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ number_format($s[1]) }}</p>
                <p class="text-xs text-gray-500">{{ $s[0] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-gray-900">Data Anggota</h2>
                <p class="text-xs text-gray-500">Kelola data anggota perpustakaan.</p>
            </div>
            <a href="{{ route('admin.anggota.create') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                <i class="fa fa-plus"></i> Tambah Anggota
            </a>
        </div>

        <div class="px-5 py-3 border-b border-gray-100">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-48">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIM, email..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <select name="jenis_anggota" class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Jenis</option>
                    @foreach(['mahasiswa','dosen','staff','umum'] as $j)
                        <option value="{{ $j }}" {{ request('jenis_anggota') === $j ? 'selected' : '' }}>{{ ucfirst($j) }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    @foreach(['aktif','nonaktif','diblokir'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition">Filter</button>
                <a href="{{ route('admin.anggota.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium hover:bg-gray-200 transition">Reset</a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-5 py-3 font-medium">No</th>
                        <th class="px-5 py-3 font-medium">Nama Lengkap</th>
                        <th class="px-5 py-3 font-medium">NIM / ID</th>
                        <th class="px-5 py-3 font-medium">Jenis</th>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">No. Telepon</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($anggotas as $i => $a)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-500">{{ $anggotas->firstItem() + $i }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fa fa-user text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $a->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $a->no_anggota }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $a->nim_nip ?? '-' }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 capitalize">{{ $a->jenis_anggota }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $a->user->email }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $a->no_telepon ?? '-' }}</td>
                        <td class="px-5 py-3">
                            @php $colors = ['aktif'=>'green','nonaktif'=>'gray','diblokir'=>'red']; @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $colors[$a->status] }}-100 text-{{ $colors[$a->status] }}-700 capitalize">{{ $a->status }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.anggota.show', $a) }}" class="w-7 h-7 bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-600 rounded-lg flex items-center justify-center transition">
                                    <i class="fa fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.anggota.edit', $a) }}" class="w-7 h-7 bg-gray-100 hover:bg-yellow-100 text-gray-600 hover:text-yellow-600 rounded-lg flex items-center justify-center transition">
                                    <i class="fa fa-pen text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.anggota.destroy', $a) }}" onsubmit="return confirm('Hapus anggota ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-7 h-7 bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 rounded-lg flex items-center justify-center transition">
                                        <i class="fa fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-5 py-10 text-center text-gray-400">Tidak ada data anggota ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>Menampilkan {{ $anggotas->firstItem() }}-{{ $anggotas->lastItem() }} dari {{ $anggotas->total() }} data</span>
            {{ $anggotas->links() }}
        </div>
    </div>
</div>
@endsection
