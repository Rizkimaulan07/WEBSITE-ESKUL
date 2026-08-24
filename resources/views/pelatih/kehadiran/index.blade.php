@extends('layouts.app')

@section('title', 'Kehadiran Anggota')
@section('subtitle', 'Input kehadiran anggota ekstrakurikuler')

@section('content')
@php
    $statusColors = [
        'hadir' => 'success',
        'izin' => 'warning',
        'sakit' => 'danger',
        'alpa' => 'secondary'
    ];

    $hari = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    $bulan = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    ];

    $hariIni = $hari[date('l')];
    $tanggal = date('d');
    $bulanIni = $bulan[date('F')];
    $tahun = date('Y');
@endphp

<!-- Header - Biru Cerah -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header border-0 py-4 px-5" 
         style="background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 30%, #38bdf8 60%, #7dd3fc 100%);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-4">
                <div class="bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="fas fa-clipboard-list fa-2x text-white"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Kehadiran Anggota</h4>
                    <p class="text-white-50 mb-0 small" style="font-weight: 400;">
                        <i class="far fa-calendar-alt me-2"></i>
                        {{ $hariIni }}, {{ $tanggal }} {{ $bulanIni }} {{ $tahun }}
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-light rounded-pill px-4" style="border-color: rgba(255,255,255,0.2);">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards - Biru Cerah -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card blue">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Anggota</span>
                <h3 class="stat-number">{{ $anggota->count() ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-user-check me-1"></i> Terdaftar
                </span>
            </div>
            <div class="stat-progress">
                <div class="progress-bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card gold">
            <div class="stat-icon gold">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Kehadiran Bulan Ini</span>
                <h3 class="stat-number">{{ $statistik['total'] ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-check-circle me-1"></i> Total
                </span>
            </div>
            <div class="stat-meta">
                <span class="badge-soft">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ $bulanIni }} {{ $tahun }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Hadir Bulan Ini</span>
                <h3 class="stat-number">{{ $statistik['hadir'] ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-arrow-up me-1"></i> 
                    {{ ($statistik['total'] ?? 0) > 0 ? round((($statistik['hadir'] ?? 0) / ($statistik['total'] ?? 1)) * 100) : 0 }}%
                </span>
            </div>
            <div class="stat-meta">
                <span class="badge-soft">
                    <i class="fas fa-percent me-1"></i>
                    Persentase kehadiran
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Info Ekskul & Button -->
<div class="card-modern mb-4" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-body-modern" style="padding: 16px 24px;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h6 class="fw-bold mb-0" style="color: #0f172a;">
                    <i class="fas fa-trophy me-2" style="color: #0ea5e9;"></i>
                    {{ $ekskul->nama_ekskul ?? 'Ekskul' }}
                </h6>
                <small class="text-muted" style="color: #94a3b8;">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ $hariIni }}, {{ $tanggal }} {{ $bulanIni }} {{ $tahun }}
                </small>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <span class="badge-soft" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 4px 14px; border-radius: 12px; font-size: 12px; font-weight: 500;">
                    <i class="far fa-clock me-1"></i>
                    {{ now()->format('H:i') }} WIB
                </span>
                <a href="{{ route('pelatih.kehadiran.rekap') }}" class="btn btn-primary btn-sm rounded-pill" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; box-shadow: 0 4px 16px rgba(14,165,233,0.25);">
                    <i class="fas fa-chart-bar me-1"></i> Rekap
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Form Kehadiran -->
<div class="card-modern" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-header-modern" style="padding: 16px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe);">
        <h6 style="font-weight: 600; font-size: 14px; color: #0f172a; margin: 0;">
            <i class="fas fa-check-circle me-2" style="color: #0ea5e9;"></i>Input Kehadiran Hari Ini
        </h6>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn-check-all" onclick="checkAll()" style="padding: 8px 18px; border: none; border-radius: 8px; background: rgba(16,185,129,0.08); color: #10b981; font-size: 12px; font-weight: 500; transition: all 0.3s ease; cursor: pointer;">
                <i class="fas fa-check-double me-1"></i> Hadir Semua
            </button>
            <button type="button" class="btn-uncheck-all" onclick="uncheckAll()" style="padding: 8px 18px; border: none; border-radius: 8px; background: rgba(239,68,68,0.06); color: #ef4444; font-size: 12px; font-weight: 500; transition: all 0.3s ease; cursor: pointer;">
                <i class="fas fa-times me-1"></i> Reset
            </button>
            <span class="badge-soft" id="totalHadir" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 4px 14px; border-radius: 12px; font-size: 12px; font-weight: 500;">
                <i class="fas fa-user-check me-1"></i> 
                <span id="hadirCount">0</span> hadir
            </span>
        </div>
    </div>
    <div class="card-body-modern" style="padding: 24px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert" style="background: #d1fae5; border-left: 4px solid #10b981;">
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
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert" style="background: #fee2e2; border-left: 4px solid #ef4444;">
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

        <form action="{{ route('pelatih.kehadiran.store') }}" method="POST" id="kehadiranForm">
            @csrf
            <input type="hidden" name="tanggal" value="{{ today()->format('Y-m-d') }}">

            <div class="table-responsive">
                <table class="table-modern" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr>
                            <th width="5%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">No</th>
                            <th width="25%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Nama Anggota</th>
                            <th width="15%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Kelas</th>
                            <th width="25%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Status</th>
                            <th width="30%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $index => $a)
                        @php
                            $kehadiran = $kehadiranHariIni[$a->id] ?? null;
                            $status = $kehadiran ? $kehadiran->status : 'alpa';
                            $isChecked = $status == 'hadir';
                        @endphp
                        <tr style="transition: all 0.3s ease;">
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.04); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $index + 1 }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle" style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 13px; flex-shrink: 0; box-shadow: 0 2px 12px rgba(14,165,233,0.15);">
                                        {{ strtoupper(substr($a->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color: #0f172a;">{{ $a->name }}</div>
                                        <small class="text-muted" style="color: #94a3b8;">ID: {{ $a->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="badge-soft" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 12px; border-radius: 8px; font-size: 12px; font-weight: 500;">{{ $a->kelas ?? '-' }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" 
                                               name="anggota_ids[]" value="{{ $a->id }}"
                                               id="hadir_{{ $a->id }}"
                                               {{ $isChecked ? 'checked' : '' }}
                                               data-id="{{ $a->id }}"
                                               onchange="toggleStatus(this)"
                                               style="width: 18px; height: 18px; cursor: pointer; border-radius: 4px; border: 2px solid #d1d5db; transition: all 0.2s ease; accent-color: #0ea5e9;">
                                        <label class="form-check-label" for="hadir_{{ $a->id }}" style="cursor: pointer; font-size: 13px;">
                                            <span class="badge-custom active" style="padding: 2px 12px; border-radius: 12px; font-size: 11px; font-weight: 500; background: rgba(16,185,129,0.08); color: #10b981;">✔ Hadir</span>
                                        </label>
                                    </div>
                                    <select class="form-select form-select-sm status-select" 
                                            name="status[{{ $a->id }}]"
                                            id="status_{{ $a->id }}"
                                            style="width: 100px; padding: 4px 8px; border: 1px solid rgba(0,0,0,0.04); border-radius: 6px; font-size: 12px; background: #f8fafc; transition: all 0.3s ease;"
                                            {{ $isChecked ? 'disabled' : '' }}>
                                        <option value="hadir" {{ $status == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                        <option value="izin" {{ $status == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                        <option value="sakit" {{ $status == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                                        <option value="alpa" {{ $status == 'alpa' ? 'selected' : '' }}>❌ Alpa</option>
                                    </select>
                                </div>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <input type="text" class="form-control form-control-sm" 
                                       name="keterangan[{{ $a->id }}]"
                                       placeholder="Contoh: Izin keluarga, Sakit, dll"
                                       value="{{ $kehadiran ? $kehadiran->keterangan : '' }}"
                                       style="padding: 6px 12px; border: 1px solid rgba(0,0,0,0.04); border-radius: 6px; font-size: 12px; background: #f8fafc; transition: all 0.3s ease; width: 100%;">
                                <small class="text-muted d-block mt-1" style="color: #94a3b8; font-size: 11px;">Keterangan opsional</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted" style="padding: 12px 16px; text-align: center; color: #94a3b8;">
                                <i class="fas fa-inbox me-2"></i>Belum ada anggota
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-4">
                <a href="{{ route('pelatih.dashboard') }}" class="btn-cancel" style="padding: 10px 32px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; background: transparent; color: #64748b; font-size: 14px; font-weight: 500; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                </a>
                <button type="submit" class="btn-submit" style="padding: 10px 40px; border: none; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 14px; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; cursor: pointer; box-shadow: 0 4px 16px rgba(14,165,233,0.25);">
                    <i class="fas fa-save me-2"></i> Simpan Kehadiran
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .badge-soft { background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 12px; font-size: 11px; font-weight: 500; }
    
    .stat-card { background: #ffffff; border-radius: 14px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden; }
    .stat-card:hover { transform: translateY(-6px); box-shadow: 0 12px 40px rgba(14,165,233,0.08); }
    .stat-card .stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
    .stat-card:hover .stat-icon { transform: scale(1.05) rotate(-2deg); }
    .stat-card .stat-icon.blue { background: rgba(14,165,233,0.06); color: #0ea5e9; }
    .stat-card .stat-icon.gold { background: rgba(245,158,11,0.06); color: #f59e0b; }
    .stat-card .stat-icon.green { background: rgba(16,185,129,0.06); color: #10b981; }
    .stat-card .stat-body { flex: 1; }
    .stat-card .stat-label { font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-card .stat-number { font-size: 28px; font-weight: 700; color: #0f172a; margin: 2px 0; letter-spacing: -0.5px; }
    .stat-change { font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; }
    .stat-change.up { background: rgba(16,185,129,0.06); color: #10b981; }
    .stat-progress { position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: rgba(0,0,0,0.03); }
    .stat-progress .progress-bar { height: 100%; border-radius: 0; transition: width 0.6s ease; }
    .stat-card.blue .progress-bar { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }
    .stat-card.gold .progress-bar { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-card.green .progress-bar { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-meta { margin-top: 8px; }
    
    .table-modern tbody tr:hover { background: rgba(14,165,233,0.015); }
    .btn-check-all:hover { background: rgba(16,185,129,0.12); transform: translateY(-2px); }
    .btn-uncheck-all:hover { background: rgba(239,68,68,0.12); transform: translateY(-2px); }
    .btn-cancel:hover { background: #f8fafc; transform: translateY(-2px); color: #0f172a; text-decoration: none; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(14,165,233,0.35); }
    .form-check-input:checked { background-color: #10b981; border-color: #10b981; }
    .form-check-input:focus { box-shadow: none; }
    .status-select:focus { outline: none; border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14,165,233,0.04); }
    .status-select:disabled { opacity: 0.5; cursor: not-allowed; }
    .form-control-sm:focus { outline: none; border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14,165,233,0.04); background: #ffffff; }
    
    @media (max-width: 768px) {
        .stat-card { padding: 16px 18px; }
        .stat-card .stat-number { font-size: 22px; }
        .card-header-modern { flex-direction: column; align-items: stretch; padding: 14px 16px; }
        .card-body-modern { padding: 14px 16px; }
        .table-modern { font-size: 12px; }
        .btn-cancel, .btn-submit { width: 100%; justify-content: center; }
        .d-flex.justify-content-end { flex-direction: column; }
    }
</style>

<script>
    function checkAll() {
        var checkboxes = document.querySelectorAll('input[name="anggota_ids[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = true;
            toggleStatus(checkboxes[i]);
        }
        updateHadirCount();
    }

    function uncheckAll() {
        var checkboxes = document.querySelectorAll('input[name="anggota_ids[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
            toggleStatus(checkboxes[i]);
        }
        updateHadirCount();
    }

    function toggleStatus(checkbox) {
        var id = checkbox.getAttribute('data-id');
        var statusSelect = document.getElementById('status_' + id);
        if (checkbox.checked) {
            statusSelect.disabled = true;
            statusSelect.value = 'hadir';
        } else {
            statusSelect.disabled = false;
            if (statusSelect.value === 'hadir') {
                statusSelect.value = 'izin';
            }
        }
        updateHadirCount();
    }

    function updateHadirCount() {
        var count = document.querySelectorAll('input[name="anggota_ids[]"]:checked').length;
        var hadirElement = document.getElementById('hadirCount');
        if (hadirElement) {
            hadirElement.textContent = count;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var checkboxes = document.querySelectorAll('input[name="anggota_ids[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            toggleStatus(checkboxes[i]);
        }
        updateHadirCount();
    });
</script>
@endsection