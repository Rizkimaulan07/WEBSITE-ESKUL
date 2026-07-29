<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'foto_path',
        'tanggal_kegiatan',
        'ekskul_id',
        'diunggah_oleh'
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date'
    ];

    // Relasi ke Ekskul
    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    // Relasi ke Pengunggah (User)
    public function pengunggah()
    {
        return $this->belongsTo(User::class, 'diunggah_oleh');
    }
}