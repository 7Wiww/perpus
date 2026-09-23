<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ─────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin Perpustakaan',
            'username' => 'admin',
            'email'    => 'admin@perpus.ac.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'is_active' => true,
        ]);

        $petugas = User::create([
            'name'     => 'Petugas Perpustakaan',
            'username' => 'petugas',
            'email'    => 'petugas@perpus.ac.id',
            'password' => Hash::make('password'),
            'role'     => 'petugas',
            'is_active' => true,
        ]);

        User::create([
            'name'     => 'Pimpinan Perpustakaan',
            'username' => 'pimpinan',
            'email'    => 'pimpinan@perpus.ac.id',
            'password' => Hash::make('password'),
            'role'     => 'pimpinan',
            'is_active' => true,
        ]);

        // Anggota users
        $anggotaData = [
            ['name' => 'Siti Nurhaliza',  'username' => 'siti',   'email' => 'siti@mahasiswa.ac.id',    'nim_nip' => 'A2021001', 'jenis' => 'mahasiswa', 'prodi' => 'Sistem Informasi'],
            ['name' => 'Muhammad Rafli',  'username' => 'rafli',  'email' => 'rafli@mahasiswa.ac.id',   'nim_nip' => 'A2022002', 'jenis' => 'mahasiswa', 'prodi' => 'Teknik Informatika'],
            ['name' => 'Dewi Lestari',    'username' => 'dewi',   'email' => 'dewi@mahasiswa.ac.id',    'nim_nip' => 'A2021003', 'jenis' => 'mahasiswa', 'prodi' => 'Manajemen'],
            ['name' => 'Budi Santoso',    'username' => 'budi',   'email' => 'budi@kampus.ac.id',       'nim_nip' => 'D19850101', 'jenis' => 'dosen',    'prodi' => 'Teknik Informatika'],
            ['name' => 'Rina Handayani',  'username' => 'rina',   'email' => 'rina@kampus.ac.id',       'nim_nip' => 'S2020001', 'jenis' => 'staff',    'prodi' => null],
        ];

        foreach ($anggotaData as $i => $a) {
            $user = User::create([
                'name'     => $a['name'],
                'username' => $a['username'],
                'email'    => $a['email'],
                'password' => Hash::make('password'),
                'role'     => 'anggota',
                'is_active' => true,
            ]);
            Anggota::create([
                'user_id'          => $user->id,
                'no_anggota'       => 'AGT' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nim_nip'          => $a['nim_nip'],
                'jenis_anggota'    => $a['jenis'],
                'program_studi'    => $a['prodi'],
                'fakultas_instansi'=> 'Universitas Ma\'soem',
                'no_telepon'       => '081' . rand(100000000, 999999999),
                'alamat'           => 'Jl. Rancaekek No.' . ($i + 1),
                'status'           => 'aktif',
                'tanggal_bergabung'=> Carbon::now()->subMonths(rand(1, 24)),
            ]);
        }

        // ── Kategoris ─────────────────────────────────────────────
        $kategoris = [
            ['nama_kategori' => 'Teknologi',    'deskripsi' => 'Buku-buku bidang teknologi dan komputer'],
            ['nama_kategori' => 'Manajemen',    'deskripsi' => 'Buku-buku bidang manajemen dan bisnis'],
            ['nama_kategori' => 'Ekonomi',      'deskripsi' => 'Buku-buku bidang ekonomi dan keuangan'],
            ['nama_kategori' => 'Komunikasi',   'deskripsi' => 'Buku-buku bidang komunikasi dan jurnalistik'],
            ['nama_kategori' => 'Pendidikan',   'deskripsi' => 'Buku-buku bidang pendidikan dan pedagogik'],
            ['nama_kategori' => 'Hukum',        'deskripsi' => 'Buku-buku bidang hukum dan perundangan'],
            ['nama_kategori' => 'Sastra',       'deskripsi' => 'Buku-buku sastra dan karya fiksi'],
            ['nama_kategori' => 'Referensi',    'deskripsi' => 'Ensiklopedi, kamus, dan buku referensi'],
        ];

        foreach ($kategoris as $k) {
            Kategori::create($k);
        }

        // ── Bukus ─────────────────────────────────────────────────
        $bukus = [
            ['judul' => 'Pemrograman Web Dasar',         'penulis' => 'Eko Kurniawan',    'penerbit' => 'Informatika',    'isbn' => '978-623-1234-01-1', 'tahun' => 2023, 'kategori' => 'Teknologi',  'stok' => 12],
            ['judul' => 'Basis Data',                    'penulis' => 'Rosa A.S',         'penerbit' => 'Modula',         'isbn' => '978-623-1234-02-8', 'tahun' => 2022, 'kategori' => 'Teknologi',  'stok' => 8],
            ['judul' => 'Struktur Data',                 'penulis' => 'Adi Nugroho',      'penerbit' => 'Andi',           'isbn' => '978-623-1234-03-5', 'tahun' => 2021, 'kategori' => 'Teknologi',  'stok' => 15],
            ['judul' => 'Manajemen Perpustakaan',        'penulis' => 'Haris Setiawan',   'penerbit' => 'Rosda',          'isbn' => '978-623-1234-04-2', 'tahun' => 2020, 'kategori' => 'Manajemen',  'stok' => 5],
            ['judul' => 'Pemasaran Digital',             'penulis' => 'Philip Kotler',    'penerbit' => 'Erlangga',       'isbn' => '978-623-1234-05-9', 'tahun' => 2023, 'kategori' => 'Ekonomi',    'stok' => 20],
            ['judul' => 'Algoritma & Pemrograman',       'penulis' => 'Munir Rinaldi',    'penerbit' => 'Informatika',    'isbn' => '978-623-1234-06-5', 'tahun' => 2022, 'kategori' => 'Teknologi',  'stok' => 10],
            ['judul' => 'Jaringan Komputer',             'penulis' => 'Onno W. Purbo',    'penerbit' => 'Elex Media',     'isbn' => '978-623-1234-07-2', 'tahun' => 2021, 'kategori' => 'Teknologi',  'stok' => 7],
            ['judul' => 'Komunikasi Efektif',            'penulis' => 'Deddy Mulyana',    'penerbit' => 'Remaja Rosda',   'isbn' => '978-623-1234-08-9', 'tahun' => 2020, 'kategori' => 'Komunikasi', 'stok' => 6],
            ['judul' => 'Akuntansi Dasar',               'penulis' => 'Soemarso SR',      'penerbit' => 'Salemba Empat',  'isbn' => '978-623-1234-09-6', 'tahun' => 2022, 'kategori' => 'Ekonomi',    'stok' => 9],
            ['judul' => 'Kecerdasan Buatan',             'penulis' => 'Suyanto',          'penerbit' => 'Informatika',    'isbn' => '978-623-1234-10-2', 'tahun' => 2023, 'kategori' => 'Teknologi',  'stok' => 11],
        ];

        foreach ($bukus as $b) {
            $kategori = Kategori::where('nama_kategori', $b['kategori'])->first();
            Buku::create([
                'judul'         => $b['judul'],
                'penulis'       => $b['penulis'],
                'penerbit'      => $b['penerbit'],
                'isbn'          => $b['isbn'],
                'tahun_terbit'  => $b['tahun'],
                'kategori_id'   => $kategori->id,
                'stok'          => $b['stok'],
                'stok_tersedia' => $b['stok'],
                'status'        => 'tersedia',
            ]);
        }
    }
}
