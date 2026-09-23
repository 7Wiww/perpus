<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        // Update status terlambat
        Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_jatuh_tempo', '<', Carbon::today())
            ->update(['status' => 'terlambat']);

        $query = Peminjaman::with(['anggota.user', 'bukus'])
            ->whereIn('status', ['dipinjam', 'terlambat']);

        if ($request->search) {
            $query->search($request->search);
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();
        $stats = [
            'hari_ini'   => Pengembalian::whereDate('tanggal_pengembalian', Carbon::today())->count(),
            'bulan_ini'  => Pengembalian::whereMonth('tanggal_pengembalian', Carbon::now()->month)->count(),
            'terlambat'  => Peminjaman::where('status', 'terlambat')->count(),
            'selesai'    => Pengembalian::whereDate('tanggal_pengembalian', Carbon::today())->count(),
        ];

        return view('petugas.pengembalian.index', compact('peminjamans', 'stats'));
    }

    public function proses(Request $request)
    {
        $peminjamanId = $request->peminjaman_id;
        $peminjaman   = null;

        if ($peminjamanId) {
            $peminjaman = Peminjaman::with(['anggota.user', 'bukus', 'pengembalian'])
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->find($peminjamanId);
        }

        // Seluruh peminjaman aktif untuk list
        $aktifPeminjamans = Peminjaman::with(['anggota.user', 'bukus'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest()
            ->paginate(8);

        return view('petugas.pengembalian.proses', compact('peminjaman', 'aktifPeminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id'       => 'required|exists:peminjamans,id',
            'tanggal_pengembalian'=> 'required|date',
            'kondisi_buku'        => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'catatan'             => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::with('bukus')->findOrFail($request->peminjaman_id);

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $tglKembali  = Carbon::parse($request->tanggal_pengembalian);
        $tglTempo    = $peminjaman->tanggal_jatuh_tempo;
        $hariTerlambat = max(0, $tglTempo->diffInDays($tglKembali, false) * -1 <= 0
            ? ($tglKembali > $tglTempo ? $tglTempo->diffInDays($tglKembali) : 0)
            : 0);

        // Hitung hari terlambat
        $hariTerlambat = 0;
        if ($tglKembali->gt($tglTempo)) {
            $hariTerlambat = $tglTempo->diffInDays($tglKembali);
        }
        $denda = $hariTerlambat * 500;

        DB::transaction(function () use ($request, $peminjaman, $hariTerlambat, $denda, $tglKembali) {
            Pengembalian::create([
                'peminjaman_id'       => $peminjaman->id,
                'petugas_id'          => auth()->id(),
                'tanggal_pengembalian'=> $tglKembali,
                'hari_terlambat'      => $hariTerlambat,
                'denda'               => $denda,
                'kondisi_buku'        => $request->kondisi_buku,
                'catatan'             => $request->catatan,
            ]);

            $peminjaman->update([
                'status'         => 'dikembalikan',
                'tanggal_kembali'=> $tglKembali,
            ]);

            // Kembalikan stok buku
            foreach ($peminjaman->bukus as $buku) {
                $buku->increment('stok_tersedia');
                if ($buku->stok_tersedia > 0) {
                    $buku->update(['status' => 'tersedia']);
                }
            }
        });

        return redirect()->route('petugas.pengembalian.index')->with('success', 'Pengembalian berhasil dicatat.' . ($denda > 0 ? " Denda: Rp " . number_format($denda, 0, ',', '.') : ''));
    }

    public function riwayat(Request $request)
    {
        $query = Pengembalian::with(['peminjaman.anggota.user', 'peminjaman.bukus', 'petugas'])->latest();

        if ($request->search) {
            $s = $request->search;
            $query->whereHas('peminjaman', fn($q) => $q->where('kode_transaksi', 'like', "%$s%")
                ->orWhereHas('anggota.user', fn($u) => $u->where('name', 'like', "%$s%")));
        }
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_pengembalian', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $pengembalians = $query->paginate(15)->withQueryString();
        $stats = [
            'total'       => Pengembalian::count(),
            'tepat_waktu' => Pengembalian::where('hari_terlambat', 0)->count(),
            'terlambat'   => Pengembalian::where('hari_terlambat', '>', 0)->count(),
            'buku_dikembalikan' => Pengembalian::count(),
        ];

        return view('petugas.pengembalian.riwayat', compact('pengembalians', 'stats'));
    }
}
