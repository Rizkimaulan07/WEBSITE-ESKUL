@extends('layouts.app')

@section('title', 'Nilai Anggota')
@section('subtitle', 'Input nilai anggota')

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

<!-- Info Ekskul - Biru Cerah -->
<div class="card-modern mb-4" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-body-modern" style="padding: 16px 24px;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h6 class="fw-bold mb-0" style="color: #0f172a;">
                    <i class="fas fa-trophy me-2" style="color: #0ea5e9;"></i>
                    {{ $ekskul->nama_ekskul ?? 'Ekskul' }}
                </h6>
                <small class="text-muted" style="color: #94a3b8;">
                    Semester {{ $semester }} - Tahun Ajaran {{ $tahunAjaran }}
                </small>
            </div>
            <div>
                <a href="{{ route('pelatih.dashboard') }}" class="btn btn-secondary btn-sm" style="background: #f1f5f9; color: #64748b; border: none; border-radius: 8px; padding: 6px 16px; font-weight: 500; transition: all 0.3s ease; text-decoration: none;">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistik - Biru Cerah -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card blue" style="background: #ffffff; border-radius: 14px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; gap: 16px; align-items: flex-start;">
            <div class="stat-icon blue" style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; background: rgba(14,165,233,0.06); color: #0ea5e9;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Anggota</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 700; color: #0f172a; margin: 2px 0; letter-spacing: -0.5px;">{{ $anggotas->count() }}</h3>
                <span class="stat-change up" style="font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; background: rgba(16,185,129,0.06); color: #10b981;">
                    <i class="fas fa-user-check me-1"></i> Terdaftar
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card gold" style="background: #ffffff; border-radius: 14px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; gap: 16px; align-items: flex-start;">
            <div class="stat-icon gold" style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; background: rgba(245,158,11,0.06); color: #f59e0b;">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Nilai</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 700; color: #0f172a; margin: 2px 0; letter-spacing: -0.5px;">{{ $statistik['total'] ?? 0 }}</h3>
                <span class="stat-change up" style="font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; background: rgba(16,185,129,0.06); color: #10b981;">
                    <i class="fas fa-check-circle me-1"></i> Tercatat
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green" style="background: #ffffff; border-radius: 14px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; gap: 16px; align-items: flex-start;">
            <div class="stat-icon green" style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; background: rgba(16,185,129,0.06); color: #10b981;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Rata-rata</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 700; color: #0f172a; margin: 2px 0; letter-spacing: -0.5px;">{{ number_format($statistik['rata_rata'] ?? 0, 1) }}</h3>
                <span class="stat-change up" style="font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; background: rgba(16,185,129,0.06); color: #10b981;">
                    <i class="fas fa-arrow-up me-1"></i> Nilai
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card purple" style="background: #ffffff; border-radius: 14px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; gap: 16px; align-items: flex-start;">
            <div class="stat-icon purple" style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; background: rgba(139,92,246,0.06); color: #8b5cf6;">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Tertinggi / Terendah</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 700; color: #0f172a; margin: 2px 0; letter-spacing: -0.5px;">
                    {{ $statistik['tertinggi'] ?? 0 }}
                    <span style="font-size: 14px; color: #94a3b8;">/</span>
                    {{ $statistik['terendah'] ?? 0 }}
                </h3>
                <span class="stat-change up" style="font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; background: rgba(16,185,129,0.06); color: #10b981;">
                    <i class="fas fa-arrow-up me-1"></i> Max/Min
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Alert -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert" style="background: #d1fae5; border-left: 4px solid #10b981;">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
            <div>
                <strong style="color: #065f46;">Berhasil!</strong> 
                <span style="color: #047857;">{{ session('success') }}</span>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert" style="background: #fee2e2; border-left: 4px solid #ef4444;">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle fa-2x me-3 text-danger"></i>
            <div>
                <strong style="color: #991b1b;">Gagal!</strong> 
                <span style="color: #7f1d1d;">{{ session('error') }}</span>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Daftar Anggota dengan Input Nilai & Kehadiran -->
