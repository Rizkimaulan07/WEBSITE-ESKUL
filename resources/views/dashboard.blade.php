@extends('layouts.app')

@section('title', 'Dashboard Pelatih')
@section('subtitle', 'Selamat datang di dashboard pelatih')

@section('content')
<!-- ===== HERO SECTION - Biru Cerah ===== -->
<div class="hero-section mb-4" style="background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 30%, #38bdf8 60%, #7dd3fc 100%); border-radius: 24px; padding: 32px 40px; position: relative; overflow: hidden; box-shadow: 0 8px 40px rgba(14,165,233,0.25);">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-4">
                <div class="hero-icon" style="width: 64px; height: 64px; border-radius: 16px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-chalkboard-teacher fa-2x text-white"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-1" style="font-size: 22px; letter-spacing: -0.5px;">Selamat Datang, {{ Auth::user()->name }}! 👋</h4>
                    <p class="text-white-75 mb-1" style="color: rgba(255,255,255,0.75); font-size: 14px;">Anda login sebagai Pelatih Ekstrakurikuler</p>
                    @if(isset($data['ekskul']))
                        <span class="hero-badge" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(12px); color: #e2e8f0; padding: 4px 18px; border-radius: 20px; font-size: 13px; font-weight: 500; border: 1px solid rgba(255,255,255,0.08); display: inline-block;">
                            <i class="fas fa-trophy me-1"></i>
                            {{ $data['ekskul']->nama_ekskul ?? 'Ekskul' }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                <span class="hero-badge" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(12px); color: #e2e8f0; padding: 6px 20px; border-radius: 20px; font-size: 13px; font-weight: 500; border: 1px solid rgba(255,255,255,0.08);">
                    <i class="fas fa-shield-alt me-2"></i>Pelatih
                </span>
                <span class="hero-badge" style="background: #ffffff; color: #10b981; padding: 6px 20px; border-radius: 20px; font-size: 13px; font-weight: 700; border: 1px solid rgba(255,255,255,0.95); box-shadow: 0 2px 12px rgba(0,0,0,0.15);">
                    <span class="dot" style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block; box-shadow: 0 0 0 3px rgba(16,185,129,0.25); margin-right: 8px;"></span>Online
                </span>
            </div>
        </div>
    </div>
    <!-- Decorative Shapes -->
    <div class="hero-shapes">
        <div class="shape-circle" style="position: absolute; width: 250px; height: 250px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.05), transparent 70%); top: -120px; right: 10%; pointer-events: none;"></div>
        <div class="shape-circle" style="position: absolute; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.04), transparent 70%); bottom: -75px; left: 15%; pointer-events: none;"></div>
        <div class="shape-circle" style="position: absolute; width: 80px; height: 80px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.06), transparent 70%); top: 20%; right: 25%; pointer-events: none; animation: float 8s ease-in-out infinite;"></div>
    </div>
</div>

<!-- ===== STATISTICS CARDS ===== -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-users"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Anggota</span>
                    <h3 class="stat-number-modern" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -1px;">{{ $data['total_anggota'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-trend-modern up" style="display: inline-flex; align-items: center; gap: 4px; margin-top: 12px; background: rgba(16,185,129,0.06); color: #10b981; padding: 2px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                <i class="fas fa-user-plus"></i> Terdaftar
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #0ea5e9, #38bdf8); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Kehadiran Hari Ini</span>
                    <h3 class="stat-number-modern" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -1px;">{{ $data['kehadiran_hari_ini'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-trend-modern {{ ($data['kehadiran_hari_ini'] ?? 0) > 0 ? 'up' : 'down' }}" style="display: inline-flex; align-items: center; gap: 4px; margin-top: 12px; {{ ($data['kehadiran_hari_ini'] ?? 0) > 0 ? 'background: rgba(16,185,129,0.06); color: #10b981;' : 'background: rgba(239,68,68,0.06); color: #ef4444;' }} padding: 2px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                <i class="fas {{ ($data['kehadiran_hari_ini'] ?? 0) > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                {{ ($data['kehadiran_hari_ini'] ?? 0) > 0 ? 'Aktif' : 'Belum ada' }}
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #10b981, #34d399); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #fffbeb, #fef3c7); display: flex; align-items: center; justify-content: center; color: #f59e0b; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-images"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Dokumentasi</span>
                    <h3 class="stat-number-modern" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -1px;">{{ $data['total_dokumentasi'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-trend-modern up" style="display: inline-flex; align-items: center; gap: 4px; margin-top: 12px; background: rgba(16,185,129,0.06); color: #10b981; padding: 2px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                <i class="fas fa-camera"></i> Dokumentasi
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #f59e0b, #fbbf24); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
</div>

<!-- ===== QUICK MENU CARDS ===== -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <a href="{{ route('pelatih.kehadiran') }}" class="menu-card-modern" style="display: block; padding: 28px 20px; background: #ffffff; border-radius: 20px; text-align: center; text-decoration: none; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); position: relative; overflow: hidden;">
            <div class="menu-icon-modern" style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 28px; margin: 0 auto 14px; transition: all 0.4s ease;">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h6 style="font-weight: 600; color: #0f172a; margin-bottom: 4px; font-size: 15px;">Kehadiran Anggota</h6>
            <p style="color: #64748b; font-size: 13px; margin-bottom: 0;">Kelola kehadiran anggota</p>
            <div class="menu-arrow" style="position: absolute; bottom: 16px; right: 20px; color: #64748b; font-size: 14px; opacity: 0; transform: translateX(-10px); transition: all 0.4s ease;">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('pelatih.nilai') }}" class="menu-card-modern" style="display: block; padding: 28px 20px; background: #ffffff; border-radius: 20px; text-align: center; text-decoration: none; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); position: relative; overflow: hidden;">
            <div class="menu-icon-modern" style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 28px; margin: 0 auto 14px; transition: all 0.4s ease;">
                <i class="fas fa-star"></i>
            </div>
            <h6 style="font-weight: 600; color: #0f172a; margin-bottom: 4px; font-size: 15px;">Nilai Anggota</h6>
            <p style="color: #64748b; font-size: 13px; margin-bottom: 0;">Input dan kelola nilai anggota</p>
            <div class="menu-arrow" style="position: absolute; bottom: 16px; right: 20px; color: #64748b; font-size: 14px; opacity: 0; transform: translateX(-10px); transition: all 0.4s ease;">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('pelatih.dokumentasi') }}" class="menu-card-modern" style="display: block; padding: 28px 20px; background: #ffffff; border-radius: 20px; text-align: center; text-decoration: none; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); position: relative; overflow: hidden;">
            <div class="menu-icon-modern" style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #fffbeb, #fef3c7); display: flex; align-items: center; justify-content: center; color: #f59e0b; font-size: 28px; margin: 0 auto 14px; transition: all 0.4s ease;">
                <i class="fas fa-images"></i>
            </div>
            <h6 style="font-weight: 600; color: #0f172a; margin-bottom: 4px; font-size: 15px;">Dokumentasi</h6>
            <p style="color: #64748b; font-size: 13px; margin-bottom: 0;">Kelola dokumentasi kegiatan</p>
            <div class="menu-arrow" style="position: absolute; bottom: 16px; right: 20px; color: #64748b; font-size: 14px; opacity: 0; transform: translateX(-10px); transition: all 0.4s ease;">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>
