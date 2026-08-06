<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KehadiranPelatih extends Model
{
    use HasFactory;

    protected $table = 'kehadiran_pelatih';

    protected $fillable = [
        'pelatih_id',
        'ekskul_id',
        'tanggal',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function pelatih()
    {
        return $this->belongsTo(User::class, 'pelatih_id');
    }

    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }
}