@extends('layouts.app')

@section('title', 'Dashboard Pelatih')
@section('subtitle', 'Selamat datang di dashboard pelatih')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-modern" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
            <div class="card-body-modern" style="padding: 28px 32px;">
                <!-- Welcome Section - Biru Cerah -->
                <div class="welcome-section mb-4">
                    <h4 class="fw-bold" style="color: #0f172a;">Selamat Datang, {{ Auth::user()->name }}! 👋</h4>
                    <p class="text-muted" style="color: #94a3b8;">Anda login sebagai Pelatih Ekstrakurikuler</p>
                    @if(isset($data['ekskul']) && $data['ekskul'])
                        <span class="badge-ekskul" style="display: inline-block; padding: 4px 16px; background: rgba(14,165,233,0.06); color: #0ea5e9; border-radius: 20px; font-size: 13px; font-weight: 500;">
                            <i class="fas fa-trophy me-1"></i>
                            {{ $data['ekskul']->nama_ekskul ?? 'Ekskul' }}
                        </span>
                    @else
                        <span class="badge-ekskul" style="display: inline-block; padding: 4px 16px; background: rgba(239,68,68,0.06); color: #ef4444; border-radius: 20px; font-size: 13px; font-weight: 500;">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Belum ada ekskul
                        </span>
                    @endif
                </div>

                <!-- Alert jika belum punya ekskul -->
                @if(!isset($data['ekskul']) || !$data['ekskul'])
                    <div class="alert alert-warning rounded-4 border-0 shadow-sm" role="alert" style="background: #fef3c7; border-left: 4px solid #f59e0b;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                            <div>
                                <strong style="color: #92400e;">Perhatian!</strong>
                                <span style="color: #78350f;">Anda belum memiliki ekskul.</span>
                                <br>
                                <small style="color: #78350f;">Silakan hubungi admin untuk mendaftarkan ekskul Anda.</small>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Statistik Cards - Biru Cerah -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="stat-card" style="display: flex; align-items: center; gap: 16px; padding: 20px 24px; background: #f8fafc; border-radius: 12px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                            <div class="stat-icon" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; background: rgba(14,165,233,0.06); color: #0ea5e9;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-body" style="flex: 1;">
                                <span class="stat-label" style="font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Anggota</span>
                                <h3 class="stat-number" style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 2px 0 0;">{{ $data['total_anggota'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card" style="display: flex; align-items: center; gap: 16px; padding: 20px 24px; background: #f8fafc; border-radius: 12px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                            <div class="stat-icon" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; background: rgba(16,185,129,0.06); color: #10b981;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-body" style="flex: 1;">
                                <span class="stat-label" style="font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Kehadiran Hari Ini</span>
                                <h3 class="stat-number" style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 2px 0 0;">{{ $data['kehadiran_hari_ini'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card" style="display: flex; align-items: center; gap: 16px; padding: 20px 24px; background: #f8fafc; border-radius: 12px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                            <div class="stat-icon" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; background: rgba(245,158,11,0.06); color: #f59e0b;">
                                <i class="fas fa-images"></i>
                            </div>
                            <div class="stat-body" style="flex: 1;">
                                <span class="stat-label" style="font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Dokumentasi</span>
                                <h3 class="stat-number" style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 2px 0 0;">{{ $data['total_dokumentasi'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Cards - Biru Cerah -->
                <div class="row mt-4 g-4">
                    <div class="col-md-4">
                        <a href="{{ route('pelatih.kehadiran') }}" class="menu-card" style="display: block; padding: 24px; background: #f8fafc; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.02);">
                            <div class="menu-icon" style="width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 12px; background: rgba(14,165,233,0.06); color: #0ea5e9;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h6 style="font-weight: 600; color: #0f172a; margin-bottom: 4px;">Kehadiran Anggota</h6>
                            <p class="text-muted small" style="color: #94a3b8; margin-bottom: 0; font-size: 12px;">Kelola kehadiran anggota</p>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('pelatih.nilai') }}" class="menu-card" style="display: block; padding: 24px; background: #f8fafc; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.02);">
                            <div class="menu-icon" style="width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 12px; background: rgba(16,185,129,0.06); color: #10b981;">
                                <i class="fas fa-star"></i>
                            </div>
                            <h6 style="font-weight: 600; color: #0f172a; margin-bottom: 4px;">Nilai Anggota</h6>
                            <p class="text-muted small" style="color: #94a3b8; margin-bottom: 0; font-size: 12px;">Kelola nilai anggota</p>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('pelatih.dokumentasi') }}" class="menu-card" style="display: block; padding: 24px; background: #f8fafc; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.02);">
                            <div class="menu-icon" style="width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 12px; background: rgba(245,158,11,0.06); color: #f59e0b;">
                                <i class="fas fa-images"></i>
                            </div>
                            <h6 style="font-weight: 600; color: #0f172a; margin-bottom: 4px;">Dokumentasi</h6>
                            <p class="text-muted small" style="color: #94a3b8; margin-bottom: 0; font-size: 12px;">Kelola dokumentasi kegiatan</p>
                        </a>
                    </div>
                </div>

                <!-- Anggota Terbaru -->
                @if(isset($data['anggota_terbaru']) && $data['anggota_terbaru']->count() > 0)
                <div class="mt-4">
                    <h6 class="fw-semibold mb-3" style="color: #0f172a;">
                        <i class="fas fa-user-plus me-2" style="color: #0ea5e9;"></i>
                        Anggota Terbaru
                    </h6>
                    <div class="table-responsive">
                        <table class="table-modern" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                            <thead>
                                <tr>
                                    <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Nama</th>
                                    <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Email</th>
                                    <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Kelas</th>
                                    <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['anggota_terbaru'] as $anggota)
                                <tr style="transition: all 0.3s ease;">
                                    <td style="padding: 10px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">{{ $anggota->name }}</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">{{ $anggota->email }}</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">{{ $anggota->kelas ?? '-' }}</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">{{ $anggota->created_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(14,165,233,0.06); }
    .menu-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(14,165,233,0.06); text-decoration: none; background: #ffffff; }
    .table-modern tbody tr:hover { background: rgba(14,165,233,0.015); }
    @media (max-width: 768px) {
        .card-body-modern { padding: 18px; }
        .stat-card { padding: 16px 18px; }
        .stat-number { font-size: 20px; }
        .menu-card { padding: 18px; }
    }
</style>
@endsection