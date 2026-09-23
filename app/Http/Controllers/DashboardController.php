<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Kategori;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'anggota') {
            return $this->anggotaDashboard($user);
        }

        $stats = $this->getStats();

        // Statistik peminjaman 7 hari terakhir
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = Peminjaman::whereDate('tanggal_pinjam', $date)->count();
        }

        $peminjamanTerbaru = Peminjaman::with(['anggota.user', 'bukus'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'chartLabels', 'chartData', 'peminjamanTerbaru'));
    }

    private function anggotaDashboard($user)
    {
        $anggota = $user->anggota;
        if (!$anggota) {
            return redirect()->route('profile.edit');
        }

        $peminjamanAktif = Peminjaman::with('bukus')
            ->where('anggota_id', $anggota->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->get();

        $riwayat = Peminjaman::with('bukus')
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->take(5)
            ->get();

        $totalPinjam = Peminjaman::where('anggota_id', $anggota->id)->count();
        $totalDenda  = Pengembalian::whereHas('peminjaman', fn($q) => $q->where('anggota_id', $anggota->id))->sum('denda');

        return view('anggota.dashboard', compact('peminjamanAktif', 'riwayat', 'totalPinjam', 'totalDenda', 'anggota'));
    }

    private function getStats(): array
    {
        $today = Carbon::today();
        return [
            'total_buku'           => Buku::count(),
            'total_anggota'        => Anggota::count(),
            'total_dipinjam'       => Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count(),
            'dikembalikan_hari_ini'=> Pengembalian::whereDate('tanggal_pengembalian', $today)->count(),
            'total_terlambat'      => Peminjaman::where('status', 'terlambat')->count(),
            'peminjaman_hari_ini'  => Peminjaman::whereDate('tanggal_pinjam', $today)->count(),
            'anggota_baru_bulan'   => Anggota::whereMonth('created_at', $today->month)->count(),
            'buku_baru_bulan'      => Buku::whereMonth('created_at', $today->month)->count(),
        ];
    }
}
