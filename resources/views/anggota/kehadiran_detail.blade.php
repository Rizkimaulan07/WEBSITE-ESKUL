@extends('layouts.app')

@section('title', 'Detail Kehadiran')
@section('subtitle', 'Detail kehadiran Anda di ekstrakurikuler')

@section('content')
@php
    $statusColors = [
        'hadir' => '#10b981',
        'izin' => '#f59e0b',
        'sakit' => '#ef4444',
        'alpa' => '#64748b'
    ];
    $statusIcons = [
        'hadir' => '✅',
        'izin' => '📝',
        'sakit' => '🏥',
        'alpa' => '❌'
    ];
    $statusLabel = [
        'hadir' => 'Hadir',
        'izin' => 'Izin',
        'sakit' => 'Sakit',
        'alpa' => 'Alpa'
    ];
    $sc = $statusColors[$kehadiran->status] ?? '#64748b';
@endphp
<div class="card premium-card" style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); overflow: hidden; transition: all 0.4s ease; max-width: 720px; margin: 0 auto;">
    <div class="card-header premium-card-header" style="padding: 20px 24px; border-bottom: 1px solid rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 60%, #38bdf8 100%);">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(255,255,255,0.15); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-white" style="font-weight: 700; font-size: 14px;">Detail Kehadiran</h6>
                <small class="text-white-50" style="font-size: 12px; color: rgba(255,255,255,0.7);">{{ $kehadiran->ekskul->nama_ekskul ?? '-' }}</small>
            </div>
        </div>
        <a href="{{ route('anggota.kehadiran') }}" class="btn btn-sm text-white" style="background: rgba(255,255,255,0.15); border: none; border-radius: 8px; padding: 6px 14px; font-weight: 500; text-decoration: none;">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
    <div class="card-body" style="padding: 24px;">
        <div class="d-flex align-items-center justify-content-center mb-4">
            <div style="text-align: center;">
                <div style="width: 88px; height: 88px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 36px; background: {{ $sc }}1a; color: {{ $sc }}; border: 2px solid {{ $sc }};">
                    {{ $statusIcons[$kehadiran->status] ?? '' }}
                </div>
                <div class="mt-2 fw-bold" style="font-size: 15px; color: {{ $sc }};">{{ strtoupper($statusLabel[$kehadiran->status] ?? $kehadiran->status) }}</div>
            </div>
        </div>

        <div class="dokumentasi-info">
            <div class="info-item" style="margin-bottom: 16px;">
                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">🎯 Ekskul</label>
                <p class="fw-semibold mb-0" style="font-size: 14px; color: #0f172a;">{{ $kehadiran->ekskul->nama_ekskul ?? '-' }}</p>
            </div>
            <div class="info-item" style="margin-bottom: 16px;">
                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">🗓️ Tanggal</label>
                <p class="fw-semibold mb-0" style="font-size: 14px; color: #0f172a;">{{ \Carbon\Carbon::parse($kehadiran->tanggal)->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="info-item" style="margin-bottom: 16px;">
                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">👨‍🏫 Dicatat oleh Pelatih</label>
                <p class="fw-semibold mb-0" style="font-size: 14px; color: #0f172a;">{{ $kehadiran->pelatih->name ?? '-' }}</p>
            </div>
            <div class="info-item" style="margin-bottom: 16px;">
                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">📝 Keterangan</label>
                <p class="mb-0" style="color: #475569; font-size: 14px;">{{ $kehadiran->keterangan ?? 'Tidak ada keterangan' }}</p>
            </div>
            <div class="info-item mt-3 pt-3 border-top" style="margin-bottom: 0; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">🕐 Data Dibuat</label>
                <p class="small text-muted mb-0" style="font-size: 12px; color: #64748b;">{{ optional($kehadiran->created_at)->format('d F Y, H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    .premium-card:hover {
        box-shadow: 0 12px 40px rgba(14,165,233,0.08);
    }
</style>
@endsection
