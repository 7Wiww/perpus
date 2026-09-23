<form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf @method('patch')
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name"
            class="w-full px-3 py-2.5 border @error('name') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
            class="w-full px-3 py-2.5 border @error('email') border-red-400 @else border-gray-300 @enderror rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="flex justify-end">
        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition">
            Simpan Perubahan
        </button>
    </div>
    @if (session('status') === 'profile-updated')
        <p class="text-green-600 text-sm">Profil berhasil diperbarui.</p>
    @endif
</form>
