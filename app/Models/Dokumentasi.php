<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'ekskul_id',
        'judul',
        'deskripsi',
        'tanggal_kegiatan',
        'diunggah_oleh',
        'foto_path',
        'foto_lainnya'
    ];

    protected $dates = ['tanggal_kegiatan'];

    protected $casts = [
        'foto_lainnya' => 'array',
        'tanggal_kegiatan' => 'date',
    ];

    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekskul_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'diunggah_oleh');
    }

    public function getFotoPathsAttribute()
    {
        $paths = [];
        if ($this->foto_path) {
            $paths[] = $this->foto_path;
        }
        if ($this->foto_lainnya) {
            $paths = array_merge($paths, (array) $this->foto_lainnya);
        }
        return $paths;
    }

    public function getFotoUrlsAttribute()
    {
        $urls = [];
        foreach ($this->foto_paths as $path) {
            $urls[] = asset('storage/' . $path);
        }
        return $urls;
    }

    public static function normalizeFotoPath($path)
    {
        if (empty($path)) {
            return null;
        }

        $path = (string) $path;

        if (preg_match('#^https?://[^/]+/(.+)$#i', $path, $m)) {
            $path = $m[1];
        }

        $path = ltrim($path, '/');

        foreach (['storage/app/public/', 'public/', 'storage/'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                $path = substr($path, strlen($prefix));
                break;
            }
        }

        return $path;
    }
}