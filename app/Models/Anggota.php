<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';

    protected $fillable = [
        'user_id', 'no_anggota', 'nim_nip', 'no_telepon', 'alamat',
        'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'program_studi',
        'fakultas_instansi', 'jenis_anggota', 'tanggal_bergabung',
        'status', 'foto', 'catatan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_bergabung' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }

    public function peminjamansAktif()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id')
                    ->whereIn('status', ['dipinjam', 'terlambat']);
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/user-placeholder.png');
    }

    public static function generateNoAnggota(): string
    {
        $last = static::orderBy('id', 'desc')->first();
        $num = $last ? ((int) substr($last->no_anggota, 3)) + 1 : 1;
        return 'AGT' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
