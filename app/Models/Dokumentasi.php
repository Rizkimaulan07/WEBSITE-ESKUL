<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasis';

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

    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    public function pengunggah()
    {
        return $this->belongsTo(User::class, 'diunggah_oleh');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'diunggah_oleh');
    }

    /**
     * Relasi ke model User sebagai pelatih
     * Menggunakan foreign key 'diunggah_oleh' yang merujuk ke id user
     */
    public function pelatih()
    {
        return $this->belongsTo(User::class, 'diunggah_oleh');
    }
}