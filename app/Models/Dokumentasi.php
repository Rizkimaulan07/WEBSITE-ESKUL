<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'foto',
        'ekskul_id',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}