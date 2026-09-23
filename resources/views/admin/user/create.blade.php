@extends('layouts.app')
@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')
<div class="max-w-xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('admin.user.index') }}" class="hover:text-blue-600">User</a>
            <span class="mx-1">/</span><span class="text-gray-800">Tambah</span>
        </nav>
        <a href="{{ route('admin.user.index') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-900 mb-5">Tambah User Baru</h3>
        <form method="POST" action="{{ route('admin.user.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="form-input">
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username') }}" required class="form-input">
                    @error('username') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="form-input">
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Role <span class="text-red-500">*</span></label>
                    <select name="role" required class="form-input">
                        <option value="">Pilih Role</option>
                        @foreach(['admin'=>'Admin','petugas'=>'Petugas','pimpinan'=>'Pimpinan'] as $val => $label)
                            <option value="{{ $val }}" {{ old('role') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required class="form-input">
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required class="form-input">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.user.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition flex items-center gap-2">
                    <i class="fa fa-floppy-disk"></i> Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
<style>
.form-label { @apply block text-sm font-medium text-gray-700 mb-1; }
.form-input  { @apply w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent; }
.form-error  { @apply text-red-500 text-xs mt-1; }
</style>
@endsection
