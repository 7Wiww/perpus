@extends('layouts.app')
@section('title', 'Proses Pengembalian')
@section('page-title', 'Proses Pengembalian')

@section('content')
<div class="max-w-5xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('petugas.pengembalian.index') }}" class="hover:text-blue-600">Pengembalian</a>
            <span class="mx-1">/</span><span class="text-gray-800">Proses</span>
        </nav>
        <a href="{{ route('petugas.pengembalian.riwayat') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-1">
            <i class="fa fa-clock-rotate-left"></i> Riwayat Pengembalian
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Daftar peminjaman aktif --}}
        <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-3">Daftar Peminjaman Aktif</h3>
            <div class="space-y-2 max-h-[500px] overflow-y-auto">
                @forelse($aktifPeminjamans as $p)
                <a href="{{ route('petugas.pengembalian.proses', ['peminjaman_id' => $p->id]) }}"
                    class="block p-3 rounded-xl border {{ $peminjaman && $peminjaman->id === $p->id ? 'border-blue-500 bg-blue-50' : 'border-gray-100 hover:border-blue-300 hover:bg-gray-50' }} transition">
                    <p class="font-medium text-gray-900 text-sm">{{ $p->anggota->user->name ?? '-' }}</p>
                    <p class="text-xs text-gray-500 font-mono">{{ $p->kode_transaksi }}</p>
                    <div class="flex items-center justify-between mt-1">
                        <p class="text-xs text-gray-500">Tempo: {{ $p->tanggal_jatuh_tempo->format('d M Y') }}</p>
                        @if($p->status === 'terlambat')
                            <span class="inline-flex px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-600">Terlambat</span>
                        @else
                            <span class="inline-flex px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-600">Aktif</span>
                        @endif
                    </div>
                </a>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Tidak ada peminjaman aktif.</p>
                @endforelse
            </div>
        </div>

        {{-- Form proses --}}
        <div class="lg:col-span-2">
            @if($peminjaman)
            <form method="POST" action="{{ route('petugas.pengembalian.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

                {{-- Info peminjaman --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Informasi Peminjaman</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-gray-500 mb-0.5">ID Peminjaman</p>
                            <p class="font-mono font-medium text-gray-900">{{ $peminjaman->kode_transaksi }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-0.5">Anggota</p>
                            <p class="font-medium text-gray-900">{{ $peminjaman->anggota->user->name ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $peminjaman->anggota->no_anggota ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-0.5">No. HP</p>
                            <p class="font-medium text-gray-900">{{ $peminjaman->anggota->no_telepon ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-0.5">Tgl Pinjam / Jatuh Tempo</p>
                            <p class="font-medium text-gray-900">{{ $peminjaman->tanggal_pinjam->format('d M Y') }} – {{ $peminjaman->tanggal_jatuh_tempo->format('d M Y') }}</p>
                            @if($peminjaman->status === 'terlambat')
                                <p class="text-xs text-red-500 font-semibold">Terlambat {{ $peminjaman->hari_terlambat }} hari</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs text-gray-500 mb-2">Daftar Buku yang Dipinjam</p>
                        <div class="space-y-2">
                            @foreach($peminjaman->bukus as $b)
                            <div class="flex items-center gap-3 p-2.5 bg-gray-50 rounded-xl">
                                <div class="w-7 h-9 bg-blue-100 rounded flex items-center justify-center flex-shrink-0">
                                    <i class="fa fa-book text-blue-600 text-xs"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 text-sm">{{ $b->judul }}</p>
                                    <p class="text-xs text-gray-500">{{ $b->penulis }}</p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">Kondisi:</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Form pengembalian --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Detail Pengembalian</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengembalian <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_pengembalian" value="{{ date('Y-m-d') }}" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"
                                onchange="hitungDenda(this.value)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Buku <span class="text-red-500">*</span></label>
                            <select name="kondisi_buku" required class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                                <option value="hilang">Hilang</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Petugas</label>
                            <textarea name="catatan" rows="2"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan catatan jika ada kerusakan, kehilangan, atau keterangan lainnya..."></textarea>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm font-semibold text-gray-900 mb-2">Total Denda</p>
                        <p id="infoDenda" class="text-2xl font-bold text-gray-900">Rp 0</p>
                        <p class="text-xs text-gray-500 mt-1">Rincian: Keterlambatan <span id="hariTerlambat">0</span> hari × Rp 500 / hari / buku</p>
                    </div>

                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl text-xs text-yellow-800 space-y-1">
                        <p><i class="fa fa-triangle-exclamation mr-1"></i> <strong>Perhatian</strong></p>
                        <p>• Periksa buku dalam kondisi baik sesuai pilihan kondisi buku.</p>
                        <p>• Denda akan ditampilkan dan dikonfirmasi anggota sebelum konfirmasi pengembalian.</p>
                        <p>• Setelah dikonfirmasi, data pengembalian tidak dapat diubah, hanya dapat ditinjau.</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('petugas.pengembalian.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-semibold transition flex items-center gap-2">
                        <i class="fa fa-circle-check"></i> Konfirmasi Pengembalian
                    </button>
                </div>
            </form>

            @push('scripts')
            <script>
            const jatuhTempo = new Date('{{ $peminjaman->tanggal_jatuh_tempo->format("Y-m-d") }}');
            const jumlahBuku = {{ $peminjaman->bukus->count() }};
            function hitungDenda(tglKembali) {
                const kembali = new Date(tglKembali);
                const diff = Math.ceil((kembali - jatuhTempo) / (1000*60*60*24));
                const hari = Math.max(0, diff);
                const denda = hari * 500 * jumlahBuku;
                document.getElementById('hariTerlambat').textContent = hari;
                document.getElementById('infoDenda').textContent = 'Rp ' + denda.toLocaleString('id-ID');
                document.getElementById('infoDenda').className = hari > 0 ? 'text-2xl font-bold text-red-600' : 'text-2xl font-bold text-green-600';
            }
            hitungDenda('{{ date("Y-m-d") }}');
            </script>
            @endpush

            @else
            <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa fa-rotate-left text-gray-400 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Pilih Peminjaman</h3>
                <p class="text-gray-500 text-sm">Pilih peminjaman yang akan diproses pengembaliannya dari daftar di sebelah kiri, atau klik tombol Kembalikan dari halaman sebelumnya.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
