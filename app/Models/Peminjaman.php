<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'kode_transaksi', 'anggota_id', 'petugas_id',
        'tanggal_pinjam', 'tanggal_jatuh_tempo', 'tanggal_kembali',
        'status', 'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam'      => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_kembali'     => 'date',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }

    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'detail_peminjamans', 'peminjaman_id', 'buku_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }

    public function getHariTerlambatAttribute(): int
    {
        $batas = $this->tanggal_jatuh_tempo;
        $sekarang = $this->tanggal_kembali ?? Carbon::today();
        if ($sekarang > $batas) {
            return $batas->diffInDays($sekarang);
        }
        return 0;
    }

    public function getDendaAttribute(): float
    {
        return $this->hari_terlambat * 500;
    }

    public static function generateKode(): string
    {
        $year = date('Y');
        $last = static::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $num = $last ? ((int) substr($last->kode_transaksi, -6)) + 1 : 1;
        return 'PMJ-' . $year . '-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('kode_transaksi', 'like', "%{$keyword}%")
              ->orWhereHas('anggota', fn($a) => $a->where('no_anggota', 'like', "%{$keyword}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$keyword}%")))
              ->orWhereHas('bukus', fn($b) => $b->where('judul', 'like', "%{$keyword}%"));
        });
    }
}
