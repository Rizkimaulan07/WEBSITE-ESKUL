@extends('layouts.app')

@section('title', 'Dashboard Pelatih')
@section('subtitle', 'Selamat datang di dashboard pelatih')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-body-modern">
                <div class="welcome-section mb-4">
                    <h4 class="fw-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h4>
                    <p class="text-muted">Anda login sebagai Pelatih Ekstrakurikuler</p>
                    @if(isset($data['ekskul']) && $data['ekskul'])
                        <span class="badge-ekskul">
                            <i class="fas fa-trophy me-1"></i>
                            {{ $data['ekskul']->nama_ekskul ?? 'Ekskul' }}
                        </span>
                    @else
                        <span class="badge-ekskul" style="background: rgba(239, 68, 68, 0.06); color: #ef4444;">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Belum ada ekskul
                        </span>
                    @endif
                </div>

                <!-- Alert jika belum punya ekskul -->
                @if(!isset($data['ekskul']) || !$data['ekskul'])
                    <div class="alert alert-warning rounded-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                            <div>
                                <strong>Perhatian!</strong> Anda belum memiliki ekskul.
                                <br>
                                <small>Silakan hubungi admin untuk mendaftarkan ekskul Anda.</small>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Statistik Cards -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(99, 102, 241, 0.06); color: #6366f1;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Total Anggota</span>
                                <h3 class="stat-number">{{ $data['total_anggota'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.06); color: #10b981;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Kehadiran Hari Ini</span>
                                <h3 class="stat-number">{{ $data['kehadiran_hari_ini'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.06); color: #f59e0b;">
                                <i class="fas fa-images"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Total Dokumentasi</span>
                                <h3 class="stat-number">{{ $data['total_dokumentasi'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Cards -->
                <div class="row mt-4 g-4">
                    <div class="col-md-4">
                        <a href="{{ route('pelatih.kehadiran') }}" class="menu-card">
                            <div class="menu-icon" style="background: rgba(99, 102, 241, 0.06); color: #6366f1;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h6>Kehadiran Anggota</h6>
                            <p class="text-muted small">Kelola kehadiran anggota</p>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('pelatih.nilai') }}" class="menu-card">
                            <div class="menu-icon" style="background: rgba(16, 185, 129, 0.06); color: #10b981;">
                                <i class="fas fa-star"></i>
                            </div>
                            <h6>Nilai Anggota</h6>
                            <p class="text-muted small">Kelola nilai anggota</p>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('pelatih.dokumentasi') }}" class="menu-card">
                            <div class="menu-icon" style="background: rgba(245, 158, 11, 0.06); color: #f59e0b;">
                                <i class="fas fa-images"></i>
                            </div>
                            <h6>Dokumentasi</h6>
                            <p class="text-muted small">Kelola dokumentasi kegiatan</p>
                        </a>
                    </div>
                </div>

                

                <!-- Anggota Terbaru -->
                @if(isset($data['anggota_terbaru']) && $data['anggota_terbaru']->count() > 0)
                <div class="mt-4">
                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-user-plus me-2" style="color: #6366f1;"></i>
                        Anggota Terbaru
                    </h6>
                    <div class="table-responsive">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Kelas</th>
                                    <th>Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['anggota_terbaru'] as $anggota)
                                <tr>
                                    <td>{{ $anggota->name }}</td>
                                    <td>{{ $anggota->email }}</td>
                                    <td>{{ $anggota->kelas ?? '-' }}</td>
                                    <td>{{ $anggota->created_at->diffForHumans() }}</td>
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
    .card-modern {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .card-body-modern {
        padding: 28px 32px;
    }

    .welcome-section h4 {
        color: #0f172a;
        margin-bottom: 4px;
    }

    .welcome-section p {
        margin-bottom: 8px;
    }

    .badge-ekskul {
        display: inline-block;
        padding: 4px 16px;
        background: rgba(99, 102, 241, 0.06);
        color: #6366f1;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .badge-count {
        background: rgba(99, 102, 241, 0.06);
        color: #6366f1;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px 24px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-body {
        flex: 1;
    }

    .stat-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin: 2px 0 0;
    }

    .menu-card {
        display: block;
        padding: 24px;
        background: #f8fafc;
        border-radius: 12px;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .menu-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        text-decoration: none;
        background: #ffffff;
    }

    .menu-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 12px;
    }

    .menu-card h6 {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .menu-card p {
        margin-bottom: 0;
        font-size: 12px;
    }

    /* ===== DOKUMENTASI CARD ===== */
    .dokumentasi-card {
        display: block;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        height: 100%;
    }

    .dokumentasi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        text-decoration: none;
        color: inherit;
    }

    .dokumentasi-card-image {
        height: 150px;
        overflow: hidden;
        background: #f8fafc;
    }

    .dokumentasi-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }

    .dokumentasi-card:hover .dokumentasi-card-image img {
        transform: scale(1.05);
    }

    .dokumentasi-placeholder {
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        color: #d1d5db;
        font-size: 40px;
    }

    .dokumentasi-card-body {
        padding: 12px 16px;
    }

    .dokumentasi-card-body h6 {
        font-size: 14px;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .dokumentasi-card-body p {
        font-size: 12px;
        margin-bottom: 0;
    }

    .btn-link-custom {
        color: #4f46e5;
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-link-custom:hover {
        color: #4f46e5;
        text-decoration: none;
        transform: translateX(4px);
    }

    .table-modern {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table-modern thead th {
        background: rgba(248, 250, 252, 0.3);
        color: #64748b;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        text-align: left;
    }

    .table-modern tbody td {
        padding: 10px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.015);
        vertical-align: middle;
    }

    .table-modern tbody tr:hover {
        background: rgba(99, 102, 241, 0.012);
    }

    .alert {
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .card-body-modern {
            padding: 18px;
        }

        .stat-card {
            padding: 16px 18px;
        }

        .stat-number {
            font-size: 20px;
        }

        .menu-card {
            padding: 18px;
        }

        .dokumentasi-card-image {
            height: 120px;
        }

        .dokumentasi-card-body h6 {
            font-size: 12px;
        }
    }
</style>
@endsection