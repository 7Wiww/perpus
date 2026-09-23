-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Sep 2026 pada 06.52
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggotas`
--

CREATE TABLE `anggotas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `no_anggota` varchar(255) NOT NULL,
  `nim_nip` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `program_studi` varchar(255) DEFAULT NULL,
  `fakultas_instansi` varchar(255) DEFAULT NULL,
  `jenis_anggota` enum('mahasiswa','dosen','staff','umum') NOT NULL DEFAULT 'mahasiswa',
  `tanggal_bergabung` date DEFAULT NULL,
  `status` enum('aktif','nonaktif','diblokir') NOT NULL DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `anggotas`
--

INSERT INTO `anggotas` (`id`, `user_id`, `no_anggota`, `nim_nip`, `no_telepon`, `alamat`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `program_studi`, `fakultas_instansi`, `jenis_anggota`, `tanggal_bergabung`, `status`, `foto`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 4, 'AGT0001', 'A2021001', '081445039300', 'Jl. Rancaekek No.1', NULL, NULL, NULL, 'Sistem Informasi', 'Universitas Ma\'soem', 'mahasiswa', '2025-06-21', 'aktif', NULL, NULL, '2026-09-21 07:12:10', '2026-09-21 07:12:10'),
(2, 5, 'AGT0002', 'A2022002', '081877735104', 'Jl. Rancaekek No.2', NULL, NULL, NULL, 'Teknik Informatika', 'Universitas Ma\'soem', 'mahasiswa', '2025-07-21', 'aktif', NULL, NULL, '2026-09-21 07:12:10', '2026-09-21 07:12:10'),
(3, 6, 'AGT0003', 'A2021003', '081354415591', 'Jl. Rancaekek No.3', NULL, NULL, NULL, 'Manajemen', 'Universitas Ma\'soem', 'mahasiswa', '2025-12-21', 'aktif', NULL, NULL, '2026-09-21 07:12:10', '2026-09-21 07:12:10'),
(4, 7, 'AGT0004', 'D19850101', '081427228315', 'Jl. Rancaekek No.4', NULL, NULL, NULL, 'Teknik Informatika', 'Universitas Ma\'soem', 'dosen', '2025-04-21', 'aktif', NULL, NULL, '2026-09-21 07:12:10', '2026-09-21 07:12:10'),
(5, 8, 'AGT0005', 'S2020001', '081479097175', 'Jl. Rancaekek No.5', NULL, NULL, NULL, NULL, 'Universitas Ma\'soem', 'staff', '2026-02-21', 'aktif', NULL, NULL, '2026-09-21 07:12:11', '2026-09-21 07:12:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bukus`
--

CREATE TABLE `bukus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `lokasi_rak` varchar(255) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 1,
  `stok_tersedia` int(11) NOT NULL DEFAULT 1,
  `deskripsi` text DEFAULT NULL,
  `sampul` varchar(255) DEFAULT NULL,
  `status` enum('tersedia','dipinjam','tidak_tersedia') NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bukus`
--

INSERT INTO `bukus` (`id`, `judul`, `penulis`, `penerbit`, `isbn`, `tahun_terbit`, `kategori_id`, `lokasi_rak`, `stok`, `stok_tersedia`, `deskripsi`, `sampul`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pemrograman Web Dasar', 'Eko Kurniawan', 'Informatika', '978-623-1234-01-1', '2023', 1, NULL, 12, 12, NULL, NULL, 'tersedia', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(2, 'Basis Data', 'Rosa A.S', 'Modula', '978-623-1234-02-8', '2022', 1, NULL, 8, 8, NULL, NULL, 'tersedia', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(3, 'Struktur Data', 'Adi Nugroho', 'Andi', '978-623-1234-03-5', '2021', 1, NULL, 15, 15, NULL, NULL, 'tersedia', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(4, 'Manajemen Perpustakaan', 'Haris Setiawan', 'Rosda', '978-623-1234-04-2', '2020', 2, NULL, 5, 5, NULL, NULL, 'tersedia', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(5, 'Pemasaran Digital', 'Philip Kotler', 'Erlangga', '978-623-1234-05-9', '2023', 3, NULL, 20, 20, NULL, NULL, 'tersedia', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(6, 'Algoritma & Pemrograman', 'Munir Rinaldi', 'Informatika', '978-623-1234-06-5', '2022', 1, NULL, 10, 10, NULL, NULL, 'tersedia', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(7, 'Jaringan Komputer', 'Onno W. Purbo', 'Elex Media', '978-623-1234-07-2', '2021', 1, NULL, 7, 7, NULL, NULL, 'tersedia', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(8, 'Komunikasi Efektif', 'Deddy Mulyana', 'Remaja Rosda', '978-623-1234-08-9', '2020', 4, NULL, 6, 6, NULL, NULL, 'tersedia', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(9, 'Akuntansi Dasar', 'Soemarso SR', 'Salemba Empat', '978-623-1234-09-6', '2022', 3, NULL, 9, 9, NULL, NULL, 'tersedia', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(10, 'Kecerdasan Buatan', 'Suyanto', 'Informatika', '978-623-1234-10-2', '2023', 1, NULL, 11, 11, NULL, NULL, 'tersedia', '2026-09-21 07:12:11', '2026-09-21 07:12:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_peminjamans`
--

CREATE TABLE `detail_peminjamans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `peminjaman_id` bigint(20) UNSIGNED NOT NULL,
  `buku_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Teknologi', 'Buku-buku bidang teknologi dan komputer', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(2, 'Manajemen', 'Buku-buku bidang manajemen dan bisnis', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(3, 'Ekonomi', 'Buku-buku bidang ekonomi dan keuangan', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(4, 'Komunikasi', 'Buku-buku bidang komunikasi dan jurnalistik', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(5, 'Pendidikan', 'Buku-buku bidang pendidikan dan pedagogik', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(6, 'Hukum', 'Buku-buku bidang hukum dan perundangan', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(7, 'Sastra', 'Buku-buku sastra dan karya fiksi', '2026-09-21 07:12:11', '2026-09-21 07:12:11'),
(8, 'Referensi', 'Ensiklopedi, kamus, dan buku referensi', '2026-09-21 07:12:11', '2026-09-21 07:12:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_kategoris_table', 1),
(5, '2024_01_01_000002_create_bukus_table', 1),
(6, '2024_01_01_000003_create_anggotas_table', 1),
(7, '2024_01_01_000004_create_peminjamans_table', 1),
(8, '2024_01_01_000005_create_detail_peminjamans_table', 1),
(9, '2024_01_01_000006_create_pengembalians_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `anggota_id` bigint(20) UNSIGNED NOT NULL,
  `petugas_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan','terlambat') NOT NULL DEFAULT 'dipinjam',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalians`
--

CREATE TABLE `pengembalians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `peminjaman_id` bigint(20) UNSIGNED NOT NULL,
  `petugas_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `hari_terlambat` int(11) NOT NULL DEFAULT 0,
  `denda` decimal(10,2) NOT NULL DEFAULT 0.00,
  `kondisi_buku` enum('baik','rusak_ringan','rusak_berat','hilang') NOT NULL DEFAULT 'baik',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','pimpinan','anggota') NOT NULL DEFAULT 'anggota',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Perpustakaan', 'admin', 'admin@perpus.ac.id', NULL, '$2y$12$yD5ZAEmZ7suK/wh1zKSlEeecFkQ.GGQT/.YRdhgPP29JAfZkJAdP.', 'admin', 1, NULL, '2026-09-21 07:12:09', '2026-09-21 07:12:09'),
(2, 'Petugas Perpustakaan', 'petugas', 'petugas@perpus.ac.id', NULL, '$2y$12$FwRRuQAkfiQ8te71uoL/rOc8fj3KjawGmcifOEjK8qDRmO3ddqIKu', 'petugas', 1, NULL, '2026-09-21 07:12:10', '2026-09-21 07:12:10'),
(3, 'Pimpinan Perpustakaan', 'pimpinan', 'pimpinan@perpus.ac.id', NULL, '$2y$12$iqxtncNX930Mqrn53UbLAexSf8uhGsLnRLVwSqSwZGprbnmwdL4fC', 'pimpinan', 1, NULL, '2026-09-21 07:12:10', '2026-09-21 07:12:10'),
(4, 'Siti Nurhaliza', 'siti', 'siti@mahasiswa.ac.id', NULL, '$2y$12$9in9vZBlaMkY5rw8GBREQOFwRGfkvVcyLM6IQN2ot8Mhxut9I998q', 'anggota', 1, NULL, '2026-09-21 07:12:10', '2026-09-21 07:12:10'),
(5, 'Muhammad Rafli', 'rafli', 'rafli@mahasiswa.ac.id', NULL, '$2y$12$2vr33hIbjlcfVlLYlVCRkexnSME55mSFCmigzHzCroXZX50BRMyIq', 'anggota', 1, NULL, '2026-09-21 07:12:10', '2026-09-21 07:12:10'),
(6, 'Dewi Lestari', 'dewi', 'dewi@mahasiswa.ac.id', NULL, '$2y$12$tjFIkzzAIVvWBUZYs4QDQuAmAZ5kiZojDEOvkOePaZvjecWN5J.Rq', 'anggota', 1, NULL, '2026-09-21 07:12:10', '2026-09-21 07:12:10'),
(7, 'Budi Santoso', 'budi', 'budi@kampus.ac.id', NULL, '$2y$12$nIu6fznV2WEmMsGyPH4ZFO5SVsX8MdnNBzlJXm3I4W6kmPplFwUzC', 'anggota', 1, NULL, '2026-09-21 07:12:10', '2026-09-21 07:12:10'),
(8, 'Rina Handayani', 'rina', 'rina@kampus.ac.id', NULL, '$2y$12$I.8vTSaWDzsj1ctIW1XQSOrtAZM2mpkgZel4ID2YVMhrMX1O4sWIe', 'anggota', 1, NULL, '2026-09-21 07:12:11', '2026-09-21 07:12:11');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggotas`
--
ALTER TABLE `anggotas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anggotas_no_anggota_unique` (`no_anggota`),
  ADD UNIQUE KEY `anggotas_nim_nip_unique` (`nim_nip`),
  ADD KEY `anggotas_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `bukus`
--
ALTER TABLE `bukus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bukus_isbn_unique` (`isbn`),
  ADD KEY `bukus_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `detail_peminjamans`
--
ALTER TABLE `detail_peminjamans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_peminjamans_peminjaman_id_foreign` (`peminjaman_id`),
  ADD KEY `detail_peminjamans_buku_id_foreign` (`buku_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategoris_nama_kategori_unique` (`nama_kategori`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peminjamans_kode_transaksi_unique` (`kode_transaksi`),
  ADD KEY `peminjamans_anggota_id_foreign` (`anggota_id`),
  ADD KEY `peminjamans_petugas_id_foreign` (`petugas_id`);

--
-- Indeks untuk tabel `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengembalians_peminjaman_id_foreign` (`peminjaman_id`),
  ADD KEY `pengembalians_petugas_id_foreign` (`petugas_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggotas`
--
ALTER TABLE `anggotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `bukus`
--
ALTER TABLE `bukus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `detail_peminjamans`
--
ALTER TABLE `detail_peminjamans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengembalians`
--
ALTER TABLE `pengembalians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggotas`
--
ALTER TABLE `anggotas`
  ADD CONSTRAINT `anggotas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `bukus`
--
ALTER TABLE `bukus`
  ADD CONSTRAINT `bukus_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`);

--
-- Ketidakleluasaan untuk tabel `detail_peminjamans`
--
ALTER TABLE `detail_peminjamans`
  ADD CONSTRAINT `detail_peminjamans_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `bukus` (`id`),
  ADD CONSTRAINT `detail_peminjamans_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjamans` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggotas` (`id`),
  ADD CONSTRAINT `peminjamans_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD CONSTRAINT `pengembalians_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjamans` (`id`),
  ADD CONSTRAINT `pengembalians_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
