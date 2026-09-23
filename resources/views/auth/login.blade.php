<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans min-h-screen">

<div class="min-h-screen flex flex-col">
    {{-- Topbar --}}
    <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 bg-blue-600 rounded-md flex items-center justify-center">
                <i class="fa fa-book-open text-white text-xs"></i>
            </div>
            <span class="font-bold text-gray-900">Sistem <span class="text-blue-600">Perpustakaan</span></span>
        </div>
        <a href="{{ route('welcome') }}" class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-house"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="flex-1 flex items-center justify-center py-10 px-4">
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-0 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            {{-- Left panel --}}
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-10 text-white flex flex-col justify-center">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fa fa-book-open text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang Kembali!</h2>
                <p class="text-blue-100 text-sm mb-8">Masuk ke Sistem Perpustakaan untuk mengelola data buku, anggota, dan transaksi peminjaman secara mudah, cepat, dan terorganisir.</p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 bg-white/10 rounded-xl p-3">
                        <i class="fa fa-shield-halved text-blue-200"></i>
                        <div>
                            <p class="text-xs font-semibold">Aman</p>
                            <p class="text-xs text-blue-200">Data terjaga dengan sistem keamanan terpercaya</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 rounded-xl p-3">
                        <i class="fa fa-bolt text-yellow-300"></i>
                        <div>
                            <p class="text-xs font-semibold">Cepat</p>
                            <p class="text-xs text-blue-200">Proses lebih cepat dan efisien dalam satu sistem</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 rounded-xl p-3">
                        <i class="fa fa-link text-green-300"></i>
                        <div>
                            <p class="text-xs font-semibold">Terintegrasi</p>
                            <p class="text-xs text-blue-200">Semua layanan terhubung dalam satu sistem terpadu</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right panel --}}
            <div class="p-10 flex flex-col justify-center">
                <h3 class="text-xl font-bold text-gray-900 mb-1">Masuk ke Akun Anda</h3>
                <p class="text-sm text-gray-500 mb-6">Silakan masukkan email dan password Anda untuk masuk</p>

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa fa-envelope text-gray-400 text-sm"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full pl-10 pr-4 py-2.5 border @error('email') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan email Anda">
                        </div>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa fa-lock text-gray-400 text-sm"></i>
                            </div>
                            <input type="password" name="password" id="pwd" required
                                class="w-full pl-10 pr-10 py-2.5 border @error('password') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan password Anda">
                            <button type="button" onclick="togglePwd()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="pwd-icon" class="fa fa-eye text-gray-400 text-sm"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
                            Ingat Saya
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Lupa Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl transition text-sm flex items-center justify-center gap-2">
                        <i class="fa fa-right-to-bracket"></i> Masuk
                    </button>

                    <div class="relative flex items-center justify-center text-xs text-gray-400 my-2">
                        <span class="absolute inset-x-0 top-1/2 h-px bg-gray-200"></span>
                        <span class="relative bg-white px-3">atau</span>
                    </div>

                    <a href="{{ route('register') }}" class="w-full flex items-center justify-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-2.5 px-4 rounded-xl transition text-sm">
                        <i class="fa fa-user-plus"></i> Daftar sebagai Anggota
                    </a>

                    <p class="text-center text-xs text-gray-500">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Daftar sekarang</a></p>
                </form>
            </div>
        </div>
    </div>
    <p class="text-center text-xs text-gray-400 pb-4">© {{ date('Y') }} Sistem Perpustakaan. Semua hak dilindungi.</p>
</div>

<script>
function togglePwd() {
    const i = document.getElementById('pwd');
    const icon = document.getElementById('pwd-icon');
    if (i.type === 'password') { i.type = 'text'; icon.className = 'fa fa-eye-slash text-gray-400 text-sm'; }
    else { i.type = 'password'; icon.className = 'fa fa-eye text-gray-400 text-sm'; }
}
</script>
</body>
</html>
