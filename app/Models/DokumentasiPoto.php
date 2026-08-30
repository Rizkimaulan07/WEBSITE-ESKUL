<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiFoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokumentasi_id',
        'path',
        'filename',
    ];

    public function dokumentasi()
    {
        return $this->belongsTo(Dokumentasi::class);
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}