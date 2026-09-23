@extends('layouts.app')
@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')
<div class="space-y-5">
    <div class="bg-white rounded-2xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-gray-900">Kelola User</h2>
                <p class="text-xs text-gray-500">Kelola akun Admin, Petugas, dan Pimpinan.</p>
            </div>
            <a href="{{ route('admin.user.create') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                <i class="fa fa-plus"></i> Tambah User
            </a>
        </div>

        <div class="px-5 py-3 border-b border-gray-100">
            <form method="GET" class="flex gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm hover:bg-blue-700 transition">Cari</button>
                <a href="{{ route('admin.user.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm hover:bg-gray-200 transition">Reset</a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-5 py-3 font-medium">No</th>
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Username</th>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Role</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $i => $u)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-500">{{ $users->firstItem() + $i }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                                    @if($u->role==='admin') bg-purple-100 text-purple-700
                                    @elseif($u->role==='petugas') bg-blue-100 text-blue-700
                                    @else bg-green-100 text-green-700 @endif">
                                    {{ strtoupper(substr($u->name,0,1)) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $u->username }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $u->email }}</td>
                        <td class="px-5 py-3">
                            @php $roleColors=['admin'=>'purple','petugas'=>'blue','pimpinan'=>'green']; @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $roleColors[$u->role]??'gray' }}-100 text-{{ $roleColors[$u->role]??'gray' }}-700 capitalize">{{ $u->role }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $u->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.user.edit', $u) }}" class="w-7 h-7 bg-gray-100 hover:bg-yellow-100 text-gray-600 hover:text-yellow-600 rounded-lg flex items-center justify-center transition">
                                    <i class="fa fa-pen text-xs"></i>
                                </a>
                                @if($u->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.user.destroy', $u) }}" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-7 h-7 bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 rounded-lg flex items-center justify-center transition">
                                        <i class="fa fa-trash text-xs"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400">Tidak ada user ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }} data</span>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
