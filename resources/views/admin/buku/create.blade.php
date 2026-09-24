@extends('layouts.app')
@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    {{-- Breadcrumb --}}
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500 flex items-center gap-1">
            <a href="{{ route('admin.buku.index') }}" class="hover:text-blue-600">Data Buku</a>
            <i class="fa fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Tambah Buku</span>
        </nav>
        <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition">
            <i class="fa fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- ── Kolom Kiri: Form Utama ── --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Card: Informasi Buku --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa fa-book text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm">Informasi Buku</h3>
                            <p class="text-xs text-gray-400">Isi data lengkap buku yang akan ditambahkan</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Judul --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Judul Buku <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul" value="{{ old('judul') }}" required
                                placeholder="Masukkan judul buku"
                                class="w-full px-3.5 py-2.5 border {{ $errors->has('judul') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('judul')
                                <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Penulis + Penerbit --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Penulis <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="penulis" value="{{ old('penulis') }}" required
                                    placeholder="Nama penulis"
                                    class="w-full px-3.5 py-2.5 border {{ $errors->has('penulis') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('penulis')
                                    <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Penerbit</label>
                                <input type="text" name="penerbit" value="{{ old('penerbit') }}"
                                    placeholder="Nama penerbit"
                                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>

                        {{-- ISBN + Tahun --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">ISBN</label>
                                <input type="text" name="isbn" value="{{ old('isbn') }}"
                                    placeholder="978-xxx-xxx-xx-x (opsional)"
                                    class="w-full px-3.5 py-2.5 border {{ $errors->has('isbn') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('isbn')
                                    <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
                                    placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y')+1 }}"
                                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>

                        {{-- Kategori + Lokasi Rak --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select name="kategori_id" required
                                    class="w-full px-3.5 py-2.5 border {{ $errors->has('kategori_id') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi Rak</label>
                                <input type="text" name="lokasi_rak" value="{{ old('lokasi_rak') }}"
                                    placeholder="Contoh: Rak A-01"
                                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>

                        {{-- Jumlah Stok --}}
                        <div class="w-1/2 pr-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Jumlah Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stok" value="{{ old('stok', 1) }}" required min="0"
                                class="w-full px-3.5 py-2.5 border {{ $errors->has('stok') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('stok')
                                <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                placeholder="Ringkasan atau sinopsis buku (opsional)"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Card: Status Buku --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa fa-circle-check text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm">Status Buku</h3>
                            <p class="text-xs text-gray-400">Tentukan ketersediaan buku saat ini</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach([
                            'tersedia'       => ['Tersedia',      'Buku dapat dipinjam',          'green',  'fa-circle-check'],
                            'dipinjam'       => ['Dipinjam',      'Buku sedang dipinjam',          'blue',   'fa-clock'],
                            'tidak_tersedia' => ['Tidak Tersedia','Buku tidak dapat dipinjam',     'gray',   'fa-circle-xmark'],
                        ] as $val => [$label, $desc, $color, $icon])
                        <label class="relative flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer transition
                            {{ old('status','tersedia') === $val ? 'border-'.$color.'-500 bg-'.$color.'-50' : 'border-gray-200 hover:border-gray-300 bg-white' }}">
                            <input type="radio" name="status" value="{{ $val }}"
                                {{ old('status','tersedia') === $val ? 'checked' : '' }}
                                class="mt-0.5 text-{{ $color }}-600 focus:ring-{{ $color }}-500">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $label }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $desc }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── Kolom Kanan: Sampul ── --}}
            <div class="space-y-5">
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa fa-image text-purple-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm">Sampul Buku</h3>
                            <p class="text-xs text-gray-400">Upload gambar sampul (opsional)</p>
                        </div>
                    </div>

                    {{-- Preview area --}}
                    <div id="drop-zone"
                        onclick="document.getElementById('sampul').click()"
                        class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition group">
                        <div id="preview-placeholder">
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-100 transition">
                                <i class="fa fa-cloud-arrow-up text-gray-400 text-xl group-hover:text-blue-500 transition"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-600">Klik untuk upload</p>
                            <p class="text-xs text-gray-400 mt-1">atau drag & drop gambar di sini</p>
                            <p class="text-xs text-gray-300 mt-2">JPG, PNG — Maks. 2MB</p>
                        </div>
                        <img id="preview-img" class="hidden w-full max-h-52 object-contain rounded-lg mx-auto">
                    </div>

                    <input type="file" id="sampul" name="sampul" accept="image/jpeg,image/png" class="hidden" onchange="previewImage(this)">

                    <button type="button" onclick="document.getElementById('sampul').click()"
                        class="mt-3 w-full flex items-center justify-center gap-2 border border-gray-300 text-gray-600 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                        <i class="fa fa-upload text-xs"></i> Pilih Gambar
                    </button>

                    @error('sampul')
                        <p class="mt-2 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Tips --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                    <p class="text-xs font-semibold text-amber-800 mb-2"><i class="fa fa-lightbulb mr-1"></i> Tips</p>
                    <ul class="text-xs text-amber-700 space-y-1.5">
                        <li class="flex items-start gap-1.5"><i class="fa fa-check mt-0.5 flex-shrink-0"></i> Gunakan gambar rasio 2:3 untuk tampilan terbaik</li>
                        <li class="flex items-start gap-1.5"><i class="fa fa-check mt-0.5 flex-shrink-0"></i> Pastikan judul dan penulis sudah terisi dengan benar</li>
                        <li class="flex items-start gap-1.5"><i class="fa fa-check mt-0.5 flex-shrink-0"></i> Field bertanda <span class="text-red-500 font-bold">*</span> wajib diisi</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.buku.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                <i class="fa fa-times text-xs"></i> Batal
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                <i class="fa fa-floppy-disk"></i> Simpan Buku
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('preview-img');
        const placeholder = document.getElementById('preview-placeholder');
        img.src = e.target.result;
        img.classList.remove('hidden');
        placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
// Drag & drop
const zone = document.getElementById('drop-zone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('border-blue-400','bg-blue-50'); });
zone.addEventListener('dragleave', () => { zone.classList.remove('border-blue-400','bg-blue-50'); });
zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.classList.remove('border-blue-400','bg-blue-50');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('sampul').files = dt.files;
        previewImage(document.getElementById('sampul'));
    }
});
</script>
@endpush
@endsection
