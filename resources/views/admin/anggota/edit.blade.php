@extends('layouts.app')
@section('title', 'Edit Anggota')
@section('page-title', 'Edit Anggota')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('admin.anggota.index') }}" class="hover:text-blue-600">Data Anggota</a>
            <span class="mx-1">/</span><span class="text-gray-800">Edit Anggota</span>
        </nav>
        <a href="{{ route('admin.anggota.index') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.anggota.update', $anggota) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-5">Edit Informasi Anggota</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $anggota->user->name) }}" required class="form-input">
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $anggota->user->email) }}" required class="form-input">
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">NIM / No. Identitas</label>
                        <input type="text" name="nim_nip" value="{{ old('nim_nip', $anggota->nim_nip) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $anggota->no_telepon) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-input">
                            <option value="">Pilih</option>
                            <option value="laki-laki" {{ old('jenis_kelamin', $anggota->jenis_kelamin) === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ old('jenis_kelamin', $anggota->jenis_kelamin) === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Jenis Anggota <span class="text-red-500">*</span></label>
                        <select name="jenis_anggota" required class="form-input">
                            @foreach(['mahasiswa','dosen','staff','umum'] as $j)
                                <option value="{{ $j }}" {{ old('jenis_anggota', $anggota->jenis_anggota) === $j ? 'selected' : '' }}>{{ ucfirst($j) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $anggota->alamat) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Program Studi</label>
                        <input type="text" name="program_studi" value="{{ old('program_studi', $anggota->program_studi) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Fakultas / Instansi</label>
                        <input type="text" name="fakultas_instansi" value="{{ old('fakultas_instansi', $anggota->fakultas_instansi) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Status Anggota <span class="text-red-500">*</span></label>
                        <select name="status" required class="form-input">
                            @foreach(['aktif','nonaktif','diblokir'] as $s)
                                <option value="{{ $s }}" {{ old('status', $anggota->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" rows="2" class="form-input">{{ old('catatan', $anggota->catatan) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Foto Anggota</h3>
                @if($anggota->foto)
                    <img src="{{ asset('storage/'.$anggota->foto) }}" class="w-full h-40 object-contain rounded-xl border border-gray-100 mb-3">
                @endif
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 text-center cursor-pointer hover:border-blue-400 transition" onclick="document.getElementById('foto').click()">
                    <img id="preview-img" class="hidden w-24 h-24 object-cover rounded-full mx-auto mb-2">
                    <i class="fa fa-upload text-2xl text-gray-300 mb-1"></i>
                    <p class="text-xs text-gray-400">Upload foto baru (opsional)</p>
                </div>
                <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('admin.anggota.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition flex items-center gap-2">
                <i class="fa fa-floppy-disk"></i> Simpan Perubahan
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