</div>

<!-- ===== ANGGOTA TERBARU ===== -->
@if(isset($data['anggota_terbaru']) && $data['anggota_terbaru']->count() > 0)
<div class="card premium-card" style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); overflow: hidden; transition: all 0.4s ease;">
    <div class="card-header premium-card-header" style="padding: 18px 24px; border-bottom: 1px solid rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; background: rgba(248,250,252,0.2);">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(14,165,233,0.08); color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fas fa-user-plus"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="font-weight: 700; font-size: 14px; color: #0f172a;">Anggota Terbaru</h6>
                <small class="text-muted" style="font-size: 12px; color: #64748b;">Bergabung baru-baru ini</small>
            </div>
        </div>
        <span class="badge-count" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $data['anggota_terbaru']->count() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table premium-table" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Nama</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Email</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Kelas</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['anggota_terbaru'] as $anggota)
                    <tr style="transition: all 0.3s ease; animation: fadeRow 0.5s ease forwards;">
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-icon" style="width: 32px; height: 32px; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 12px; flex-shrink: 0;">
                                    {{ strtoupper(substr($anggota->name, 0, 1)) }}
                                </div>
                                <span style="font-weight: 600; color: #0f172a;">{{ $anggota->name }}</span>
                            </div>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span style="color: #475569; font-size: 13px;">{{ $anggota->email }}</span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="badge-kelas" style="background: rgba(245,158,11,0.06); color: #f59e0b; padding: 2px 14px; border-radius: 8px; font-size: 12px; font-weight: 500;">{{ $anggota->kelas }}</span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span style="color: #64748b; font-size: 13px;">{{ $anggota->created_at->diffForHumans() }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<style>
    /* ===== ANIMATIONS ===== */
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(0.7); }
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(10px, -20px); }
    }
    
    @keyframes fadeRow {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== STAT CARD HOVER ===== */
    .stat-card-modern:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(14,165,233,0.08);
        border-color: rgba(14,165,233,0.06);
    }
    
    .stat-card-modern:hover .stat-icon-modern {
        transform: scale(1.08) rotate(-3deg);
    }
    
    .stat-card-modern:hover .stat-progress-modern {
        transform: scaleX(1);
    }

    /* ===== MENU CARD HOVER ===== */
    .menu-card-modern:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 60px rgba(14,165,233,0.08);
        border-color: rgba(14,165,233,0.06);
    }
    
    .menu-card-modern:hover .menu-icon-modern {
        transform: scale(1.1) rotate(-3deg);
    }
    
    .menu-card-modern:hover .menu-arrow {
        opacity: 1;
        transform: translateX(0);
        color: #0ea5e9;
    }

    /* ===== TABLE HOVER ===== */
    .premium-card:hover {
        box-shadow: 0 12px 40px rgba(14,165,233,0.06);
    }
    
    .premium-table tbody tr:hover {
        background: rgba(14,165,233,0.015);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .hero-section {
            padding: 24px 20px;
        }
        .stat-card-modern {
            padding: 16px 18px;
        }
        .stat-number-modern {
            font-size: 22px !important;
        }
        .menu-card-modern {
            padding: 20px 16px;
        }
        .premium-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        .premium-table {
            font-size: 12px;
        }
    }
</style>
@endsection