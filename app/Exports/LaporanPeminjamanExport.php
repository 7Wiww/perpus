<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanPeminjamanExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected string $awal;
    protected string $akhir;

    public function __construct(string $awal, string $akhir)
    {
        $this->awal  = $awal;
        $this->akhir = $akhir;
    }

    public function collection()
    {
        return Peminjaman::with(['anggota.user', 'bukus', 'pengembalian'])
            ->whereBetween('tanggal_pinjam', [$this->awal, $this->akhir])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No', 'Kode Transaksi', 'Nama Anggota', 'No Anggota',
            'Buku Dipinjam', 'Tgl Pinjam', 'Tgl Jatuh Tempo',
            'Tgl Kembali', 'Status', 'Hari Terlambat', 'Denda (Rp)',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->kode_transaksi,
            $row->anggota->user->name ?? '-',
            $row->anggota->no_anggota ?? '-',
            $row->bukus->pluck('judul')->implode(', '),
            $row->tanggal_pinjam?->format('d/m/Y'),
            $row->tanggal_jatuh_tempo?->format('d/m/Y'),
            $row->tanggal_kembali?->format('d/m/Y') ?? '-',
            ucfirst($row->status),
            $row->pengembalian?->hari_terlambat ?? 0,
            number_format($row->pengembalian?->denda ?? 0, 0, ',', '.'),
        ];
    }

    public function title(): string
    {
        return 'Laporan Peminjaman';
    }
}
