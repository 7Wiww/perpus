# Sistem Perpustakaan Digital

Aplikasi manajemen perpustakaan berbasis web yang dibangun dengan **Laravel** dan **MySQL**. Mendukung multi-role pengguna untuk mengelola koleksi buku, data anggota, transaksi peminjaman, pengembalian, dan laporan.

---

## Akun Login Default

| Role     | Email                    | Username  | Password   |
|----------|--------------------------|-----------|------------|
| Admin    | admin@perpus.ac.id       | admin     | password   |
| Petugas  | petugas@perpus.ac.id     | petugas   | password   |
| Pimpinan | pimpinan@perpus.ac.id    | pimpinan  | password   |
| Anggota  | siti@mahasiswa.ac.id     | siti      | password   |
| Anggota  | rafli@mahasiswa.ac.id    | rafli     | password   |
| Anggota  | dewi@mahasiswa.ac.id     | dewi      | password   |

> Password default anggota yang ditambahkan via admin: `password`

---

## Teknologi

- **Backend**: PHP 8.2, Laravel (versi terbaru)
- **Frontend**: Blade, Tailwind CSS, Font Awesome, Chart.js
- **Database**: MySQL
- **Paket tambahan**: `barryvdh/laravel-dompdf`, `maatwebsite/excel`, `laravel/breeze`

---

## Cara Menjalankan

```bash
# Masuk ke folder proyek
cd perpustakaan

# Install dependensi PHP
composer install

# Install dependensi Node & build asset
npm install && npm run build

# Salin file env
cp .env.example .env

# Generate app key
php artisan key:generate

# Atur database di .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# Jalankan migrasi & seeder
php artisan migrate --seed

# Buat symlink storage
php artisan storage:link

# Jalankan server
php artisan serve
```

Akses di: `http://127.0.0.1:8000`

---

## Fitur per Role

### Admin
- Dashboard statistik (total buku, anggota, peminjaman, pengembalian) dengan chart 7 hari
- **CRUD Buku** — tambah, lihat, edit, hapus buku beserta upload sampul
- **CRUD Anggota** — tambah, lihat, edit, hapus anggota dengan upload foto
- **CRUD Kategori** — kelola kategori buku
- **Kelola User** — tambah/edit/hapus akun Admin, Petugas, Pimpinan
- Akses ke semua fitur Petugas dan Laporan

### Petugas
- Dashboard statistik
- **Lihat Data Buku** — cari dan lihat detail buku (tanpa edit/hapus)
- **Lihat Data Anggota** — cari dan lihat detail anggota (tanpa edit/hapus)
- **Peminjaman Buku** — catat peminjaman baru, maks. 3 buku per anggota
- **Pengembalian Buku** — proses pengembalian, hitung denda otomatis (Rp 500/hari/buku)
- **Riwayat** peminjaman dan pengembalian
- **Laporan** — lihat statistik dan export PDF/Excel

### Pimpinan
- Dashboard statistik
- **Laporan & Statistik** — grafik peminjaman vs pengembalian per hari, top 5 buku terpinjam
- **Export PDF** laporan peminjaman (via DomPDF)
- **Export Excel** laporan peminjaman (via Maatwebsite Excel)

### Anggota
- Dashboard personal (buku aktif dipinjam, riwayat, estimasi denda)
- **Koleksi Buku** — cari dan lihat buku berdasarkan judul, penulis, atau kategori
- **Riwayat Peminjaman** — melihat seluruh history peminjaman dan status denda

---

## Struktur Database

| Tabel               | Keterangan                                  |
|---------------------|---------------------------------------------|
| `users`             | Akun pengguna dengan kolom `role`           |
| `kategoris`         | Kategori buku                               |
| `bukus`             | Data buku dengan stok dan status            |
| `anggotas`          | Profil anggota (relasi ke `users`)          |
| `peminjamans`       | Header transaksi peminjaman                 |
| `detail_peminjamans`| Detail buku per transaksi (many-to-many)    |
| `pengembalians`     | Data pengembalian + denda                   |

---

## Aturan Bisnis

- Maksimal **3 buku** per peminjaman per anggota
- Denda keterlambatan: **Rp 500 / hari / buku**
- Status peminjaman otomatis berubah menjadi **terlambat** jika melewati tanggal jatuh tempo
- Stok buku otomatis berkurang saat dipinjam dan bertambah saat dikembalikan

---

## Riwayat Perubahan

### v1.0.0 — Rilis Awal
- Setup Laravel + MySQL + Breeze authentication
- Multi-role: Admin, Petugas, Pimpinan, Anggota
- CRUD lengkap: Buku, Anggota, Kategori, User
- Sistem peminjaman & pengembalian dengan kalkulasi denda otomatis
- Laporan dengan export PDF dan Excel
- Halaman welcome, login, dan registrasi anggota
- Dashboard interaktif dengan Chart.js

### v1.0.1 — Perbaikan Bug
- **Bug fix**: Petugas tidak bisa mengakses halaman Data Buku (`/admin/buku`) — route middleware diperbarui agar `role:admin,petugas` dapat mengakses index dan show buku
- **Bug fix**: Petugas tidak bisa mengakses halaman Data Anggota (`/admin/anggota`) — middleware diperluas sama seperti buku
- **Bug fix**: Petugas tidak bisa mengakses halaman Laporan (`/pimpinan/laporan`) — middleware diperbarui menjadi `role:admin,petugas,pimpinan`
- Tombol Tambah/Edit/Hapus pada halaman Data Buku dan Data Anggota sekarang hanya tampil untuk Admin; Petugas hanya dapat melihat (read-only)

### v1.0.2 — Perbaikan Bug Logout
- **Bug fix**: Klik tombol Keluar menampilkan "Page Expired" (error 419 CSRF mismatch) — diperbaiki dengan mengambil CSRF token segar dari meta tag sebelum form disubmit via JavaScript, sehingga token selalu valid meski halaman sudah lama dibuka
