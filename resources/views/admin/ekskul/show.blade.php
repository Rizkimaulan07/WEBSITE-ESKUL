@extends('layouts.app')

@section('title', 'Detail Ekstrakurikuler')
@section('subtitle', 'Informasi lengkap ekstrakurikuler')

@section('content')
<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-xl-4 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header Profile - Biru Cerah -->
            <div class="card-header border-0 py-4 px-4 hero-gradient">
                <div class="text-center">
                    <div class="position-relative d-inline-block">
                        @if($ekskul->logo)
                            <img src="{{ asset($ekskul->logo) }}" 
                                 class="rounded-circle border border-3 border-white shadow-lg" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="logo-large bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 120px; height: 120px; margin: 0 auto; border: 4px solid rgba(255,255,255,0.3);">
                                <i class="fas fa-image fa-4x text-white opacity-90"></i>
                            </div>
                        @endif
                        <span class="position-absolute bottom-0 end-0 {{ $ekskul->status == 'aktif' ? 'bg-success' : 'bg-danger' }} rounded-circle p-2 border border-white">
                            <span class="d-block" style="width: 8px; height: 8px;"></span>
                        </span>
                    </div>
                    <h4 class="text-white fw-bold mt-3 mb-0" style="font-size: 20px; letter-spacing: -0.5px;">{{ $ekskul->nama_ekskul }}</h4>
                    <p class="text-white-50 small mb-0" style="font-weight: 400;">{{ $ekskul->pembina }}</p>
                    <div class="mt-2">
                        <span class="badge-role" style="background: rgba(255,255,255,0.12); color: #fff; padding: 4px 16px; border-radius: 20px; font-size: 12px; font-weight: 500; backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.06);">
                            <i class="fas fa-trophy me-1"></i>
                            {{ $ekskul->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Body Profile -->
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom" style="border-color: #f1f5f9 !important;">
                    <span class="text-muted small" style="color: #64748b; font-size: 12px;">Status</span>
                    <span class="badge-status {{ $ekskul->status == 'aktif' ? 'active' : 'inactive' }}" style="padding: 2px 14px; border-radius: 12px; font-size: 11px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; {{ $ekskul->status == 'aktif' ? 'background: rgba(16,185,129,0.08); color: #10b981;' : 'background: rgba(239,68,68,0.06); color: #ef4444;' }}">
                        <span class="dot" style="width: 6px; height: 6px; {{ $ekskul->status == 'aktif' ? 'background: #10b981;' : 'background: #ef4444;' }} border-radius: 50%; display: inline-block;"></span>
                        {{ $ekskul->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom" style="border-color: #f1f5f9 !important;">
                    <span class="text-muted small" style="color: #64748b; font-size: 12px;">Dibuat</span>
                    <span class="text-dark fw-semibold small" style="color: #0f172a; font-size: 13px; font-weight: 600;">
                        <i class="far fa-calendar-alt me-1 text-muted"></i>
                        {{ $ekskul->created_at->format('d M Y') }}
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted small" style="color: #64748b; font-size: 12px;">ID Ekskul</span>
                    <span class="text-dark fw-semibold small" style="color: #0f172a; font-size: 13px; font-weight: 600;">#{{ str_pad($ekskul->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.ekskul.edit', $ekskul->id) }}" class="btn-edit btn-primary-gradient" style="display: block; width: 100%; padding: 12px; font-weight: 600; font-size: 14px; text-align: center; text-decoration: none; transition: all 0.3s ease;">
                        <i class="fas fa-edit me-2"></i> Edit Ekskul
                    </a>
                    <form action="{{ route('admin.ekskul.destroy', $ekskul->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus ekstrakurikuler {{ $ekskul->nama_ekskul }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete w-100" style="padding: 12px; border: none; border-radius: 10px; background: rgba(239,68,68,0.04); color: #ef4444; font-weight: 600; font-size: 14px; text-align: center; transition: all 0.3s ease; cursor: pointer;">
                            <i class="fas fa-trash-alt me-2"></i> Hapus Ekskul
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Detail -->
    <div class="col-xl-8 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4" style="background: #ffffff;">
            <div class="card-header border-0 py-3 px-4 bg-transparent">
                <h5 class="fw-bold mb-0" style="color: #0f172a; font-size: 18px;">
                    <i class="fas fa-info-circle me-2" style="color: #0ea5e9;"></i>
                    Informasi Lengkap
                </h5>
            </div>
            <div class="card-body px-4">
                <div class="row g-4">
                    <!-- Deskripsi -->
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3" style="color: #0ea5e9; font-size: 14px;">
                            <i class="fas fa-align-left me-2"></i> Deskripsi
                        </h6>
                        <div class="info-item" style="padding: 14px 18px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02);">
                            <p class="mb-0" style="color: #1e293b; font-size: 14px; line-height: 1.7;">{{ $ekskul->deskripsi }}</p>
                        </div>
                    </div>

                    <div class="col-12"><hr style="border-color: #f1f5f9;"></div>

                    <!-- Jadwal -->
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3" style="color: #0ea5e9; font-size: 14px;">
                            <i class="fas fa-calendar-alt me-2"></i> Jadwal Latihan
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02);">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-calendar-day me-1 text-muted"></i> Hari
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0; display: flex; flex-wrap: wrap; gap: 4px;">
                                        @forelse(array_map('trim', explode(',', $ekskul->hari_latihan ?? '')) as $day)
                                            <span style="background: rgba(14,165,233,0.1); color: #0c4a6e; padding: 2px 10px; border-radius: 8px; font-size: 12px; font-weight: 600;">{{ $day }}</span>
                                        @empty
                                            -
                                        @endforelse
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02);">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-clock me-1 text-muted"></i> Jam Mulai
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0;">{{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02);">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-clock me-1 text-muted"></i> Jam Selesai
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0;">{{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12"><hr style="border-color: #f1f5f9;"></div>

                    <!-- Tempat & Informasi Lain -->
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3" style="color: #0ea5e9; font-size: 14px;">
                            <i class="fas fa-map-marker-alt me-2"></i> Tempat & Informasi
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02);">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-map-pin me-1 text-muted"></i> Tempat Latihan
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0;">{{ $ekskul->tempat_latihan }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02);">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-user-tie me-1 text-muted"></i> Pembina
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0;">{{ $ekskul->pembina }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02);">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-users me-1 text-muted"></i> Total Anggota
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0;">{{ $ekskul->users->count() ?? 0 }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid rgba(0,0,0,0.02);">
                                    <label class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                        <i class="fas fa-calendar-plus me-1 text-muted"></i> Dibuat
                                    </label>
                                    <p class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0;">{{ $ekskul->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12"><hr style="border-color: #f1f5f9;"></div>

                    <!-- List Anggota -->
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3" style="color: #0ea5e9; font-size: 14px;">
                            <i class="fas fa-users me-2"></i> Daftar Anggota
                        </h6>
                        @if($ekskul->users->count() > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($ekskul->users as $anggota)
                                    <div class="member-tag" style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px 6px 10px; background: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0;">
                                        <div class="member-avatar" style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 11px; flex-shrink: 0;">
                                            {{ strtoupper(substr($anggota->name, 0, 1)) }}
                                        </div>
                                        <span style="font-size: 13px; color: #0f172a; font-weight: 500;">{{ $anggota->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-inbox fa-2x text-muted mb-2 d-block" style="color: #64748b;"></i>
                                <span class="text-muted" style="color: #64748b;">Belum ada anggota yang bergabung</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer border-0 bg-transparent px-4 pb-4 pt-0">
                <a href="{{ route('admin.ekskul.index') }}" class="btn-back" style="display: inline-flex; align-items: center; padding: 10px 24px; border: 1px solid #e2e8f0; border-radius: 10px; background: transparent; color: #64748b; font-weight: 500; font-size: 13px; text-decoration: none; transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Ekskul
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .info-item:hover { background: #f1f5f9; transform: translateY(-2px); transition: all 0.3s ease; }
    .btn-edit:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(14,165,233,0.4); color: #fff; text-decoration: none; }
    .btn-delete:hover { background: rgba(239,68,68,0.08); transform: translateY(-2px); }
    .btn-back:hover { background: #f8fafc; transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.04); color: #0f172a; text-decoration: none; }
    .member-tag:hover { background: #f1f5f9; transform: translateY(-2px); transition: all 0.3s ease; }
    .badge-status .dot { animation: pulse 2s infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.3; transform: scale(0.7); } }
    @media (max-width: 768px) { .info-item { padding: 8px 12px; } .info-value { font-size: 13px; } }
</style>
@endsection