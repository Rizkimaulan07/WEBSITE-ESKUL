@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('subtitle', 'Overview sistem manajemen ekstrakurikuler')

@section('content')
@php
    $user = Auth::user();
    $hour = date('H');
    $greeting = $hour < 11 ? '🌅 Selamat Pagi' : ($hour < 15 ? '☀️ Selamat Siang' : ($hour < 19 ? '🌤️ Selamat Sore' : '🌙 Selamat Malam'));
@endphp

<!-- ===== WELCOME BANNER ULTRA PREMIUM ===== -->
<div class="welcome-banner">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <div class="d-flex align-items-center gap-4">
                <div class="avatar-ring">
                    <div class="avatar-circle">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-1">{{ $greeting }}, {{ $user->name }}! 👋</h4>
                    <p class="text-white-75 mb-1">
                        <i class="far fa-calendar-alt me-2"></i>
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-white-75 mb-0" id="clock">
                        <i class="far fa-clock me-2"></i>
                        {{ now()->format('H:i:s') }} WIB
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 text-lg-end mt-3 mt-lg-0">
            <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
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
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>
</div>

<!-- ===== STATISTICS CARDS ===== -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #4f46e5; --accent-light: #818cf8;">
            <div class="stat-icon">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Ekskul</span>
                <h3 class="stat-number">{{ $data['total_ekskul'] ?? 0 }}</h3>
                <span class="stat-trend up">
                    <i class="fas fa-arrow-up me-1"></i> Aktif
                </span>
            </div>
            <div class="stat-progress" style="--accent: #4f46e5;"></div>
            <div class="stat-glow" style="--accent: #4f46e5;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #3b82f6; --accent-light: #60a5fa;">
            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.08); color: #3b82f6;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Anggota</span>
                <h3 class="stat-number">{{ $data['total_anggota'] ?? 0 }}</h3>
                <span class="stat-trend up">
                    <i class="fas fa-user-plus me-1"></i> Terdaftar
                </span>
            </div>
            <div class="stat-progress" style="--accent: #3b82f6;"></div>
            <div class="stat-glow" style="--accent: #3b82f6;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #10b981; --accent-light: #34d399;">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.08); color: #10b981;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Pelatih</span>
                <h3 class="stat-number">{{ $data['total_pelatih'] ?? 0 }}</h3>
                <span class="stat-trend up">
                    <i class="fas fa-star me-1"></i> Profesional
                </span>
            </div>
            <div class="stat-progress" style="--accent: #10b981;"></div>
            <div class="stat-glow" style="--accent: #10b981;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #f59e0b; --accent-light: #fbbf24;">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.08); color: #f59e0b;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Kehadiran Hari Ini</span>
                <h3 class="stat-number">{{ $data['total_kehadiran_hari_ini'] ?? 0 }}</h3>
                <span class="stat-trend {{ ($data['total_kehadiran_hari_ini'] ?? 0) > 0 ? 'up' : 'down' }}">
                    <i class="fas {{ ($data['total_kehadiran_hari_ini'] ?? 0) > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} me-1"></i>
                    {{ ($data['total_kehadiran_hari_ini'] ?? 0) > 0 ? 'Aktif' : 'Belum ada' }}
                </span>
            </div>
            <div class="stat-progress" style="--accent: #f59e0b;"></div>
            <div class="stat-glow" style="--accent: #f59e0b;"></div>
        </div>
    </div>
</div>

<!-- ===== QUICK MENU (Tanpa Laporan) ===== -->
<div class="row g-4 mb-4">
    <div class="col-md-4 col-6">
        <a href="{{ route('admin.ekskul.index') }}" class="quick-menu">
            <div class="quick-icon" style="background: rgba(79, 70, 229, 0.08); color: #4f46e5;">
                <i class="fas fa-trophy fa-2x"></i>
            </div>
            <h6>Kelola Ekskul</h6>
            <p class="quick-desc">Tambah & edit ekskul</p>
            <span class="quick-arrow"><i class="fas fa-arrow-right"></i></span>
        </a>
    </div>
    <div class="col-md-4 col-6">
        <a href="{{ route('admin.anggota.index') }}" class="quick-menu">
            <div class="quick-icon" style="background: rgba(16, 185, 129, 0.08); color: #10b981;">
                <i class="fas fa-users fa-2x"></i>
            </div>
            <h6>Kelola Anggota</h6>
            <p class="quick-desc">Tambah & edit anggota</p>
            <span class="quick-arrow"><i class="fas fa-arrow-right"></i></span>
        </a>
    </div>
    <div class="col-md-4 col-6">
        <a href="{{ route('admin.template-surat.index') }}" class="quick-menu">
            <div class="quick-icon" style="background: rgba(245, 158, 11, 0.08); color: #f59e0b;">
                <i class="fas fa-file-alt fa-2x"></i>
            </div>
            <h6>Template Surat</h6>
            <p class="quick-desc">Kelola template surat</p>
            <span class="quick-arrow"><i class="fas fa-arrow-right"></i></span>
        </a>
    </div>
