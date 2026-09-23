@extends('layouts.app')
@section('title', 'Detail Anggota')
@section('page-title', 'Detail Anggota')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('admin.anggota.index') }}" class="hover:text-blue-600">Data Anggota</a>
            <span class="mx-1">/</span><span class="text-gray-800">{{ $anggota->user->name }}</span>
        </nav>
        <a href="{{ route('admin.anggota.index') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 text-center">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                @if($anggota->foto)
                    <img src="{{ asset('storage/'.$anggota->foto) }}" class="w-20 h-20 rounded-full object-cover">
                @else
                    <i class="fa fa-user text-blue-600 text-2xl"></i>
                @endif
            </div>
            <h2 class="font-bold text-gray-900">{{ $anggota->user->name }}</h2>
            <p class="text-gray-500 text-sm">{{ $anggota->no_anggota }}</p>
            @php $colors = ['aktif'=>'green','nonaktif'=>'gray','diblokir'=>'red']; @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $colors[$anggota->status] }}-100 text-{{ $colors[$anggota->status] }}-700 capitalize mt-2">{{ $anggota->status }}</span>
            <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                <div class="bg-blue-50 rounded-xl p-2">
                    <p class="font-bold text-blue-700">{{ $anggota->peminjamans->count() }}</p>
                    <p class="text-xs text-gray-500">Total Pinjam</p>
                </div>
                <div class="bg-green-50 rounded-xl p-2">
                    <p class="font-bold text-green-700">{{ $anggota->peminjamans->where('status','dikembalikan')->count() }}</p>
                    <p class="text-xs text-gray-500">Selesai</p>
                </div>
                <div class="bg-orange-50 rounded-xl p-2">
                    <p class="font-bold text-orange-700">{{ $anggota->peminjamansAktif()->count() }}</p>
                    <p class="text-xs text-gray-500">Aktif</p>
                </div>
            </div>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('admin.anggota.edit', $anggota) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl text-sm font-medium transition text-center">Edit</a>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Data Pribadi</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    @foreach([['Email',$anggota->user->email],['NIM/NIP',$anggota->nim_nip??'-'],['No. Telepon',$anggota->no_telepon??'-'],['Jenis Anggota',ucfirst($anggota->jenis_anggota)],['Program Studi',$anggota->program_studi??'-'],['Fakultas/Instansi',$anggota->fakultas_instansi??'-'],['Alamat',$anggota->alamat??'-'],['Bergabung',$anggota->tanggal_bergabung?->format('d M Y')??'-']] as $item)
                    <div>
                        <dt class="text-gray-500 text-xs mb-0.5">{{ $item[0] }}</dt>
                        <dd class="font-medium text-gray-900">{{ $item[1] }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Riwayat Peminjaman</h3>
                @forelse($anggota->peminjamans->take(5) as $p)
                <div class="flex items-center justify-between py-2 border-b border-gray-50 text-sm">
                    <span class="text-gray-600">{{ $p->kode_transaksi }}</span>
                    <span class="text-gray-500">{{ $p->tanggal_pinjam?->format('d M Y') }}</span>
                    <span class="badge-status {{ $p->status }}">{{ ucfirst($p->status) }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-400">Belum ada riwayat peminjaman</p>
                @endforelse
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
