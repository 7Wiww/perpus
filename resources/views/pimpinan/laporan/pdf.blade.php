<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; color: #333; margin: 20px; }
        h1 { font-size: 16px; text-align: center; margin-bottom: 4px; }
        .sub { text-align: center; font-size: 10px; color: #666; margin-bottom: 16px; }
        .stats { display: flex; gap: 12px; margin-bottom: 16px; }
        .stat-box { border: 1px solid #ddd; border-radius: 4px; padding: 8px 12px; flex: 1; text-align: center; }
        .stat-box .val { font-size: 18px; font-weight: bold; color: #2563eb; }
        .stat-box .lbl { font-size: 9px; color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #2563eb; color: white; padding: 6px 8px; text-align: left; font-size: 9px; }
        td { padding: 5px 8px; border-bottom: 1px solid #eee; font-size: 9px; }
        tr:nth-child(even) td { background: #f9fafb; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 9px; font-size: 8px; font-weight: bold; }
        .badge-dipinjam { background: #dbeafe; color: #1d4ed8; }
        .badge-dikembalikan { background: #dcfce7; color: #15803d; }
        .badge-terlambat { background: #fee2e2; color: #dc2626; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #999; }
    </style>
</head>
<body>
    <h1>LAPORAN PEMINJAMAN BUKU</h1>
    <p class="sub">Perpustakaan Digital – Universitas Ma'soem<br>
    Periode: {{ $awal->format('d M Y') }} – {{ $akhir->format('d M Y') }}<br>
    Dicetak: {{ now()->format('d M Y H:i') }} | Oleh: {{ auth()->user()->name }}</p>

    <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
        <tr>
            <td style="border:1px solid #ddd; padding:6px 10px; text-align:center;">
                <div style="font-size:16px; font-weight:bold; color:#2563eb;">{{ number_format($stats['total_peminjaman']) }}</div>
                <div style="font-size:9px; color:#666;">Total Peminjaman</div>
            </td>
            <td style="border:1px solid #ddd; padding:6px 10px; text-align:center;">
                <div style="font-size:16px; font-weight:bold; color:#16a34a;">{{ number_format($stats['total_pengembalian']) }}</div>
                <div style="font-size:9px; color:#666;">Total Pengembalian</div>
            </td>
            <td style="border:1px solid #ddd; padding:6px 10px; text-align:center;">
                <div style="font-size:16px; font-weight:bold; color:#dc2626;">{{ number_format($stats['total_terlambat']) }}</div>
                <div style="font-size:9px; color:#666;">Keterlambatan</div>
            </td>
            <td style="border:1px solid #ddd; padding:6px 10px; text-align:center;">
                <div style="font-size:16px; font-weight:bold; color:#d97706;">Rp {{ number_format($stats['total_denda'], 0, ',', '.') }}</div>
                <div style="font-size:9px; color:#666;">Total Denda</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Nama Anggota</th>
                <th>No. Anggota</th>
                <th>Buku Dipinjam</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->kode_transaksi }}</td>
                <td>{{ $p->anggota->user->name ?? '-' }}</td>
                <td>{{ $p->anggota->no_anggota ?? '-' }}</td>
                <td>{{ $p->bukus->pluck('judul')->implode(', ') }}</td>
                <td>{{ $p->tanggal_pinjam?->format('d/m/Y') }}</td>
                <td>{{ $p->tanggal_jatuh_tempo?->format('d/m/Y') }}</td>
                <td>{{ $p->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span>
                </td>
                <td>Rp {{ number_format($p->pengembalian?->denda ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sistem Perpustakaan – Universitas Ma'soem | Halaman 1
    </div>
</body>
</html>
