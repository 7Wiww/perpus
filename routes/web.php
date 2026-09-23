<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Petugas\PeminjamanController;
use App\Http\Controllers\Petugas\PengembalianController;
use App\Http\Controllers\Pimpinan\LaporanController;
use App\Http\Controllers\Anggota\BukuAnggotaController;
use Illuminate\Support\Facades\Route;

// ── Welcome ────────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ── Auth (Breeze) ──────────────────────────────────────────────────────────
require __DIR__.'/auth.php';

// ── Authenticated Routes ───────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Admin Routes ───────────────────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('buku', BukuController::class);
        Route::resource('anggota', AnggotaController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('user', UserController::class)->except(['show']);
    });

    // ── Admin + Petugas shared (Buku & Anggota read) ───────────────────────
    // Petugas can view buku & anggota
    Route::prefix('admin')->name('admin.')->middleware('role:admin,petugas')->group(function () {
        // intentionally left empty; specific sharing handled in petugas routes
    });

    // ── Petugas Routes ────────────────────────────────────────────────────
    Route::prefix('petugas')->name('petugas.')->middleware('role:admin,petugas')->group(function () {
        // Peminjaman
        Route::get('peminjaman',          [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('peminjaman/create',   [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('peminjaman',         [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('peminjaman/riwayat',  [PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
        Route::get('peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

        // Pengembalian
        Route::get('pengembalian',           [PengembalianController::class, 'index'])->name('pengembalian.index');
        Route::get('pengembalian/proses',    [PengembalianController::class, 'proses'])->name('pengembalian.proses');
        Route::post('pengembalian',          [PengembalianController::class, 'store'])->name('pengembalian.store');
        Route::get('pengembalian/riwayat',   [PengembalianController::class, 'riwayat'])->name('pengembalian.riwayat');
    });

    // ── Pimpinan Routes ───────────────────────────────────────────────────
    Route::prefix('pimpinan')->name('pimpinan.')->middleware('role:admin,pimpinan')->group(function () {
        Route::get('laporan',          [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/pdf',      [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('laporan/excel',    [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    });

    // ── Anggota Routes ────────────────────────────────────────────────────
    Route::prefix('anggota')->name('anggota.')->middleware('role:anggota')->group(function () {
        Route::get('buku',          [BukuAnggotaController::class, 'index'])->name('buku.index');
        Route::get('buku/{buku}',   [BukuAnggotaController::class, 'show'])->name('buku.show');
        Route::get('riwayat',       [BukuAnggotaController::class, 'riwayat'])->name('riwayat');
    });
});
