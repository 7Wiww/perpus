<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class BukuAnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        if ($request->search) {
            $query->search($request->search);
        }
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $bukus     = $query->latest()->paginate(12)->withQueryString();
        $kategoris = Kategori::all();

        return view('anggota.buku.index', compact('bukus', 'kategoris'));
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');
        return view('anggota.buku.show', compact('buku'));
    }

    public function riwayat(Request $request)
    {
        $anggota = auth()->user()->anggota;
        if (!$anggota) {
            return redirect()->route('dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        $query = Peminjaman::with(['bukus', 'pengembalian'])
            ->where('anggota_id', $anggota->id);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();
        $stats = [
            'total'     => Peminjaman::where('anggota_id', $anggota->id)->count(),
            'aktif'     => Peminjaman::where('anggota_id', $anggota->id)->whereIn('status', ['dipinjam', 'terlambat'])->count(),
            'selesai'   => Peminjaman::where('anggota_id', $anggota->id)->where('status', 'dikembalikan')->count(),
            'terlambat' => Peminjaman::where('anggota_id', $anggota->id)->where('status', 'terlambat')->count(),
        ];

        return view('anggota.riwayat', compact('peminjamans', 'anggota', 'stats'));
    }
}
