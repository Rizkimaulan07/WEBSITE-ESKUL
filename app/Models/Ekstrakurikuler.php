<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ekskul',
        'deskripsi',
        'pembina',
        'hari_latihan',
        'jam_mulai',
        'jam_selesai',
        'tempat_latihan',
        'logo',
        'slug'  // Tambahkan ini
    ];

    // Relasi ke User (Pelatih)
    public function pelatih()
    {
        return $this->hasOne(User::class, 'ekskul_id')->where('role', 'pelatih');
    }

    // Relasi ke User (Anggota) - Many to Many
    public function users()
    {
        return $this->belongsToMany(User::class, 'anggota_ekskul', 'ekskul_id', 'user_id')
                    ->withPivot('jabatan', 'tahun_masuk')
                    ->withTimestamps();
    }

    // Relasi ke Dokumentasi
    public function dokumentasis()
    {
        return $this->hasMany(Dokumentasi::class);
    }

    // Relasi ke Kehadiran
    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }

    // Accessor untuk jumlah anggota
    public function getJumlahAnggotaAttribute()
    {
        return $this->users()->where('role', 'anggota')->count();
    }
}