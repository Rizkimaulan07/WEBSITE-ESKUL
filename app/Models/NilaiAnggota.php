<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAnggota extends Model
{
    use HasFactory;

    protected $table = 'nilai_anggota';

    const PREDIKAT = [
        'S' => 'Sangat Baik',
        'A' => 'Baik',
        'B' => 'Cukup',
    ];

    protected $fillable = [
        'anggota_id',
        'ekskul_id',
        'pelatih_id',
        'predikat',
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

    public function getPredikatLabelAttribute(): string
    {
        return self::PREDIKAT[$this->predikat] ?? '-';
    }

    public function getPredikatColorAttribute(): string
    {
        return match ($this->predikat) {
            'S' => '#047857',
            'A' => '#0284c7',
            'B' => '#b45309',
            default => '#64748b',
        };
    }

    public function getPredikatBackgroundAttribute(): string
    {
        return match ($this->predikat) {
            'S' => 'rgba(16,185,129,0.12)',
            'A' => 'rgba(14,165,233,0.10)',
            'B' => 'rgba(245,158,11,0.10)',
            default => 'rgba(100,116,139,0.08)',
        };
    }

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