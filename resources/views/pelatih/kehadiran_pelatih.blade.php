@extends('layouts.app')

@section('title', 'Kehadiran Saya')
@section('subtitle', 'Input kehadiran pelatih')

@section('content')
@php
    $statusColors = [
        'hadir' => 'success',
        'izin' => 'warning',
        'sakit' => 'danger',
        'alpa' => 'secondary',
    ];
@endphp

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header border-0 py-4 px-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-4">
                        <div class="bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-user-check fa-2x text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-white fw-bold mb-0">Kehadiran Saya</h4>
                            <p class="text-white-50 mb-0 small">Catat kehadiran Anda hari ini</p>
                        </div>
                    </div>
                    <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-light rounded-pill px-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4 p-lg-5">
                @if(session('success'))
                    <div class="alert alert-success rounded-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                            <div>
                                <strong>Berhasil!</strong> {{ session('success') }}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row g-4 align-items-stretch">
                    <div class="col-md-5">
                        <div class="border rounded-4 p-4 h-100 bg-light-subtle">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="avatar-circle-large">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                <div>
                                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                                    <small class="text-muted">Pelatih</small>
                                </div>
                            </div>
                            <div class="small text-muted mb-2">
                                <i class="fas fa-trophy me-2 text-primary"></i>
                                {{ $ekskul->nama_ekskul ?? 'Belum ada ekskul' }}
                            </div>
                            <div class="small text-muted">
                                <i class="far fa-calendar me-2 text-primary"></i>
                                {{ now()->translatedFormat('l, d F Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <form action="{{ route('pelatih.kehadiran_pelatih.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="fw-semibold mb-2">
                                        <i class="fas fa-user-check me-2 text-primary"></i>Status Kehadiran
                                    </label>
                                    <select name="status" class="form-select form-select-lg rounded-3" required>
                                        <option value="">-- Pilih status --</option>
                                        <option value="hadir" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                        <option value="izin" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                        <option value="sakit" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="fw-semibold mb-2">
                                        <i class="fas fa-sticky-note me-2 text-primary"></i>Keterangan
                                    </label>
                                    <textarea name="keterangan" rows="4" class="form-control rounded-3" placeholder="Contoh: izin keluarga, sakit ringan, atau keterangan hadir...">{{ isset($kehadiranHariIni) ? $kehadiranHariIni->keterangan : '' }}</textarea>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 btn-gradient">
                                        <i class="fas fa-save me-2"></i>Simpan Kehadiran
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-4 alert alert-light rounded-4 border-0 shadow-sm">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                            <i class="fas fa-info-circle text-primary"></i>
                        </div>
                        <div>
                            <strong>Status saat ini:</strong>
                            @if(isset($kehadiranHariIni))
                                <span class="badge bg-{{ $statusColors[$kehadiranHariIni->status] ?? 'secondary' }} rounded-pill ms-2">
                                    {{ ucfirst($kehadiranHariIni->status) }}
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill ms-2">Belum diisi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle-large {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.25);
    }
    .btn-gradient {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        border: none;
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.16);
    }
</style>
@endsection