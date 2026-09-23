@extends('layouts.app')
@section('title', 'Tambah Anggota')
@section('page-title', 'Tambah Anggota')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('admin.anggota.index') }}" class="hover:text-blue-600">Data Anggota</a>
            <span class="mx-1">/</span><span class="text-gray-800">Tambah Anggota</span>
        </nav>
        <a href="{{ route('admin.anggota.index') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Kembali ke Data Anggota
        </a>
    </div>

    <form method="POST" action="{{ route('admin.anggota.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-5">Informasi Pribadi</h3>
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
                    <div>
                        <label class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="form-input">
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">NIM / No. Identitas</label>
                        <input type="text" name="nim_nip" value="{{ old('nim_nip') }}" class="form-input">
                        @error('nim_nip') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-input">
                            <option value="">Pilih</option>
                            <option value="laki-laki" {{ old('jenis_kelamin') === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ old('jenis_kelamin') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Jenis Anggota <span class="text-red-500">*</span></label>
                        <select name="jenis_anggota" required class="form-input">
                            @foreach(['mahasiswa','dosen','staff','umum'] as $j)
                                <option value="{{ $j }}" {{ old('jenis_anggota') === $j ? 'selected' : '' }}>{{ ucfirst($j) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Program Studi / Jurusan</label>
                        <input type="text" name="program_studi" value="{{ old('program_studi') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Fakultas / Instansi</label>
                        <input type="text" name="fakultas_instansi" value="{{ old('fakultas_instansi') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Tanggal Bergabung</label>
                        <input type="date" name="tanggal_bergabung" value="{{ old('tanggal_bergabung', date('Y-m-d')) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Status Anggota <span class="text-red-500">*</span></label>
                        <select name="status" required class="form-input">
                            @foreach(['aktif','nonaktif','diblokir'] as $s)
                                <option value="{{ $s }}" {{ old('status','aktif') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="catatan" rows="2" class="form-input">{{ old('catatan') }}</textarea>
                    </div>
                </div>
                <div class="mt-3 p-3 bg-blue-50 rounded-xl text-xs text-blue-700">
                    <i class="fa fa-circle-info mr-1"></i> Password default untuk anggota baru adalah <strong>password</strong>. Anggota dapat menggantinya setelah login.
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Foto Anggota</h3>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 transition" onclick="document.getElementById('foto').click()">
                    <img id="preview-img" class="hidden w-24 h-24 object-cover rounded-full mx-auto mb-2">
                    <i class="fa fa-user text-3xl text-gray-300 mb-2"></i>
                    <p class="text-xs text-gray-400">Drag & drop foto di sini</p>
                    <p class="text-xs text-gray-400">atau klik tombol di bawah</p>
                </div>
                <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
                <button type="button" onclick="document.getElementById('foto').click()" class="mt-3 w-full border border-gray-300 text-gray-700 py-2 rounded-xl text-sm hover:bg-gray-50 transition flex items-center justify-center gap-2">
                    <i class="fa fa-upload"></i> Pilih Foto
                </button>
                <p class="text-xs text-gray-400 text-center mt-2">Format: JPG, PNG (Maks. 2MB) | Rasio yang disarankan: 1:1</p>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('admin.anggota.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition flex items-center gap-2">
                <i class="fa fa-floppy-disk"></i> Simpan Anggota
            </button>
        </div>
    </form>
</div>

<style>
.form-label { @apply block text-sm font-medium text-gray-700 mb-1; }
.form-input  { @apply w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent; }
.form-error  { @apply text-red-500 text-xs mt-1; }
</style>
@push('scripts')
<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('preview-img');
            img.src = e.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
