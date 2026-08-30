@extends('layouts.app')

@section('title', 'Detail Nilai')
@section('subtitle', 'Detail nilai Anda di ekstrakurikuler')

@section('content')
<div class="card premium-card" style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); overflow: hidden; transition: all 0.4s ease; max-width: 720px; margin: 0 auto;">
    <div class="card-header premium-card-header" style="padding: 20px 24px; border-bottom: 1px solid rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 60%, #38bdf8 100%);">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(255,255,255,0.15); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-white" style="font-weight: 700; font-size: 14px;">Detail Nilai</h6>
                <small class="text-white-50" style="font-size: 12px; color: rgba(255,255,255,0.7);">{{ $nilai->ekskul->nama_ekskul ?? '-' }}</small>
            </div>
        </div>
        <a href="{{ route('anggota.nilai') }}" class="btn btn-sm text-white" style="background: rgba(255,255,255,0.15); border: none; border-radius: 8px; padding: 6px 14px; font-weight: 500; text-decoration: none;">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
    <div class="card-body" style="padding: 24px;">
        <div class="d-flex align-items-center justify-content-center mb-4">
            <div style="text-align: center;">
                <div style="width: 88px; height: 88px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 800; background: {{ $nilai->predikat_background }}; color: {{ $nilai->predikat_color }}; border: 2px solid {{ $nilai->predikat_color }};">
                    {{ $nilai->predikat }}
                </div>
                <div class="mt-2 fw-bold" style="font-size: 15px; color: {{ $nilai->predikat_color }};">{{ $nilai->predikat_label }}</div>
            </div>
        </div>

        <div class="dokumentasi-info">
            <div class="info-item" style="margin-bottom: 16px;">
                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">🎯 Ekskul</label>
                <p class="fw-semibold mb-0" style="font-size: 14px; color: #0f172a;">{{ $nilai->ekskul->nama_ekskul ?? '-' }}</p>
            </div>
            <div class="info-item" style="margin-bottom: 16px;">
                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">👨‍🏫 Penilai (Pelatih)</label>
                <p class="fw-semibold mb-0" style="font-size: 14px; color: #0f172a;">{{ $nilai->pelatih->name ?? '-' }}</p>
            </div>
            <div class="info-item" style="margin-bottom: 16px;">
                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">📅 Semester / Tahun Ajaran</label>
                <p class="fw-semibold mb-0" style="font-size: 14px; color: #0f172a;">{{ $nilai->semester ?? '-' }} {{ $nilai->tahun_ajaran ?? '' }}</p>
            </div>
            <div class="info-item" style="margin-bottom: 16px;">
                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">📝 Keterangan</label>
                <p class="mb-0" style="color: #475569; font-size: 14px;">{{ $nilai->catatan ?? 'Tidak ada keterangan' }}</p>
            </div>
            <div class="info-item mt-3 pt-3 border-top" style="margin-bottom: 0; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <label class="text-muted small text-uppercase fw-semibold" style="font-size: 10px; font-weight: 600; letter-spacing: 0.5px; display: block; margin-bottom: 2px; color: #64748b;">🕐 Dinilai Pada</label>
                <p class="small text-muted mb-0" style="font-size: 12px; color: #64748b;">{{ $nilai->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>

        <div class="alert alert-info rounded-4 mt-4" style="background: #f0f9ff; border-left: 4px solid #0ea5e9;">
            <small style="color: #0c4a6e;">
                <i class="fas fa-info-circle me-1"></i>
                S = Sangat Baik &nbsp;•&nbsp; A = Baik &nbsp;•&nbsp; B = Cukup
            </small>
        </div>
    </div>
</div>

<style>
    .premium-card:hover {
        box-shadow: 0 12px 40px rgba(14,165,233,0.08);
    }
</style>
@endsection