<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
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
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $bukus     = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::all();
        $stats = [
            'total'          => Buku::count(),
            'tersedia'       => Buku::where('status', 'tersedia')->count(),
            'dipinjam'       => Buku::where('status', 'dipinjam')->count(),
            'tidak_tersedia' => Buku::where('status', 'tidak_tersedia')->count(),
        ];

        return view('admin.buku.index', compact('bukus', 'kategoris', 'stats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'penulis'     => 'required|string|max:255',
            'penerbit'    => 'nullable|string|max:255',
            'isbn'        => 'nullable|string|max:30|unique:bukus',
            'tahun_terbit'=> 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_rak'  => 'nullable|string|max:50',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'sampul'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:tersedia,dipinjam,tidak_tersedia',
        ]);

        if ($request->hasFile('sampul')) {
            $validated['sampul'] = $request->file('sampul')->store('sampul', 'public');
        }

        $validated['stok_tersedia'] = $validated['stok'];
        Buku::create($validated);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori', 'detailPeminjamans.peminjaman.anggota.user');
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'penulis'     => 'required|string|max:255',
            'penerbit'    => 'nullable|string|max:255',
            'isbn'        => 'nullable|string|max:30|unique:bukus,isbn,' . $buku->id,
            'tahun_terbit'=> 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_rak'  => 'nullable|string|max:50',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'sampul'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:tersedia,dipinjam,tidak_tersedia',
        ]);

        if ($request->hasFile('sampul')) {
            if ($buku->sampul) Storage::disk('public')->delete($buku->sampul);
            $validated['sampul'] = $request->file('sampul')->store('sampul', 'public');
        }

        $buku->update($validated);
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->detailPeminjamans()->whereHas('peminjaman', fn($q) => $q->whereIn('status', ['dipinjam', 'terlambat']))->exists()) {
            return back()->with('error', 'Buku sedang dipinjam, tidak dapat dihapus.');
        }
        if ($buku->sampul) Storage::disk('public')->delete($buku->sampul);
        $buku->delete();
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
