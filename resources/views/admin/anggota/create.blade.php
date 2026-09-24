@extends('layouts.app')
@section('title', 'Tambah Anggota')
@section('page-title', 'Tambah Anggota')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    {{-- Breadcrumb --}}
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500 flex items-center gap-1">
            <a href="{{ route('admin.anggota.index') }}" class="hover:text-blue-600">Data Anggota</a>
            <i class="fa fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Tambah Anggota</span>
        </nav>
        <a href="{{ route('admin.anggota.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition">
            <i class="fa fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.anggota.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- ── Kolom Kiri: Form ── --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Card: Akun Login --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa fa-user-circle text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm">Data Akun</h3>
                            <p class="text-xs text-gray-400">Informasi untuk login ke sistem</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                placeholder="Masukkan nama lengkap"
                                class="w-full px-3.5 py-2.5 border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('name') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                            <input type="text" name="username" value="{{ old('username') }}" required
                                placeholder="Username untuk login"
                                class="w-full px-3.5 py-2.5 border {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('username') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="contoh@email.com"
                                class="w-full px-3.5 py-2.5 border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('email') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-3 flex items-start gap-2.5 p-3 bg-blue-50 border border-blue-100 rounded-xl">
                        <i class="fa fa-circle-info text-blue-500 mt-0.5 flex-shrink-0"></i>
                        <p class="text-xs text-blue-700">Password default untuk anggota baru adalah <strong class="font-semibold">password</strong>. Anggota dapat menggantinya setelah login pertama kali.</p>
                    </div>
                </div>

                {{-- Card: Data Pribadi --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa fa-id-card text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm">Data Pribadi</h3>
                            <p class="text-xs text-gray-400">Informasi identitas anggota perpustakaan</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">NIM / No. Identitas</label>
                            <input type="text" name="nim_nip" value="{{ old('nim_nip') }}"
                                placeholder="Contoh: A2024001"
                                class="w-full px-3.5 py-2.5 border {{ $errors->has('nim_nip') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('nim_nip') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon</label>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                                <option value="">-- Pilih --</option>
                                <option value="laki-laki" {{ old('jenis_kelamin') === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Anggota <span class="text-red-500">*</span></label>
                            <select name="jenis_anggota" required
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                                @foreach(['mahasiswa'=>'Mahasiswa','dosen'=>'Dosen','staff'=>'Staff','umum'=>'Umum'] as $val => $lbl)
                                    <option value="{{ $val }}" {{ old('jenis_anggota') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                            <input type="text" name="alamat" value="{{ old('alamat') }}"
                                placeholder="Alamat lengkap anggota"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Program Studi / Jurusan</label>
                            <input type="text" name="program_studi" value="{{ old('program_studi') }}"
                                placeholder="Contoh: Teknik Informatika"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Fakultas / Instansi</label>
                            <input type="text" name="fakultas_instansi" value="{{ old('fakultas_instansi') }}"
                                placeholder="Contoh: Fakultas Teknik"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Bergabung</label>
                            <input type="date" name="tanggal_bergabung" value="{{ old('tanggal_bergabung', date('Y-m-d')) }}"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Anggota <span class="text-red-500">*</span></label>
                            <select name="status" required
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                                @foreach(['aktif'=>'Aktif','nonaktif'=>'Nonaktif','diblokir'=>'Diblokir'] as $val => $lbl)
                                    <option value="{{ $val }}" {{ old('status','aktif') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan</label>
                            <textarea name="catatan" rows="2"
                                placeholder="Catatan tambahan (opsional)"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Kolom Kanan: Foto ── --}}
            <div class="space-y-5">
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa fa-camera text-purple-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm">Foto Anggota</h3>
                            <p class="text-xs text-gray-400">Foto profil (opsional)</p>
                        </div>
                    </div>

                    {{-- Preview --}}
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <div id="avatar-placeholder" class="w-28 h-28 bg-gray-100 rounded-full flex items-center justify-center border-4 border-gray-200">
                                <i class="fa fa-user text-gray-400 text-3xl"></i>
                            </div>
                            <img id="preview-img" class="hidden w-28 h-28 rounded-full object-cover border-4 border-blue-200">
                        </div>
                    </div>

                    <div id="drop-zone-foto"
                        onclick="document.getElementById('foto').click()"
                        class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition group">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:bg-blue-100 transition">
                            <i class="fa fa-cloud-arrow-up text-gray-400 text-lg group-hover:text-blue-500 transition"></i>
                        </div>
                        <p class="text-xs font-medium text-gray-600">Klik untuk upload foto</p>
                        <p class="text-xs text-gray-400 mt-0.5">JPG, PNG — Maks. 2MB</p>
                    </div>

                    <input type="file" id="foto" name="foto" accept="image/jpeg,image/png" class="hidden" onchange="previewFoto(this)">

                    <button type="button" onclick="document.getElementById('foto').click()"
                        class="mt-3 w-full flex items-center justify-center gap-2 border border-gray-300 text-gray-600 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                        <i class="fa fa-upload text-xs"></i> Pilih Foto
                    </button>
                </div>

                {{-- Tips --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                    <p class="text-xs font-semibold text-amber-800 mb-2"><i class="fa fa-lightbulb mr-1"></i> Tips</p>
                    <ul class="text-xs text-amber-700 space-y-1.5">
                        <li class="flex items-start gap-1.5"><i class="fa fa-check mt-0.5 flex-shrink-0"></i> Field bertanda <span class="text-red-500 font-bold">*</span> wajib diisi</li>
                        <li class="flex items-start gap-1.5"><i class="fa fa-check mt-0.5 flex-shrink-0"></i> Gunakan foto wajah yang jelas</li>
                        <li class="flex items-start gap-1.5"><i class="fa fa-check mt-0.5 flex-shrink-0"></i> No. Anggota akan dibuat otomatis oleh sistem</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Action --}}
        <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.anggota.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                <i class="fa fa-times text-xs"></i> Batal
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                <i class="fa fa-floppy-disk"></i> Simpan Anggota
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewFoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('preview-img');
        const placeholder = document.getElementById('avatar-placeholder');
        img.src = e.target.result;
        img.classList.remove('hidden');
        placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
@endsection
