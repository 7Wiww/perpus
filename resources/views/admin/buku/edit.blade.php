@extends('layouts.app')
@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('admin.buku.index') }}" class="hover:text-blue-600">Data Buku</a>
            <span class="mx-1">/</span><span class="text-gray-800">Edit Buku</span>
        </nav>
        <a href="{{ route('admin.buku.index') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Kembali ke Data Buku
        </a>
    </div>

    <form method="POST" action="{{ route('admin.buku.update', $buku) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-5">Informasi Buku</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="form-label">Judul Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" required class="form-input">
                        @error('judul') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn', $buku->isbn) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori_id" required class="form-input">
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id', $buku->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="form-input" min="1900" max="{{ date('Y')+1 }}">
                    </div>
                    <div>
                        <label class="form-label">Lokasi Rak</label>
                        <input type="text" name="lokasi_rak" value="{{ old('lokasi_rak', $buku->lokasi_rak) }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Jumlah Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" required min="0" class="form-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-input">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="form-label">Status Buku</label>
                    <div class="flex gap-3 mt-1 flex-wrap">
                        @foreach(['tersedia'=>'Tersedia','dipinjam'=>'Dipinjam','tidak_tersedia'=>'Tidak Tersedia'] as $val => $label)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="{{ $val }}" {{ old('status', $buku->status) === $val ? 'checked' : '' }} class="text-blue-600">
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Sampul Buku</h3>
                @if($buku->sampul)
                    <img src="{{ asset('storage/'.$buku->sampul) }}" class="w-full h-40 object-contain rounded-xl border border-gray-100 mb-3">
                @endif
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 text-center cursor-pointer hover:border-blue-400 transition" onclick="document.getElementById('sampul').click()">
                    <img id="preview-img" class="hidden w-full h-36 object-contain rounded mb-2">
                    <i class="fa fa-upload text-2xl text-gray-300 mb-1"></i>
                    <p class="text-xs text-gray-400">Upload gambar baru (opsional)</p>
                </div>
                <input type="file" id="sampul" name="sampul" accept="image/*" class="hidden" onchange="previewImage(this)">
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('admin.buku.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
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
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('preview-img').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