</div>

<!-- ===== RECENT EKSKUL ===== -->
<div class="card premium-card">
    <div class="card-header premium-card-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold">Ekstrakurikuler Terbaru</h6>
                <small class="text-muted">Data terbaru yang ditambahkan</small>
            </div>
        </div>
        <a href="{{ route('admin.ekskul.index') }}" class="btn-link-custom">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table premium-table">
                <thead>
                    <tr>
                        <th>Nama Ekskul</th>
                        <th>Pembina</th>
                        <th>Jadwal</th>
                        <th>Anggota</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($data['ekskul_terbaru'] ?? []) as $ekskul)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-icon">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <span class="fw-semibold">{{ $ekskul->nama_ekskul }}</span>
                            </div>
                        </td>
                        <td>{{ $ekskul->pembina }}</td>
                        <td>
                            <span class="badge-day">{{ $ekskul->hari_latihan }}</span>
                            <div class="small text-muted">
                                {{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}
                            </div>
                        </td>
                        <td>
                            <span class="badge-member">
                                <i class="fas fa-user me-1"></i>
                                {{ $ekskul->users_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $ekskul->status == 'aktif' ? 'active' : 'inactive' }}">
                                {{ $ekskul->status == 'aktif' ? '● Aktif' : '● Nonaktif' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="action-group">
                                <a href="{{ route('admin.ekskul.show', $ekskul->id) }}" class="btn-action view" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.ekskul.edit', $ekskul->id) }}" class="btn-action edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.ekskul.destroy', $ekskul->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus ekskul ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h6>Belum ada data</h6>
                                <p class="small">Tambahkan ekstrakurikuler pertama Anda</p>
                            </div>
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
        background: linear-gradient(135deg, #0f172a 0%, #1a1a3e 40%, #2d1b69 70%, #4f46e5 100%);
        border-radius: 24px;
        padding: 36px 44px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(79, 70, 229, 0.15);
    }

    .welcome-banner .avatar-ring {
        padding: 4px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #818cf8, #06b6d4);
        animation: spin 6s linear infinite;
        flex-shrink: 0;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .welcome-banner .avatar-circle {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 24px;
        border: 2px solid rgba(255,255,255,0.1);
    }

    .text-white-75 { color: rgba(255,255,255,0.75); }

    .badge-role {
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(12px);
        color: #e2e8f0;
        padding: 6px 22px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.04);
    }

    .badge-status {
        background: rgba(16, 185, 129, 0.12);
        color: #34d399;
        padding: 4px 18px;
        border-radius: 20px;
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

    /* Floating Shapes */
    .floating-shapes .shape {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        opacity: 0.08;
    }

    .floating-shapes .shape-1 {
        width: 300px;
        height: 300px;
        top: -150px;
        right: -50px;
        background: radial-gradient(circle, #4f46e5, transparent 70%);
        animation: float 8s ease-in-out infinite;
    }

    .floating-shapes .shape-2 {
        width: 150px;
        height: 150px;
        bottom: -75px;
        left: 10%;
        background: radial-gradient(circle, #818cf8, transparent 70%);
        animation: float 6s ease-in-out infinite reverse;
    }

    .floating-shapes .shape-3 {
        width: 80px;
        height: 80px;
        top: 10%;
        right: 20%;
        background: radial-gradient(circle, #06b6d4, transparent 70%);
        animation: float 10s ease-in-out infinite;
    }

    .floating-shapes .shape-4 {
        width: 50px;
        height: 50px;
        bottom: 20%;
        right: 15%;
        background: radial-gradient(circle, #34d399, transparent 70%);
        animation: float 7s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -30px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }

    /* ===== STAT CARDS ===== */
    .stat-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px 28px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 60px rgba(79, 70, 229, 0.12);
        border-color: rgba(79, 70, 229, 0.06);
    }

    .stat-card .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: rgba(79, 70, 229, 0.08);
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        transition: all 0.4s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(-3deg);
    }

    .stat-card .stat-body { flex: 1; }
    .stat-card .stat-label { font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-card .stat-number { font-size: 30px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px; }

    .stat-trend {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-trend.up { background: rgba(16, 185, 129, 0.06); color: #10b981; }
    .stat-trend.down { background: rgba(239, 68, 68, 0.06); color: #ef4444; }

    .stat-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), var(--accent-light));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.6s ease;
    }

    .stat-card:hover .stat-progress { transform: scaleX(1); }

    .stat-glow {
        position: absolute;
        top: -50%;
        right: -20%;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: radial-gradient(circle, var(--accent), transparent 70%);
        opacity: 0;
        transition: opacity 0.6s ease;
        pointer-events: none;
    }

    .stat-card:hover .stat-glow { opacity: 0.06; }

    /* ===== QUICK MENU ===== */
    .quick-menu {
        display: block;
        padding: 24px;
        background: #ffffff;
        border-radius: 16px;
        text-align: center;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
    }

    .quick-menu::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--quick-color), transparent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .quick-menu:hover::before { opacity: 0.03; }

    .quick-menu:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 60px rgba(79, 70, 229, 0.12);
        text-decoration: none;
        border-color: rgba(79, 70, 229, 0.06);
    }

    .quick-menu .quick-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        transition: all 0.4s ease;
        position: relative;
        z-index: 1;
    }

    .quick-menu:hover .quick-icon { transform: scale(1.1) rotate(-3deg); }

    .quick-menu h6 {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 2px;
        font-size: 14px;
        position: relative;
        z-index: 1;
    }

    .quick-menu .quick-desc {
        color: #94a3b8;
        font-size: 12px;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .quick-menu .quick-arrow {
        position: absolute;
        top: 16px;
        right: 16px;
        color: #94a3b8;
        font-size: 12px;
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.4s ease;
    }

    .quick-menu:hover .quick-arrow {
        opacity: 1;
        transform: translateX(0);
        color: #4f46e5;
    }

    /* ===== PREMIUM CARD ===== */
    .premium-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .premium-card:hover { box-shadow: 0 12px 60px rgba(79, 70, 229, 0.08); }

    .premium-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(248,250,252,0.3);
    }

    .premium-card-header .header-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(245, 158, 11, 0.08);
        color: #f59e0b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .premium-card-header h6 { font-weight: 600; font-size: 14px; color: #0f172a; }
    .premium-card-header small { font-size: 12px; }

    .btn-link-custom {
        color: #4f46e5;
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 6px 16px;
        border-radius: 10px;
        background: rgba(79, 70, 229, 0.04);
    }

    .btn-link-custom:hover {
        color: #4f46e5;
        background: rgba(79, 70, 229, 0.08);
        text-decoration: none;
        transform: translateX(4px);
    }

    /* ===== TABLE ===== */
    .premium-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .premium-table thead th {
        background: rgba(248,250,252,0.3);
        color: #64748b;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        text-align: left;
    }

    .premium-table tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.015);
        vertical-align: middle;
    }

    .premium-table tbody tr { transition: all 0.3s ease; }
    .premium-table tbody tr:hover { background: rgba(79, 70, 229, 0.015); }
    .premium-table tbody tr:last-child td { border-bottom: none; }

    .avatar-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(79, 70, 229, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4f46e5;
        font-size: 14px;
    }

    .badge-day {
        background: rgba(59, 130, 246, 0.06);
        color: #3b82f6;
        padding: 2px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-member {
        background: rgba(16, 185, 129, 0.06);
        color: #10b981;
        padding: 2px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-badge {
        padding: 3px 14px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .status-badge.active {
        background: rgba(16, 185, 129, 0.08);
        color: #10b981;
    }

    .status-badge.inactive {
        background: rgba(239, 68, 68, 0.06);
        color: #ef4444;
    }

    /* Action Buttons */
    .action-group {
        display: flex;
        gap: 4px;
        justify-content: center;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        background: transparent;
        color: #94a3b8;
    }

    .btn-action:hover { transform: translateY(-2px); }
    .btn-action.view:hover { background: rgba(79, 70, 229, 0.06); color: #4f46e5; }
    .btn-action.edit:hover { background: rgba(245, 158, 11, 0.06); color: #f59e0b; }
    .btn-action.delete:hover { background: rgba(239, 68, 68, 0.06); color: #ef4444; }

    /* Empty State */
    .empty-state { padding: 30px 0; }
    .empty-state .empty-icon {
        font-size: 48px;
        color: #d1d5db;
        margin-bottom: 12px;
    }
    .empty-state h6 { color: #64748b; margin-bottom: 4px; }
    .empty-state p { color: #94a3b8; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .welcome-banner { padding: 24px 20px; }
        .stat-card { padding: 16px 18px; }
        .stat-card .stat-number { font-size: 22px; }
        .quick-menu { padding: 16px; }
        .premium-card-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .premium-table { font-size: 12px; }
        .action-group { gap: 2px; }
        .btn-action { width: 28px; height: 28px; font-size: 11px; }
    }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const options = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const time = now.toLocaleTimeString('id-ID', options);
        document.getElementById('clock').innerHTML = '<i class="far fa-clock me-2"></i> ' + time + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection