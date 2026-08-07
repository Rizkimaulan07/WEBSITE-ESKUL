@extends('layouts.app')

@section('title', 'Nilai & Kehadiran')
@section('subtitle', 'Input nilai dan kehadiran anggota')

@section('content')
@php
    $user = Auth::user();
    $statusColors = [
        'hadir' => 'success',
        'izin' => 'warning',
        'sakit' => 'danger',
        'alpa' => 'secondary',
        'terlambat' => 'info'
    ];
    $statusIcons = [
        'hadir' => '✅',
        'izin' => '📝',
        'sakit' => '🏥',
        'alpa' => '❌',
        'terlambat' => '⏰'
    ];
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
                        <th width="4%">No</th>
                        <th width="14%">Nama Anggota</th>
                        <th width="8%">Kelas</th>
                        <th width="10%">Nilai Huruf</th>
                        <th width="18%">Nilai (0-100)</th>
                        <th width="16%">Kehadiran</th>
                        <th width="10%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotas as $index => $item)
                        @php
                            $nilai = $item->nilai ?? null;
                            $nilaiTotal = $nilai ? $nilai->nilai_total : 0;
                            // Konversi ke huruf
                            if ($nilaiTotal >= 85) $nilaiHuruf = 'A';
                            elseif ($nilaiTotal >= 75) $nilaiHuruf = 'B';
                            elseif ($nilaiTotal >= 65) $nilaiHuruf = 'C';
                            elseif ($nilaiTotal >= 55) $nilaiHuruf = 'D';
                            else $nilaiHuruf = 'E';
                            
                            $kehadiran = $item->kehadiran ?? null;
                            $kehadiranStatus = $kehadiran ? $kehadiran->status : '-';
                            $status = $nilai ? 'Sudah Dinilai' : 'Belum Dinilai';
                            $statusClass = $nilai ? 'success' : 'warning';
                            
                            // Data untuk input
                            $nilaiKehadiran = $nilai ? $nilai->nilai_kehadiran : '';
                            $nilaiTugas = $nilai ? $nilai->nilai_tugas : '';
                            $nilaiUjian = $nilai ? $nilai->nilai_ujian : '';
                            $catatan = $nilai ? $nilai->catatan : '';
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
                            <span class="badge-nilai 
                                {{ $nilaiHuruf == 'A' ? 'nilai-a' : 
                                   ($nilaiHuruf == 'B' ? 'nilai-b' : 
                                   ($nilaiHuruf == 'C' ? 'nilai-c' : 
                                   ($nilaiHuruf == 'D' ? 'nilai-d' : 'nilai-e'))) }}">
                                {{ $nilaiHuruf }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('pelatih.nilai.store') }}" method="POST" class="nilai-form">
                                @csrf
                                <input type="hidden" name="anggota_id" value="{{ $item->id }}">
                                <div class="d-flex flex-wrap gap-1 align-items-center">
                                    <div class="input-group-nilai">
                                        <label class="label-nilai">Hadir</label>
                                        <input type="number" name="nilai_kehadiran" class="form-control form-control-sm input-nilai" 
                                               placeholder="0" min="0" max="100" step="0.01"
                                               value="{{ $nilaiKehadiran }}" style="width: 60px;">
                                    </div>
                                    <div class="input-group-nilai">
                                        <label class="label-nilai">Tugas</label>
                                        <input type="number" name="nilai_tugas" class="form-control form-control-sm input-nilai" 
                                               placeholder="0" min="0" max="100" step="0.01"
                                               value="{{ $nilaiTugas }}" style="width: 60px;">
                                    </div>
                                    <div class="input-group-nilai">
                                        <label class="label-nilai">Ujian</label>
                                        <input type="number" name="nilai_ujian" class="form-control form-control-sm input-nilai" 
                                               placeholder="0" min="0" max="100" step="0.01"
                                               value="{{ $nilaiUjian }}" style="width: 60px;">
                                    </div>
                                    <button type="submit" class="btn-save-nilai" title="Simpan Nilai">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="catatan" value="{{ $catatan }}">
                            </form>
                            <div class="bobot-nilai">
                                <small class="text-muted">
                                    <span class="bobot-item">Hadir 20%</span>
                                    <span class="bobot-item">Tugas 30%</span>
                                    <span class="bobot-item">Ujian 50%</span>
                                    <span class="bobot-total">Total: <strong>{{ number_format($nilaiTotal, 1) }}</strong></span>
                                </small>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('pelatih.nilai.kehadiran') }}" method="POST" class="d-flex gap-1 align-items-center">
                                @csrf
                                <input type="hidden" name="anggota_id" value="{{ $item->id }}">
                                <select name="status" class="form-select form-select-sm kehadiran-select" required style="width: 120px;">
                                    <option value="">- Pilih -</option>
                                    <option value="hadir" {{ $kehadiranStatus == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                    <option value="izin" {{ $kehadiranStatus == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                    <option value="sakit" {{ $kehadiranStatus == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                                    <option value="alpa" {{ $kehadiranStatus == 'alpa' ? 'selected' : '' }}>❌ Alpa</option>
                                    <option value="terlambat" {{ $kehadiranStatus == 'terlambat' ? 'selected' : '' }}>⏰ Terlambat</option>
                                </select>
                                <button type="submit" class="btn-save-kehadiran" title="Simpan Kehadiran">
                                    <i class="fas fa-save"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="badge bg-{{ $statusClass }}" style="font-size: 11px; padding: 4px 10px; display: inline-block;">
                                {{ $status }}
                            </span>
                            @if($kehadiranStatus != '-')
                                <span class="badge bg-{{ $statusColors[$kehadiranStatus] ?? 'secondary' }}" 
                                      style="font-size: 11px; padding: 4px 10px; margin-top: 2px; display: inline-block;">
                                    {{ $statusIcons[$kehadiranStatus] ?? '' }} {{ ucfirst($kehadiranStatus) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($nilai)
                            <button class="btn-detail" onclick="showDetail({{ $item->id }})" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-user-plus"></i></div>
                                <h6 class="empty-title">Belum ada anggota</h6>
                                <p class="empty-desc">Tambahkan anggota terlebih dahulu</p>
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
                <strong>Cara Input Nilai:</strong>
                <ul class="mb-0 mt-1">
                    <li>Masukkan nilai <strong>Hadir (20%)</strong>, <strong>Tugas (30%)</strong>, dan <strong>Ujian (50%)</strong> pada kolom Nilai</li>
                    <li>Total nilai otomatis dihitung dari bobot masing-masing</li>
                    <li>Klik tombol <strong>💾</strong> untuk menyimpan nilai</li>
                    <li>Pilih status kehadiran dan klik <strong>💾</strong> untuk menyimpan</li>
                    <li>Nilai akan otomatis dikonversi menjadi huruf (A-E)</li>
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

    .badge-nilai {
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        display: inline-block;
        min-width: 32px;
        text-align: center;
    }

    .badge-nilai.nilai-a { background: rgba(16, 185, 129, 0.08); color: #10b981; }
    .badge-nilai.nilai-b { background: rgba(59, 130, 246, 0.08); color: #3b82f6; }
    .badge-nilai.nilai-c { background: rgba(245, 158, 11, 0.08); color: #f59e0b; }
    .badge-nilai.nilai-d { background: rgba(239, 68, 68, 0.08); color: #ef4444; }
    .badge-nilai.nilai-e { background: rgba(0,0,0,0.03); color: #94a3b8; }

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

    .input-group-nilai {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1px;
    }

    .label-nilai {
        font-size: 8px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .input-nilai {
        font-size: 12px;
        padding: 2px 4px;
        border: 2px solid #e5e7eb;
        border-radius: 6px;
        background: #fafbfc;
        transition: all 0.3s ease;
        width: 60px;
        text-align: center;
    }

    .input-nilai:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
        outline: none;
        background: #ffffff;
    }

    .nilai-form {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        align-items: center;
    }

    .bobot-nilai {
        margin-top: 2px;
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        align-items: center;
    }

    .bobot-item {
        font-size: 9px;
        color: #94a3b8;
        background: #f1f5f9;
        padding: 1px 6px;
        border-radius: 4px;
    }

    .bobot-total {
        font-size: 10px;
        color: #0f172a;
        font-weight: 600;
    }

    .bobot-total strong {
        color: #4f46e5;
        font-size: 12px;
    }

    .btn-save-nilai {
        background: #6366f1;
        border: none;
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        height: 28px;
        align-self: flex-end;
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
        border-radius: 6px;
        font-size: 11px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        height: 28px;
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

    .btn-detail {
        background: transparent;
        border: none;
        color: #94a3b8;
        padding: 4px 8px;
        border-radius: 6px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-detail:hover {
        background: rgba(99, 102, 241, 0.06);
        color: #6366f1;
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
        margin-bottom: 4px;
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
        .input-nilai {
            width: 45px;
            font-size: 10px;
        }
        .btn-save-nilai, .btn-save-kehadiran {
            padding: 2px 6px;
            font-size: 10px;
            height: 24px;
        }
        .form-select-sm {
            font-size: 10px;
            padding: 2px 4px;
            width: 90px !important;
        }
        .card-header-modern {
            flex-direction: column;
            align-items: stretch;
        }
        .nilai-form {
            flex-direction: column;
            align-items: stretch;
        }
        .bobot-nilai {
            flex-wrap: wrap;
        }
        .label-nilai {
            font-size: 7px;
        }
    }
</style>

<script>
    function checkAllHadir() {
        document.querySelectorAll('.kehadiran-select').forEach(function(select) {
            select.value = 'hadir';
        });
    }

    function showDetail(id) {
        alert('Detail nilai untuk anggota ID: ' + id + '\nFitur detail akan segera hadir!');
    }
</script>
@endsection