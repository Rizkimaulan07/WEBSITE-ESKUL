@extends('layouts.app')

@section('title', 'Nilai Anggota')
@section('subtitle', 'Input nilai anggota')

@section('content')
<!-- Info Ekskul - Biru Cerah -->
<div class="card-modern mb-4" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-body-modern" style="padding: 16px 24px;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h6 class="fw-bold mb-0" style="color: #0f172a;">
                    <i class="fas fa-trophy me-2" style="color: #0ea5e9;"></i>
                    {{ $ekskul->nama_ekskul ?? 'Ekskul' }}
                </h6>
                <small class="text-muted" style="color: #64748b;">
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
                <span class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Anggota</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 700; color: #0f172a; margin: 2px 0; letter-spacing: -0.5px;">{{ $anggotas->count() }}</h3>
                <span class="stat-change up" style="font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; background: rgba(16,185,129,0.06); color: #10b981;">
                    <i class="fas fa-user-check me-1"></i>Terdaftar
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card blue" style="background: #ffffff; border-radius: 14px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; gap: 16px; align-items: flex-start;">
            <div class="stat-icon blue" style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; background: rgba(14,165,233,0.06); color: #0ea5e9;">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Penilaian Sangat Baik (S)</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 700; color: #047857; margin: 2px 0; letter-spacing: -0.5px;">{{ $statistik['s'] ?? 0 }}</h3>
                <span class="stat-change up" style="font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; background: rgba(16,185,129,0.06); color: #10b981;">
                    <i class="fas fa-check-circle me-1"></i> S = Sangat Baik
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card blue" style="background: #ffffff; border-radius: 14px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; gap: 16px; align-items: flex-start;">
            <div class="stat-icon blue" style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; background: rgba(14,165,233,0.06); color: #0ea5e9;">
                <i class="fas fa-star-half-alt"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Penilaian Baik (A)</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 700; color: #0284c7; margin: 2px 0; letter-spacing: -0.5px;">{{ $statistik['a'] ?? 0 }}</h3>
                <span class="stat-change up" style="font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; background: rgba(14,165,233,0.06); color: #0ea5e9;">
                    <i class="fas fa-check-circle me-1"></i> A = Baik
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card blue" style="background: #ffffff; border-radius: 14px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; gap: 16px; align-items: flex-start;">
            <div class="stat-icon blue" style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; background: rgba(245,158,11,0.06); color: #f59e0b;">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-body" style="flex: 1;">
                <span class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Penilaian Cukup (B)</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 700; color: #b45309; margin: 2px 0; letter-spacing: -0.5px;">{{ $statistik['b'] ?? 0 }}</h3>
                <span class="stat-change up" style="font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; background: rgba(245,158,11,0.06); color: #f59e0b;">
                    <i class="fas fa-check-circle me-1"></i> B = Cukup
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Anggota dengan Input Nilai -->
<div class="card-modern" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-header-modern" style="padding: 16px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe);">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
            <h6 style="font-weight: 600; font-size: 14px; color: #0f172a; margin: 0;">
                <i class="fas fa-list me-2" style="color: #0ea5e9;"></i>Daftar Anggota
            </h6>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="badge-soft" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 12px; font-size: 11px; font-weight: 500;">{{ $anggotas->count() }} anggota</span>
                <a href="{{ route('pelatih.nilai.export') }}" class="btn btn-success btn-sm" style="background: linear-gradient(135deg, #10b981, #34d399); border: none; padding: 6px 16px; border-radius: 10px; color: #fff; font-weight: 500; font-size: 12px; box-shadow: 0 2px 12px rgba(16,185,129,0.25); text-decoration: none;">
                    <i class="fas fa-download me-1"></i> Unduh File
                </a>
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
                        <th width="10%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Predikat</th>
                        <th width="22%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Input Nilai (S/A/B)</th>
                        <th width="28%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Keterangan</th>
                        <th width="10%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotas as $index => $item)
                        @php
                            $nilai = $item->nilai ?? null;
                            $predikat = $nilai ? $nilai->predikat : null;
                            $predikatLabel = $nilai ? $nilai->predikat_label : null;
                            $catatan = $nilai ? $nilai->catatan : '';
                            
                            switch ($predikat) {
                                case 'S':
                                    $predikatBg = 'rgba(16,185,129,0.12)';
                                    $predikatColor = '#047857';
                                    break;
                                case 'A':
                                    $predikatBg = 'rgba(14,165,233,0.10)';
                                    $predikatColor = '#0284c7';
                                    break;
                                case 'B':
                                    $predikatBg = 'rgba(245,158,11,0.10)';
                                    $predikatColor = '#b45309';
                                    break;
                                default:
                                    $predikatBg = 'rgba(100,116,139,0.08)';
                                    $predikatColor = '#64748b';
                            }
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
                            @if($predikat)
                                <span class="badge-nilai" style="padding: 4px 12px; border-radius: 8px; font-size: 15px; font-weight: 800; display: inline-block; min-width: 34px; text-align: center; background: {{ $predikatBg }}; color: {{ $predikatColor }};">
                                    {{ $predikat }}
                                </span>
                                <small class="d-block mt-1" style="font-size: 11px; font-weight: 600; color: {{ $predikatColor }};">{{ $predikatLabel }}</small>
                            @else
                                <span class="badge-soft" style="background: rgba(245,158,11,0.08); color: #f59e0b; padding: 4px 10px; border-radius: 8px; font-size: 11px;">Belum dinilai</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <form action="{{ route('pelatih.nilai.store') }}" method="POST" class="nilai-form">
                                @csrf
                                <input type="hidden" name="anggota_id" value="{{ $item->id }}">
                                <select name="predikat" class="form-control form-control-sm select-nilai" required
                                        style="width: 70px; font-size: 13px; padding: 4px 6px; border: 2px solid #e5e7eb; border-radius: 6px; background: #fafbfc; transition: all 0.3s ease; display: inline-block;">
                                    <option value="" disabled {{ !$predikat ? 'selected' : '' }}>-</option>
                                    <option value="S" {{ $predikat == 'S' ? 'selected' : '' }}>S - Sangat Baik</option>
                                    <option value="A" {{ $predikat == 'A' ? 'selected' : '' }}>A - Baik</option>
                                    <option value="B" {{ $predikat == 'B' ? 'selected' : '' }}>B - Cukup</option>
                                </select>
                                <button type="submit" class="btn-save-nilai btn-primary-gradient" title="Simpan Nilai" 
                                        style="padding: 4px 10px; border-radius: 6px; font-size: 11px; height: 28px; margin-left: 4px;">
                                    <i class="fas fa-save"></i>
                                </button>
                            </form>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <form action="{{ route('pelatih.nilai.store') }}" method="POST" class="catatan-form">
                                @csrf
                                <input type="hidden" name="anggota_id" value="{{ $item->id }}">
                                @if($predikat)
                                    <input type="hidden" name="predikat" value="{{ $predikat }}">
                                @endif
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" name="catatan" class="form-control form-control-sm input-catatan" 
                                           placeholder="Keterangan / catatan (opsional)" value="{{ $catatan }}"
                                           style="font-size: 12px; padding: 4px 8px; border: 2px solid #e5e7eb; border-radius: 6px; background: #fafbfc; transition: all 0.3s ease;">
                                    <button type="submit" class="btn-save-nilai" title="Simpan Keterangan" 
                                            style="background: #f1f5f9; border: none; color: #64748b; padding: 4px 10px; border-radius: 6px; font-size: 11px; transition: all 0.3s ease; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; height: 28px; flex-shrink: 0;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; text-align: center;">
                            <span class="badge" style="font-size: 11px; padding: 4px 10px; display: inline-block; {{ $predikat ? 'background: rgba(16,185,129,0.08); color: #10b981;' : 'background: rgba(245,158,11,0.08); color: #f59e0b;' }}">
                                {{ $predikat ? 'Sudah Dinilai' : 'Belum Dinilai' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding: 12px 16px; text-align: center;">
                            <div class="empty-state" style="padding: 40px 0; text-align: center;">
                                <div class="empty-icon" style="font-size: 56px; color: #d1d5db; margin-bottom: 16px; opacity: 0.5;"><i class="fas fa-user-plus"></i></div>
                                <h6 class="empty-title" style="font-weight: 600; color: #0f172a; margin-bottom: 4px;">Belum ada anggota</h6>
                                <p class="empty-desc" style="color: #64748b; font-size: 13px; margin-bottom: 4px;">Tambahkan anggota terlebih dahulu</p>
                                <a href="{{ route('admin.anggota.create') }}" class="btn-primary-gradient mt-2" target="_blank" 
                                   style="padding: 10px 24px; font-size: 13px; font-weight: 600;">
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
                    <li>Pilih predikat pada kolom <strong>Input Nilai (S/A/B)</strong>: <strong>S</strong> = Sangat Baik, <strong>A</strong> = Baik, <strong>B</strong> = Cukup</li>
                    <li>Isi <strong>Keterangan</strong> (opsional) sebagai catatan penilaian</li>
                    <li>Klik tombol <strong>💾</strong> untuk menyimpan nilai; nilai langsung terlihat anggota</li>
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
    .select-nilai:focus, .input-catatan:focus { border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14,165,233,0.08); outline: none; background: #ffffff; }
    .btn-save-nilai:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(14,165,233,0.35); }
    .btn-primary-gradient:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(14,165,233,0.35); color: #fff; text-decoration: none; }

    @media (max-width: 768px) {
        .stat-card { padding: 16px 18px; }
        .stat-card .stat-number { font-size: 22px; }
        .card-body-modern { padding: 14px 16px; }
        .table-modern { font-size: 12px; }
        .select-nilai { width: 100%; }
        .nilai-form { width: 100%; }
        .card-header-modern { flex-direction: column; align-items: stretch; }
    }
</style>
@endsection