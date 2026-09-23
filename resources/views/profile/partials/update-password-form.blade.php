<form method="POST" action="{{ route('password.update') }}" class="space-y-4">
    @csrf @method('put')
    <div>
        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
        <input type="password" id="current_password" name="current_password" autocomplete="current-password"
            class="w-full px-3 py-2.5 border @error('current_password') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
        @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
        <input type="password" id="password" name="password" autocomplete="new-password"
            class="w-full px-3 py-2.5 border @error('password') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
            class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="flex justify-end">
        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition">
            Ubah Password
        </button>
    </div>
    @if (session('status') === 'password-updated')
        <p class="text-green-600 text-sm">Password berhasil diubah.</p>
    @endif
</form>
