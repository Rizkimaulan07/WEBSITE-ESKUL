@extends('layouts.app')

@section('title', 'Profile Saya')
@section('subtitle', 'Informasi lengkap akun Anda')

@push('styles')
<style>
    /* ===== CARD PROFILE PREMIUM ===== */
    .profile-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid rgba(0, 0, 0, 0.02);
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.04);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
    }
    .profile-card:hover {
        box-shadow: 0 16px 60px rgba(59, 130, 246, 0.10);
    }

    /* ===== HEADER GRADIENT ===== */
    .profile-header {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #60a5fa 100%);
        height: 180px;
        position: relative;
    }
    .profile-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15), transparent 70%);
        pointer-events: none;
    }

    /* ===== AVATAR ===== */
    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 6px solid #ffffff;
        box-shadow: 0 12px 40px rgba(59, 130, 246, 0.25);
        object-fit: cover;
        position: relative;
        z-index: 2;
    }
    .avatar-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 6px solid #ffffff;
        box-shadow: 0 12px 40px rgba(59, 130, 246, 0.25);
        background: linear-gradient(135deg, #2563eb, #60a5fa);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
    }

    /* ===== INFO BOX ===== */
    .info-box {
        background: #f8fafc;
        border: 1px solid rgba(0, 0, 0, 0.02);
        border-radius: 16px;
        padding: 18px 22px;
        transition: all 0.3s ease;
    }
    .info-box:hover {
        background: #eff6ff;
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.08);
    }
    .info-box .info-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .info-box .info-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 4px;
    }
    .info-box .info-value {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    /* ===== BUTTONS ===== */
    .btn-action-profile {
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-action-profile:hover {
        transform: translateY(-3px);
    }
    .btn-edit-profile {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: #fff;
        border: none;
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.25);
    }
    .btn-edit-profile:hover {
        box-shadow: 0 12px 32px rgba(59, 130, 246, 0.4);
        color: #fff;
    }
    .btn-back-profile {
        background: transparent;
        border: 2px solid #e2e8f0;
        color: #64748b;
    }
    .btn-back-profile:hover {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.04);
        color: #0f172a;
    }

    /* ===== BADGE ===== */
    .role-badge {
        background: rgba(59, 130, 246, 0.08);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.1);
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* ===== DOT STATUS ===== */
    .status-dot {
        position: absolute;
        bottom: 12px;
        right: 12px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #10b981;
        border: 4px solid #ffffff;
        z-index: 3;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .profile-card {
            border-radius: 16px;
        }
        .profile-header {
            height: 140px;
        }
        .profile-avatar, .avatar-placeholder {
            width: 110px;
            height: 110px;
        }
        .info-box {
            padding: 14px 16px;
        }
        .info-value {
            font-size: 14px;
        }
        .btn-action-profile {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <!-- ===== CARD PROFILE PREMIUM ===== -->
        <div class="profile-card">
            
            <!-- ===== HEADER GRADIENT ===== -->
            <div class="profile-header"></div>

            <!-- ===== BODY PROFILE ===== -->
            <div class="p-5 pt-0" style="margin-top: -75px;">
                
                <!-- AVATAR & INFO UTAMA -->
                <div class="text-center mb-5">
                    <div class="position-relative d-inline-block">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset(Auth::user()->avatar) }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="profile-avatar">
                        @else
                            <div class="avatar-placeholder">
                                <i class="fas fa-user fa-4x text-white opacity-75"></i>
                            </div>
                        @endif
                        <span class="status-dot"></span>
                    </div>
                    
                    <h3 class="fw-bold mt-4 mb-1" style="color: #0f172a; font-size: 26px; letter-spacing: -0.5px;">
                        {{ Auth::user()->name }}
                    </h3>
                    <p class="text-muted mb-3" style="font-size: 15px;">{{ Auth::user()->email }}</p>
                    
                    <div class="role-badge">
                        <i class="fas fa-shield-alt"></i>
                        {{ ucfirst(Auth::user()->role) }}
                    </div>
                </div>

                <!-- ===== INFO DETAILS (GRID) ===== -->
                <div class="row g-4 mb-5">
                    
                    <!-- NO HP -->
                    <div class="col-md-6">
                        <div class="info-box d-flex align-items-center gap-3">
                            <div class="info-icon" style="background: rgba(59,130,246,0.1); color: #3b82f6;">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <span class="info-label">No HP</span>
                                <p class="info-value">{{ Auth::user()->no_hp ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- BERGABUNG SEJAK -->
                    <div class="col-md-6">
                        <div class="info-box d-flex align-items-center gap-3">
                            <div class="info-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <span class="info-label">Bergabung Sejak</span>
                                <p class="info-value">{{ Auth::user()->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- KELAS (ANGGOTA SAJA) -->
                    @if(Auth::user()->role == 'anggota')
                    <div class="col-md-6">
                        <div class="info-box d-flex align-items-center gap-3">
                            <div class="info-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div>
                                <span class="info-label">Kelas</span>
                                <p class="info-value">{{ Auth::user()->kelas ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- EKSKUL (PELATIH SAJA) -->
                    @if(Auth::user()->role == 'pelatih' && Auth::user()->ekskul)
                    <div class="col-md-6">
                        <div class="info-box d-flex align-items-center gap-3">
                            <div class="info-icon" style="background: rgba(236,72,153,0.1); color: #ec4899;">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div>
                                <span class="info-label">Ekstrakurikuler</span>
                                <p class="info-value">{{ Auth::user()->ekskul->nama_ekskul }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>

                <!-- ===== TOMBOL AKSI ===== -->
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('profile.edit') }}" class="btn btn-action-profile btn-edit-profile">
                        <i class="bi bi-pencil me-2"></i> Edit Profile
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-action-profile btn-back-profile">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection