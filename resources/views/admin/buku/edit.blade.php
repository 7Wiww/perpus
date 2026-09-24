@extends('layouts.app')
@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500 flex items-center gap-1">
            <a href="{{ route('admin.buku.index') }}" class="hover:text-blue-600">Data Buku</a>
            <i class="fa fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Edit Buku</span>
        </nav>
        <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition">
            <i class="fa fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.buku.update', $buku) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Kolom Kiri --}}
            <div class="lg:col-span-2 space-y-5">

                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa fa-book text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm">Informasi Buku</h3>
                            <p class="text-xs text-gray-400">Perbarui data buku di bawah ini</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul Buku <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" required
                                class="w-full px-3.5 py-2.5 border {{ $errors->has('judul') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('judul') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Penulis <span class="text-red-500">*</span></label>
                                <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required
                                    class="w-full px-3.5 py-2.5 border {{ $errors->has('penulis') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('penulis') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Penerbit</label>
                                <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}"
                                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">ISBN</label>
                                <input type="text" name="isbn" value="{{ old('isbn', $buku->isbn) }}"
                                    class="w-full px-3.5 py-2.5 border {{ $errors->has('isbn') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('isbn') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                                    min="1900" max="{{ date('Y')+1 }}"
                                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori_id" required
                                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id', $buku->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi Rak</label>
                                <input type="text" name="lokasi_rak" value="{{ old('lokasi_rak', $buku->lokasi_rak) }}"
                                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Stok <span class="text-red-500">*</span></label>
                                <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" required min="0"
                                    class="w-full px-3.5 py-2.5 border {{ $errors->has('stok') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('stok') <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 text-sm mb-4">Status Buku</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach(['tersedia'=>['Tersedia','Buku dapat dipinjam','green'],'dipinjam'=>['Dipinjam','Buku sedang dipinjam','blue'],'tidak_tersedia'=>['Tidak Tersedia','Buku tidak dapat dipinjam','gray']] as $val => [$lbl,$desc,$color])
                        <label class="flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer transition
                            {{ old('status', $buku->status) === $val ? 'border-'.$color.'-500 bg-'.$color.'-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="status" value="{{ $val }}"
                                {{ old('status', $buku->status) === $val ? 'checked' : '' }}
                                class="mt-0.5 text-{{ $color }}-600">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $lbl }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $desc }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Sampul --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6 h-fit">
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-image text-purple-600 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm">Sampul Buku</h3>
                        <p class="text-xs text-gray-400">Upload gambar baru untuk mengganti</p>
                    </div>
                </div>

                @if($buku->sampul)
                <div class="mb-3">
                    <p class="text-xs text-gray-500 mb-2">Sampul saat ini:</p>
                    <img src="{{ asset('storage/'.$buku->sampul) }}" class="w-full h-40 object-contain rounded-xl border border-gray-100">
                </div>
                @endif

                <div onclick="document.getElementById('sampul').click()"
                    class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition group">
                    <img id="preview-img" class="hidden w-full h-36 object-contain rounded mb-2 mx-auto">
                    <div id="upload-placeholder">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:bg-blue-100 transition">
                            <i class="fa fa-cloud-arrow-up text-gray-400 text-lg group-hover:text-blue-500 transition"></i>
                        </div>
                        <p class="text-xs text-gray-500">Klik untuk upload gambar baru</p>
                        <p class="text-xs text-gray-400 mt-0.5">JPG, PNG — Maks. 2MB</p>
                    </div>
                </div>
                <input type="file" id="sampul" name="sampul" accept="image/jpeg,image/png" class="hidden" onchange="previewImage(this)">
                <button type="button" onclick="document.getElementById('sampul').click()"
                    class="mt-3 w-full flex items-center justify-center gap-2 border border-gray-300 text-gray-600 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                    <i class="fa fa-upload text-xs"></i> Pilih Gambar
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.buku.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                <i class="fa fa-times text-xs"></i> Batal
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                <i class="fa fa-floppy-disk"></i> Simpan Perubahan
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
        const placeholder = document.getElementById('upload-placeholder');
        img.src = e.target.result;
        img.classList.remove('hidden');
        placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
@endsection
