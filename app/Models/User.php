<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nis', // Tambahkan NIS
        'email',
        'password',
        'role',
        'no_hp',
        'kelas',
        'jurusan', // Tambahkan Jurusan
        'ekskul_id',
        'pelatih_id',
        'is_verified',
        'verified_at'
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
            'verified_at' => 'datetime',
            'is_verified' => 'boolean',
        ];
    }

    // Relasi ke Ekskul
    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    // Relasi ke Pelatih (untuk anggota)
    public function pelatih()
    {
        return $this->belongsTo(User::class, 'pelatih_id');
    }

    // Relasi ke Anggota (untuk pelatih)
    public function anggotas()
    {
        return $this->hasMany(User::class, 'pelatih_id');
    }

    // Relasi ke Ekskuls (many-to-many)
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

    // Helper methods
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

    // Accessor untuk NIS
    public function getNisFormattedAttribute()
    {
        return $this->nis ? 'NIS: ' . $this->nis : '-';
    }

    // Accessor untuk Jurusan
    public function getJurusanFormattedAttribute()
    {
        return $this->jurusan ?? '-';
    }

    // Scope untuk pelatih yang belum diverifikasi
    public function scopeUnverified($query)
    {
        return $query->where('role', 'pelatih')->where('is_verified', false);
    }

    // Scope untuk pelatih yang sudah diverifikasi
    public function scopeVerified($query)
    {
        return $query->where('role', 'pelatih')->where('is_verified', true);
    }

    // Scope untuk anggota berdasarkan ekskul
    public function scopeByEkskul($query, $ekskulId)
    {
        return $query->where('ekskul_id', $ekskulId);
    }

    // Scope untuk anggota berdasarkan pelatih
    public function scopeByPelatih($query, $pelatihId)
    {
        return $query->where('pelatih_id', $pelatihId);
    }
}