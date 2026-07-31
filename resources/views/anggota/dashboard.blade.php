@extends('layouts.app')

@section('title', 'Dashboard Anggota')
@section('subtitle', 'Selamat datang di dashboard anggota')

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
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card blue">
            <div class="stat-icon blue">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Kehadiran</span>
                <h3 class="stat-number">{{ $data['total_kehadiran'] ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-check-circle me-1"></i> Total
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Hadir</span>
                <h3 class="stat-number">{{ $data['hadir'] ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-arrow-up me-1"></i> Kehadiran
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card gold">
            <div class="stat-icon gold">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Persentase Kehadiran</span>
                <h3 class="stat-number">{{ $data['persentase_hadir'] ?? 0 }}%</h3>
                <span class="stat-change up">
                    <i class="fas fa-percent me-1"></i> Baik
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card purple">
            <div class="stat-icon purple">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Ekskul</span>
                <h3 class="stat-number" style="font-size: 16px; margin-top: 8px;">
                    {{ $data['ekskul']->nama_ekskul ?? '-' }}
                </h3>
                <span class="stat-change up">
                    <i class="fas fa-trophy me-1"></i> Bergabung
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Kehadiran -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-history me-2" style="color: #f59e0b;"></i>Riwayat Kehadiran Terbaru</h5>
        <span class="badge bg-primary">{{ $data['total_kehadiran'] ?? 0 }} total</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($data['riwayat_terbaru'] ?? []) as $index => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <i class="far fa-calendar-alt me-2 text-muted"></i>
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </td>
                        <td>
                            <span class="badge bg-{{ $item->status == 'hadir' ? 'success' : ($item->status == 'izin' ? 'warning' : ($item->status == 'sakit' ? 'info' : 'danger')) }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox me-2"></i>Belum ada riwayat kehadiran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
    .stat-card .stat-icon.green { background: rgba(16, 185, 129, 0.06); color: #10b981; }
    .stat-card .stat-icon.gold { background: rgba(245, 158, 11, 0.06); color: #f59e0b; }
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