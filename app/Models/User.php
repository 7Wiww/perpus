<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'role', 'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function anggota()
    {
        return $this->hasOne(Anggota::class);
    }

    public function peminjamansAspetugas()
    {
        return $this->hasMany(Peminjaman::class, 'petugas_id');
    }

    public function pengembalianAspetugas()
    {
        return $this->hasMany(Pengembalian::class, 'petugas_id');
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isPetugas(): bool { return $this->role === 'petugas'; }
    public function isPimpinan(): bool { return $this->role === 'pimpinan'; }
    public function isAnggota(): bool { return $this->role === 'anggota'; }

    public function canManage(): bool
    {
        return in_array($this->role, ['admin', 'petugas']);
    }
}
