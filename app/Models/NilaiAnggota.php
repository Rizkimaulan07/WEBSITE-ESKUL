<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAnggota extends Model
{
    use HasFactory;

    protected $table = 'nilai_anggota';

    protected $fillable = [
        'anggota_id',
        'ekskul_id',
        'pelatih_id',
        'nilai_kehadiran',
        'nilai_keterampilan',
        'nilai_sikap',
        'nilai_total',
        'catatan',
        'semester',
        'tahun_ajaran'
    ];

    protected $casts = [
        'nilai_kehadiran' => 'integer',
        'nilai_keterampilan' => 'integer',
        'nilai_sikap' => 'integer',
        'nilai_total' => 'decimal:2',
    ];

    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    public function pelatih()
    {
        return $this->belongsTo(User::class, 'pelatih_id');
    }
}