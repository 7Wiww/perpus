<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Perpustakaan')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">

{{-- Mobile overlay --}}
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden" onclick="closeSidebar()"></div>

<div class="flex h-screen overflow-hidden">
    {{-- ── Sidebar ─────────────────────────────────────────────────────────── --}}
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-200 flex flex-col shadow-sm transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        {{-- Brand --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fa fa-book-open text-white text-sm"></i>
            </div>
            <div>
                <p class="font-bold text-gray-900 text-sm leading-tight">Sistem</p>
                <p class="font-bold text-blue-600 text-sm leading-tight">Perpustakaan</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            @php $role = auth()->user()->role; @endphp

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-gauge-high w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            @if(in_array($role, ['admin']))
                <p class="nav-section">ADMINISTRASI</p>
                <a href="{{ route('admin.buku.index') }}" class="nav-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
                    <i class="fa fa-book w-5 text-center"></i><span>Data Buku</span>
                </a>
                <a href="{{ route('admin.anggota.index') }}" class="nav-link {{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}">
                    <i class="fa fa-users w-5 text-center"></i><span>Data Anggota</span>
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                    <i class="fa fa-tags w-5 text-center"></i><span>Kategori Buku</span>
                </a>
                <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <i class="fa fa-user-shield w-5 text-center"></i><span>Kelola User</span>
                </a>
            @endif

            @if(in_array($role, ['admin', 'petugas']))
                <p class="nav-section">TRANSAKSI</p>
                @if($role === 'petugas')
                <a href="{{ route('admin.buku.index') }}" class="nav-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
                    <i class="fa fa-book w-5 text-center"></i><span>Data Buku</span>
                </a>
                <a href="{{ route('admin.anggota.index') }}" class="nav-link {{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}">
                    <i class="fa fa-users w-5 text-center"></i><span>Data Anggota</span>
                </a>
                @endif
                <a href="{{ route('petugas.peminjaman.index') }}" class="nav-link {{ request()->routeIs('petugas.peminjaman.*') ? 'active' : '' }}">
                    <i class="fa fa-file-export w-5 text-center"></i><span>Peminjaman Buku</span>
                </a>
                <a href="{{ route('petugas.pengembalian.index') }}" class="nav-link {{ request()->routeIs('petugas.pengembalian.*') ? 'active' : '' }}">
                    <i class="fa fa-file-import w-5 text-center"></i><span>Pengembalian Buku</span>
                </a>
                <a href="{{ route('pimpinan.laporan.index') }}" class="nav-link {{ request()->routeIs('pimpinan.laporan.*') ? 'active' : '' }}">
                    <i class="fa fa-chart-bar w-5 text-center"></i><span>Laporan</span>
                </a>
            @endif

            @if($role === 'pimpinan')
                <p class="nav-section">LAPORAN</p>
                <a href="{{ route('pimpinan.laporan.index') }}" class="nav-link {{ request()->routeIs('pimpinan.laporan.*') ? 'active' : '' }}">
                    <i class="fa fa-chart-line w-5 text-center"></i><span>Laporan & Statistik</span>
                </a>
            @endif

            @if($role === 'anggota')
                <p class="nav-section">PERPUSTAKAAN</p>
                <a href="{{ route('anggota.buku.index') }}" class="nav-link {{ request()->routeIs('anggota.buku.*') ? 'active' : '' }}">
                    <i class="fa fa-book-open w-5 text-center"></i><span>Koleksi Buku</span>
                </a>
                <a href="{{ route('anggota.riwayat') }}" class="nav-link {{ request()->routeIs('anggota.riwayat') ? 'active' : '' }}">
                    <i class="fa fa-clock-rotate-left w-5 text-center"></i><span>Riwayat Peminjaman</span>
                </a>
            @endif
        </nav>

        {{-- Footer sidebar --}}
        <div class="px-4 py-4 border-t border-gray-100">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fa fa-user text-blue-600 text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                    <i class="fa fa-right-from-bracket text-sm"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main content ─────────────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-200 px-4 lg:px-6 py-3 flex items-center gap-4">
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700">
                <i class="fa fa-bars text-lg"></i>
            </button>
            <div class="flex-1">
                <h1 class="text-base font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if(auth()->user()->role === 'admin') bg-purple-100 text-purple-700
                    @elseif(auth()->user()->role === 'petugas') bg-blue-100 text-blue-700
                    @elseif(auth()->user()->role === 'pimpinan') bg-green-100 text-green-700
                    @else bg-orange-100 text-orange-700 @endif capitalize">
                    {{ auth()->user()->role }}
                </span>
                <a href="{{ route('profile.edit') }}" class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition">
                    <i class="fa fa-user text-gray-600 text-xs"></i>
                </a>
            </div>
        </header>

        {{-- Alert messages --}}
        <div class="px-4 lg:px-6">
            @if(session('success'))
                <div class="mt-4 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm" id="alert-success">
                    <i class="fa fa-circle-check text-green-500"></i>
                    <span class="flex-1">{{ session('success') }}</span>
                    <button onclick="document.getElementById('alert-success').remove()" class="text-green-500 hover:text-green-700"><i class="fa fa-times"></i></button>
                </div>
            @endif
            @if(session('error'))
                <div class="mt-4 flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 text-sm" id="alert-error">
                    <i class="fa fa-circle-xmark text-red-500"></i>
                    <span class="flex-1">{{ session('error') }}</span>
                    <button onclick="document.getElementById('alert-error').remove()" class="text-red-500 hover:text-red-700"><i class="fa fa-times"></i></button>
                </div>
            @endif
        </div>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-6">
            @yield('content')
        </main>
    </div>
</div>

<style>
.nav-link {
    display: flex; align-items: center; gap: 0.625rem;
    padding: 0.5rem 0.75rem; border-radius: 0.5rem;
    font-size: 0.875rem; color: #4b5563;
    transition: all 0.15s; text-decoration: none;
}
.nav-link:hover { background: #f3f4f6; color: #1d4ed8; }
.nav-link.active { background: #eff6ff; color: #1d4ed8; font-weight: 600; }
.nav-link.active i { color: #1d4ed8; }
.nav-section {
    padding: 0.75rem 0.75rem 0.25rem;
    font-size: 0.65rem; font-weight: 700;
    letter-spacing: 0.1em; color: #9ca3af;
    text-transform: uppercase;
}
</style>

<script>
function toggleSidebar() {
    const s = document.getElementById('sidebar');
    const o = document.getElementById('sidebar-overlay');
    s.classList.toggle('-translate-x-full');
    o.classList.toggle('hidden');
}
function closeSidebar() {
    const s = document.getElementById('sidebar');
    const o = document.getElementById('sidebar-overlay');
    s.classList.add('-translate-x-full');
    o.classList.add('hidden');
}
// Auto dismiss alerts
setTimeout(() => {
    ['alert-success','alert-error'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.remove();
    });
}, 5000);
</script>
@stack('scripts')
</body>
</html>
