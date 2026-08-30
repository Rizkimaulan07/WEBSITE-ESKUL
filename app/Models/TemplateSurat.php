<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_template',
        'file_template',
        'keterangan'
    ];

    public function suratKeluars()
    {
        return $this->hasMany(SuratKeluar::class);
    }

    public function getFileTypeAttribute(): string
    {
        if (!$this->file_template) {
            return '-';
        }

        $ext = strtolower(pathinfo($this->file_template, PATHINFO_EXTENSION));

        return match ($ext) {
            'pdf' => 'PDF',
            'docx', 'doc' => 'Word',
            default => strtoupper($ext),
        };
    }
}