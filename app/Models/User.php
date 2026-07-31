<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'kelas',
        'ekskul_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Ekskul (untuk pelatih)
    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    // Relasi ke Ekskul (untuk anggota) - Many to Many
    public function ekskuls()
    {
        return $this->belongsToMany(Ekstrakurikuler::class, 'anggota_ekskul', 'user_id', 'ekskul_id')
                    ->withPivot('jabatan', 'tahun_masuk')
                    ->withTimestamps();
    }

    // Relasi ke Kehadiran (sebagai anggota)
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'anggota_id');
    }

    // Relasi ke Kehadiran (sebagai pelatih)
    public function kehadiranPelatih()
    {
        return $this->hasMany(Kehadiran::class, 'pelatih_id');
    }

    // Relasi ke Nilai Anggota
    public function nilaiAnggota()
    {
        return $this->hasMany(NilaiAnggota::class, 'anggota_id');
    }

    // Relasi ke Nilai Anggota (sebagai pelatih)
    public function nilaiPelatih()
    {
        return $this->hasMany(NilaiAnggota::class, 'pelatih_id');
    }

    // Relasi ke Dokumentasi
    public function dokumentasis()
    {
        return $this->hasMany(Dokumentasi::class, 'diunggah_oleh');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPelatih()
    {
        return $this->role === 'pelatih';
    }

    public function isAnggota()
    {
        return $this->role === 'anggota';
    }
}