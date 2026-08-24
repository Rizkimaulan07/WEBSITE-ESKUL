@extends('layouts.app')

@section('title', 'Kehadiran Saya')
@section('subtitle', 'Input kehadiran pelatih')

@section('content')
@php
    $statusColors = [
        'hadir' => '#10b981',
        'izin' => '#f59e0b',
        'sakit' => '#ef4444',
        'alpa' => '#94a3b8'
    ];
    $statusLabel = [
        'hadir' => 'Hadir',
        'izin' => 'Izin',
        'sakit' => 'Sakit',
        'alpa' => 'Alpa'
    ];
@endphp

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="background: #ffffff;">
            <!-- Header - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5" style="background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 30%, #38bdf8 60%, #7dd3fc 100%);">
                <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-4">
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-user-check fa-2x text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Kehadiran Saya</h4>
                            <p class="text-white-50 mb-0 small" style="font-weight: 400;">Catat kehadiran Anda hari ini</p>
                        </div>
                    </div>
                    <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-light rounded-pill px-4" style="color: white; border-color: rgba(255,255,255,0.3); transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4 p-lg-5">
                @if(session('success'))
                    <div class="alert alert-success rounded-4 border-0 shadow-sm" role="alert" style="background: #d1fae5; border-left: 4px solid #10b981;">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                            <div>
                                <strong style="color: #065f46;">Berhasil!</strong> 
                                <span style="color: #047857;">{{ session('success') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger rounded-4 border-0 shadow-sm" role="alert" style="background: #fee2e2; border-left: 4px solid #ef4444;">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                            <div>
                                <strong style="color: #991b1b;">Gagal!</strong> 
                                <span style="color: #7f1d1d;">{{ session('error') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row g-4 align-items-stretch">
                    <div class="col-md-5">
                        <div class="border rounded-4 p-4 h-100 bg-light-subtle" style="background: #f8fafc; border-color: #e2e8f0;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="avatar-circle-large" style="width: 54px; height: 54px; border-radius: 18px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; box-shadow: 0 8px 20px rgba(14,165,233,0.25);">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold" style="color: #0f172a;">{{ Auth::user()->name }}</div>
                                    <small class="text-muted" style="color: #94a3b8;">Pelatih</small>
                                </div>
                            </div>
                            <div class="small text-muted mb-2" style="color: #94a3b8;">
                                <i class="fas fa-trophy me-2" style="color: #0ea5e9;"></i>
                                {{ $ekskul->nama_ekskul ?? 'Belum ada ekskul' }}
                            </div>
                            <div class="small text-muted" style="color: #94a3b8;">
                                <i class="far fa-calendar me-2" style="color: #0ea5e9;"></i>
                                {{ now()->translatedFormat('l, d F Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <form action="{{ route('pelatih.kehadiran_pelatih.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                        <i class="fas fa-user-check me-2" style="color: #0ea5e9;"></i>Status Kehadiran
                                    </label>
                                    <select name="status" class="form-select form-select-lg rounded-3" required style="border: 2px solid #e2e8f0; padding: 12px 16px; font-size: 14px; background: #fafbfc; transition: all 0.3s ease;">
                                        <option value="">-- Pilih status --</option>
                                        <option value="hadir" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                        <option value="izin" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                        <option value="sakit" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                        <i class="fas fa-sticky-note me-2" style="color: #0ea5e9;"></i>Keterangan
                                    </label>
                                    <textarea name="keterangan" rows="4" class="form-control rounded-3" placeholder="Contoh: izin keluarga, sakit ringan, atau keterangan hadir..." style="border: 2px solid #e2e8f0; padding: 12px 16px; font-size: 14px; background: #fafbfc; transition: all 0.3s ease; resize: vertical; min-height: 100px;">{{ isset($kehadiranHariIni) ? $kehadiranHariIni->keterangan : '' }}</textarea>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 btn-gradient" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; box-shadow: 0 4px 16px rgba(14,165,233,0.25); transition: all 0.3s ease; color: #fff; font-weight: 600; padding: 12px 40px;">
                                        <i class="fas fa-save me-2"></i>Simpan Kehadiran
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-4 alert alert-light rounded-4 border-0 shadow-sm" style="background: #f0f9ff; border: 1px solid rgba(14,165,233,0.06);">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2" style="background: rgba(14,165,233,0.08);">
                            <i class="fas fa-info-circle" style="color: #0ea5e9;"></i>
                        </div>
                        <div>
                            <strong style="color: #0c4a6e;">Status saat ini:</strong>
                            @if(isset($kehadiranHariIni))
                                <span class="badge rounded-pill ms-2" style="background: {{ $statusColors[$kehadiranHariIni->status] ?? '#94a3b8' }}; color: white; padding: 4px 14px; font-size: 12px;">
                                    {{ $statusLabel[$kehadiranHariIni->status] ?? ucfirst($kehadiranHariIni->status) }}
                                </span>
                            @else
                                <span class="badge rounded-pill ms-2" style="background: #94a3b8; color: white; padding: 4px 14px; font-size: 12px;">Belum diisi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(14,165,233,0.4); }
    .form-select:focus, .form-control:focus { border-color: #0ea5e9; box-shadow: 0 0 0 4px rgba(14,165,233,0.12); background: #ffffff; outline: none; }
    @media (max-width: 768px) {
        .card-body { padding: 20px !important; }
        .card-header { padding: 16px 20px !important; }
        .btn { width: 100%; justify-content: center; }
        .avatar-circle-large { width: 44px; height: 44px; font-size: 16px; }
        .col-md-5 .border { margin-bottom: 16px; }
    }
</style>
@endsection