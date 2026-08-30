<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'nis',
        'email',
        'password',
        'role',
        'no_hp',
        'kelas',
        'jurusan',
        'ekskul_id',
        'pelatih_id',
        'avatar',
        'is_verified',
        'verified_at',
        'deleted_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verified_at' => 'datetime',
            'is_verified' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    // =================================================================
    // ===== RELASI =====
    // =================================================================

    // Relasi ke Ekskul (satu user punya satu ekskul)
    public function ekskul()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    // Relasi ke Pelatih (untuk anggota)
    public function pelatih()
    {
        return $this->belongsTo(User::class, 'pelatih_id');
    }

    // Relasi ke Anggota (untuk pelatih)
    public function anggotas()
    {
        return $this->hasMany(User::class, 'pelatih_id');
    }

    // Relasi ke Ekskuls (many-to-many) untuk anggota yang punya banyak ekskul
    public function ekskuls()
    {
        return $this->belongsToMany(Ekstrakurikuler::class, 'anggota_ekskul', 'user_id', 'ekskul_id')
                    ->withPivot('jabatan', 'tahun_masuk')
                    ->withTimestamps();
    }

    // Relasi ke Kehadiran (sebagai anggota)
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'anggota_id');
    }

    // Relasi ke Kehadiran (sebagai pelatih)
    public function kehadiranPelatih()
    {
        return $this->hasMany(Kehadiran::class, 'pelatih_id');
    }

    // Relasi ke Nilai Anggota
    public function nilaiAnggota()
    {
        return $this->hasMany(NilaiAnggota::class, 'anggota_id');
    }

    // Relasi ke Nilai Anggota (sebagai pelatih)
    public function nilaiPelatih()
    {
        return $this->hasMany(NilaiAnggota::class, 'pelatih_id');
    }

    // Relasi ke Dokumentasi
    public function dokumentasis()
    {
        return $this->hasMany(Dokumentasi::class, 'diunggah_oleh');
    }

    // =================================================================
    // ===== ACCESSOR: URL AVATAR / FOTO PROFIL =====
    // =================================================================
    
    /**
     * Get the user's avatar URL.
     * Jika ada avatar di database, pakai itu. Jika tidak, pakai UI Avatars.
     */
    public function getAvatarUrlAttribute(): string
    {
        // Jika user punya avatar yang tersimpan di database
        if ($this->avatar && file_exists(public_path($this->avatar))) {
            return asset($this->avatar);
        }
        
        // Jika user punya avatar di storage
        if ($this->avatar && file_exists(storage_path('app/public/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }
        
        // Default avatar berdasarkan role
        $defaults = [
            'admin' => 'https://ui-avatars.com/api/?name=Admin&background=0ea5e9&color=fff&size=128&bold=true',
            'pelatih' => 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=10b981&color=fff&size=128&bold=true',
            'anggota' => 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=f59e0b&color=fff&size=128&bold=true',
        ];
        
        return $defaults[$this->role] ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=fff&size=128&bold=true';
    }

    /**
     * Get avatar with fallback to default.
     * Alias untuk avatar_url
     */
    public function getFotoAttribute(): string
    {
        return $this->avatar_url;
    }

    // =================================================================
    // ===== HELPER METHODS =====
    // =================================================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPelatih(): bool
    {
        return $this->role === 'pelatih';
    }

    public function isAnggota(): bool
    {
        return $this->role === 'anggota';
    }

    public function getNisFormattedAttribute(): string
    {
        return $this->nis ? 'NIS: ' . $this->nis : '-';
    }

    public function getJurusanFormattedAttribute(): string
    {
        return $this->jurusan ?? '-';
    }

    public function getRoleLabelAttribute(): string
    {
        $labels = [
            'admin' => 'Administrator',
            'pelatih' => 'Pelatih',
            'anggota' => 'Anggota',
        ];
        return $labels[$this->role] ?? ucfirst($this->role);
    }

    public function getRoleIconAttribute(): string
    {
        $icons = [
            'admin' => 'fas fa-shield-alt',
            'pelatih' => 'fas fa-chalkboard-teacher',
            'anggota' => 'fas fa-user-graduate',
        ];
        return $icons[$this->role] ?? 'fas fa-user';
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->is_verified) {
            return '<span class="badge bg-success">Verified</span>';
        }
        return '<span class="badge bg-warning">Pending</span>';
    }

    // =================================================================
    // ===== SCOPES =====
    // =================================================================

    public function scopeUnverified(Builder $query): Builder
    {
        return $query->where('role', 'pelatih')->where('is_verified', false);
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('role', 'pelatih')->where('is_verified', true);
    }

    public function scopeByEkskul(Builder $query, int $ekskulId): Builder
    {
        return $query->where('ekskul_id', $ekskulId);
    }

    public function scopeByPelatih(Builder $query, int $pelatihId): Builder
    {
        return $query->where('pelatih_id', $pelatihId);
    }

    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('role', 'admin');
    }

    public function scopePelatih(Builder $query): Builder
    {
        return $query->where('role', 'pelatih');
    }

    public function scopeAnggota(Builder $query): Builder
    {
        return $query->where('role', 'anggota');
    }
}