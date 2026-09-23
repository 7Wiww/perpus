@extends('layouts.app')
@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('admin.buku.index') }}" class="hover:text-blue-600">Data Buku</a>
            <span class="mx-1">/</span>
            <span class="text-gray-800">Tambah Buku</span>
        </nav>
        <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-blue-600">
            <i class="fa fa-arrow-left"></i> Kembali ke Data Buku
        </a>
    </div>

    <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Main form --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-5">Informasi Buku</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="form-label">Judul Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required class="form-input" placeholder="Masukkan judul buku">
                        @error('judul') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn') }}" class="form-input" placeholder="Masukkan ISBN (Opsional)">
                        @error('isbn') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="penulis" value="{{ old('penulis') }}" required class="form-input" placeholder="Masukkan nama penulis">
                        @error('penulis') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ old('penerbit') }}" class="form-input" placeholder="Masukkan nama penerbit">
                    </div>
                    <div>
                        <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori_id" required class="form-input">
                            <option value="">Pilih kategori</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" class="form-input" placeholder="Pilih tahun terbit" min="1900" max="{{ date('Y')+1 }}">
                    </div>
                    <div>
                        <label class="form-label">Lokasi Rak</label>
                        <input type="text" name="lokasi_rak" value="{{ old('lokasi_rak') }}" class="form-input" placeholder="Masukkan lokasi rak">
                    </div>
                    <div>
                        <label class="form-label">Jumlah Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stok" value="{{ old('stok', 1) }}" required min="0" class="form-input" placeholder="Masukkan jumlah stok">
                        @error('stok') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-input" placeholder="Masukkan deskripsi buku (opsional)">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="form-label">Status Buku</label>
                    <div class="flex gap-4 mt-1">
                        @foreach(['tersedia' => ['Tersedia','Buku dapat dipinjam','green'], 'dipinjam' => ['Dipinjam','Buku sedang dipinjam','blue'], 'tidak_tersedia' => ['Tidak Tersedia','Buku tidak dapat dipinjam','gray']] as $val => $info)
                        <label class="flex-1 flex items-center gap-2 border-2 {{ old('status','tersedia') === $val ? 'border-'.$info[2].'-500 bg-'.$info[2].'-50' : 'border-gray-200' }} rounded-xl p-3 cursor-pointer">
                            <input type="radio" name="status" value="{{ $val }}" {{ old('status','tersedia') === $val ? 'checked' : '' }} class="text-{{ $info[2] }}-600">
                            <div>
                                <p class="text-xs font-semibold text-gray-800">{{ $info[0] }}</p>
                                <p class="text-xs text-gray-500">{{ $info[1] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sampul --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Sampul Buku</h3>
                <p class="text-xs text-gray-500 mb-3">Upload sampul buku untuk menampilkan gambar pada daftar buku.</p>

                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-400 transition cursor-pointer" onclick="document.getElementById('sampul').click()">
                    <div id="preview-container">
                        <i class="fa fa-image text-3xl text-gray-300 mb-2"></i>
                        <p class="text-xs text-gray-400">Klik atau drag & drop gambar di sini</p>
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                    </div>
                    <img id="preview-img" class="hidden w-full h-40 object-contain rounded-lg mt-2">
                </div>
                <input type="file" id="sampul" name="sampul" accept="image/*" class="hidden" onchange="previewImage(this)">
                <button type="button" onclick="document.getElementById('sampul').click()" class="mt-3 w-full border border-gray-300 text-gray-700 py-2 rounded-xl text-sm hover:bg-gray-50 transition flex items-center justify-center gap-2">
                    <i class="fa fa-upload"></i> Pilih Foto
                </button>
                @error('sampul') <p class="form-error mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('admin.buku.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition flex items-center gap-2">
                <i class="fa fa-floppy-disk"></i> Simpan Buku
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
            document.getElementById('preview-container').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
