<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota.user', 'bukus'])->latest();

        if ($request->search) {
            $query->search($request->search);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_pinjam', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        // Auto-update status terlambat
        Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_jatuh_tempo', '<', Carbon::today())
            ->update(['status' => 'terlambat']);

        $peminjamans = $query->paginate(10)->withQueryString();
        $stats = [
            'hari_ini'   => Peminjaman::whereDate('tanggal_pinjam', Carbon::today())->count(),
            'bulan_ini'  => Peminjaman::whereMonth('tanggal_pinjam', Carbon::now()->month)->count(),
            'aktif'      => Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count(),
            'terlambat'  => Peminjaman::where('status', 'terlambat')->count(),
        ];

        return view('petugas.peminjaman.index', compact('peminjamans', 'stats'));
    }

    public function create()
    {
        $anggotas = Anggota::with('user')->where('status', 'aktif')->get();
        $bukus    = Buku::with('kategori')->where('stok_tersedia', '>', 0)->get();
        return view('petugas.peminjaman.create', compact('anggotas', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'           => 'required|exists:anggotas,id',
            'buku_ids'             => 'required|array|min:1|max:3',
            'buku_ids.*'           => 'exists:bukus,id',
            'tanggal_pinjam'       => 'required|date',
            'tanggal_jatuh_tempo'  => 'required|date|after:tanggal_pinjam',
            'keterangan'           => 'nullable|string',
        ]);

        $anggota = Anggota::findOrFail($request->anggota_id);

        // Cek max 3 buku
        $pinjamAktif = $anggota->peminjamansAktif()->count();
        $totalBuku = $pinjamAktif + count($request->buku_ids);
        if ($totalBuku > 3) {
            return back()->withInput()->with('error', 'Anggota sudah memiliki ' . $pinjamAktif . ' peminjaman aktif. Maksimal 3 buku.');
        }

        DB::transaction(function () use ($request, $anggota) {
            $peminjaman = Peminjaman::create([
                'kode_transaksi'      => Peminjaman::generateKode(),
                'anggota_id'          => $anggota->id,
                'petugas_id'          => auth()->id(),
                'tanggal_pinjam'      => $request->tanggal_pinjam,
                'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                'status'              => 'dipinjam',
                'keterangan'          => $request->keterangan,
            ]);

            foreach ($request->buku_ids as $bukuId) {
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id'       => $bukuId,
                ]);
                // Kurangi stok
                Buku::where('id', $bukuId)->decrement('stok_tersedia');
                Buku::where('id', $bukuId)->where('stok_tersedia', 0)->update(['status' => 'dipinjam']);
            }
        });

        return redirect()->route('petugas.peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['anggota.user', 'bukus.kategori', 'petugas', 'pengembalian']);
        return view('petugas.peminjaman.show', compact('peminjaman'));
    }

    public function riwayat(Request $request)
    {
        $query = Peminjaman::with(['anggota.user', 'bukus'])->latest();

        if ($request->search) {
            $query->search($request->search);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_pinjam', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $peminjamans = $query->paginate(15)->withQueryString();
        $stats = [
            'total'          => Peminjaman::count(),
            'selesai'        => Peminjaman::where('status', 'dikembalikan')->count(),
            'aktif'          => Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count(),
            'terlambat'      => Peminjaman::where('status', 'terlambat')->count(),
        ];

        return view('petugas.peminjaman.riwayat', compact('peminjamans', 'stats'));
    }
}
