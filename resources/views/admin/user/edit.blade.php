@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">

    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500 flex items-center gap-1">
            <a href="{{ route('admin.user.index') }}" class="hover:text-blue-600">Kelola User</a>
            <i class="fa fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Edit User</span>
        </nav>
        <a href="{{ route('admin.user.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition">
            <i class="fa fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="w-9 h-9 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa fa-user-pen text-yellow-600"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 text-sm">Edit User: {{ $user->name }}</h3>
                <p class="text-xs text-gray-400 capitalize">Role saat ini: {{ $user->role }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.user.update', $user) }}" class="p-6 space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3.5 py-2.5 border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    @error('name') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                        class="w-full px-3.5 py-2.5 border {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    @error('username') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-3.5 py-2.5 border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                @error('email') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach([
                        'admin'    => ['Admin',    'Akses penuh ke semua fitur',      'purple'],
                        'petugas'  => ['Petugas',  'Kelola peminjaman & pengembalian', 'blue'],
                        'pimpinan' => ['Pimpinan', 'Lihat laporan & statistik',        'green'],
                    ] as $val => [$lbl, $desc, $color])
                    <label class="flex items-start gap-3 p-3.5 border-2 rounded-xl cursor-pointer transition
                        {{ old('role', $user->role) === $val ? 'border-'.$color.'-500 bg-'.$color.'-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" name="role" value="{{ $val }}"
                            {{ old('role', $user->role) === $val ? 'checked' : '' }}
                            class="mt-0.5 text-{{ $color }}-600">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $lbl }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $desc }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Status aktif --}}
            <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-xl">
                <div>
                    <p class="text-sm font-medium text-gray-700">Status Akun</p>
                    <p class="text-xs text-gray-400 mt-0.5">Nonaktifkan untuk mencegah user login</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-2 text-sm font-medium text-gray-600">Aktif</span>
                </label>
            </div>

            <div class="border-t border-gray-100 pt-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Ubah Password <span class="text-gray-400 font-normal normal-case">(kosongkan jika tidak diubah)</span></p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password" id="pwd"
                            placeholder="Minimal 8 karakter"
                            class="w-full px-3.5 py-2.5 pr-10 border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <button type="button" onclick="togglePwd('pwd','pwd-icon')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i id="pwd-icon" class="fa fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="pwd2"
                            placeholder="Ulangi password baru"
                            class="w-full px-3.5 py-2.5 pr-10 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <button type="button" onclick="togglePwd('pwd2','pwd2-icon')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i id="pwd2-icon" class="fa fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                <a href="{{ route('admin.user.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                    <i class="fa fa-times text-xs"></i> Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                    <i class="fa fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function togglePwd(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa fa-eye-slash text-sm';
    } else {
        input.type = 'password';
        icon.className = 'fa fa-eye text-sm';
    }
}
</script>
@endpush
@endsection
