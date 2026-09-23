<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPeminjamanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $awal  = $request->tanggal_awal  ? Carbon::parse($request->tanggal_awal)  : Carbon::now()->startOfMonth();
        $akhir = $request->tanggal_akhir ? Carbon::parse($request->tanggal_akhir) : Carbon::now()->endOfMonth();

        $stats = [
            'total_peminjaman'   => Peminjaman::whereBetween('tanggal_pinjam', [$awal, $akhir])->count(),
            'total_pengembalian' => Pengembalian::whereBetween('tanggal_pengembalian', [$awal, $akhir])->count(),
            'total_terlambat'    => Pengembalian::where('hari_terlambat', '>', 0)->whereBetween('tanggal_pengembalian', [$awal, $akhir])->count(),
            'anggota_aktif'      => Anggota::where('status', 'aktif')->count(),
            'total_denda'        => Pengembalian::whereBetween('tanggal_pengembalian', [$awal, $akhir])->sum('denda'),
        ];

        // Chart data – peminjaman per hari dalam rentang
        $chartLabels = [];
        $chartPinjam = [];
        $chartKembali = [];
        for ($date = $awal->copy(); $date->lte($akhir); $date->addDay()) {
            $chartLabels[]  = $date->format('d M');
            $chartPinjam[]  = Peminjaman::whereDate('tanggal_pinjam', $date)->count();
            $chartKembali[] = Pengembalian::whereDate('tanggal_pengembalian', $date)->count();
        }

        // Top 5 buku terpinjam
        $topBukus = Buku::withCount(['detailPeminjamans as total_pinjam' => function ($q) use ($awal, $akhir) {
            $q->whereHas('peminjaman', fn($p) => $p->whereBetween('tanggal_pinjam', [$awal, $akhir]));
        }])->orderByDesc('total_pinjam')->take(5)->get();

        return view('pimpinan.laporan.index', compact('stats', 'chartLabels', 'chartPinjam', 'chartKembali', 'topBukus', 'awal', 'akhir'));
    }

    public function exportPdf(Request $request)
    {
        $awal  = $request->tanggal_awal  ? Carbon::parse($request->tanggal_awal)  : Carbon::now()->startOfMonth();
        $akhir = $request->tanggal_akhir ? Carbon::parse($request->tanggal_akhir) : Carbon::now()->endOfMonth();

        $peminjamans = Peminjaman::with(['anggota.user', 'bukus', 'pengembalian'])
            ->whereBetween('tanggal_pinjam', [$awal, $akhir])
            ->latest()
            ->get();

        $stats = [
            'total_peminjaman'   => $peminjamans->count(),
            'total_pengembalian' => $peminjamans->where('status', 'dikembalikan')->count(),
            'total_terlambat'    => $peminjamans->where('status', 'terlambat')->count(),
            'total_denda'        => Pengembalian::whereBetween('tanggal_pengembalian', [$awal, $akhir])->sum('denda'),
        ];

        $pdf = Pdf::loadView('pimpinan.laporan.pdf', compact('peminjamans', 'stats', 'awal', 'akhir'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . $awal->format('Ymd') . '-' . $akhir->format('Ymd') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $awal  = $request->tanggal_awal  ?? Carbon::now()->startOfMonth()->toDateString();
        $akhir = $request->tanggal_akhir ?? Carbon::now()->endOfMonth()->toDateString();
        return Excel::download(new LaporanPeminjamanExport($awal, $akhir), 'laporan-peminjaman.xlsx');
    }
}
