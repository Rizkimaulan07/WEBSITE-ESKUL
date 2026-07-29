<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'pelatih_id',
        'ekskul_id',
        'tanggal',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    // Relasi ke Anggota (User)
    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    // Relasi ke Pelatih (User)
    public function pelatih()
    {
        return $this->belongsTo(User::class, 'pelatih_id');
    }

    // Relasi ke Ekskul
    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }
}