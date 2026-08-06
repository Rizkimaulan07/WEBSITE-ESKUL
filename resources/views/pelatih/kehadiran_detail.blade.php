@extends('layouts.app')

@section('title', 'Detail Kehadiran')
@section('subtitle', 'Detail kehadiran pelatih')

@section('content')
@php
    $statusColors = [
        'hadir' => 'success',
        'izin' => 'warning',
        'sakit' => 'danger',
        'alpa' => 'secondary'
    ];
    $statusIcons = [
        'hadir' => '✅',
        'izin' => '📝',
        'sakit' => '🏥',
        'alpa' => '❌'
    ];
@endphp

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Header -->
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3">
                        <i class="fas fa-clipboard-check fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0">Detail Kehadiran</h4>
                        <p class="text-white-50 mb-0 small">
                            {{ \Carbon\Carbon::parse($kehadiran->tanggal)->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <!-- Status Card -->
                <div class="text-center mb-4">
                    <div class="status-circle mx-auto mb-3" 
                         style="width: 100px; height: 100px; border-radius: 50%; background: {{ $kehadiran->status == 'hadir' ? 'rgba(16,185,129,0.1)' : ($kehadiran->status == 'izin' ? 'rgba(245,158,11,0.1)' : ($kehadiran->status == 'sakit' ? 'rgba(239,68,68,0.1)' : 'rgba(0,0,0,0.04)')) }}; display: flex; align-items: center; justify-content: center; border: 3px solid {{ $kehadiran->status == 'hadir' ? '#10b981' : ($kehadiran->status == 'izin' ? '#f59e0b' : ($kehadiran->status == 'sakit' ? '#ef4444' : '#94a3b8')) }};">
                        <span style="font-size: 40px;">{{ $statusIcons[$kehadiran->status] ?? '📌' }}</span>
                    </div>
                    <h3 class="fw-bold mb-1">
                        <span class="badge bg-{{ $statusColors[$kehadiran->status] ?? 'secondary' }}" style="font-size: 18px; padding: 8px 24px;">
                            {{ strtoupper($kehadiran->status) }}
                        </span>
                    </h3>
                    <p class="text-muted">
                        Status kehadiran pada {{ \Carbon\Carbon::parse($kehadiran->tanggal)->translatedFormat('l, d F Y') }}
                    </p>
                </div>

                <!-- Informasi Detail -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i> Tanggal
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($kehadiran->tanggal)->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="info-sub text-muted">
                                <i class="far fa-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($kehadiran->tanggal)->format('H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="fas fa-clock me-2 text-warning"></i> Waktu Input
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($kehadiran->created_at)->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="info-sub text-muted">
                                <i class="far fa-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($kehadiran->created_at)->format('H:i') }} WIB
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="fas fa-trophy me-2 text-success"></i> Ekstrakurikuler
                            </div>
                            <div class="info-value">{{ $kehadiran->ekskul->nama_ekskul ?? '-' }}</div>
                            <div class="info-sub text-muted">
                                <i class="fas fa-user-tie me-1"></i>
                                {{ $kehadiran->ekskul->pembina ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="fas fa-user me-2 text-primary"></i> Pelatih
                            </div>
                            <div class="info-value">{{ $kehadiran->pelatih->name ?? '-' }}</div>
                            <div class="info-sub text-muted">
                                <i class="fas fa-envelope me-1"></i>
                                {{ $kehadiran->pelatih->email ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="fas fa-info-circle me-2 text-info"></i> Keterangan
                            </div>
                            <div class="info-value" style="font-weight: 400;">
                                {{ $kehadiran->keterangan ?? 'Tidak ada keterangan' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex gap-3 justify-content-between flex-wrap">
                        <a href="{{ route('pelatih.kehadiran') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('pelatih.kehadiran') }}" class="btn btn-outline-primary rounded-pill px-4">
                                <i class="fas fa-edit me-2"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-card {
        padding: 16px 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        height: 100%;
    }

    .info-card:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .info-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .info-sub {
        font-size: 12px;
    }

    .status-circle {
        transition: all 0.3s ease;
    }

    .status-circle:hover {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 20px !important;
        }
        .card-header {
            padding: 16px 20px !important;
        }
        .btn {
            width: 100%;
        }
        .d-flex.gap-3.justify-content-between {
            flex-direction: column;
        }
        .d-flex.gap-2 {
            flex-direction: column;
        }
        .status-circle {
            width: 80px !important;
            height: 80px !important;
        }
        .status-circle span {
            font-size: 30px !important;
        }
        .info-card {
            padding: 12px 16px;
        }
    }
</style>
@endsection