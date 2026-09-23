@extends('layouts.app')
@section('title', 'Peminjaman Baru')
@section('page-title', 'Peminjaman Baru')

@section('content')
<div class="max-w-5xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('petugas.peminjaman.index') }}" class="hover:text-blue-600">Peminjaman</a>
            <span class="mx-1">/</span><span class="text-gray-800">Peminjaman Baru</span>
        </nav>
        <a href="{{ route('petugas.peminjaman.index') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-arrow-left"></i> Kembali ke Peminjaman
        </a>
    </div>

    <form method="POST" action="{{ route('petugas.peminjaman.store') }}" id="formPeminjaman">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Left: Form --}}
            <div class="lg:col-span-2 space-y-5">
                {{-- Pilih Anggota --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">1. Pilih Anggota</h3>
                    <input type="text" id="searchAnggota" placeholder="Cari anggota berdasarkan nama atau NIM..."
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 mb-3">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr class="text-left text-xs text-gray-500">
                                    <th class="px-4 py-2 font-medium">No. Anggota</th>
                                    <th class="px-4 py-2 font-medium">Nama</th>
                                    <th class="px-4 py-2 font-medium">Status</th>
                                    <th class="px-4 py-2 font-medium">Program Studi</th>
                                    <th class="px-4 py-2 font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="anggotaTable" class="divide-y divide-gray-100">
                                @foreach($anggotas as $a)
                                <tr class="anggota-row hover:bg-gray-50" data-name="{{ strtolower($a->user->name) }}" data-nim="{{ strtolower($a->nim_nip ?? '') }}">
                                    <td class="px-4 py-2 font-mono text-xs text-gray-600">{{ $a->no_anggota }}</td>
                                    <td class="px-4 py-2 font-medium text-gray-900">{{ $a->user->name }}</td>
                                    <td class="px-4 py-2"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span></td>
                                    <td class="px-4 py-2 text-gray-500 text-xs">{{ $a->program_studi ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        <button type="button" onclick="pilihAnggota({{ $a->id }}, '{{ $a->no_anggota }}', '{{ $a->user->name }}', '{{ $a->program_studi ?? '-' }}')"
                                            class="px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition">Pilih</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="anggota_id" id="anggotaId">
                    @error('anggota_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    {{-- Anggota terpilih --}}
                    <div id="anggotaTerpilih" class="hidden mt-4 p-3 bg-blue-50 rounded-xl border border-blue-100 flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-200 rounded-full flex items-center justify-center">
                            <i class="fa fa-user text-blue-700 text-sm"></i>
                        </div>
                        <div>
                            <p id="anggotaNama" class="font-semibold text-gray-900 text-sm"></p>
                            <p id="anggotaInfo" class="text-xs text-gray-500"></p>
                        </div>
                        <button type="button" onclick="resetAnggota()" class="ml-auto text-gray-400 hover:text-red-500">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>

                {{-- Pilih Buku --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">2. Pilih Buku <span class="text-xs text-gray-400 font-normal">(Maksimal 3 buku)</span></h3>
                    <input type="text" id="searchBuku" placeholder="Cari judul buku, penulis, atau ISBN..."
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 mb-3">
                    <div class="overflow-x-auto border border-gray-100 rounded-xl max-h-64 overflow-y-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr class="text-left text-xs text-gray-500">
                                    <th class="px-4 py-2 font-medium">Judul</th>
                                    <th class="px-4 py-2 font-medium">Penulis</th>
                                    <th class="px-4 py-2 font-medium">Kategori</th>
                                    <th class="px-4 py-2 font-medium">Tersedia</th>
                                    <th class="px-4 py-2 font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bukuTable" class="divide-y divide-gray-100">
                                @foreach($bukus as $b)
                                <tr class="buku-row hover:bg-gray-50" id="buku-row-{{ $b->id }}"
                                    data-judul="{{ strtolower($b->judul) }}" data-penulis="{{ strtolower($b->penulis) }}" data-isbn="{{ strtolower($b->isbn ?? '') }}">
                                    <td class="px-4 py-2 font-medium text-gray-900">{{ $b->judul }}</td>
                                    <td class="px-4 py-2 text-gray-500 text-xs">{{ $b->penulis }}</td>
                                    <td class="px-4 py-2 text-gray-500 text-xs">{{ $b->kategori->nama_kategori ?? '-' }}</td>
                                    <td class="px-4 py-2 font-semibold text-green-600">{{ $b->stok_tersedia }}</td>
                                    <td class="px-4 py-2">
                                        <button type="button" onclick="pilihBuku({{ $b->id }}, '{{ addslashes($b->judul) }}', '{{ addslashes($b->penulis) }}')"
                                            id="btn-buku-{{ $b->id }}"
                                            class="px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition">Pilih</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @error('buku_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Detail Peminjaman --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">3. Detail Peminjaman</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"
                                onchange="updateJatuhTempo()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_jatuh_tempo" id="jatuhTempo" required
                                value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-400 mt-1">Maksimal 14 hari peminjaman</p>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                            <textarea name="keterangan" rows="2"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"
                                placeholder="Keterangan tambahan (opsional)"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Ringkasan --}}
            <div class="space-y-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-5 sticky top-4">
                    <h3 class="font-semibold text-gray-900 mb-4">Ringkasan Peminjaman</h3>

                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">Anggota</p>
                        <div id="ringkasanAnggota" class="text-sm text-gray-400 italic">Belum dipilih</div>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs text-gray-500">Buku yang Dipinjam</p>
                            <button type="button" onclick="resetBuku()" class="text-xs text-red-500 hover:underline hidden" id="btnResetBuku">Kosongkan</button>
                        </div>
                        <div id="ringkasanBuku" class="space-y-2">
                            <div class="text-sm text-gray-400 italic text-center py-4 border-2 border-dashed border-gray-200 rounded-xl">
                                <i class="fa fa-book text-gray-300 text-2xl mb-1 block"></i>
                                Belum ada buku dipilih
                            </div>
                        </div>
                        <div id="bukuInputs"></div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Buku</span>
                            <span id="totalBuku" class="font-semibold text-gray-900">0 buku</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Lama Peminjaman</span>
                            <span class="font-semibold text-gray-900">7 hari</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Denda Keterlambatan</span>
                            <span class="font-semibold text-gray-900">Rp 500/hari/buku</span>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl text-xs text-yellow-800">
                        <i class="fa fa-circle-info mr-1"></i> Maksimal peminjaman 3 buku per anggota.
                    </div>

                    <button type="submit" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                        <i class="fa fa-floppy-disk"></i> Simpan Peminjaman
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
let selectedBukus = {};

function pilihAnggota(id, noAnggota, nama, prodi) {
    document.getElementById('anggotaId').value = id;
    document.getElementById('anggotaNama').textContent = nama;
    document.getElementById('anggotaInfo').textContent = noAnggota + ' · ' + prodi;
    document.getElementById('anggotaTerpilih').classList.remove('hidden');
    document.getElementById('ringkasanAnggota').innerHTML = '<span class="font-semibold text-gray-900">' + nama + '</span><br><span class="text-xs text-gray-500">' + noAnggota + '</span>';
}
function resetAnggota() {
    document.getElementById('anggotaId').value = '';
    document.getElementById('anggotaTerpilih').classList.add('hidden');
    document.getElementById('ringkasanAnggota').innerHTML = '<span class="text-gray-400 italic">Belum dipilih</span>';
}

function pilihBuku(id, judul, penulis) {
    if (Object.keys(selectedBukus).length >= 3) {
        alert('Maksimal 3 buku per peminjaman.');
        return;
    }
    if (selectedBukus[id]) return;
    selectedBukus[id] = { judul, penulis };
    document.getElementById('btn-buku-' + id).textContent = '✓ Dipilih';
    document.getElementById('btn-buku-' + id).className = 'px-3 py-1 bg-green-600 text-white text-xs rounded-lg cursor-default';
    renderRingkasanBuku();
}

function hapusBuku(id) {
    delete selectedBukus[id];
    const btn = document.getElementById('btn-buku-' + id);
    if (btn) { btn.textContent = 'Pilih'; btn.className = 'px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition'; btn.onclick = () => pilihBuku(id, selectedBukus[id]?.judul, selectedBukus[id]?.penulis); }
    renderRingkasanBuku();
}

function resetBuku() {
    Object.keys(selectedBukus).forEach(id => {
        const btn = document.getElementById('btn-buku-' + id);
        if (btn) { btn.textContent = 'Pilih'; btn.className = 'px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition'; }
    });
    selectedBukus = {};
    renderRingkasanBuku();
}

function renderRingkasanBuku() {
    const container = document.getElementById('ringkasanBuku');
    const inputsContainer = document.getElementById('bukuInputs');
    const ids = Object.keys(selectedBukus);
    document.getElementById('totalBuku').textContent = ids.length + ' buku';
    document.getElementById('btnResetBuku').classList.toggle('hidden', ids.length === 0);

    if (ids.length === 0) {
        container.innerHTML = '<div class="text-sm text-gray-400 italic text-center py-4 border-2 border-dashed border-gray-200 rounded-xl"><i class="fa fa-book text-gray-300 text-2xl mb-1 block"></i>Belum ada buku dipilih</div>';
        inputsContainer.innerHTML = '';
        return;
    }

    container.innerHTML = ids.map(id =>
        `<div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg text-sm">
            <div><p class="font-medium text-gray-900 text-xs">${selectedBukus[id].judul}</p><p class="text-xs text-gray-500">${selectedBukus[id].penulis}</p></div>
            <button type="button" onclick="hapusBuku(${id})" class="text-red-400 hover:text-red-600 ml-2"><i class="fa fa-times text-xs"></i></button>
        </div>`
    ).join('');

    inputsContainer.innerHTML = ids.map(id => `<input type="hidden" name="buku_ids[]" value="${id}">`).join('');
}

// Search anggota
document.getElementById('searchAnggota').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.anggota-row').forEach(row => {
        const match = row.dataset.name.includes(q) || row.dataset.nim.includes(q);
        row.style.display = match ? '' : 'none';
    });
});

// Search buku
document.getElementById('searchBuku').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.buku-row').forEach(row => {
        const match = row.dataset.judul.includes(q) || row.dataset.penulis.includes(q) || row.dataset.isbn.includes(q);
        row.style.display = match ? '' : 'none';
    });
});

function updateJatuhTempo() {
    const tglPinjam = document.querySelector('[name=tanggal_pinjam]').value;
    if (tglPinjam) {
        const d = new Date(tglPinjam);
        d.setDate(d.getDate() + 7);
        document.getElementById('jatuhTempo').value = d.toISOString().split('T')[0];
    }
}
</script>
@endpush
@endsection
