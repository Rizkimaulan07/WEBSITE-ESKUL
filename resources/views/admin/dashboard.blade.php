@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('subtitle', 'Overview sistem manajemen ekstrakurikuler')

@section('content')
@php
    $user = Auth::user();
    $hour = date('H');
    $greeting = $hour < 11 ? '🌅 Selamat Pagi' : ($hour < 15 ? '☀️ Selamat Siang' : ($hour < 19 ? '🌤️ Selamat Sore' : '🌙 Selamat Malam'));
@endphp

<!-- ===== WELCOME BANNER - Biru Cerah ===== -->
<div class="welcome-banner hero-gradient" style="border-radius: 24px; padding: 36px 44px; position: relative; overflow: hidden; box-shadow: 0 8px 40px rgba(14,165,233,0.25);">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <div class="d-flex align-items-center gap-4">
                <div class="avatar-ring" style="padding: 4px; border-radius: 50%; background: linear-gradient(135deg, #0ea5e9, #38bdf8, #7dd3fc); flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                    <div class="avatar-circle" style="width: 64px; height: 64px; border-radius: 50%; background: #ffffff; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255,255,255,0.1); overflow: hidden;">
                        <img src="{{ asset('images/logo-smk-bppi.png') }}" alt="SMK BPPI Baleendah" style="width: 100%; height: 100%; object-fit: contain; padding: 6px;">
                    </div>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-1" style="font-size: 22px; letter-spacing: -0.5px;">{{ $greeting }}, {{ $user->name }}! 👋</h4>
                    <p class="text-white-75 mb-1" style="color: rgba(255,255,255,0.75);">
                        <i class="far fa-calendar-alt me-2"></i>
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-white-75 mb-0" id="clock" style="color: rgba(255,255,255,0.75);">
                        <i class="far fa-clock me-2"></i>
                        {{ now()->format('H:i:s') }} WIB
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 text-lg-end mt-3 mt-lg-0">
            <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                <span class="badge-role" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(12px); color: #e2e8f0; padding: 6px 22px; border-radius: 20px; font-size: 13px; font-weight: 500; border: 1px solid rgba(255,255,255,0.08);">
                    <i class="fas fa-shield-alt me-2"></i>
                    {{ ucfirst($user->role) }}
                </span>
                <span class="badge-status" style="background: #ffffff; color: #10b981; padding: 4px 18px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; border: 1px solid rgba(255,255,255,0.95); box-shadow: 0 2px 12px rgba(0,0,0,0.15);">
                    <span class="dot" style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block; box-shadow: 0 0 0 3px rgba(16,185,129,0.25);"></span>
                    Online
                </span>
            </div>
        </div>
    </div>
    <div class="floating-shapes">
        <div class="shape shape-1" style="position: absolute; border-radius: 50%; pointer-events: none; opacity: 0.08; width: 300px; height: 300px; top: -150px; right: -50px; background: radial-gradient(circle, #0ea5e9, transparent 70%); animation: float 8s ease-in-out infinite;"></div>
        <div class="shape shape-2" style="position: absolute; border-radius: 50%; pointer-events: none; opacity: 0.08; width: 150px; height: 150px; bottom: -75px; left: 10%; background: radial-gradient(circle, #38bdf8, transparent 70%); animation: float 6s ease-in-out infinite reverse;"></div>
        <div class="shape shape-3" style="position: absolute; border-radius: 50%; pointer-events: none; opacity: 0.08; width: 80px; height: 80px; top: 10%; right: 20%; background: radial-gradient(circle, #7dd3fc, transparent 70%); animation: float 10s ease-in-out infinite;"></div>
        <div class="shape shape-4" style="position: absolute; border-radius: 50%; pointer-events: none; opacity: 0.08; width: 50px; height: 50px; bottom: 20%; right: 15%; background: radial-gradient(circle, #34d399, transparent 70%); animation: float 7s ease-in-out infinite reverse;"></div>
    </div>
</div>

