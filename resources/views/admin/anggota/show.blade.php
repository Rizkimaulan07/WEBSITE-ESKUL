@extends('layouts.app')

@section('title', 'Detail Anggota')
@section('subtitle', 'Informasi lengkap anggota')

@section('content')
<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-xl-4 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Header Profile - Biru Cerah -->
            <div class="card-header border-0 py-4 px-4" 
                 style="background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 40%, #7dd3fc 80%, #bae6fd 100%);">
                <div class="text-center">
                    <div class="position-relative d-inline-block">
                        @if($anggota->avatar)
                            <img src="{{ asset($anggota->avatar) }}" 
                                 class="rounded-circle border border-3 border-white shadow-lg" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="avatar-large bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 120px; height: 120px; margin: 0 auto; border: 4px solid rgba(255,255,255,0.3);">
                                <i class="fas fa-user fa-4x text-white opacity-90"></i>
                            </div>
                        @endif
                        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 border border-white">
                            <span class="d-block" style="width: 8px; height: 8px;"></span>
                        </span>
                    </div>
                    <h4 class="text-white fw-bold mt-3 mb-0" style="font-size: 20px; letter-spacing: -0.5px;">{{ $anggota->name }}</h4>
                    <p class="text-white-50 small mb-0" style="font-weight: 400;">{{ $anggota->email }}</p>
                    <div class="mt-2">
                        <span class="badge-role" style="background: rgba(255,255,255,0.12); color: #fff; padding: 4px 16px; border-radius: 20px; font-size: 12px; font-weight: 500; backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.06);">
                            <i class="fas fa-shield-alt me-1"></i>
                            {{ ucfirst($anggota->role) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Body Profile -->
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom" style="border-color: #f1f5f9 !important;">
                    <span class="text-muted small" style="color: #94a3b8; font-size: 12px;">Status</span>
                    <span class="badge-status" style="background: rgba(16,185,129,0.08); color: #10b981; padding: 2px 14px; border-radius: 12px; font-size: 11px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                        <span class="dot" style="width: 6px; height: 6px; background: #10b981; border-radius: 50%; display: inline-block;"></span>
                        Aktif
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom" style="border-color: #f1f5f9 !important;">
                    <span class="text-muted small" style="color: #94a3b8; font-size: 12px;">Bergabung</span>
                    <span class="text-dark fw-semibold small" style="color: #0f172a; font-size: 13px; font-weight: 600;">
                        <i class="far fa-calendar-alt me-1 text-muted"></i>
                        {{ $anggota->created_at->format('d M Y') }}
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted small" style="color: #94a3b8; font-size: 12px;">ID Anggota</span>
                    <span class="text-dark fw-semibold small" style="color: #0f172a; font-size: 13px; font-weight: 600;">#{{ str_pad($anggota->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.anggota.edit', $anggota->id) }}" class="btn-edit" style="display: block; width: 100%; padding: 12px; border: none; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-weight: 600; font-size: 14px; text-align: center; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(14,165,233,0.3);">
                        <i class="fas fa-edit me-2"></i> Edit Anggota
                    </a>
                    <form action="{{ route('admin.anggota.destroy', $anggota->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus anggota {{ $anggota->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete w-100" style="padding: 12px; border: none; border-radius: 10px; background: rgba(239,68,68,0.04); color: #ef4444; font-weight: 600; font-size: 14px; text-align: center; transition: all 0.3s ease; cursor: pointer;">
                            <i class="fas fa-trash-alt me-2"></i> Hapus Anggota
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Detail -->
    <div class="col-xl-8 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header border-0 py-3 px-4 bg-transparent">
                <h5 class="fw-bold mb-0" style="color: #0f172a; font-size: 18px;">
                    <i class="fas fa-info-circle me-2" style="color: #0ea5e9;"></i>
                    Informasi Lengkap
                </h5>
            </div>
            <div class="card-body px-4">
                <div class="row g-4">
                    <!-- Personal Info -->
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3" style="color: #0ea5e9; font-size: 14px;">
                            <i class="fas fa-user me-2"></i> Data Personal
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-user-circle me-1 text-muted"></i> Nama Lengkap
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0;">{{ $anggota->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-envelope me-1 text-muted"></i> Email
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0;">{{ $anggota->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-graduation-cap me-1 text-muted"></i> Kelas
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0;">{{ $anggota->kelas ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-phone me-1 text-muted"></i> No HP
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0;">{{ $anggota->no_hp ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12"><hr style="border-color: #f1f5f9;"></div>

                    <!-- Ekskul Info -->
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3" style="color: #0ea5e9; font-size: 14px;">
                            <i class="fas fa-trophy me-2"></i> Ekstrakurikuler
                        </h6>
                        <div class="row">
                            <div class="col-12">
                                @if($anggota->ekskuls->count() > 0)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($anggota->ekskuls as $ekskul)
                                            <div class="ekskul-card" style="display: flex; align-items: center; gap: 12px; padding: 12px 18px; background: #f8fafc; border-radius: 12px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease; min-width: 200px;">
                                                <div class="ekskul-icon" style="width: 40px; height: 40px; border-radius: 10px; background: rgba(14,165,233,0.06); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 16px; flex-shrink: 0;">
                                                    <i class="fas fa-trophy"></i>
                                                </div>
                                                <div>
                                                    <div class="ekskul-name" style="font-weight: 600; font-size: 14px; color: #0f172a;">{{ $ekskul->nama_ekskul }}</div>
                                                    <div class="ekskul-meta" style="font-size: 11px; color: #94a3b8;">
                                                        <i class="far fa-calendar-alt me-1"></i>
                                                        {{ $ekskul->hari_latihan ?? 'Hari' }}
                                                        <span class="mx-1">•</span>
                                                        <i class="far fa-clock me-1"></i>
                                                        {{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-3">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2 d-block" style="color: #94a3b8;"></i>
                                        <span class="text-muted" style="color: #94a3b8;">Belum bergabung dengan ekskul manapun</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12"><hr style="border-color: #f1f5f9;"></div>

                    <!-- Statistik -->
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3" style="color: #0ea5e9; font-size: 14px;">
                            <i class="fas fa-chart-bar me-2"></i> Statistik
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="stat-mini blue" style="display: flex; align-items: center; gap: 14px; padding: 14px 18px; background: #f8fafc; border-radius: 12px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                                    <div class="stat-mini-icon" style="width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: rgba(14,165,233,0.06); color: #0ea5e9;">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div>
                                        <div class="stat-mini-label" style="font-size: 11px; color: #94a3b8; font-weight: 500;">Total Kehadiran</div>
                                        <div class="stat-mini-value" style="font-size: 18px; font-weight: 700; color: #0f172a; line-height: 1.2;">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-mini gold" style="display: flex; align-items: center; gap: 14px; padding: 14px 18px; background: #f8fafc; border-radius: 12px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                                    <div class="stat-mini-icon" style="width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: rgba(245,158,11,0.06); color: #f59e0b;">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div>
                                        <div class="stat-mini-label" style="font-size: 11px; color: #94a3b8; font-weight: 500;">Rata-rata Nilai</div>
                                        <div class="stat-mini-value" style="font-size: 18px; font-weight: 700; color: #0f172a; line-height: 1.2;">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-mini green" style="display: flex; align-items: center; gap: 14px; padding: 14px 18px; background: #f8fafc; border-radius: 12px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                                    <div class="stat-mini-icon" style="width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: rgba(16,185,129,0.06); color: #10b981;">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <div class="stat-mini-label" style="font-size: 11px; color: #94a3b8; font-weight: 500;">Persentase Kehadiran</div>
                                        <div class="stat-mini-value" style="font-size: 18px; font-weight: 700; color: #0f172a; line-height: 1.2;">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer border-0 bg-transparent px-4 pb-4 pt-0">
                <a href="{{ route('admin.anggota.index') }}" class="btn-back" style="display: inline-flex; align-items: center; padding: 10px 24px; border: 1px solid #e2e8f0; border-radius: 10px; background: transparent; color: #64748b; font-weight: 500; font-size: 13px; text-decoration: none; transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Anggota
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .info-item:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .ekskul-card:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    }

    .stat-mini:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(14,165,233,0.4);
        color: #fff;
        text-decoration: none;
    }

    .btn-delete:hover {
        background: rgba(239,68,68,0.08);
        transform: translateY(-2px);
    }

    .btn-back:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        color: #0f172a;
        text-decoration: none;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(0.7); }
    }

    .badge-status .dot {
        animation: pulse 2s infinite;
    }

    @media (max-width: 768px) {
        .info-item { padding: 8px 12px; }
        .info-value { font-size: 13px; }
        .ekskul-card { min-width: 100%; }
        .stat-mini { padding: 12px 14px; }
        .stat-mini-value { font-size: 16px; }
    }
</style>
@endsection