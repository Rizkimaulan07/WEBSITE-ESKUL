@extends('layouts.app')

@section('title', 'Nilai & Kehadiran')
@section('subtitle', 'Input nilai dan kehadiran anggota')

@section('content')
@php
    $user = Auth::user();
@endphp

<!-- Info Ekskul -->
<div class="card-modern mb-4">
    <div class="card-body-modern">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-trophy text-primary me-2"></i>
                    {{ $ekskul->nama_ekskul ?? 'Ekskul' }}
                </h6>
                <small class="text-muted">
                    Semester {{ $semester }} - Tahun Ajaran {{ $tahunAjaran }}
                </small>
            </div>
            <div>
                <a href="{{ route('pelatih.dashboard') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card blue">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Anggota</span>
                <h3 class="stat-number">{{ $anggotas->count() }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-user-check me-1"></i> Terdaftar
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card gold">
            <div class="stat-icon gold">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Nilai</span>
                <h3 class="stat-number">{{ $statistik['total'] ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-check-circle me-1"></i> Tercatat
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Rata-rata</span>
                <h3 class="stat-number">{{ number_format($statistik['rata_rata'] ?? 0, 1) }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-arrow-up me-1"></i> Nilai
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card purple">
            <div class="stat-icon purple">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Tertinggi / Terendah</span>
                <h3 class="stat-number">
                    {{ $statistik['tertinggi'] ?? 0 }}
                    <span style="font-size: 14px; color: #94a3b8;">/</span>
                    {{ $statistik['terendah'] ?? 0 }}
                </h3>
                <span class="stat-change up">
                    <i class="fas fa-arrow-up me-1"></i> Max/Min
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Alert -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle fa-2x me-3 text-danger"></i>
            <div>
                <strong>Gagal!</strong> {{ session('error') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Daftar Anggota dengan Input Nilai & Kehadiran -->
<div class="card-modern">
    <div class="card-header-modern">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
            <h6><i class="fas fa-list me-2" style="color: #6366f1;"></i>Daftar Anggota</h6>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="badge-soft me-2">{{ $anggotas->count() }} anggota</span>
                @if($anggotas->count() > 0)
                <button class="btn-check-all" onclick="checkAllHadir()">
                    <i class="fas fa-check-double me-1"></i> Hadir Semua
                </button>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body-modern p-0">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="18%">Nama Anggota</th>
                        <th width="10%">Kelas</th>
                        <th width="20%">Nilai (A-E)</th>
                        <th width="25%">Kehadiran</th>
                        <th width="12%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotas as $index => $item)
                        @php
                            $nilai = $item->nilai ?? null;
                            $nilaiHuruf = $nilai ? $this->getNilaiHuruf($nilai->nilai_total) : '-';
                            $kehadiran = $item->kehadiran ?? null;
                            $kehadiranStatus = $kehadiran ? $kehadiran->status : '-';
                            $status = $nilai ? 'Sudah Dinilai' : 'Belum Dinilai';
                            $statusClass = $nilai ? 'success' : 'warning';
                        @endphp
                    <tr>
                        <td>
                            <span class="number-badge">{{ $loop->iteration }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle">
                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $item->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-soft">{{ $item->kelas ?? '-' }}</span>
                        </td>
                        <td>
                            <form action="{{ route('pelatih.nilai.store') }}" method="POST" class="d-flex gap-1 align-items-center">
                                @csrf
                                <input type="hidden" name="anggota_id" value="{{ $item->id }}">
                                <select name="nilai" class="form-select form-select-sm nilai-select" required>
                                    <option value="">- Pilih -</option>
                                    <option value="A" {{ $nilaiHuruf == 'A' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                    <option value="B" {{ $nilaiHuruf == 'B' ? 'selected' : '' }}>B (Baik)</option>
                                    <option value="C" {{ $nilaiHuruf == 'C' ? 'selected' : '' }}>C (Cukup)</option>
                                    <option value="D" {{ $nilaiHuruf == 'D' ? 'selected' : '' }}>D (Kurang)</option>
                                    <option value="E" {{ $nilaiHuruf == 'E' ? 'selected' : '' }}>E (Sangat Kurang)</option>
                                </select>
                                <button type="submit" class="btn-save-nilai" title="Simpan Nilai">
                                    <i class="fas fa-save"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('pelatih.nilai.kehadiran') }}" method="POST" class="d-flex gap-1 align-items-center">
                                @csrf
                                <input type="hidden" name="anggota_id" value="{{ $item->id }}">
                                <select name="status" class="form-select form-select-sm kehadiran-select" required>
                                    <option value="">- Pilih -</option>
                                    <option value="hadir" {{ $kehadiranStatus == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                    <option value="izin" {{ $kehadiranStatus == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                    <option value="sakit" {{ $kehadiranStatus == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                                    <option value="alpa" {{ $kehadiranStatus == 'alpa' ? 'selected' : '' }}>❌ Alpa</option>
                                </select>
                                <button type="submit" class="btn-save-kehadiran" title="Simpan Kehadiran">
                                    <i class="fas fa-save"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="badge bg-{{ $statusClass }}" style="font-size: 12px; padding: 5px 12px; display: inline-block;">
                                {{ $status }}
                            </span>
                            @if($kehadiranStatus != '-')
                                <span class="badge bg-{{ $kehadiranStatus == 'hadir' ? 'success' : ($kehadiranStatus == 'izin' ? 'warning' : ($kehadiranStatus == 'sakit' ? 'info' : 'danger')) }}" 
                                      style="font-size: 12px; padding: 5px 12px; margin-top: 3px; display: inline-block;">
                                    {{ ucfirst($kehadiranStatus) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-user-plus"></i></div>
                                <h6 class="empty-title">Belum ada anggota</h6>
                                <p class="empty-desc">Tambahkan anggota terlebih dahulu melalui menu Admin</p>
                                <a href="{{ route('admin.anggota.create') }}" class="btn-primary-gradient mt-2" target="_blank">
                                    <i class="fas fa-plus me-2"></i> Tambah Anggota
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Informasi Input -->
@if($anggotas->count() > 0)
<div class="mt-4">
    <div class="alert alert-info rounded-4 border-0 shadow-sm">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="bg-info bg-opacity-10 rounded-circle p-2">
                <i class="fas fa-info-circle fa-2x text-info"></i>
            </div>
            <div>
                <strong>Cara Input:</strong>
                <ul class="mb-0 mt-1">
                    <li>Pilih nilai (A-E) pada kolom <strong>Nilai</strong>, lalu klik tombol 💾</li>
                    <li>Pilih status kehadiran pada kolom <strong>Kehadiran</strong>, lalu klik tombol 💾</li>
                    <li>Klik tombol <strong>Hadir Semua</strong> untuk menandai semua anggota hadir</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .card-modern {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .card-body-modern {
        padding: 20px 24px;
    }

    .card-header-modern {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        background: rgba(248, 250, 252, 0.3);
    }

    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 22px 24px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
    }

    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-card .stat-icon.blue { background: rgba(99, 102, 241, 0.06); color: #6366f1; }
    .stat-card .stat-icon.gold { background: rgba(245, 158, 11, 0.06); color: #f59e0b; }
    .stat-card .stat-icon.green { background: rgba(16, 185, 129, 0.06); color: #10b981; }
    .stat-card .stat-icon.purple { background: rgba(139, 92, 246, 0.06); color: #8b5cf6; }

    .stat-card .stat-body { flex: 1; }
    .stat-card .stat-label { font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-card .stat-number { font-size: 28px; font-weight: 700; color: #0f172a; margin: 2px 0; letter-spacing: -0.5px; }

    .stat-change {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-change.up { background: rgba(16, 185, 129, 0.06); color: #10b981; }

    .badge-soft {
        background: rgba(99, 102, 241, 0.05);
        color: #6366f1;
        padding: 2px 14px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .table-modern {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table-modern thead th {
        background: rgba(248, 250, 252, 0.3);
        color: #64748b;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        text-align: left;
    }

    .table-modern tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.015);
        vertical-align: middle;
    }

    .table-modern tbody tr:hover {
        background: rgba(99, 102, 241, 0.012);
    }

    .number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(99, 102, 241, 0.04);
        color: #6366f1;
        font-weight: 600;
        font-size: 12px;
    }

    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        flex-shrink: 0;
        box-shadow: 0 2px 12px rgba(99, 102, 241, 0.15);
    }

    .form-select-sm {
        font-size: 12px;
        padding: 4px 8px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: #f8fafc;
        transition: all 0.3s ease;
        cursor: pointer;
        min-width: 80px;
    }

    .form-select-sm:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
        outline: none;
    }

    .btn-save-nilai {
        background: #6366f1;
        border: none;
        color: white;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-save-nilai:hover {
        background: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35);
    }

    .btn-save-kehadiran {
        background: #10b981;
        border: none;
        color: white;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-save-kehadiran:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);
    }

    .btn-check-all {
        padding: 6px 16px;
        border: none;
        border-radius: 8px;
        background: rgba(16, 185, 129, 0.06);
        color: #10b981;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-check-all:hover {
        background: rgba(16, 185, 129, 0.12);
        transform: translateY(-2px);
    }

    .btn-primary-gradient {
        padding: 10px 24px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(99, 102, 241, 0.35);
        color: #fff;
        text-decoration: none;
    }

    .empty-state {
        padding: 40px 0;
        text-align: center;
    }

    .empty-state .empty-icon {
        font-size: 56px;
        color: #d1d5db;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state .empty-title {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .empty-state .empty-desc {
        color: #94a3b8;
        font-size: 13px;
        margin-bottom: 16px;
    }

    @media (max-width: 768px) {
        .stat-card {
            padding: 16px 18px;
        }
        .stat-card .stat-number {
            font-size: 22px;
        }
        .card-body-modern {
            padding: 14px 16px;
        }
        .table-modern {
            font-size: 12px;
        }
        .btn-save-nilai, .btn-save-kehadiran {
            padding: 2px 6px;
            font-size: 10px;
        }
        .form-select-sm {
            font-size: 10px;
            padding: 2px 4px;
            width: 60px !important;
        }
        .card-header-modern {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<script>
    function checkAllHadir() {
        document.querySelectorAll('.kehadiran-select').forEach(function(select) {
            select.value = 'hadir';
        });
    }

    @php
    function getNilaiHuruf($nilai)
    {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 75) return 'B';
        if ($nilai >= 65) return 'C';
        if ($nilai >= 55) return 'D';
        return 'E';
    }
    @endphp
</script>
@endsection