<!-- ===== STATISTICS CARDS - Biru Cerah ===== -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #0ea5e9; --accent-light: #38bdf8; background: #ffffff; border-radius: 18px; padding: 24px 28px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden; display: flex; gap: 16px; align-items: center;">
            <div class="stat-icon" style="width: 56px; height: 56px; border-radius: 14px; background: rgba(14,165,233,0.08); color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; transition: all 0.4s ease;">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Ekskul</span>
                <h3 class="stat-number" style="font-size: 30px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $data['total_ekskul'] ?? 0 }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-arrow-up me-1"></i> Aktif
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent-light)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #0ea5e9; --accent-light: #38bdf8; background: #ffffff; border-radius: 18px; padding: 24px 28px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden; display: flex; gap: 16px; align-items: center;">
            <div class="stat-icon" style="width: 56px; height: 56px; border-radius: 14px; background: rgba(14,165,233,0.08); color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; transition: all 0.4s ease;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Anggota</span>
                <h3 class="stat-number" style="font-size: 30px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $data['total_anggota'] ?? 0 }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-user-plus me-1"></i> Terdaftar
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent-light)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #10b981; --accent-light: #34d399; background: #ffffff; border-radius: 18px; padding: 24px 28px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden; display: flex; gap: 16px; align-items: center;">
            <div class="stat-icon" style="width: 56px; height: 56px; border-radius: 14px; background: rgba(16,185,129,0.08); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; transition: all 0.4s ease;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Pelatih</span>
                <h3 class="stat-number" style="font-size: 30px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $data['total_pelatih'] ?? 0 }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-star me-1"></i> Profesional
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent-light)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #f59e0b; --accent-light: #fbbf24; background: #ffffff; border-radius: 18px; padding: 24px 28px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden; display: flex; gap: 16px; align-items: center;">
            <div class="stat-icon" style="width: 56px; height: 56px; border-radius: 14px; background: rgba(245,158,11,0.08); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; transition: all 0.4s ease;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Kehadiran Hari Ini</span>
                <h3 class="stat-number" style="font-size: 30px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $data['total_kehadiran_hari_ini'] ?? 0 }}</h3>
                <span class="stat-trend {{ ($data['total_kehadiran_hari_ini'] ?? 0) > 0 ? 'up' : 'down' }}" style="{{ ($data['total_kehadiran_hari_ini'] ?? 0) > 0 ? 'background: rgba(16,185,129,0.06); color: #10b981;' : 'background: rgba(239,68,68,0.06); color: #ef4444;' }} font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas {{ ($data['total_kehadiran_hari_ini'] ?? 0) > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} me-1"></i>
                    {{ ($data['total_kehadiran_hari_ini'] ?? 0) > 0 ? 'Aktif' : 'Belum ada' }}
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent-light)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
</div>

