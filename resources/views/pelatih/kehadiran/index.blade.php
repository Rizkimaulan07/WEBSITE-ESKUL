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

<!-- Header -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header border-0 py-4 px-5" 
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="fas fa-clipboard-list fa-2x text-white"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-0">Kehadiran Anggota</h4>
                    <p class="text-white-50 mb-0 small">
                        <i class="far fa-calendar-alt me-2"></i>
                        {{ $hariIni }}, {{ $tanggal }} {{ $bulanIni }} {{ $tahun }}
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-light rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
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
<div class="card-modern mb-4">
    <div class="card-body-modern">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-trophy text-primary me-2"></i>
                    {{ $ekskul->nama_ekskul ?? 'Ekskul' }}
                </h6>
                <small class="text-muted">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ $hariIni }}, {{ $tanggal }} {{ $bulanIni }} {{ $tahun }}
                </small>
            </div>
            <div class="d-flex gap-2">
                <span class="badge-soft">
                    <i class="far fa-clock me-1"></i>
                    {{ now()->format('H:i') }} WIB
                </span>
                <a href="{{ route('pelatih.kehadiran.rekap') }}" class="btn btn-primary btn-sm rounded-pill">
                    <i class="fas fa-chart-bar me-1"></i> Rekap
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Form Kehadiran -->
<div class="card-modern">
    <div class="card-header-modern">
        <h6><i class="fas fa-check-circle me-2" style="color: #6366f1;"></i>Input Kehadiran Hari Ini</h6>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn-check-all" onclick="checkAll()">
                <i class="fas fa-check-double me-1"></i> Hadir Semua
            </button>
            <button type="button" class="btn-uncheck-all" onclick="uncheckAll()">
                <i class="fas fa-times me-1"></i> Reset
            </button>
            <span class="badge-soft" id="totalHadir">
                <i class="fas fa-user-check me-1"></i> 
                <span id="hadirCount">0</span> hadir
            </span>
        </div>
    </div>
    <div class="card-body-modern">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
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
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fa-2x me-3 text-danger"></i>
                    <div>
                        <strong>Gagal!</strong> {{ session('error') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('pelatih.kehadiran.store') }}" method="POST" id="kehadiranForm">
            @csrf
            <input type="hidden" name="tanggal" value="{{ today()->format('Y-m-d') }}">

            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Nama Anggota</th>
                            <th width="15%">Kelas</th>
                            <th width="25%">Status</th>
                            <th width="30%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $index => $a)
                        @php
                            $kehadiran = $kehadiranHariIni[$a->id] ?? null;
                            $status = $kehadiran ? $kehadiran->status : 'alpa';
                            $isChecked = $status == 'hadir';
                        @endphp
                        <tr>
                            <td>
                                <span class="number-badge">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($a->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $a->name }}</div>
                                        <small class="text-muted">ID: {{ $a->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-soft">{{ $a->kelas ?? '-' }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" 
                                               name="anggota_ids[]" value="{{ $a->id }}"
                                               id="hadir_{{ $a->id }}"
                                               {{ $isChecked ? 'checked' : '' }}
                                               data-id="{{ $a->id }}"
                                               onchange="toggleStatus(this)">
                                        <label class="form-check-label" for="hadir_{{ $a->id }}">
                                            <span class="badge-custom active">✔ Hadir</span>
                                        </label>
                                    </div>
                                    <select class="form-select form-select-sm status-select" 
                                            name="status[{{ $a->id }}]"
                                            id="status_{{ $a->id }}"
                                            style="width: 100px;"
                                            {{ $isChecked ? 'disabled' : '' }}>
                                        <option value="hadir" {{ $status == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                        <option value="izin" {{ $status == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                        <option value="sakit" {{ $status == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                                        <option value="alpa" {{ $status == 'alpa' ? 'selected' : '' }}>❌ Alpa</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" 
                                       name="keterangan[{{ $a->id }}]"
                                       placeholder="Contoh: Izin keluarga, Sakit, dll"
                                       value="{{ $kehadiran ? $kehadiran->keterangan : '' }}">
                                <small class="text-muted d-block mt-1">Keterangan opsional</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox me-2"></i>Belum ada anggota
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-4">
                <a href="{{ route('pelatih.dashboard') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i> Simpan Kehadiran
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .badge-custom { padding: 2px 12px; border-radius: 12px; font-size: 11px; font-weight: 500; }
    .badge-custom.active { background: rgba(16, 185, 129, 0.08); color: #10b981; }
    .badge-soft { background: rgba(99, 102, 241, 0.05); color: #6366f1; padding: 2px 14px; border-radius: 12px; font-size: 11px; font-weight: 500; }
    
    .stat-card { background: #ffffff; border-radius: 14px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden; }
    .stat-card:hover { transform: translateY(-6px); box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08); }
    .stat-card .stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
    .stat-card:hover .stat-icon { transform: scale(1.05) rotate(-2deg); }
    .stat-card .stat-icon.blue { background: rgba(99, 102, 241, 0.06); color: #6366f1; }
    .stat-card .stat-icon.gold { background: rgba(245, 158, 11, 0.06); color: #f59e0b; }
    .stat-card .stat-icon.green { background: rgba(16, 185, 129, 0.06); color: #10b981; }
    .stat-card .stat-body { flex: 1; }
    .stat-card .stat-label { font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-card .stat-number { font-size: 28px; font-weight: 700; color: #0f172a; margin: 2px 0; letter-spacing: -0.5px; }
    .stat-change { font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; }
    .stat-change.up { background: rgba(16, 185, 129, 0.06); color: #10b981; }
    .stat-progress { position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: rgba(0,0,0,0.03); }
    .stat-progress .progress-bar { height: 100%; border-radius: 0; transition: width 0.6s ease; }
    .stat-card.blue .progress-bar { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .stat-card.gold .progress-bar { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-card.green .progress-bar { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-meta { margin-top: 8px; }
    
    .card-modern { background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; }
    .card-body-modern { padding: 20px 24px; }
    .card-header-modern { padding: 16px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: rgba(248, 250, 252, 0.3); }
    .card-header-modern h6 { font-weight: 600; font-size: 14px; color: #0f172a; margin: 0; }
    
    .table-modern { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-modern thead th { background: rgba(248, 250, 252, 0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left; }
    .table-modern tbody td { padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; }
    .table-modern tbody tr:hover { background: rgba(99, 102, 241, 0.012); }
    
    .number-badge { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(99, 102, 241, 0.04); color: #6366f1; font-weight: 600; font-size: 12px; }
    .avatar-circle { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #6366f1, #4f46e5); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 13px; flex-shrink: 0; box-shadow: 0 2px 12px rgba(99, 102, 241, 0.15); }
    
    .btn-check-all { padding: 8px 18px; border: none; border-radius: 8px; background: rgba(16, 185, 129, 0.06); color: #10b981; font-size: 12px; font-weight: 500; transition: all 0.3s ease; cursor: pointer; }
    .btn-check-all:hover { background: rgba(16, 185, 129, 0.12); transform: translateY(-2px); }
    .btn-uncheck-all { padding: 8px 18px; border: none; border-radius: 8px; background: rgba(239, 68, 68, 0.06); color: #ef4444; font-size: 12px; font-weight: 500; transition: all 0.3s ease; cursor: pointer; }
    .btn-uncheck-all:hover { background: rgba(239, 68, 68, 0.12); transform: translateY(-2px); }
    
    .btn-cancel { padding: 10px 32px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; background: transparent; color: #64748b; font-size: 14px; font-weight: 500; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-cancel:hover { background: #f8fafc; transform: translateY(-2px); color: #0f172a; text-decoration: none; }
    .btn-submit { padding: 10px 40px; border: none; border-radius: 10px; background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; font-size: 14px; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; cursor: pointer; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(99, 102, 241, 0.35); }
    
    .form-check-input { width: 18px; height: 18px; cursor: pointer; border-radius: 4px; border: 2px solid #d1d5db; transition: all 0.2s ease; }
    .form-check-input:checked { background-color: #10b981; border-color: #10b981; }
    .form-check-input:focus { box-shadow: none; }
    .form-check-label { cursor: pointer; font-size: 13px; }
    
    .status-select { padding: 4px 8px; border: 1px solid rgba(0,0,0,0.04); border-radius: 6px; font-size: 12px; background: #f8fafc; transition: all 0.3s ease; }
    .status-select:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.04); }
    .status-select:disabled { opacity: 0.5; cursor: not-allowed; }
    
    .form-control-sm { padding: 6px 12px; border: 1px solid rgba(0,0,0,0.04); border-radius: 6px; font-size: 12px; background: #f8fafc; transition: all 0.3s ease; width: 100%; }
    .form-control-sm:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.04); background: #ffffff; }
    
    .alert { border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; }
    .alert .btn-close { padding: 12px; }

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