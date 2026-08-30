@extends('layouts.app')

@section('title', 'Kehadiran Pelatih')
@section('subtitle', 'Rekap kehadiran pelatih di semua ekskul')

@push('styles')
<style>
    .card-modern {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(14,165,233,0.06);
        border: 1px solid rgba(14,165,233,0.04);
        transition: all 0.3s ease;
    }
    .card-modern:hover { box-shadow: 0 8px 30px rgba(14,165,233,0.08); }
    .card-body-modern { padding: 24px 28px; }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 12px rgba(14,165,233,0.06);
        border: 1px solid rgba(14,165,233,0.04);
        transition: all 0.3s ease;
        height: 100%;
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(14,165,233,0.10); }
    .stat-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }
    .stat-icon.blue { background: #f0f9ff; color: #0ea5e9; }
    .stat-icon.green { background: #ecfdf5; color: #10b981; }
    .stat-icon.gold { background: #fffbeb; color: #f59e0b; }
    .stat-icon.red { background: #fef2f2; color: #ef4444; }
    .stat-icon.slate { background: #f1f5f9; color: #64748b; }
    .stat-body { flex: 1; min-width: 0; }
    .stat-label { font-size: 13px; color: #6b7280; font-weight: 500; display: block; margin-bottom: 4px; }
    .stat-number { font-size: 28px; font-weight: 700; color: #111827; margin: 0; line-height: 1.2; }

    .filter-container {
        background: #f8fafc;
        border-radius: 12px;
        padding: 24px 28px;
    }
    .filter-row {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .filter-group {
        flex: 1;
        min-width: 160px;
    }
    .filter-group label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
        display: block;
    }

    .type-selector {
        display: flex;
        gap: 8px;
        background: white;
        padding: 4px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }
    .type-selector .btn-type {
        padding: 8px 10px;
        border-radius: 8px;
        border: none;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        background: transparent;
        cursor: pointer;
        transition: all 0.2s;
        flex: 1;
        white-space: nowrap;
        text-align: center;
    }
    .type-selector .btn-type:hover { color: #0f172a; background: #f1f5f9; }
    .type-selector .btn-type.active { background: #0c4a6e; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .type-selector .btn-type.active:hover { background: #0c4a6e; }
    .type-selector .btn-type i { margin-right: 5px; }

    .filter-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        font-size: 14px;
        color: #1e293b;
        transition: all 0.2s;
    }
    .filter-input:hover { border-color: #64748b; }
    .filter-input:focus { border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14,165,233,0.1); outline: none; }

    .btn-primary-custom {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        border: none;
        color: white;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(14,165,233,0.25);
        display: inline-flex;
        align-items: center;
    }
    .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(14,165,233,0.35); }

    .monthly-summary {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }
    .monthly-summary .month-item {
        background: #f8fafc;
        border-radius: 10px;
        padding: 12px 16px;
        text-align: center;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .monthly-summary .month-item:hover { background: #f1f5f9; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(14,165,233,0.05); }
    .monthly-summary .month-item .month-name { font-weight: 600; font-size: 13px; color: #0f172a; }
    .monthly-summary .month-item .month-total { font-size: 20px; font-weight: 700; color: #0ea5e9; margin-top: 4px; }
    .monthly-summary .month-item .month-detail { font-size: 11px; color: #64748b; margin-top: 2px; }

    .semester-summary {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-top: 16px;
    }
    .semester-summary .semester-item {
        background: #f8fafc;
        border-radius: 10px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .semester-summary .semester-item:hover { background: #f1f5f9; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(14,165,233,0.05); }
    .semester-summary .semester-item .sem-name { font-weight: 700; font-size: 13px; color: #0f172a; }
    .semester-summary .semester-item .sem-range { font-size: 11px; color: #64748b; }
    .semester-summary .semester-item .sem-total { font-size: 22px; font-weight: 700; color: #0ea5e9; margin-top: 6px; }
    .semester-summary .semester-item .sem-detail { font-size: 11px; color: #64748b; margin-top: 2px; }

    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 14px;
    }
    .table-modern thead th {
        background: #f8fafc;
        padding: 14px 16px;
        font-weight: 600;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }
    .table-modern tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }
    .table-modern tbody tr { transition: background 0.15s ease; }
    .table-modern tbody tr:hover { background: #f8fafc; }
    .table-modern tbody tr:last-child td { border-bottom: none; }

    @media (max-width: 768px) {
        .card-body-modern { padding: 16px !important; }
        .stat-card { padding: 16px 18px; }
        .stat-number { font-size: 22px; }
        .stat-icon { width: 44px; height: 44px; font-size: 18px; }
        .table-modern { font-size: 12px; }
        .table-modern thead th, .table-modern tbody td { padding: 10px 12px; }
        .filter-row { flex-direction: column; align-items: stretch; }
        .filter-group { min-width: unset; }
        .semester-summary { grid-template-columns: 1fr; }
        .monthly-summary { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); }
        .type-selector .btn-type { padding: 8px 12px; font-size: 12px; }
    }
</style>
@endpush

@section('content')
@php
    $bulanIndo = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
    $jenisRekap = $type ?? 'monthly';
    $selectedYear = $year ?? now()->year;
    $selectedMonth = $month ?? now()->month;
    $selectedSemester = $semester ?? 'ganjil';
    $titleText = $jenisRekap == 'monthly' ? 'Rekap Bulanan' : ($jenisRekap == 'semester' ? 'Rekap Semester' : 'Rekap Tahunan');
    $periodBadge = $jenisRekap == 'monthly'
        ? ($bulanIndo[str_pad($selectedMonth, 2, '0', STR_PAD_LEFT)] ?? 'Bulanan')
        : ($jenisRekap == 'semester' ? ($selectedSemester == 'genap' ? 'Semester Genap' : 'Semester Ganjil') : 'Tahunan');
    $filterParams = http_build_query([
        'type' => $jenisRekap,
        'year' => $selectedYear,
        'month' => $selectedMonth,
        'semester' => $selectedSemester,
    ]);
@endphp

<!-- Header -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header border-0 py-4 px-5 hero-gradient">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-4">
                <div class="bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="fas fa-chart-bar fa-2x text-white"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">{{ $titleText }} Kehadiran Pelatih</h4>
                    <p class="text-white-50 mb-0 small" style="font-weight: 400;">
                        Semua ekskul — {{ $selectedYear }} - {{ $periodBadge }}
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('admin.kehadiran_pelatih.export', $filterParams) }}" class="btn" style="background: #10b981; border: none; color: #fff; font-weight: 600; padding: 10px 20px; border-radius: 10px; box-shadow: 0 4px 16px rgba(16,185,129,0.3);">
                    <i class="fas fa-download me-2"></i>Unduh File
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn" style="border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.06); color: #e2e8f0; padding: 10px 20px; border-radius: 10px;">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card-modern mb-4">
    <div class="card-body-modern">
        <form method="GET" action="{{ route('admin.kehadiran_pelatih') }}" id="filterForm">
            <div class="filter-container">
                <div class="filter-row">
                    <div class="filter-group" style="flex: 0 0 360px;">
                        <label>Jenis Rekap</label>
                        <div class="type-selector">
                            <button type="button" class="btn-type type-btn {{ $jenisRekap == 'monthly' ? 'active' : '' }}" data-type="monthly">
                                <i class="fas fa-calendar-alt"></i> Bulanan
                            </button>
                            <button type="button" class="btn-type type-btn {{ $jenisRekap == 'semester' ? 'active' : '' }}" data-type="semester">
                                <i class="fas fa-layer-group"></i> Semester
                            </button>
                            <button type="button" class="btn-type type-btn {{ $jenisRekap == 'yearly' ? 'active' : '' }}" data-type="yearly">
                                <i class="fas fa-calendar"></i> Tahunan
                            </button>
                        </div>
                        <input type="hidden" name="type" id="typeInput" value="{{ $jenisRekap }}">
                    </div>

                    <div class="filter-group" style="flex: 0 0 140px;">
                        <label>Tahun</label>
                        <select name="year" id="yearInput" class="filter-input">
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group" style="flex: 1 1 auto;">
                        <button type="submit" class="btn-primary-custom">
                            <i class="fas fa-search me-2"></i>Tampilkan
                        </button>
                    </div>
                </div>

                @if($jenisRekap == 'monthly')
                <div class="filter-row" style="margin-top: 16px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                    <div class="filter-group" style="flex: 0 0 180px;">
                        <label>Bulan</label>
                        <select name="month" id="monthInput" class="filter-input">
                            @foreach($bulanIndo as $num => $name)
                                <option value="{{ (int) $num }}" {{ $selectedMonth == (int) $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                @if($jenisRekap == 'semester')
                <div class="filter-row" style="margin-top: 16px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                    <div class="filter-group" style="flex: 0 0 220px;">
                        <label>Semester</label>
                        <select name="semester" id="semesterInput" class="filter-input">
                            <option value="ganjil" {{ $selectedSemester == 'ganjil' ? 'selected' : '' }}>Semester Ganjil (Jul - Des)</option>
                            <option value="genap" {{ $selectedSemester == 'genap' ? 'selected' : '' }}>Semester Genap (Jan - Jun)</option>
                        </select>
                    </div>
                </div>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Statistics Summary -->
<div class="row g-4 mb-4">
    <div class="col-md col-sm-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-user-tie"></i></div>
            <div class="stat-body">
                <span class="stat-label">Total Catatan</span>
                <h3 class="stat-number">{{ $statistikBulanan['total'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md col-sm-6">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
            <div class="stat-body">
                <span class="stat-label">Hadir</span>
                <h3 class="stat-number">{{ $statistikBulanan['hadir'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md col-sm-6">
        <div class="stat-card">
            <div class="stat-icon gold"><i class="fas fa-notes-medical"></i></div>
            <div class="stat-body">
                <span class="stat-label">Izin</span>
                <h3 class="stat-number">{{ $statistikBulanan['izin'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md col-sm-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-thermometer-half"></i></div>
            <div class="stat-body">
                <span class="stat-label">Sakit</span>
                <h3 class="stat-number">{{ $statistikBulanan['sakit'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md col-sm-6">
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-user-times"></i></div>
            <div class="stat-body">
                <span class="stat-label">Alpa</span>
                <h3 class="stat-number">{{ $statistikBulanan['alpa'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Summary (Tahunan) -->
@if($jenisRekap == 'yearly' && isset($monthlySummary) && count($monthlySummary) > 0)
<div class="card-modern mb-4">
    <div class="card-body-modern">
        <h6 class="fw-bold mb-3" style="color: #0f172a;">
            <i class="fas fa-calendar-alt me-2" style="color: #0ea5e9;"></i>Rekap Per Bulan - {{ $selectedYear }}
        </h6>
        <div class="monthly-summary">
            @foreach($monthlySummary as $bulanNum => $md)
                <div class="month-item">
                    <div class="month-name">{{ $bulanIndo[str_pad($bulanNum, 2, '0', STR_PAD_LEFT)] ?? $bulanNum }}</div>
                    <div class="month-total">{{ $md['total'] }}</div>
                    <div class="month-detail">H:{{ $md['hadir'] }} I:{{ $md['izin'] }} S:{{ $md['sakit'] }} A:{{ $md['alpa'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Semester Summary (Tahunan) -->
@if($jenisRekap == 'yearly' && isset($semesterSummary))
<div class="card-modern mb-4">
    <div class="card-body-modern">
        <h6 class="fw-bold mb-3" style="color: #0f172a;">
            <i class="fas fa-layer-group me-2" style="color: #0ea5e9;"></i>Rekap Per Semester - {{ $selectedYear }}
        </h6>
        <div class="semester-summary">
            @foreach(['ganjil' => ['Semester Ganjil', 'Juli - Desember'], 'genap' => ['Semester Genap', 'Januari - Juni']] as $semKey => $semInfo)
                @php $sd = $semesterSummary[$semKey] ?? []; @endphp
                <div class="semester-item">
                    <div class="sem-name">{{ $semInfo[0] }}</div>
                    <div class="sem-range">{{ $semInfo[1] }}</div>
                    <div class="sem-total">{{ $sd['total'] ?? 0 }}</div>
                    <div class="sem-detail">
                        H:{{ $sd['hadir'] ?? 0 }} I:{{ $sd['izin'] ?? 0 }} S:{{ $sd['sakit'] ?? 0 }} A:{{ $sd['alpa'] ?? 0 }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Data Table -->
<div class="card-modern">
    <div class="card-body-modern">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h5 class="fw-bold mb-0" style="color: #0f172a;">
                <i class="fas fa-list-ul me-2" style="color: #0ea5e9;"></i>Rekap Kehadiran Pelatih
            </h5>
            <span class="badge" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 6px 16px; border-radius: 20px; font-weight: 600;">
                <i class="fas fa-calendar-alt me-1"></i>{{ $selectedYear }} - {{ $periodBadge }}
            </span>
        </div>

        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelatih</th>
                        <th>Ekskul</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Alpa</th>
                        <th>Total</th>
                        <th>% Hadir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapBulanan as $i => $r)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 13px; font-weight: 600; flex-shrink: 0; background: rgba(14,165,233,0.06); color: #0ea5e9;">
                                        {{ strtoupper(substr($r['pelatih']->name ?? '?', 0, 1)) }}
                                    </div>
                                    {{ $r['pelatih']->name ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $r['ekskul']->nama_ekskul ?? '-' }}</span>
                            </td>
                            <td><span class="badge" style="background: #10b981; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $r['hadir'] ?? 0 }}</span></td>
                            <td><span class="badge" style="background: #f59e0b; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $r['izin'] ?? 0 }}</span></td>
                            <td><span class="badge" style="background: #0ea5e9; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $r['sakit'] ?? 0 }}</span></td>
                            <td><span class="badge" style="background: #ef4444; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $r['alpa'] ?? 0 }}</span></td>
                            <td><strong style="color: #0f172a;">{{ $r['total'] ?? 0 }}</strong></td>
                            <td>
                                @php
                                    $p = $r['persentase_hadir'] ?? 0;
                                    $bc = $p >= 80 ? '#10b981' : ($p >= 60 ? '#f59e0b' : '#ef4444');
                                @endphp
                                <span class="badge" style="background: {{ $bc }}; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $p }}%</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4" style="color: #64748b;">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                Belum ada data kehadiran untuk periode ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        const typeInput = document.getElementById('typeInput');

        document.querySelectorAll('.type-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                typeInput.value = this.dataset.type;
                form.submit();
            });
        });
    });
</script>
@endpush
