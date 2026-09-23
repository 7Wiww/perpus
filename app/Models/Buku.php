<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $fillable = [
        'judul', 'penulis', 'penerbit', 'isbn', 'tahun_terbit',
        'kategori_id', 'lokasi_rak', 'stok', 'stok_tersedia',
        'deskripsi', 'sampul', 'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'buku_id');
    }

    public function peminjamans()
    {
        return $this->belongsToMany(Peminjaman::class, 'detail_peminjamans', 'buku_id', 'peminjaman_id');
    }

    public function getSampulUrlAttribute(): string
    {
        if ($this->sampul) {
            return asset('storage/' . $this->sampul);
        }
        return asset('images/book-placeholder.png');
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
              ->orWhere('penulis', 'like', "%{$keyword}%")
              ->orWhere('isbn', 'like', "%{$keyword}%")
              ->orWhere('penerbit', 'like', "%{$keyword}%");
        });
    }
}
