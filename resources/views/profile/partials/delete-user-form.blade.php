<p class="text-sm text-gray-600 mb-4">Setelah akun dihapus, semua data dan sumber daya akan dihapus secara permanen.</p>
<form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')">
    @csrf @method('delete')
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
        <input type="password" name="password" placeholder="Masukkan password untuk konfirmasi"
            class="w-full px-3 py-2.5 border @error('password', 'userDeletion') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-red-500">
        @error('password', 'userDeletion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold transition">
        Hapus Akun
    </button>
</form>
