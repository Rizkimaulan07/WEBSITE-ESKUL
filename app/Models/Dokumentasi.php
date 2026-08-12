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

    protected static function booted(): void
    {
        static::saving(function (self $dokumentasi) {
            $dokumentasi->foto_path = self::normalizeFotoPath($dokumentasi->foto_path);
        });
    }

    public static function normalizeFotoPath(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        $normalized = str_replace('\\', '/', $path);
        $normalized = preg_replace('#^/?(public|storage)/#', '', $normalized);
        $normalized = ltrim($normalized, '/');

        return $normalized ?: null;
    }

    public function getFotoPathAttribute($value): ?string
    {
        return self::normalizeFotoPath($value);
    }

    // Relasi ke Ekstrakurikuler
    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekskul_id');
    }

    // Relasi ke User (yang mengunggah)
    public function user()
    {
        return $this->belongsTo(User::class, 'diunggah_oleh');
    }

    // Alias untuk pelatih (agar kompatibel dengan kode yang memanggil ->pelatih)
    public function pelatih()
    {
        return $this->belongsTo(User::class, 'diunggah_oleh');
    }
}