<div class="card-modern" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-header-modern" style="padding: 16px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe);">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
            <h6 style="font-weight: 600; font-size: 14px; color: #0f172a; margin: 0;">
                <i class="fas fa-list me-2" style="color: #0ea5e9;"></i>Daftar Anggota
            </h6>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="badge-soft" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 12px; font-size: 11px; font-weight: 500;">{{ $anggotas->count() }} anggota</span>
            </div>
        </div>
    </div>
    <div class="card-body-modern p-0" style="padding: 0;">
        <div class="table-responsive">
            <table class="table-modern" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th width="4%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">No</th>
                        <th width="18%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Nama Anggota</th>
                        <th width="8%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Kelas</th>
                        <th width="10%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Nilai</th>
                        <th width="22%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Nilai (0-100)</th>
                        <th width="18%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Status</th>
                        <th width="10%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotas as $index => $item)
                        @php
                            $nilai = $item->nilai ?? null;
                            $nilaiTotal = $nilai ? $nilai->nilai_total : 0;
                            // Konversi ke skala yang sesuai kebutuhan user: S = Sangat Baik, A = Baik, B = Cukup
                            if ($nilaiTotal >= 85) {
                                $nilaiHuruf = 'S';
                                $nilaiLabel = 'Sangat Baik';
                            } elseif ($nilaiTotal >= 70) {
                                $nilaiHuruf = 'A';
                                $nilaiLabel = 'Baik';
                            } elseif ($nilaiTotal >= 55) {
                                $nilaiHuruf = 'B';
                                $nilaiLabel = 'Cukup';
                            } else {
                                $nilaiHuruf = 'C';
                                $nilaiLabel = 'Perlu Perbaikan';
                            }
                            
                            $status = $nilai ? 'Sudah Dinilai' : 'Belum Dinilai';
                            $statusClass = $nilai ? 'success' : 'warning';

                            // Data untuk input
                            $nilaiKehadiran = $nilai ? $nilai->nilai_kehadiran : '';
                            $nilaiTugas = $nilai ? $nilai->nilai_tugas : '';
                            $nilaiUjian = $nilai ? $nilai->nilai_ujian : '';
                            $catatan = $nilai ? $nilai->catatan : '';
                        @endphp
                    <tr style="transition: all 0.3s ease;">
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.04); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $loop->iteration }}</span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle" style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 13px; flex-shrink: 0; box-shadow: 0 2px 12px rgba(14,165,233,0.15);">
                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="color: #0f172a;">{{ $item->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="badge-soft" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 12px; border-radius: 8px; font-size: 12px; font-weight: 500;">{{ $item->kelas ?? '-' }}</span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="badge-nilai 
                                {{ $nilaiHuruf == 'S' ? 'nilai-s' : 
                                   ($nilaiHuruf == 'A' ? 'nilai-a' : 
                                   ($nilaiHuruf == 'B' ? 'nilai-b' : 'nilai-c')) }}"
                                title="{{ $nilaiLabel }}"
                                style="padding: 4px 12px; border-radius: 8px; font-size: 14px; font-weight: 700; display: inline-block; min-width: 32px; text-align: center;
                                {{ $nilaiHuruf == 'S' ? 'background: rgba(16,185,129,0.12); color: #047857;' : 
                                   ($nilaiHuruf == 'A' ? 'background: rgba(14,165,233,0.10); color: #0284c7;' : 
                                   ($nilaiHuruf == 'B' ? 'background: rgba(245,158,11,0.10); color: #b45309;' : 
                                   'background: rgba(239,68,68,0.10); color: #b91c1c;')) }}">
                                {{ $nilaiHuruf }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <form action="{{ route('pelatih.nilai.store') }}" method="POST" class="nilai-form" style="display: flex; flex-wrap: wrap; gap: 4px; align-items: center;">
                                @csrf
                                <input type="hidden" name="anggota_id" value="{{ $item->id }}">
                                <div class="d-flex flex-wrap gap-1 align-items-center">
                                    <div class="input-group-nilai" style="display: flex; flex-direction: column; align-items: center; gap: 1px;">
                                        <label class="label-nilai" style="font-size: 8px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">Hadir</label>
                                        <input type="number" name="nilai_kehadiran" class="form-control form-control-sm input-nilai" 
                                               placeholder="0" min="0" max="100" step="0.01"
                                               value="{{ $nilaiKehadiran }}" 
                                               style="width: 60px; font-size: 12px; padding: 2px 4px; border: 2px solid #e5e7eb; border-radius: 6px; background: #fafbfc; transition: all 0.3s ease; text-align: center;">
                                    </div>
                                    <div class="input-group-nilai" style="display: flex; flex-direction: column; align-items: center; gap: 1px;">
                                        <label class="label-nilai" style="font-size: 8px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">Tugas</label>
                                        <input type="number" name="nilai_tugas" class="form-control form-control-sm input-nilai" 
                                               placeholder="0" min="0" max="100" step="0.01"
                                               value="{{ $nilaiTugas }}" 
                                               style="width: 60px; font-size: 12px; padding: 2px 4px; border: 2px solid #e5e7eb; border-radius: 6px; background: #fafbfc; transition: all 0.3s ease; text-align: center;">
                                    </div>
                                    <div class="input-group-nilai" style="display: flex; flex-direction: column; align-items: center; gap: 1px;">
                                        <label class="label-nilai" style="font-size: 8px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">Ujian</label>
                                        <input type="number" name="nilai_ujian" class="form-control form-control-sm input-nilai" 
                                               placeholder="0" min="0" max="100" step="0.01"
                                               value="{{ $nilaiUjian }}" 
                                               style="width: 60px; font-size: 12px; padding: 2px 4px; border: 2px solid #e5e7eb; border-radius: 6px; background: #fafbfc; transition: all 0.3s ease; text-align: center;">
                                    </div>
                                    <button type="submit" class="btn-save-nilai" title="Simpan Nilai" 
                                            style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; color: white; padding: 4px 8px; border-radius: 6px; font-size: 11px; transition: all 0.3s ease; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; height: 28px; align-self: flex-end; box-shadow: 0 2px 12px rgba(14,165,233,0.25);">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="catatan" value="{{ $catatan }}">
                            </form>
                            <div class="bobot-nilai" style="margin-top: 2px; display: flex; flex-wrap: wrap; gap: 4px; align-items: center;">
                                <small class="text-muted" style="color: #94a3b8;">
                                    <span class="bobot-item" style="font-size: 9px; color: #94a3b8; background: #f1f5f9; padding: 1px 6px; border-radius: 4px;">Hadir 20%</span>
                                    <span class="bobot-item" style="font-size: 9px; color: #94a3b8; background: #f1f5f9; padding: 1px 6px; border-radius: 4px;">Tugas 30%</span>
                                    <span class="bobot-item" style="font-size: 9px; color: #94a3b8; background: #f1f5f9; padding: 1px 6px; border-radius: 4px;">Ujian 50%</span>
                                    <span class="bobot-total" style="font-size: 10px; color: #0f172a; font-weight: 600;">Total: <strong style="color: #0ea5e9; font-size: 12px;">{{ number_format($nilaiTotal, 1) }}</strong></span>
                                </small>
                            </div>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="badge bg-{{ $statusClass }}" style="font-size: 11px; padding: 4px 10px; display: inline-block; {{ $statusClass == 'success' ? 'background: rgba(16,185,129,0.08); color: #10b981;' : 'background: rgba(245,158,11,0.08); color: #f59e0b;' }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; text-align: center;">
                            @if($nilai)
                            <button class="btn-detail" onclick="showDetail({{ $item->id }})" title="Lihat Detail" 
                                    style="background: transparent; border: none; color: #94a3b8; padding: 4px 8px; border-radius: 6px; transition: all 0.3s ease; cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding: 12px 16px; text-align: center;">
                            <div class="empty-state" style="padding: 40px 0; text-align: center;">
                                <div class="empty-icon" style="font-size: 56px; color: #d1d5db; margin-bottom: 16px; opacity: 0.5;"><i class="fas fa-user-plus"></i></div>
                                <h6 class="empty-title" style="font-weight: 600; color: #0f172a; margin-bottom: 4px;">Belum ada anggota</h6>
                                <p class="empty-desc" style="color: #94a3b8; font-size: 13px; margin-bottom: 4px;">Tambahkan anggota terlebih dahulu</p>
                                <a href="{{ route('admin.anggota.create') }}" class="btn-primary-gradient mt-2" target="_blank" 
                                   style="padding: 10px 24px; border: none; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 13px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 4px 16px rgba(14,165,233,0.25);">
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
    <div class="alert alert-info rounded-4 border-0 shadow-sm" style="background: #f0f9ff; border-left: 4px solid #0ea5e9;">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="bg-info bg-opacity-10 rounded-circle p-2" style="background: rgba(14,165,233,0.08);">
                <i class="fas fa-info-circle fa-2x" style="color: #0ea5e9;"></i>
            </div>
            <div>
                <strong style="color: #0c4a6e;">Cara Input Nilai:</strong>
                <ul class="mb-0 mt-1" style="color: #0c4a6e;">
                    <li>Masukkan nilai <strong>Hadir (20%)</strong>, <strong>Tugas (30%)</strong>, dan <strong>Ujian (50%)</strong> pada kolom Nilai</li>
                    <li>Total nilai otomatis dihitung dari bobot masing-masing</li>
                    <li>Skala penilaian: <strong>S</strong> = Sangat Baik, <strong>A</strong> = Baik, <strong>B</strong> = Cukup</li>
                    <li>Klik tombol <strong>💾</strong> untuk menyimpan nilai</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    .stat-card:hover { transform: translateY(-6px); box-shadow: 0 12px 40px rgba(14,165,233,0.08); }
    .stat-card:hover .stat-icon { transform: scale(1.05) rotate(-2deg); }
    .table-modern tbody tr:hover { background: rgba(14,165,233,0.015); }
    .input-nilai:focus { border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14,165,233,0.08); outline: none; background: #ffffff; }
    .btn-save-nilai:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(14,165,233,0.35); }
    .btn-detail:hover { background: rgba(14,165,233,0.06); color: #0ea5e9; transform: translateY(-2px); }
    .btn-primary-gradient:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(14,165,233,0.35); color: #fff; text-decoration: none; }

    @media (max-width: 768px) {
        .stat-card { padding: 16px 18px; }
        .stat-card .stat-number { font-size: 22px; }
        .card-body-modern { padding: 14px 16px; }
        .table-modern { font-size: 12px; }
        .input-nilai { width: 45px; font-size: 10px; }
        .btn-save-nilai { padding: 2px 6px; font-size: 10px; height: 24px; }
        .card-header-modern { flex-direction: column; align-items: stretch; }
        .nilai-form { flex-direction: column; align-items: stretch; }
        .bobot-nilai { flex-wrap: wrap; }
        .label-nilai { font-size: 7px; }
    }
</style>

<script>
    function showDetail(id) {
        alert('Detail nilai untuk anggota ID: ' + id + '\nFitur detail akan segera hadir!');
    }
</script>
@endsection