<!-- ===== QUICK MENU - Biru Cerah ===== -->
<div class="row g-4 mb-4">
    <div class="col-md-4 col-6">
        <a href="{{ route('admin.ekskul.index') }}" class="quick-menu" style="display: block; padding: 24px; background: #ffffff; border-radius: 16px; text-align: center; text-decoration: none; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden;">
            <div class="quick-icon" style="width: 64px; height: 64px; border-radius: 16px; background: rgba(14,165,233,0.08); color: #0ea5e9; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; transition: all 0.4s ease; position: relative; z-index: 1;">
                <i class="fas fa-trophy fa-2x"></i>
            </div>
            <h6 style="font-weight: 600; color: #0f172a; margin-bottom: 2px; font-size: 14px; position: relative; z-index: 1;">Kelola Ekskul</h6>
            <p class="quick-desc" style="color: #64748b; font-size: 12px; margin-bottom: 0; position: relative; z-index: 1;">Tambah & edit ekskul</p>
            <span class="quick-arrow" style="position: absolute; top: 16px; right: 16px; color: #64748b; font-size: 12px; opacity: 0; transform: translateX(-10px); transition: all 0.4s ease;">
                <i class="fas fa-arrow-right"></i>
            </span>
        </a>
    </div>
    <div class="col-md-4 col-6">
        <a href="{{ route('admin.anggota.index') }}" class="quick-menu" style="display: block; padding: 24px; background: #ffffff; border-radius: 16px; text-align: center; text-decoration: none; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden;">
            <div class="quick-icon" style="width: 64px; height: 64px; border-radius: 16px; background: rgba(16,185,129,0.08); color: #10b981; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; transition: all 0.4s ease; position: relative; z-index: 1;">
                <i class="fas fa-users fa-2x"></i>
            </div>
            <h6 style="font-weight: 600; color: #0f172a; margin-bottom: 2px; font-size: 14px; position: relative; z-index: 1;">Kelola Anggota</h6>
            <p class="quick-desc" style="color: #64748b; font-size: 12px; margin-bottom: 0; position: relative; z-index: 1;">Tambah & edit anggota</p>
            <span class="quick-arrow" style="position: absolute; top: 16px; right: 16px; color: #64748b; font-size: 12px; opacity: 0; transform: translateX(-10px); transition: all 0.4s ease;">
                <i class="fas fa-arrow-right"></i>
            </span>
        </a>
    </div>
    <div class="col-md-4 col-6">
        <a href="{{ route('admin.template-surat.index') }}" class="quick-menu" style="display: block; padding: 24px; background: #ffffff; border-radius: 16px; text-align: center; text-decoration: none; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden;">
            <div class="quick-icon" style="width: 64px; height: 64px; border-radius: 16px; background: rgba(245,158,11,0.08); color: #f59e0b; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; transition: all 0.4s ease; position: relative; z-index: 1;">
                <i class="fas fa-file-alt fa-2x"></i>
            </div>
            <h6 style="font-weight: 600; color: #0f172a; margin-bottom: 2px; font-size: 14px; position: relative; z-index: 1;">Template Surat</h6>
            <p class="quick-desc" style="color: #64748b; font-size: 12px; margin-bottom: 0; position: relative; z-index: 1;">Kelola template surat</p>
            <span class="quick-arrow" style="position: absolute; top: 16px; right: 16px; color: #64748b; font-size: 12px; opacity: 0; transform: translateX(-10px); transition: all 0.4s ease;">
                <i class="fas fa-arrow-right"></i>
            </span>
        </a>
    </div>
</div>

