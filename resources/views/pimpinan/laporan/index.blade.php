@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan & Statistik')

@section('content')
<div class="space-y-5">
    {{-- Filter periode --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-5">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" value="{{ $awal->format('Y-m-d') }}"
                    class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="{{ $akhir->format('Y-m-d') }}"
                    class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition">Terapkan Filter</button>
            <div class="flex-1"></div>
            <div class="flex gap-2">
                <a href="{{ route('pimpinan.laporan.pdf', request()->query()) }}" target="_blank"
                    class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                    <i class="fa fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('pimpinan.laporan.excel', request()->query()) }}"
                    class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>
            </div>
        </form>
        <p class="text-xs text-gray-500 mt-2">Periode: <strong>{{ $awal->format('d M Y') }}</strong> – <strong>{{ $akhir->format('d M Y') }}</strong></p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([['Total Peminjaman',$stats['total_peminjaman'],'fa-file-export','blue'],['Total Pengembalian',$stats['total_pengembalian'],'fa-file-import','green'],['Keterlambatan',$stats['total_terlambat'],'fa-triangle-exclamation','red'],['Anggota Aktif',$stats['anggota_aktif'],'fa-users','purple']] as $s)
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-{{ $s[3] }}-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa {{ $s[2] }} text-{{ $s[3] }}-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($s[1]) }}</p>
                <p class="text-xs text-gray-500">{{ $s[0] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Total denda --}}
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-5 text-white flex items-center gap-4">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
            <i class="fa fa-coins text-white text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-orange-100">Total Denda Terkumpul</p>
            <p class="text-2xl font-bold">Rp {{ number_format($stats['total_denda'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Chart peminjaman --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Ringkasan Aktivitas Perpustakaan</h3>
                <span class="text-xs text-gray-500">Perbandingan: Periode Lalu</span>
            </div>
            <canvas id="laporanChart" height="200"></canvas>
        </div>

        {{-- Top buku --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Peminjaman Terbanyak (Top 5 Buku)</h3>
            <div class="space-y-3">
                @forelse($topBukus as $i => $b)
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">{{ $i+1 }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 text-sm truncate">{{ $b->judul }}</p>
                        <p class="text-xs text-gray-500">{{ $b->penulis }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-blue-600">{{ $b->total_pinjam ?? 0 }}x</p>
                        <div class="w-24 bg-gray-100 rounded-full h-1.5 mt-1">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $topBukus->first()->total_pinjam > 0 ? (($b->total_pinjam/$topBukus->first()->total_pinjam)*100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Belum ada data peminjaman pada periode ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('laporanChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [
            {
                label: 'Peminjaman',
                data: {!! json_encode($chartPinjam) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.08)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
            },
            {
                label: 'Pengembalian',
                data: {!! json_encode($chartKembali) !!},
                borderColor: '#16a34a',
                backgroundColor: 'rgba(22,163,74,0.08)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: true, position: 'top' } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
            x: { grid: { display: false }, ticks: { maxTicksLimit: 10 } }
        }
    }
});
</script>
@endpush
@endsection
