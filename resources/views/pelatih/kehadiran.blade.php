@extends('layouts.app')

@section('title', 'Kehadiran Pelatih')
@section('subtitle', 'Input kehadiran pelatih')

@section('content')
@php
    $statusColors = [
        'hadir' => 'success',
        'izin' => 'warning',
        'sakit' => 'danger',
        'alpa' => 'secondary'
    ];
@endphp

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header border-0 py-3 px-4" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2">
                            <i class="fas fa-clipboard-check fa-2x text-white"></i>
                        </div>
                        <div>
                            <h5 class="text-white fw-bold mb-0">Kehadiran Pelatih</h5>
                            <p class="text-white-50 small mb-0">Catat kehadiran Anda sebagai pelatih</p>
                        </div>
                    </div>
                    <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-4">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <div>
                                <strong>Berhasil!</strong> {{ session('success') }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                            </div>
                            <div>
                                <strong>Gagal!</strong> {{ session('error') }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Info Kegiatan -->
                <div class="info-card mb-4">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-trophy me-1"></i> Ekskul</span>
                                <span class="info-value">{{ $ekskul->nama_ekskul ?? 'Belum ada' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-calendar-day me-1"></i> Hari</span>
                                <span class="info-value">{{ now()->translatedFormat('l') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-calendar-alt me-1"></i> Tanggal</span>
                                <span class="info-value">{{ now()->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-clock me-1"></i> Jam</span>
                                <span class="info-value" id="clockDisplay">{{ now()->format('H:i:s') }} WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(99, 102, 241, 0.06); color: #6366f1;">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Total</span>
                                <h3 class="stat-number">{{ $statistik['total'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.06); color: #10b981;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Hadir</span>
                                <h3 class="stat-number">{{ $statistik['hadir'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.06); color: #f59e0b;">
                                <i class="fas fa-pen"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Izin/Sakit</span>
                                <h3 class="stat-number">{{ ($statistik['izin'] ?? 0) + ($statistik['sakit'] ?? 0) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.06); color: #ef4444;">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Alpa</span>
                                <h3 class="stat-number">{{ $statistik['alpa'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Input Kehadiran -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-edit me-2" style="color: #f59e0b;"></i>
                            Input Kehadiran Hari Ini
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Kegiatan Hari Ini -->
                        <div class="info-kegiatan mb-3 p-3 rounded-3" style="background: rgba(99,102,241,0.03); border: 1px solid rgba(99,102,241,0.06);">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-calendar-check" style="color: #4f46e5;"></i>
                                        <span class="fw-semibold">Hari ini:</span>
                                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-clock" style="color: #f59e0b;"></i>
                                        <span class="fw-semibold">Waktu:</span>
                                        <span id="clockDisplay2">{{ now()->format('H:i:s') }} WIB</span>
                                    </div>
                                </div>
                            </div>
                            @if($ekskul)
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-trophy" style="color: #10b981;"></i>
                                        <span class="fw-semibold">Ekskul:</span>
                                        <span>{{ $ekskul->nama_ekskul }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-user-tie" style="color: #6366f1;"></i>
                                        <span class="fw-semibold">Pembina:</span>
                                        <span>{{ $ekskul->pembina }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-map-marker-alt" style="color: #ef4444;"></i>
                                        <span class="fw-semibold">Tempat:</span>
                                        <span>{{ $ekskul->tempat_latihan }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-clock" style="color: #f59e0b;"></i>
                                        <span class="fw-semibold">Jam Latihan:</span>
                                        <span>{{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}</span>
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
                                    <label class="fw-semibold mb-1">
                                        <i class="fas fa-user-check me-1" style="color: #6366f1;"></i> Status Kehadiran
                                    </label>
                                    <select name="status" class="form-select form-select-lg">
                                        <option value="hadir" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                        <option value="izin" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                        <option value="sakit" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                                        <option value="alpa" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'alpa' ? 'selected' : '' }}>❌ Alpa</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="fw-semibold mb-1">
                                        <i class="fas fa-info-circle me-1" style="color: #6366f1;"></i> Keterangan
                                    </label>
                                    <input type="text" name="keterangan" class="form-control form-control-lg" 
                                           placeholder="Keterangan (opsional)" 
                                           value="{{ isset($kehadiranHariIni) ? $kehadiranHariIni->keterangan : '' }}">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill"
                                            style="background: linear-gradient(135deg, #4f46e5, #6366f1); border: none;">
                                        <i class="fas fa-save me-2"></i> Simpan
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Status saat ini: 
                                    @if(isset($kehadiranHariIni))
                                        <span class="badge bg-{{ $statusColors[$kehadiranHariIni->status] ?? 'secondary' }}">
                                            {{ ucfirst($kehadiranHariIni->status) }}
                                        </span>
                                        ({{ $kehadiranHariIni->updated_at->diffForHumans() }})
                                    @else
                                        <span class="badge bg-secondary">Belum diisi</span>
                                    @endif
                                </small>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Riwayat Kehadiran -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-history me-2" style="color: #6366f1;"></i>
                                Riwayat Kehadiran
                            </h6>
                            <span class="badge-count">{{ $riwayat->total() }} total</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Hari</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Input</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayat as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="far fa-calendar-alt me-2 text-muted"></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $statusColors[$item->status] ?? 'secondary' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $item->created_at->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('pelatih.kehadiran.show', $item->id) }}" 
                                               class="btn btn-sm btn-outline-primary rounded-pill"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox me-2"></i>Belum ada riwayat kehadiran
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        {{ $riwayat->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 16px 20px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .info-item {
        text-align: center;
        padding: 6px 0;
    }

    .info-label {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
    }

    .info-kegiatan {
        background: rgba(99,102,241,0.02);
        border: 1px solid rgba(99,102,241,0.04);
        border-radius: 12px;
        padding: 14px 18px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-body {
        flex: 1;
    }

    .stat-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-number {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .form-select-lg, .form-control-lg {
        padding: 12px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .form-select-lg:focus, .form-control-lg:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
    }

    .badge-count {
        background: rgba(99, 102, 241, 0.06);
        color: #6366f1;
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .btn-outline-primary {
        border-color: #e5e7eb;
        color: #64748b;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: #4f46e5;
        color: #fff;
        border-color: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(79,70,229,0.2);
    }

    @media (max-width: 768px) {
        .stat-card {
            padding: 12px 16px;
        }
        .stat-number {
            font-size: 18px;
        }
        .info-item {
            padding: 4px 0;
        }
        .info-value {
            font-size: 13px;
        }
        .form-select-lg, .form-control-lg {
            padding: 10px 14px;
            font-size: 13px;
        }
        .btn-lg {
            padding: 10px 16px;
            font-size: 14px;
        }
        .info-kegiatan .row > div {
            margin-bottom: 6px;
        }
        .btn-outline-primary {
            padding: 4px 10px;
            font-size: 12px;
        }
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
@endsection@extends('layouts.app')

@section('title', 'Kehadiran Pelatih')
@section('subtitle', 'Input kehadiran pelatih')

@section('content')
@php
    $statusColors = [
        'hadir' => 'success',
        'izin' => 'warning',
        'sakit' => 'danger',
        'alpa' => 'secondary'
    ];
@endphp

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header border-0 py-3 px-4" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2">
                            <i class="fas fa-clipboard-check fa-2x text-white"></i>
                        </div>
                        <div>
                            <h5 class="text-white fw-bold mb-0">Kehadiran Pelatih</h5>
                            <p class="text-white-50 small mb-0">Catat kehadiran Anda sebagai pelatih</p>
                        </div>
                    </div>
                    <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-4">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <div>
                                <strong>Berhasil!</strong> {{ session('success') }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                            </div>
                            <div>
                                <strong>Gagal!</strong> {{ session('error') }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Info Kegiatan -->
                <div class="info-card mb-4">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-trophy me-1"></i> Ekskul</span>
                                <span class="info-value">{{ $ekskul->nama_ekskul ?? 'Belum ada' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-calendar-day me-1"></i> Hari</span>
                                <span class="info-value">{{ now()->translatedFormat('l') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-calendar-alt me-1"></i> Tanggal</span>
                                <span class="info-value">{{ now()->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-clock me-1"></i> Jam</span>
                                <span class="info-value" id="clockDisplay">{{ now()->format('H:i:s') }} WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(99, 102, 241, 0.06); color: #6366f1;">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Total</span>
                                <h3 class="stat-number">{{ $statistik['total'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.06); color: #10b981;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Hadir</span>
                                <h3 class="stat-number">{{ $statistik['hadir'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.06); color: #f59e0b;">
                                <i class="fas fa-pen"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Izin/Sakit</span>
                                <h3 class="stat-number">{{ ($statistik['izin'] ?? 0) + ($statistik['sakit'] ?? 0) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.06); color: #ef4444;">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="stat-body">
                                <span class="stat-label">Alpa</span>
                                <h3 class="stat-number">{{ $statistik['alpa'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Input Kehadiran -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-edit me-2" style="color: #f59e0b;"></i>
                            Input Kehadiran Hari Ini
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Kegiatan Hari Ini -->
                        <div class="info-kegiatan mb-3 p-3 rounded-3" style="background: rgba(99,102,241,0.03); border: 1px solid rgba(99,102,241,0.06);">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-calendar-check" style="color: #4f46e5;"></i>
                                        <span class="fw-semibold">Hari ini:</span>
                                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-clock" style="color: #f59e0b;"></i>
                                        <span class="fw-semibold">Waktu:</span>
                                        <span id="clockDisplay2">{{ now()->format('H:i:s') }} WIB</span>
                                    </div>
                                </div>
                            </div>
                            @if($ekskul)
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-trophy" style="color: #10b981;"></i>
                                        <span class="fw-semibold">Ekskul:</span>
                                        <span>{{ $ekskul->nama_ekskul }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-user-tie" style="color: #6366f1;"></i>
                                        <span class="fw-semibold">Pembina:</span>
                                        <span>{{ $ekskul->pembina }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-map-marker-alt" style="color: #ef4444;"></i>
                                        <span class="fw-semibold">Tempat:</span>
                                        <span>{{ $ekskul->tempat_latihan }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-clock" style="color: #f59e0b;"></i>
                                        <span class="fw-semibold">Jam Latihan:</span>
                                        <span>{{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}</span>
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
                                    <label class="fw-semibold mb-1">
                                        <i class="fas fa-user-check me-1" style="color: #6366f1;"></i> Status Kehadiran
                                    </label>
                                    <select name="status" class="form-select form-select-lg">
                                        <option value="hadir" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                        <option value="izin" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                        <option value="sakit" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                                        <option value="alpa" {{ isset($kehadiranHariIni) && $kehadiranHariIni->status == 'alpa' ? 'selected' : '' }}>❌ Alpa</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="fw-semibold mb-1">
                                        <i class="fas fa-info-circle me-1" style="color: #6366f1;"></i> Keterangan
                                    </label>
                                    <input type="text" name="keterangan" class="form-control form-control-lg" 
                                           placeholder="Keterangan (opsional)" 
                                           value="{{ isset($kehadiranHariIni) ? $kehadiranHariIni->keterangan : '' }}">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill"
                                            style="background: linear-gradient(135deg, #4f46e5, #6366f1); border: none;">
                                        <i class="fas fa-save me-2"></i> Simpan
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Status saat ini: 
                                    @if(isset($kehadiranHariIni))
                                        <span class="badge bg-{{ $statusColors[$kehadiranHariIni->status] ?? 'secondary' }}">
                                            {{ ucfirst($kehadiranHariIni->status) }}
                                        </span>
                                        ({{ $kehadiranHariIni->updated_at->diffForHumans() }})
                                    @else
                                        <span class="badge bg-secondary">Belum diisi</span>
                                    @endif
                                </small>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Riwayat Kehadiran -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-history me-2" style="color: #6366f1;"></i>
                                Riwayat Kehadiran
                            </h6>
                            <span class="badge-count">{{ $riwayat->total() }} total</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Hari</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Input</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayat as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <i class="far fa-calendar-alt me-2 text-muted"></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $statusColors[$item->status] ?? 'secondary' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $item->created_at->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('pelatih.kehadiran.show', $item->id) }}" 
                                               class="btn btn-sm btn-outline-primary rounded-pill"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox me-2"></i>Belum ada riwayat kehadiran
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        {{ $riwayat->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 16px 20px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .info-item {
        text-align: center;
        padding: 6px 0;
    }

    .info-label {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
    }

    .info-kegiatan {
        background: rgba(99,102,241,0.02);
        border: 1px solid rgba(99,102,241,0.04);
        border-radius: 12px;
        padding: 14px 18px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-body {
        flex: 1;
    }

    .stat-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-number {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .form-select-lg, .form-control-lg {
        padding: 12px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .form-select-lg:focus, .form-control-lg:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
    }

    .badge-count {
        background: rgba(99, 102, 241, 0.06);
        color: #6366f1;
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .btn-outline-primary {
        border-color: #e5e7eb;
        color: #64748b;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: #4f46e5;
        color: #fff;
        border-color: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(79,70,229,0.2);
    }

    @media (max-width: 768px) {
        .stat-card {
            padding: 12px 16px;
        }
        .stat-number {
            font-size: 18px;
        }
        .info-item {
            padding: 4px 0;
        }
        .info-value {
            font-size: 13px;
        }
        .form-select-lg, .form-control-lg {
            padding: 10px 14px;
            font-size: 13px;
        }
        .btn-lg {
            padding: 10px 16px;
            font-size: 14px;
        }
        .info-kegiatan .row > div {
            margin-bottom: 6px;
        }
        .btn-outline-primary {
            padding: 4px 10px;
            font-size: 12px;
        }
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