<!-- ===== DOKUMENTASI SECTION ===== -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card premium-card" style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; transition: all 0.4s ease;">
            <div class="card-header premium-card-header" style="padding: 20px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; background: rgba(248,250,252,0.3);">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(236,72,153,0.08); color: #ec4899; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fas fa-images"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold" style="font-weight: 600; font-size: 14px; color: #0f172a;">📸 Dokumentasi Kegiatan</h6>
                        <small class="text-muted" style="font-size: 12px;">Total {{ $data['total_dokumentasi'] ?? 0 }} dokumentasi</small>
                    </div>
                </div>
                <a href="{{ route('admin.dokumentasi.index') }}" class="btn-link-custom" style="color: #0ea5e9; font-weight: 500; font-size: 13px; text-decoration: none; transition: all 0.3s ease; padding: 6px 16px; border-radius: 10px; background: rgba(14,165,233,0.04);">
                    Kelola Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body" style="padding: 20px 24px;">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
                    <label class="form-label small fw-semibold text-muted mb-2" style="font-size: 12px; font-weight: 600; color: #64748b;">Pilih Ekskul</label>
                    <select name="ekskul_id" class="form-select" onchange="this.form.submit()" style="max-width: 320px; padding: 10px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13px;">
                        <option value="">Semua Ekskul</option>
                        @foreach(App\Models\Ekstrakurikuler::orderBy('nama_ekskul')->get() as $ekskulOption)
                            <option value="{{ $ekskulOption->id }}" {{ request('ekskul_id') == $ekskulOption->id ? 'selected' : '' }}>
                                {{ $ekskulOption->nama_ekskul }}
                            </option>
                        @endforeach
                    </select>
                </form>

                @if(isset($data['dokumentasi_terbaru']) && $data['dokumentasi_terbaru']->isNotEmpty())
                    <div class="row g-3">
                        @foreach($data['dokumentasi_terbaru'] as $dok)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="dokumentasi-card" style="background: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); cursor: pointer;">
                                <div class="dokumentasi-image" style="position: relative; height: 180px; overflow: hidden; background: #f8fafc;">
                                    @if($dok->foto_path && file_exists(storage_path('app/public/' . $dok->foto_path)))
                                        <img src="{{ asset('storage/' . $dok->foto_path) }}" 
                                             alt="{{ $dok->judul }}"
                                             loading="lazy"
                                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;">
                                    @else
                                        <div class="dokumentasi-placeholder" style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #d1d5db; background: linear-gradient(135deg, #f8fafc, #f1f5f9);">
                                            <i class="fas fa-image fa-3x"></i>
                                            <small class="text-muted d-block mt-2" style="color: #64748b;">Tidak ada gambar</small>
                                        </div>
                                    @endif
                                    <div class="dokumentasi-overlay" onclick="showDetail({{ $dok->id }})" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15,23,42,0.4); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; opacity: 0; transition: all 0.4s ease;">
                                        <span class="badge-dokumentasi" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color: #fff; padding: 8px 20px; border-radius: 12px; font-size: 13px; font-weight: 500; border: 1px solid rgba(255,255,255,0.1); transition: all 0.3s ease;">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </span>
                                    </div>
                                </div>
                                <div class="dokumentasi-body" style="padding: 14px 16px;">
                                    <h6 class="dokumentasi-title" title="{{ $dok->judul }}" style="font-weight: 600; font-size: 14px; color: #0f172a; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ Str::limit($dok->judul, 40) }}
                                    </h6>
                                    <div class="dokumentasi-meta" style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 8px;">
                                        <span class="meta-item" style="font-size: 11px; color: #64748b; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ isset($dok->tanggal_kegiatan) ? \Carbon\Carbon::parse($dok->tanggal_kegiatan)->format('d/m/Y') : '-' }}
                                        </span>
                                        <span class="meta-item" style="font-size: 11px; color: #64748b; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-tag" style="color: #0ea5e9;"></i>
                                            {{ $dok->ekskul->nama_ekskul ?? 'Tanpa Ekskul' }}
                                        </span>
                                    </div>
                                    <div class="dokumentasi-footer" style="display: flex; justify-content: space-between; align-items: center; padding-top: 8px; border-top: 1px solid rgba(0,0,0,0.02);">
                                        <span class="meta-item small text-muted" style="font-size: 11px; color: #64748b; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-user"></i>
                                            {{ $dok->user->name ?? 'Unknown' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                @else
                    <div class="text-center py-5">
                        <div class="empty-state" style="padding: 30px 0;">
                            <div class="empty-icon" style="font-size: 64px; color: #d1d5db;">
                                <i class="fas fa-camera"></i>
                            </div>
                            <h6 class="mt-3" style="color: #64748b;">Belum Ada Dokumentasi</h6>
                            <p class="text-muted small" style="color: #64748b;">Dokumentasi akan muncul setelah pelatih mengunggah foto kegiatan</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ===== RECENT EKSKUL ===== -->
<div class="card premium-card" style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; transition: all 0.4s ease;">
    <div class="card-header premium-card-header" style="padding: 20px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; background: rgba(248,250,252,0.3);">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(14,165,233,0.08); color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="font-weight: 600; font-size: 14px; color: #0f172a;">Ekstrakurikuler Terbaru</h6>
                <small class="text-muted" style="font-size: 12px;">Data terbaru yang ditambahkan</small>
            </div>
        </div>
        <a href="{{ route('admin.ekskul.index') }}" class="btn-link-custom" style="color: #0ea5e9; font-weight: 500; font-size: 13px; text-decoration: none; transition: all 0.3s ease; padding: 6px 16px; border-radius: 10px; background: rgba(14,165,233,0.04);">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table premium-table" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Nama Ekskul</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Pembina</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Jadwal</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Anggota</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Status</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($data['ekskul_terbaru'] ?? []) as $ekskul)
                    <tr style="transition: all 0.3s ease;">
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-icon" style="width: 32px; height: 32px; border-radius: 50%; background: rgba(14,165,233,0.06); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 14px;">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <span class="fw-semibold" style="color: #0f172a;">{{ $ekskul->nama_ekskul }}</span>
                            </div>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">{{ $ekskul->pembina }}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="badge-day" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 12px; border-radius: 10px; font-size: 12px; font-weight: 500;">{{ $ekskul->hari_latihan }}</span>
                            <div class="small text-muted" style="font-size: 12px; color: #64748b;">
                                {{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}
                            </div>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="badge-member" style="background: rgba(16,185,129,0.06); color: #10b981; padding: 2px 12px; border-radius: 10px; font-size: 12px; font-weight: 500;">
                                <i class="fas fa-user me-1"></i>
                                {{ $ekskul->users_count ?? 0 }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="status-badge {{ $ekskul->status == 'aktif' ? 'active' : 'inactive' }}" style="padding: 3px 14px; border-radius: 12px; font-size: 11px; font-weight: 500; {{ $ekskul->status == 'aktif' ? 'background: rgba(16,185,129,0.08); color: #10b981;' : 'background: rgba(239,68,68,0.06); color: #ef4444;' }}">
                                {{ $ekskul->status == 'aktif' ? '● Aktif' : '● Nonaktif' }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; text-align: center;">
                            <div class="action-group" style="display: flex; gap: 4px; justify-content: center;">
                                <a href="{{ route('admin.ekskul.show', $ekskul->id) }}" class="btn-action view" title="Detail" style="width: 32px; height: 32px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; background: transparent; color: #64748b;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.ekskul.edit', $ekskul->id) }}" class="btn-action edit" title="Edit" style="width: 32px; height: 32px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; background: transparent; color: #64748b;">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.ekskul.destroy', $ekskul->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus ekskul ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus" style="width: 32px; height: 32px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.3s ease; cursor: pointer; background: transparent; color: #64748b;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted" style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; text-align: center; color: #64748b;">
                            <div class="empty-state" style="padding: 30px 0;">
                                <div class="empty-icon" style="font-size: 48px; color: #d1d5db; margin-bottom: 12px;">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h6 style="color: #64748b; margin-bottom: 4px;">Belum ada data</h6>
                                <p class="small" style="color: #64748b;">Tambahkan ekstrakurikuler pertama Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ===== MODAL DETAIL DOKUMENTASI ===== -->
@if(isset($data['dokumentasi_terbaru']) && $data['dokumentasi_terbaru']->isNotEmpty())
@foreach($data['dokumentasi_terbaru'] as $dok)
<div class="modal fade" id="dokumentasiModal{{ $dok->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg" style="background: #ffffff;">
            <div class="modal-header border-0 hero-gradient" style="padding: 20px 24px;">
                <h5 class="text-white fw-bold mb-0" style="font-size: 18px;">
                    <i class="fas fa-image me-2"></i>
                    {{ $dok->judul }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-7">
                        @if($dok->foto_path && file_exists(storage_path('app/public/' . $dok->foto_path)))
                            <img src="{{ asset('storage/' . $dok->foto_path) }}" 
                                 class="img-fluid rounded-3 w-100" 
                                 alt="{{ $dok->judul }}"
                                 style="max-height: 400px; object-fit: cover; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                        @else
                            <div class="bg-light rounded-3 d-flex flex-column align-items-center justify-content-center" 
                                 style="height: 350px; border: 2px dashed #e5e7eb;">
                                <i class="fas fa-image fa-4x text-muted mb-3"></i>
                                <p class="text-muted small">Gambar tidak ditemukan</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-5">
                        <div class="dokumentasi-info">
                            <div class="info-item" style="margin-bottom: 16px;">
                                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">📌 Ekskul</label>
                                <p class="fw-semibold mb-0" style="font-size: 14px; color: #0f172a;">{{ $dok->ekskul->nama_ekskul ?? '-' }}</p>
                            </div>
                            <div class="info-item" style="margin-bottom: 16px;">
                                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">📅 Tanggal Kegiatan</label>
                                <p class="fw-semibold mb-0" style="font-size: 14px; color: #0f172a;">{{ isset($dok->tanggal_kegiatan) ? \Carbon\Carbon::parse($dok->tanggal_kegiatan)->format('d F Y') : '-' }}</p>
                            </div>
                            <div class="info-item" style="margin-bottom: 16px;">
                                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">👤 Diunggah Oleh</label>
                                <p class="fw-semibold mb-0" style="font-size: 14px; color: #0f172a;">{{ $dok->user->name ?? 'Unknown' }}</p>
                            </div>
                            @if($dok->deskripsi)
                            <div class="info-item" style="margin-bottom: 16px;">
                                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">📝 Deskripsi</label>
                                <p class="mb-0" style="color: #475569; font-size: 14px;">{{ $dok->deskripsi }}</p>
                            </div>
                            @endif
                            <div class="info-item mt-3 pt-3 border-top" style="margin-bottom: 0; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">🕐 Diunggah</label>
                                <p class="small text-muted mb-0" style="font-size: 12px; color: #64748b;">{{ $dok->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0" style="padding: 16px 24px;">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal" style="background: #f1f5f9; color: #64748b; border: none; font-weight: 500;">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

<style>
    /* ===== ANIMATIONS ===== */
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(0.7); }
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -30px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }

    /* ===== HOVER EFFECTS ===== */
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 60px rgba(14,165,233,0.12);
        border-color: rgba(14,165,233,0.06);
    }
    
    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(-3deg);
    }
    
    .stat-card:hover .stat-progress {
        transform: scaleX(1);
    }
    
    .stat-card:hover .stat-glow {
        opacity: 0.06;
    }

    .quick-menu:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 60px rgba(14,165,233,0.12);
        text-decoration: none;
        border-color: rgba(14,165,233,0.06);
    }
    
    .quick-menu:hover .quick-icon {
        transform: scale(1.1) rotate(-3deg);
    }
    
    .quick-menu:hover .quick-arrow {
        opacity: 1;
        transform: translateX(0);
        color: #0ea5e9;
    }

    .dokumentasi-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(236,72,153,0.12);
        border-color: rgba(236,72,153,0.1);
    }
    
    .dokumentasi-card:hover .dokumentasi-image img {
        transform: scale(1.05);
    }
    
    .dokumentasi-card:hover .dokumentasi-overlay {
        opacity: 1;
    }
    
    .badge-dokumentasi:hover {
        background: rgba(255,255,255,0.25);
        transform: scale(1.05);
    }

    .btn-link-custom:hover {
        color: #0ea5e9;
        background: rgba(14,165,233,0.08);
        text-decoration: none;
        transform: translateX(4px);
    }

    .premium-card:hover {
        box-shadow: 0 12px 60px rgba(14,165,233,0.08);
    }

    .premium-table tbody tr:hover {
        background: rgba(14,165,233,0.015);
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }
    
    .btn-action.view:hover {
        background: rgba(14,165,233,0.06);
        color: #0ea5e9;
    }
    
    .btn-action.edit:hover {
        background: rgba(245,158,11,0.06);
        color: #f59e0b;
    }
    
    .btn-action.delete:hover {
        background: rgba(239,68,68,0.06);
        color: #ef4444;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .welcome-banner {
            padding: 24px 20px;
        }
        .stat-card {
            padding: 16px 18px;
        }
        .stat-card .stat-number {
            font-size: 22px;
        }
        .quick-menu {
            padding: 16px;
        }
        .premium-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        .premium-table {
            font-size: 12px;
        }
        .action-group {
            gap: 2px;
        }
        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }
        .dokumentasi-image {
            height: 140px;
        }
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

    function showDetail(id) {
        const modal = new bootstrap.Modal(document.getElementById('dokumentasiModal' + id));
        modal.show();
    }
</script>
@endsection