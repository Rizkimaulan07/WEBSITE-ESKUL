@extends('layouts.app')

@section('title', 'Kehadiran Pelatih')
@section('subtitle', 'Input kehadiran pelatih')

@section('content')
@php
    $statusColors = [
        'hadir' => '#10b981',
        'izin' => '#f59e0b',
        'sakit' => '#ef4444',
        'alpa' => '#64748b'
    ];
    $statusLabel = [
        'hadir' => 'Hadir',
        'izin' => 'Izin',
        'sakit' => 'Sakit',
        'alpa' => 'Alpa'
    ];
    $statusIcons = [
        'hadir' => '✅',
        'izin' => '📝',
        'sakit' => '🏥',
        'alpa' => '❌'
    ];
@endphp

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5 hero-gradient">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-clipboard-check fa-2x text-white"></i>
                        </div>
                        <div>
                            <h5 class="text-white fw-bold mb-0" style="font-size: 20px; letter-spacing: -0.5px;">Kehadiran Pelatih</h5>
                            <p class="text-white-50 small mb-0" style="font-weight: 400;">Catat kehadiran Anda sebagai pelatih</p>
                        </div>
                    </div>
                    <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-4" style="color: white; border-color: rgba(255,255,255,0.3); transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Info Kegiatan -->
                <div class="info-card mb-4" style="background: #ffffff; border-radius: 14px; padding: 16px 20px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="info-item" style="text-align: center; padding: 6px 0;">
                                <span class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                    <i class="fas fa-trophy me-1" style="color: #0ea5e9;"></i> Ekskul
                                </span>
                                <span class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a;">{{ $ekskul->nama_ekskul ?? 'Belum ada' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-item" style="text-align: center; padding: 6px 0;">
                                <span class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                    <i class="fas fa-calendar-day me-1" style="color: #0ea5e9;"></i> Hari
                                </span>
                                <span class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a;">{{ now()->translatedFormat('l') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-item" style="text-align: center; padding: 6px 0;">
                                <span class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                    <i class="fas fa-calendar-alt me-1" style="color: #0ea5e9;"></i> Tanggal
                                </span>
                                <span class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a;">{{ now()->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-item" style="text-align: center; padding: 6px 0;">
                                <span class="info-label" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                    <i class="fas fa-clock me-1" style="color: #0ea5e9;"></i> Jam
                                </span>
                                <span class="info-value" style="font-size: 15px; font-weight: 600; color: #0f172a;" id="clockDisplay">{{ now()->format('H:i:s') }} WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik - Biru Cerah -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="stat-card" style="background: #ffffff; border-radius: 12px; padding: 16px 20px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease; display: flex; gap: 12px; align-items: center;">
                            <div class="stat-icon" style="width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; background: rgba(14,165,233,0.06); color: #0ea5e9;">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-body" style="flex: 1;">
                                <span class="stat-label" style="font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total</span>
                                <h3 class="stat-number" style="font-size: 22px; font-weight: 700; color: #0f172a; margin: 0; letter-spacing: -0.5px;">{{ $statistik['total'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card" style="background: #ffffff; border-radius: 12px; padding: 16px 20px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease; display: flex; gap: 12px; align-items: center;">
                            <div class="stat-icon" style="width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; background: rgba(16,185,129,0.06); color: #10b981;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-body" style="flex: 1;">
                                <span class="stat-label" style="font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Hadir</span>
                                <h3 class="stat-number" style="font-size: 22px; font-weight: 700; color: #0f172a; margin: 0; letter-spacing: -0.5px;">{{ $statistik['hadir'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card" style="background: #ffffff; border-radius: 12px; padding: 16px 20px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease; display: flex; gap: 12px; align-items: center;">
                            <div class="stat-icon" style="width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; background: rgba(245,158,11,0.06); color: #f59e0b;">
                                <i class="fas fa-pen"></i>
                            </div>
                            <div class="stat-body" style="flex: 1;">
                                <span class="stat-label" style="font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Izin/Sakit</span>
                                <h3 class="stat-number" style="font-size: 22px; font-weight: 700; color: #0f172a; margin: 0; letter-spacing: -0.5px;">{{ ($statistik['izin'] ?? 0) + ($statistik['sakit'] ?? 0) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card" style="background: #ffffff; border-radius: 12px; padding: 16px 20px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease; display: flex; gap: 12px; align-items: center;">
                            <div class="stat-icon" style="width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; background: rgba(239,68,68,0.06); color: #ef4444;">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="stat-body" style="flex: 1;">
                                <span class="stat-label" style="font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Alpa</span>
                                <h3 class="stat-number" style="font-size: 22px; font-weight: 700; color: #0f172a; margin: 0; letter-spacing: -0.5px;">{{ $statistik['alpa'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Input Kehadiran -->
                <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #ffffff;">
                    <div class="card-header bg-transparent border-0" style="padding: 16px 20px 0;">
                        <h6 class="fw-bold mb-0" style="color: #0f172a;">
                            <i class="fas fa-edit me-2" style="color: #0ea5e9;"></i>
                            Input Kehadiran Hari Ini
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 20px;">
                        <!-- Informasi Kegiatan Hari Ini -->
                        <div class="info-kegiatan mb-3 p-3 rounded-3" style="background: rgba(14,165,233,0.02); border: 1px solid rgba(14,165,233,0.06); border-radius: 12px; padding: 14px 18px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-calendar-check" style="color: #0ea5e9;"></i>
                                        <span class="fw-semibold" style="color: #0f172a;">Hari ini:</span>
                                        <span style="color: #0f172a;">{{ now()->translatedFormat('l, d F Y') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-clock" style="color: #f59e0b;"></i>
                                        <span class="fw-semibold" style="color: #0f172a;">Waktu:</span>
                                        <span style="color: #0f172a;" id="clockDisplay2">{{ now()->format('H:i:s') }} WIB</span>
                                    </div>
                                </div>
                            </div>
                            @if($ekskul)
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-trophy" style="color: #10b981;"></i>
                                        <span class="fw-semibold" style="color: #0f172a;">Ekskul:</span>
                                        <span style="color: #0f172a;">{{ $ekskul->nama_ekskul }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-user-tie" style="color: #0ea5e9;"></i>
                                        <span class="fw-semibold" style="color: #0f172a;">Pembina:</span>
                                        <span style="color: #0f172a;">{{ $ekskul->pembina }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-map-marker-alt" style="color: #ef4444;"></i>
                                        <span class="fw-semibold" style="color: #0f172a;">Tempat:</span>
                                        <span style="color: #0f172a;">{{ $ekskul->tempat_latihan }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-clock" style="color: #f59e0b;"></i>
                                        <span class="fw-semibold" style="color: #0f172a;">Jam Latihan:</span>
                                        <span style="color: #0f172a;">{{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <form action="{{ route('pelatih.kehadiran.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tanggal" value="{{ today()->format('Y-m-d') }}">
                            
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="fw-semibold mb-1" style="color: #1e293b; font-size: 14px;">
                                        <i class="fas fa-user-check me-1" style="color: #0ea5e9;"></i> Status Kehadiran
                                    </label>
                                    <select name="status" class="form-select form-select-lg" style="padding: 12px 20px; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s ease; font-size: 14px; background: #fafbfc; width: 100%;">
                                        <option value="hadir" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                        <option value="izin" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                        <option value="sakit" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                                        <option value="alpa" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'alpa' ? 'selected' : '' }}>❌ Alpa</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="fw-semibold mb-1" style="color: #1e293b; font-size: 14px;">
                                        <i class="fas fa-info-circle me-1" style="color: #0ea5e9;"></i> Keterangan
                                    </label>
                                    <input type="text" name="keterangan" class="form-control form-control-lg" 
                                           placeholder="Keterangan (opsional)" 
                                           value="{{ isset($kehadiranHariIni) ? $kehadiranHariIni->keterangan : '' }}"
                                           style="padding: 12px 20px; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s ease; font-size: 14px; background: #fafbfc; width: 100%;">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill btn-primary-gradient"
                                            style="padding: 12px 16px;">
                                        <i class="fas fa-save me-2"></i> Simpan
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <small class="text-muted" style="color: #64748b;">
                                    <i class="fas fa-info-circle me-1" style="color: #0ea5e9;"></i>
                                    Status saat ini: 
                                    @if(isset($kehadiranHariIni))
                                        <span class="badge rounded-pill" style="background: {{ $statusColors[$kehadiranHariIni->status] ?? '#64748b' }}; color: white; padding: 4px 12px; font-size: 12px;">
                                            {{ $statusLabel[$kehadiranHariIni->status] ?? ucfirst($kehadiranHariIni->status) }}
                                        </span>
                                        ({{ $kehadiranHariIni->updated_at->diffForHumans() }})
                                    @else
                                        <span class="badge rounded-pill" style="background: #64748b; color: white; padding: 4px 12px; font-size: 12px;">Belum diisi</span>
                                    @endif
                                </small>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Riwayat Kehadiran -->
                <div class="card border-0 shadow-sm rounded-4" style="background: #ffffff;">
                    <div class="card-header bg-transparent border-0" style="padding: 16px 20px 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0" style="color: #0f172a;">
                                <i class="fas fa-history me-2" style="color: #0ea5e9;"></i>
                                Riwayat Kehadiran
                            </h6>
                            <span class="badge-count" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 12px; border-radius: 12px; font-size: 11px; font-weight: 500;">{{ $riwayat->total() }} total</span>
                        </div>
                    </div>
                    <div class="card-body p-0" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                                <thead class="table-light" style="background: rgba(248,250,252,0.3);">
                                    <tr>
                                        <th style="color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">No</th>
                                        <th style="color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Tanggal</th>
                                        <th style="color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Hari</th>
                                        <th style="color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Status</th>
                                        <th style="color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Keterangan</th>
                                        <th style="color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Input</th>
                                        <th class="text-center" style="color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayat as $item)
                                    <tr style="transition: all 0.3s ease;">
                                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                            <i class="far fa-calendar-alt me-2 text-muted" style="color: #64748b;"></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                        </td>
                                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</td>
                                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                            <span class="badge rounded-pill" style="background: {{ $statusColors[$item->status] ?? '#64748b' }}; color: white; padding: 4px 12px; font-size: 12px;">
                                                {{ $statusLabel[$item->status] ?? ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">{{ $item->keterangan ?? '-' }}</td>
                                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                            <small class="text-muted" style="color: #64748b;">
                                                {{ $item->created_at->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td class="text-center" style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                            <a href="{{ route('pelatih.kehadiran.show', $item->id) }}" 
                                               class="btn btn-sm rounded-pill"
                                               title="Lihat Detail"
                                               style="border-color: #e2e8f0; color: #64748b; transition: all 0.3s ease; padding: 4px 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-eye" style="color: #0ea5e9;"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted" style="color: #64748b;">
                                            <i class="fas fa-inbox me-2"></i>Belum ada riwayat kehadiran
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0" style="padding: 12px 20px; border-top: 1px solid rgba(0,0,0,0.02);">
                        {{ $riwayat->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-select:focus, .form-control:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
        background: #ffffff;
        outline: none;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(14, 165, 233, 0.06);
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(14, 165, 233, 0.4) !important;
    }
    .table tbody tr:hover {
        background: rgba(14, 165, 233, 0.015);
    }
    .btn-outline-primary:hover {
        background: #0ea5e9;
        color: #fff;
        border-color: #0ea5e9;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.2);
    }
    .pagination .page-item .page-link {
        border: none;
        border-radius: 10px;
        margin: 0 3px;
        color: #64748b;
        transition: all 0.3s ease;
        font-size: 13px;
        padding: 8px 14px;
    }
    .pagination .page-item .page-link:hover {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: white;
        border: none;
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
    }
    @media (max-width: 768px) {
        .stat-card { padding: 12px 16px; }
        .stat-number { font-size: 18px; }
        .info-item { padding: 4px 0; }
        .info-value { font-size: 13px; }
        .form-select-lg, .form-control-lg { padding: 10px 14px; font-size: 13px; }
        .btn-lg { padding: 10px 16px; font-size: 14px; }
        .info-kegiatan .row > div { margin-bottom: 6px; }
        .btn-outline-primary { padding: 4px 10px; font-size: 12px; }
        .card-header { padding: 16px 20px !important; }
        .card-body { padding: 16px !important; }
    }
</style>

<script>
    // Update clock
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
        
        const clockDisplay = document.getElementById('clockDisplay');
        const clockDisplay2 = document.getElementById('clockDisplay2');
        
        if (clockDisplay) {
            clockDisplay.textContent = time + ' WIB';
        }
        if (clockDisplay2) {
            clockDisplay2.textContent = time + ' WIB';
        }
    }
    
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection