@extends('layouts.app')
@section('title', 'Dashboard – Sistem Perpustakaan')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Greeting --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-xl font-bold">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-blue-100 text-sm mt-1">Berikut ringkasan aktivitas perpustakaan hari ini.</p>
            </div>
            <p class="text-blue-100 text-sm">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>

    {{-- Stats grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card-main border-blue-200 bg-blue-50">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fa fa-book text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_buku']) }}</p>
                <p class="text-xs text-gray-500">Total Buku</p>
            </div>
        </div>
        <div class="stat-card-main border-green-200 bg-green-50">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fa fa-users text-green-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_anggota']) }}</p>
                <p class="text-xs text-gray-500">Total Anggota</p>
            </div>
        </div>
        <div class="stat-card-main border-orange-200 bg-orange-50">
            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                <i class="fa fa-file-export text-orange-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_dipinjam']) }}</p>
                <p class="text-xs text-gray-500">Sedang Dipinjam</p>
            </div>
        </div>
        <div class="stat-card-main border-teal-200 bg-teal-50">
            <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center">
                <i class="fa fa-rotate-left text-teal-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['dikembalikan_hari_ini']) }}</p>
                <p class="text-xs text-gray-500">Dikembalikan Hari Ini</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Chart --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Statistik Peminjaman</h3>
                <span class="text-xs text-gray-500">7 Hari Terakhir</span>
            </div>
            <canvas id="peminjamanChart" height="220"></canvas>
        </div>

        {{-- Activities --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Aktivitas Hari Ini</h3>
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl">
                    <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fa fa-file-export text-blue-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Peminjaman Buku</p>
                        <p class="text-xs text-gray-500">Total transaksi peminjaman</p>
                    </div>
                    <span class="font-bold text-blue-600">{{ $stats['peminjaman_hari_ini'] }}</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl">
                    <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fa fa-rotate-left text-green-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Pengembalian Buku</p>
                        <p class="text-xs text-gray-500">Total transaksi pengembalian</p>
                    </div>
                    <span class="font-bold text-green-600">{{ $stats['dikembalikan_hari_ini'] }}</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-orange-50 rounded-xl">
                    <div class="w-9 h-9 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fa fa-user-plus text-orange-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Anggota Baru</p>
                        <p class="text-xs text-gray-500">Pendaftaran bulan ini</p>
                    </div>
                    <span class="font-bold text-orange-600">{{ $stats['anggota_baru_bulan'] }}</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-red-50 rounded-xl">
                    <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fa fa-clock text-red-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Terlambat</p>
                        <p class="text-xs text-gray-500">Perlu perhatian</p>
                    </div>
                    <span class="font-bold text-red-600">{{ $stats['total_terlambat'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent peminjaman --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Peminjaman Terbaru</h3>
            <a href="{{ route('petugas.peminjaman.riwayat') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-500 border-b border-gray-100">
                        <th class="pb-2 font-medium">Anggota</th>
                        <th class="pb-2 font-medium">Buku</th>
                        <th class="pb-2 font-medium">Tgl Pinjam</th>
                        <th class="pb-2 font-medium">Jatuh Tempo</th>
                        <th class="pb-2 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($peminjamanTerbaru as $p)
                    <tr>
                        <td class="py-2.5 font-medium text-gray-800">{{ $p->anggota->user->name ?? '-' }}</td>
                        <td class="py-2.5 text-gray-600">{{ $p->bukus->first()?->judul ?? '-' }}
                            @if($p->bukus->count() > 1) <span class="text-xs text-gray-400">+{{ $p->bukus->count()-1 }}</span> @endif
                        </td>
                        <td class="py-2.5 text-gray-500">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                        <td class="py-2.5 text-gray-500">{{ $p->tanggal_jatuh_tempo->format('d M Y') }}</td>
                        <td class="py-2.5">
                            <span class="badge-status {{ $p->status }}">{{ ucfirst($p->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-400 text-sm">Belum ada transaksi peminjaman</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.stat-card-main { @apply flex items-center gap-4 p-5 rounded-2xl border; }
.badge-status { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium; }
.badge-status.dipinjam    { @apply bg-blue-100 text-blue-700; }
.badge-status.dikembalikan{ @apply bg-green-100 text-green-700; }
.badge-status.terlambat   { @apply bg-red-100 text-red-700; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('peminjamanChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Peminjaman',
            data: {!! json_encode($chartData) !!},
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37,99,235,0.08)',
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#2563eb',
            pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush
