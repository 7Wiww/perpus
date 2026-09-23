<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans">

{{-- Navbar --}}
<nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fa fa-book-open text-white text-sm"></i>
            </div>
            <span class="font-bold text-gray-900 text-lg">Sistem <span class="text-blue-600">Perpustakaan</span></span>
        </div>
        @auth
            <a href="{{ route('dashboard') }}" class="btn-primary">Ke Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn-primary"><i class="fa fa-right-to-bracket mr-1"></i> Masuk</a>
        @endauth
    </div>
</nav>

{{-- Hero --}}
<section class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-12">
        <div class="flex-1 text-center lg:text-left">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                Selamat Datang di<br>
                <span class="text-blue-600">Sistem Perpustakaan</span>
            </h1>
            <p class="text-lg text-gray-600 mb-8 max-w-xl">
                Kelola koleksi, peminjaman, dan informasi perpustakaan dengan mudah, cepat, dan terorganisir.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="{{ route('login') }}" class="btn-primary text-center py-3 px-8 text-base">
                    <i class="fa fa-book mr-2"></i> Jelajahi Perpustakaan
                </a>
                <a href="{{ route('register') }}" class="btn-outline text-center py-3 px-8 text-base">
                    <i class="fa fa-user-plus mr-2"></i> Daftar Anggota
                </a>
            </div>

            <div class="mt-10 grid grid-cols-3 gap-6">
                <div class="feature-item">
                    <i class="fa fa-shield-halved text-blue-600 text-xl mb-2"></i>
                    <p class="text-xs font-semibold text-gray-700">Aman</p>
                    <p class="text-xs text-gray-500">Data terjaga</p>
                </div>
                <div class="feature-item">
                    <i class="fa fa-bolt text-yellow-500 text-xl mb-2"></i>
                    <p class="text-xs font-semibold text-gray-700">Efisien</p>
                    <p class="text-xs text-gray-500">Cepat & mudah</p>
                </div>
                <div class="feature-item">
                    <i class="fa fa-link text-green-500 text-xl mb-2"></i>
                    <p class="text-xs font-semibold text-gray-700">Terintegrasi</p>
                    <p class="text-xs text-gray-500">Satu sistem</p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex justify-center">
            <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-sm border border-gray-100">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <i class="fa fa-book-open text-blue-600 text-2xl"></i>
                    </div>
                    <h2 class="font-bold text-gray-900 text-lg">Perpustakaan Digital</h2>
                    <p class="text-sm text-gray-500">Universitas Ma'soem</p>
                </div>
                <div class="space-y-3">
                    <div class="stat-card bg-blue-50">
                        <i class="fa fa-book text-blue-600"></i>
                        <div>
                            <p class="text-xs text-gray-500">Total Koleksi</p>
                            <p class="font-bold text-gray-900">{{ \App\Models\Buku::count() }} Buku</p>
                        </div>
                    </div>
                    <div class="stat-card bg-green-50">
                        <i class="fa fa-users text-green-600"></i>
                        <div>
                            <p class="text-xs text-gray-500">Anggota Aktif</p>
                            <p class="font-bold text-gray-900">{{ \App\Models\Anggota::where('status','aktif')->count() }} Orang</p>
                        </div>
                    </div>
                    <div class="stat-card bg-orange-50">
                        <i class="fa fa-file-export text-orange-600"></i>
                        <div>
                            <p class="text-xs text-gray-500">Sedang Dipinjam</p>
                            <p class="font-bold text-gray-900">{{ \App\Models\Peminjaman::whereIn('status',['dipinjam','terlambat'])->count() }} Buku</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Fitur Utama Sistem</h2>
            <p class="text-gray-500 mt-2">Solusi lengkap pengelolaan perpustakaan digital</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['icon'=>'fa-book','color'=>'blue','title'=>'Manajemen Buku','desc'=>'Kelola koleksi buku, kategori, stok, dan informasi lengkap setiap buku.'],
                ['icon'=>'fa-users','color'=>'green','title'=>'Data Anggota','desc'=>'Kelola data anggota perpustakaan dengan informasi lengkap dan status keanggotaan.'],
                ['icon'=>'fa-file-export','color'=>'purple','title'=>'Peminjaman','desc'=>'Catat dan pantau transaksi peminjaman buku dengan mudah dan akurat.'],
                ['icon'=>'fa-file-import','color'=>'orange','title'=>'Pengembalian','desc'=>'Proses pengembalian buku, hitung denda keterlambatan secara otomatis.'],
                ['icon'=>'fa-chart-bar','color'=>'red','title'=>'Laporan','desc'=>'Hasilkan laporan komprehensif peminjaman, pengembalian, dan statistik.'],
                ['icon'=>'fa-magnifying-glass','color'=>'teal','title'=>'Pencarian','desc'=>'Cari buku berdasarkan judul, penulis, ISBN, atau kategori dengan cepat.'],
            ] as $f)
            <div class="p-6 rounded-2xl border border-gray-100 hover:shadow-md transition bg-white">
                <div class="w-12 h-12 bg-{{ $f['color'] }}-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fa {{ $f['icon'] }} text-{{ $f['color'] }}-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">{{ $f['title'] }}</h3>
                <p class="text-sm text-gray-500">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<footer class="bg-gray-900 text-gray-400 text-center py-6 text-sm">
    <p>© {{ date('Y') }} Sistem Perpustakaan – Universitas Ma'soem. Semua hak dilindungi.</p>
</footer>

<style>
.btn-primary { @apply inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl transition text-sm; }
.btn-outline  { @apply inline-flex items-center border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold py-2 px-5 rounded-xl transition text-sm; }
.feature-item { @apply flex flex-col items-center p-3 bg-white rounded-xl border border-gray-100; }
.stat-card    { @apply flex items-center gap-3 p-3 rounded-xl; }
</style>
</body>
</html>
