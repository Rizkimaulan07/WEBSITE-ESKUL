@extends('layouts.app')

@section('title', 'Detail Ekstrakurikuler')
@section('subtitle', 'Informasi lengkap ekstrakurikuler')

@section('content')
@php
    $statusColor = $ekskul->status == 'aktif' ? 'success' : 'danger';
    $statusIcon = $ekskul->status == 'aktif' ? '●' : '●';
@endphp

<div class="row g-4">
    <!-- ===== LEFT COLUMN ===== -->
    <div class="col-xl-4 col-lg-5">
        <div class="card premium-card">
            <!-- Header -->
            <div class="card-header premium-card-header" style="background: linear-gradient(135deg, #0f172a 0%, #1a1a3e 40%, #2d1b69 70%, #4f46e5 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon-white">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div>
                        <h6 class="text-white fw-bold mb-0">Logo Ekskul</h6>
                        <small class="text-white-50">Preview logo</small>
                    </div>
                </div>
            </div>
            <div class="card-body text-center py-4">
                @if($ekskul->logo)
                    <img src="{{ asset('storage/' . $ekskul->logo) }}" 
                         class="logo-preview" 
                         alt="{{ $ekskul->nama_ekskul }}">
                @else
                    <div class="logo-placeholder-large">
                        <i class="fas fa-image"></i>
                        <span class="d-block mt-2 text-muted small">Belum ada logo</span>
                    </div>
                @endif
                <h4 class="fw-bold mt-3 mb-1">{{ $ekskul->nama_ekskul }}</h4>
                <span class="status-badge {{ $ekskul->status == 'aktif' ? 'active' : 'inactive' }}">
                    {{ $statusIcon }} {{ ucfirst($ekskul->status) }}
                </span>
                <div class="mt-3">
                    <span class="badge-member">
                        <i class="fas fa-user me-1"></i>
                        {{ $ekskul->users_count ?? 0 }} Anggota
                    </span>
                </div>
            </div>
            <div class="card-footer border-0 bg-transparent pt-0 pb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.ekskul.edit', $ekskul->id) }}" class="btn-edit">
                        <i class="fas fa-edit me-2"></i> Edit Ekskul
                    </a>
                    <form action="{{ route('admin.ekskul.destroy', $ekskul->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus ekskul {{ $ekskul->nama_ekskul }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete w-100">
                            <i class="fas fa-trash-alt me-2"></i> Hapus Ekskul
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== STATISTIK MINI ===== -->
        <div class="card premium-card mt-4">
            <div class="card-header premium-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Statistik</h6>
                        <small class="text-muted">Data ekskul</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="stat-mini-item">
                    <div class="stat-mini-icon" style="background: rgba(79,70,229,0.06); color: #4f46e5;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div class="stat-mini-label">Total Anggota</div>
                        <div class="stat-mini-value">{{ $ekskul->users_count ?? 0 }}</div>
                    </div>
                </div>
                <div class="stat-mini-item">
                    <div class="stat-mini-icon" style="background: rgba(16,185,129,0.06); color: #10b981;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="stat-mini-label">Hari Latihan</div>
                        <div class="stat-mini-value">{{ $ekskul->hari_latihan }}</div>
                    </div>
                </div>
                <div class="stat-mini-item">
                    <div class="stat-mini-icon" style="background: rgba(245,158,11,0.06); color: #f59e0b;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="stat-mini-label">Jam Latihan</div>
                        <div class="stat-mini-value">
                            {{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}
                        </div>
                    </div>
                </div>
                <div class="stat-mini-item">
                    <div class="stat-mini-icon" style="background: rgba(139,92,246,0.06); color: #8b5cf6;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div class="stat-mini-label">Dibuat</div>
                        <div class="stat-mini-value">{{ \Carbon\Carbon::parse($ekskul->created_at)->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== RIGHT COLUMN ===== -->
    <div class="col-xl-8 col-lg-7">
        <!-- ===== INFORMASI EKSKUL ===== -->
        <div class="card premium-card">
            <div class="card-header premium-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Informasi Ekstrakurikuler</h6>
                        <small class="text-muted">Detail lengkap ekskul</small>
                    </div>
                </div>
                <span class="badge-count">{{ $ekskul->status == 'aktif' ? '🟢 Aktif' : '🔴 Nonaktif' }}</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-tag me-1"></i> Nama Ekskul</label>
                            <p class="info-value">{{ $ekskul->nama_ekskul }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-user-tie me-1"></i> Pembina</label>
                            <p class="info-value">{{ $ekskul->pembina }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-calendar-day me-1"></i> Hari Latihan</label>
                            <p class="info-value">
                                <span class="badge-day">{{ $ekskul->hari_latihan }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-clock me-1"></i> Jam Latihan</label>
                            <p class="info-value">
                                <i class="far fa-clock me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-map-marker-alt me-1"></i> Tempat Latihan</label>
                            <p class="info-value">
                                <i class="fas fa-map-pin me-1 text-danger"></i>
                                {{ $ekskul->tempat_latihan }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-align-left me-1"></i> Deskripsi</label>
                            <p class="info-value" style="font-weight: 400; line-height: 1.6;">
                                {{ $ekskul->deskripsi }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-users me-1"></i> Total Anggota</label>
                            <p class="info-value">
                                <span class="badge-member">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $ekskul->users_count ?? 0 }} Anggota
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-calendar-alt me-1"></i> Tanggal Dibuat</label>
                            <p class="info-value">
                                <i class="far fa-calendar-alt me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($ekskul->created_at)->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== DAFTAR ANGGOTA ===== -->
        <div class="card premium-card mt-4">
            <div class="card-header premium-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Daftar Anggota</h6>
                        <small class="text-muted">{{ $ekskul->users->where('role', 'anggota')->count() }} anggota terdaftar</small>
                    </div>
                </div>
                <a href="{{ route('admin.anggota.index') }}" class="btn-link-custom">
                    <i class="fas fa-user-plus me-1"></i> Tambah Anggota
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table premium-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $anggotaList = $ekskul->users->where('role', 'anggota');
                            @endphp
                            @forelse($anggotaList as $index => $user)
                            <tr>
                                <td>
                                    <span class="number-badge">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-mini">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-kelas">{{ $user->kelas ?? '-' }}</span>
                                </td>
                                <td>
                                    <i class="fas fa-envelope me-2 text-muted"></i>
                                    {{ $user->email }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state-mini">
                                        <div class="empty-icon-mini">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                        <h6>Belum ada anggota</h6>
                                        <p class="small text-muted">Tambahkan anggota ke ekskul ini</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===== TOMBOL KEMBALI ===== -->
        <div class="mt-4">
            <a href="{{ route('admin.ekskul.index') }}" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Ekskul
            </a>
        </div>
    </div>
</div>

<style>
    /* ===== PREMIUM CARD ===== */
    .premium-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .premium-card:hover {
        box-shadow: 0 12px 60px rgba(79,70,229,0.06);
    }

    .premium-card-header {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(248,250,252,0.2);
    }

    .premium-card-header .header-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(79,70,229,0.06);
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .premium-card-header .header-icon-white {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(255,255,255,0.08);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .premium-card-header h6 { font-weight: 700; font-size: 14px; color: #0f172a; }
    .premium-card-header small { font-size: 12px; color: #94a3b8; }

    /* ===== LOGO ===== */
    .logo-preview {
        max-width: 150px;
        max-height: 150px;
        border-radius: 16px;
        object-fit: cover;
        border: 4px solid rgba(0,0,0,0.02);
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        transition: all 0.4s ease;
    }

    .logo-preview:hover {
        transform: scale(1.03);
        box-shadow: 0 12px 40px rgba(79,70,229,0.12);
    }

    .logo-placeholder-large {
        width: 150px;
        height: 150px;
        border-radius: 16px;
        background: rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        border: 2px dashed rgba(0,0,0,0.04);
        margin: 0 auto;
        transition: all 0.4s ease;
    }

    .logo-placeholder-large:hover {
        background: rgba(79,70,229,0.02);
        border-color: rgba(79,70,229,0.1);
    }

    .logo-placeholder-large i { font-size: 48px; opacity: 0.3; }

    /* ===== BADGES ===== */
    .status-badge {
        padding: 4px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 500;
        display: inline-block;
    }

    .status-badge.active {
        background: rgba(16,185,129,0.08);
        color: #10b981;
    }

    .status-badge.inactive {
        background: rgba(239,68,68,0.06);
        color: #ef4444;
    }

    .badge-member {
        background: rgba(16,185,129,0.06);
        color: #10b981;
        padding: 4px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 500;
    }

    .badge-day {
        background: rgba(59,130,246,0.06);
        color: #3b82f6;
        padding: 2px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        display: inline-block;
    }

    .badge-kelas {
        background: rgba(245,158,11,0.06);
        color: #f59e0b;
        padding: 2px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-count {
        background: rgba(79,70,229,0.06);
        color: #4f46e5;
        padding: 2px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    /* ===== INFO ITEM ===== */
    .info-item {
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .info-label {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    /* ===== STAT MINI ===== */
    .stat-mini-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(0,0,0,0.02);
    }

    .stat-mini-item:last-child { border-bottom: none; }

    .stat-mini-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .stat-mini-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
    }

    .stat-mini-value {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }

    /* ===== BUTTONS ===== */
    .btn-edit {
        display: block;
        padding: 12px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(79,70,229,0.15);
    }

    .btn-edit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(79,70,229,0.35);
        color: #fff;
        text-decoration: none;
    }

    .btn-delete {
        padding: 12px;
        border: none;
        border-radius: 12px;
        background: rgba(239,68,68,0.04);
        color: #ef4444;
        font-weight: 600;
        font-size: 14px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: rgba(239,68,68,0.08);
        transform: translateY(-3px);
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        padding: 10px 24px;
        border: 1px solid rgba(0,0,0,0.02);
        border-radius: 12px;
        background: transparent;
        color: #64748b;
        font-weight: 500;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        color: #0f172a;
        text-decoration: none;
    }

    .btn-link-custom {
        color: #4f46e5;
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 6px 16px;
        border-radius: 10px;
        background: rgba(79,70,229,0.04);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-link-custom:hover {
        background: rgba(79,70,229,0.08);
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
        background: rgba(248,250,252,0.2);
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
        border-bottom: 1px solid rgba(0,0,0,0.01);
        vertical-align: middle;
    }

    .premium-table tbody tr:hover { background: rgba(79,70,229,0.015); }
    .premium-table tbody tr:last-child td { border-bottom: none; }

    .number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(79,70,229,0.04);
        color: #4f46e5;
        font-weight: 600;
        font-size: 12px;
    }

    .avatar-mini {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: linear-gradient(135deg, #4f46e5, #818cf8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 12px;
        flex-shrink: 0;
    }

    /* ===== EMPTY STATE MINI ===== */
    .empty-state-mini {
        padding: 30px 0;
        text-align: center;
    }

    .empty-state-mini .empty-icon-mini {
        font-size: 40px;
        color: #d1d5db;
        margin-bottom: 8px;
    }

    .empty-state-mini h6 { color: #64748b; margin-bottom: 2px; font-weight: 600; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .premium-card-header { flex-direction: column; align-items: flex-start; gap: 8px; }
        .logo-preview { max-width: 120px; max-height: 120px; }
        .logo-placeholder-large { width: 120px; height: 120px; }
        .info-item { padding: 10px 12px; }
        .info-value { font-size: 14px; }
        .btn-back { width: 100%; justify-content: center; }
        .btn-link-custom { width: 100%; justify-content: center; }
        .premium-table { font-size: 12px; }
    }
</style>
@endsection