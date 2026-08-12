<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'nis',
        'email',
        'password',
        'role',
        'no_hp',
        'kelas',
        'jurusan',
        'ekskul_id',
        'pelatih_id',
        'avatar',
        'is_verified',
        'verified_at',
        'deleted_at'
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
            'deleted_at' => 'datetime',
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
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPelatih(): bool
    {
        return $this->role === 'pelatih';
    }

    public function isAnggota(): bool
    {
        return $this->role === 'anggota';
    }

    // Accessor untuk NIS
    public function getNisFormattedAttribute(): string
    {
        return $this->nis ? 'NIS: ' . $this->nis : '-';
    }

    // Accessor untuk Jurusan
    public function getJurusanFormattedAttribute(): string
    {
        return $this->jurusan ?? '-';
    }

    // Scope untuk pelatih yang belum diverifikasi
    public function scopeUnverified(Builder $query): Builder
    {
        return $query->where('role', 'pelatih')->where('is_verified', false);
    }

    // Scope untuk pelatih yang sudah diverifikasi
    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('role', 'pelatih')->where('is_verified', true);
    }

    // Scope untuk anggota berdasarkan ekskul
    public function scopeByEkskul(Builder $query, int $ekskulId): Builder
    {
        return $query->where('ekskul_id', $ekskulId);
    }

    // Scope untuk anggota berdasarkan pelatih
    public function scopeByPelatih(Builder $query, int $pelatihId): Builder
    {
        return $query->where('pelatih_id', $pelatihId);
    }
}