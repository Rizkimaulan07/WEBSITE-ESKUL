@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('subtitle', 'Overview sistem manajemen ekstrakurikuler')

@section('content')
@php
    $user = Auth::user();
@endphp

<!-- Welcome Banner -->
<div class="welcome-banner mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center gap-4">
                <div class="avatar-large">
                    <i class="fas fa-user-circle fa-4x text-white opacity-90"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-1">Selamat Datang, {{ $user->name }}! 👋</h4>
                    <p class="text-white-75 mb-1">
                        <i class="far fa-calendar-alt me-2"></i>
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-white-75 mb-0 small" id="clock">
                        <i class="far fa-clock me-2"></i>
                        {{ now()->format('H:i:s') }} WIB
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="d-inline-flex flex-column align-items-end gap-2">
                <span class="badge-role">
                    <i class="fas fa-shield-alt me-2"></i>
                    {{ ucfirst($user->role) }}
                </span>
                <span class="badge-status">
                    <span class="dot"></span>
                    Online
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-3 g-xl-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card blue">
            <div class="stat-icon blue">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Ekskul</span>
                <h3 class="stat-number">{{ $data['total_ekskul'] ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-arrow-up me-1"></i> Aktif
                </span>
            </div>
            <div class="stat-progress">
                <div class="progress-bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card gold">
            <div class="stat-icon gold">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Anggota</span>
                <h3 class="stat-number">{{ $data['total_anggota'] ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-user-plus me-1"></i> Terdaftar
                </span>
            </div>
            <div class="stat-meta">
                <span class="badge-soft">Aktif semua</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Pelatih</span>
                <h3 class="stat-number">{{ $data['total_pelatih'] ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-star me-1"></i> Profesional
                </span>
            </div>
            <div class="stat-meta">
                <span class="badge-soft">Berpengalaman</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card purple">
            <div class="stat-icon purple">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Kehadiran Hari Ini</span>
                <h3 class="stat-number">{{ $data['total_kehadiran_hari_ini'] ?? 0 }}</h3>
                <span class="stat-change {{ ($data['total_kehadiran_hari_ini'] ?? 0) > 0 ? 'up' : 'down' }}">
                    <i class="fas {{ ($data['total_kehadiran_hari_ini'] ?? 0) > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} me-1"></i>
                    {{ ($data['total_kehadiran_hari_ini'] ?? 0) > 0 ? 'Aktif' : 'Belum ada' }}
                </span>
            </div>
            <div class="stat-meta">
                <span class="badge-soft">{{ now()->format('H:i') }} WIB</span>
            </div>
        </div>
    </div>
</div>

<!-- Ekskul Terbaru -->
<div class="table-container">
    <div class="table-header">
        <h6><i class="fas fa-clock me-2" style="color: #f59e0b;"></i>Ekskul Terbaru</h6>
        <a href="{{ route('admin.ekskul.index') }}" class="btn-outline-custom btn-sm">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Nama Ekskul</th>
                    <th>Pembina</th>
                    <th>Jadwal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($data['ekskul_terbaru'] ?? []) as $ekskul)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-placeholder">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <span class="fw-semibold">{{ $ekskul->nama_ekskul }}</span>
                        </div>
                    </td>
                    <td>{{ $ekskul->pembina }}</td>
                    <td>
                        <span class="badge-soft">{{ $ekskul->hari_latihan }}</span>
                        <div class="small text-muted">
                            {{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}
                        </div>
                    </td>
                    <td>
                        <span class="status-badge {{ $ekskul->status == 'aktif' ? 'active' : 'inactive' }}">
                            {{ $ekskul->status == 'aktif' ? '🟢 Aktif' : '🔴 Nonaktif' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox me-2"></i>Belum ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* ===== WELCOME BANNER ===== */
    .welcome-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);
        border-radius: 16px;
        padding: 28px 36px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 30px rgba(99, 102, 241, 0.08);
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .text-white-75 {
        color: rgba(255,255,255,0.75);
    }

    .badge-role {
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(12px);
        color: #e2e8f0;
        padding: 6px 22px;
        border-radius: 22px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.04);
        transition: all 0.3s ease;
    }

    .badge-role:hover {
        background: rgba(255,255,255,0.1);
        transform: scale(1.02);
    }

    .badge-status {
        background: rgba(16, 185, 129, 0.12);
        color: #34d399;
        padding: 4px 18px;
        border-radius: 22px;
        font-size: 12px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(16, 185, 129, 0.06);
        backdrop-filter: blur(12px);
    }

    .badge-status .dot {
        width: 7px;
        height: 7px;
        background: #34d399;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(0.7); }
    }

    .avatar-large {
        opacity: 0.9;
    }

    /* ===== STAT CARDS ===== */
    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 22px 24px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.06);
    }

    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.05) rotate(-2deg);
    }

    .stat-card .stat-icon.blue { background: rgba(99, 102, 241, 0.06); color: #6366f1; }
    .stat-card .stat-icon.gold { background: rgba(245, 158, 11, 0.06); color: #f59e0b; }
    .stat-card .stat-icon.green { background: rgba(16, 185, 129, 0.06); color: #10b981; }
    .stat-card .stat-icon.purple { background: rgba(139, 92, 246, 0.06); color: #8b5cf6; }

    .stat-card .stat-body {
        flex: 1;
    }

    .stat-card .stat-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin: 2px 0;
        letter-spacing: -0.5px;
    }

    .stat-change {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-change.up {
        background: rgba(16, 185, 129, 0.06);
        color: #10b981;
    }

    .stat-change.down {
        background: rgba(239, 68, 68, 0.06);
        color: #ef4444;
    }

    .stat-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(0,0,0,0.03);
    }

    .stat-progress .progress-bar {
        height: 100%;
        border-radius: 0;
        transition: width 0.6s ease;
        background: linear-gradient(90deg, #6366f1, #818cf8);
    }

    .stat-meta {
        margin-top: 6px;
    }

    .badge-soft {
        background: rgba(99, 102, 241, 0.05);
        color: #6366f1;
        padding: 2px 14px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    /* ===== TABLE ===== */
    .table-container {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .table-header {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        background: rgba(248, 250, 252, 0.3);
    }

    .table-header h6 {
        font-weight: 600;
        font-size: 14px;
        color: #0f172a;
        margin: 0;
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
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        text-align: left;
    }

    .table-modern tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.015);
        vertical-align: middle;
    }

    .table-modern tbody tr:hover {
        background: rgba(99, 102, 241, 0.012);
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== BADGES ===== */
    .status-badge {
        padding: 3px 14px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-badge.active {
        background: rgba(16, 185, 129, 0.08);
        color: #10b981;
    }

    .status-badge.inactive {
        background: rgba(239, 68, 68, 0.06);
        color: #ef4444;
    }

    .btn-outline-custom {
        background: transparent;
        color: #4f46e5;
        border: 1.5px solid #4f46e5;
        padding: 7px 18px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-outline-custom:hover {
        background: #4f46e5;
        color: #fff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .avatar-placeholder {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(99, 102, 241, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .welcome-banner {
            padding: 20px 24px;
        }

        .stat-card {
            padding: 16px 18px;
        }

        .stat-card .stat-number {
            font-size: 22px;
        }
    }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const options = {
            timeZone: 'Asia/Jakarta',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };
        const time = now.toLocaleTimeString('id-ID', options);
        const clockElement = document.getElementById('clock');
        if (clockElement) {
            clockElement.innerHTML = '<i class="far fa-clock me-2"></i> ' + time + ' WIB';
        }
    }
    
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection