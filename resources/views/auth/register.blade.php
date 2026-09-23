<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Anggota – Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">
<div class="min-h-screen flex flex-col">
    <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 bg-blue-600 rounded-md flex items-center justify-center">
                <i class="fa fa-book-open text-white text-xs"></i>
            </div>
            <span class="font-bold text-gray-900">Sistem <span class="text-blue-600">Perpustakaan</span></span>
        </div>
        <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-right-to-bracket"></i> Sudah punya akun? <span class="font-semibold text-blue-600">Masuk</span>
        </a>
    </div>

    <div class="flex-1 flex items-center justify-center py-10 px-4">
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-0 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            {{-- Left --}}
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-10 text-white flex flex-col justify-center">
                <h2 class="text-2xl font-bold mb-3">Registrasi Anggota</h2>
                <p class="text-blue-100 text-sm mb-8">Daftarkan diri Anda untuk mendapatkan akses layanan perpustakaan digital dengan mudah dan cepat.</p>
                <div class="grid grid-cols-1 gap-4">
                    @foreach([['fa-book','Akses Koleksi Buku','Dapatkan akses ke berbagai koleksi buku dan referensi berkualitas'],['fa-rotate-left','Peminjaman Mudah','Pinjam dan kembalikan buku dengan proses yang cepat dan praktis'],['fa-clock-rotate-left','Riwayat Aktivitas','Lihat riwayat peminjaman dan aktivitas perpustakaan Anda kapan saja']] as $f)
                    <div class="bg-white/10 rounded-xl p-4 flex items-start gap-3">
                        <i class="fa {{ $f[0] }} text-white mt-0.5"></i>
                        <div>
                            <p class="text-sm font-semibold">{{ $f[1] }}</p>
                            <p class="text-xs text-blue-200">{{ $f[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right --}}
            <div class="p-10 overflow-y-auto">
                <h3 class="text-xl font-bold text-gray-900 mb-1">Buat Akun Anggota</h3>
                <p class="text-sm text-gray-500 mb-6">Lengkapi data diri Anda dengan benar untuk proses registrasi</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa fa-user absolute left-3 top-3 text-gray-400 text-sm"></i>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full pl-9 pr-3 py-2.5 border @error('name') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan nama lengkap Anda">
                            </div>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
                            <input type="text" name="username" value="{{ old('username') }}" required
                                class="w-full px-3 py-2.5 border @error('username') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Username unik">
                            @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa fa-envelope absolute left-3 top-3 text-gray-400 text-sm"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full pl-9 pr-3 py-2.5 border @error('email') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan email Anda">
                            </div>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <div class="relative">
                                <i class="fa fa-phone absolute left-3 top-3 text-gray-400 text-sm"></i>
                                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                                    class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan nomor telepon">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <div class="relative">
                            <i class="fa fa-location-dot absolute left-3 top-3 text-gray-400 text-sm"></i>
                            <input type="text" name="alamat" value="{{ old('alamat') }}"
                                class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan alamat lengkap Anda">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa fa-lock absolute left-3 top-3 text-gray-400 text-sm"></i>
                                <input type="password" name="password" id="pwd" required
                                    class="w-full pl-9 pr-9 py-2.5 border @error('password') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Buat password Anda">
                                <button type="button" onclick="togglePwd('pwd','pwd-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i id="pwd-icon" class="fa fa-eye text-gray-400 text-sm"></i>
                                </button>
                            </div>
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa fa-lock absolute left-3 top-3 text-gray-400 text-sm"></i>
                                <input type="password" name="password_confirmation" id="pwd2" required
                                    class="w-full pl-9 pr-9 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Konfirmasi password Anda">
                                <button type="button" onclick="togglePwd('pwd2','pwd2-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i id="pwd2-icon" class="fa fa-eye text-gray-400 text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-xs text-blue-700 flex items-start gap-2">
                        <i class="fa fa-circle-info mt-0.5"></i>
                        <span>Gunakan minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk keamanan akun Anda.</span>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl transition text-sm flex items-center justify-center gap-2">
                        <i class="fa fa-user-plus"></i> Daftar Sekarang
                    </button>

                    <p class="text-center text-xs text-gray-500">Dengan mendaftar, Anda menyetujui <a href="#" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> dan <a href="#" class="text-blue-600 hover:underline">Kebijakan Privasi</a>.</p>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function togglePwd(id, iconId) {
    const i = document.getElementById(id);
    const icon = document.getElementById(iconId);
    if (i.type === 'password') { i.type = 'text'; icon.className = 'fa fa-eye-slash text-gray-400 text-sm'; }
    else { i.type = 'password'; icon.className = 'fa fa-eye text-gray-400 text-sm'; }
}
</script>
</body>
</html>
