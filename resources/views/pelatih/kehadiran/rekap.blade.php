@extends('layouts.app')

@section('title', 'Rekap Kehadiran Anggota')
@section('subtitle', 'Rekap bulanan, semester, dan tahunan kehadiran anggota ekskul')

@push('styles')
<style>
    /* Reset dan perbaikan konflik */
    .rekap-container .card-modern {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(14,165,233,0.06);
        border: 1px solid rgba(14,165,233,0.04);
        transition: all 0.3s ease;
    }
    .rekap-container .card-modern:hover {
        box-shadow: 0 8px 30px rgba(14,165,233,0.08);
    }
    .rekap-container .card-body-modern { 
        padding: 24px 28px; 
    }

    /* Hero Gradient - Perbaikan */
    .rekap-container .hero-gradient {
        background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 50%, #38bdf8 100%);
        padding: 28px 32px;
        border-radius: 16px 16px 0 0;
    }

    /* Stat Card */
    .rekap-container .stat-card {
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
    .rekap-container .stat-card:hover { 
        transform: translateY(-4px); 
        box-shadow: 0 8px 24px rgba(14,165,233,0.10); 
    }
    .rekap-container .stat-icon { 
        width: 56px; 
        height: 56px; 
        border-radius: 14px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 24px; 
        flex-shrink: 0; 
    }
    .rekap-container .stat-icon.blue { background: #f0f9ff; color: #0ea5e9; }
    .rekap-container .stat-icon.green { background: #ecfdf5; color: #10b981; }
    .rekap-container .stat-icon.gold { background: #fffbeb; color: #f59e0b; }
    .rekap-container .stat-icon.red { background: #fef2f2; color: #ef4444; }
    .rekap-container .stat-body { flex: 1; min-width: 0; }
    .rekap-container .stat-label { 
        font-size: 13px; 
        color: #6b7280; 
        font-weight: 500; 
        display: block; 
        margin-bottom: 4px; 
    }
    .rekap-container .stat-number { 
        font-size: 28px; 
        font-weight: 700; 
        color: #111827; 
        margin: 0; 
        line-height: 1.2; 
    }

    /* Filter Container */
    .rekap-container .filter-container {
        background: #f8fafc;
        border-radius: 12px;
        padding: 24px 28px;
    }
    .rekap-container .filter-row {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .rekap-container .filter-group {
        flex: 1;
        min-width: 180px;
    }
    .rekap-container .filter-group label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
        display: block;
    }

    /* Type Selector */
    .rekap-container .type-selector {
        display: flex;
        gap: 8px;
        background: white;
        padding: 4px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }
    .rekap-container .type-selector .btn-type {
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
    .rekap-container .type-selector .btn-type:hover { 
        color: #0f172a; 
        background: #f1f5f9; 
    }
    .rekap-container .type-selector .btn-type.active { 
        background: #0c4a6e; 
        color: white; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
    }
    .rekap-container .type-selector .btn-type.active:hover { 
        background: #0c4a6e; 
    }
    .rekap-container .type-selector .btn-type i { 
        margin-right: 5px; 
    }

    /* Filter Input */
    .rekap-container .filter-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        font-size: 14px;
        color: #1e293b;
        transition: all 0.2s;
    }
    .rekap-container .filter-input:hover { 
        border-color: #64748b; 
    }
    .rekap-container .filter-input:focus { 
        border-color: #0ea5e9; 
        box-shadow: 0 0 0 3px rgba(14,165,233,0.1); 
        outline: none; 
    }
    .rekap-container .filter-input::placeholder { 
        color: #64748b; 
        font-size: 13px; 
    }
    .rekap-container .filter-input.input-error { 
        border-color: #ef4444; 
        box-shadow: 0 0 0 3px rgba(239,68,68,0.1); 
    }
    .rekap-container .input-hint { 
        font-size: 11px; 
        color: #64748b; 
        margin-top: 4px; 
        display: block; 
    }
    .rekap-container .input-hint.error { 
        color: #ef4444; 
    }

    /* Tombol Submit */
    .rekap-container .btn-primary-gradient {
        background: linear-gradient(135deg, #0c4a6e, #0ea5e9);
        border: none;
        color: white;
        font-weight: 600;
        padding: 10px 28px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(14,165,233,0.25);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .rekap-container .btn-primary-gradient:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 8px 30px rgba(14,165,233,0.35); 
        color: white;
    }

    /* Button Kembali */
    .rekap-container .btn-outline-light-custom {
        padding: 10px 24px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.3);
        background: rgba(255,255,255,0.1);
        color: white;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .rekap-container .btn-outline-light-custom:hover { 
        background: rgba(255,255,255,0.2); 
        color: #fff; 
        text-decoration: none;
    }

    /* Month & Semester Grid */
    .rekap-container .month-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
        margin-top: 4px;
    }
    .rekap-container .month-grid .btn-month {
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: white;
        font-size: 12px;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }
    .rekap-container .month-grid .btn-month:hover { 
        background: #f1f5f9; 
        border-color: #64748b; 
    }
    .rekap-container .month-grid .btn-month.active { 
        background: #0c4a6e; 
        color: white; 
        border-color: #0c4a6e; 
    }
    .rekap-container .month-grid .btn-month.active:hover { 
        background: #0c4a6e; 
    }
    .rekap-container .month-grid .btn-month.all-month { 
        grid-column: span 4; 
        font-weight: 600; 
        background: #f1f5f9; 
        border-color: #cbd5e1; 
    }
    .rekap-container .month-grid .btn-month.all-month:hover { 
        background: #e2e8f0; 
    }
    .rekap-container .month-grid .btn-month.all-month.active { 
        background: #0c4a6e; 
        color: white; 
        border-color: #0c4a6e; 
    }

    .rekap-container .semester-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 6px;
        margin-top: 4px;
    }
    .rekap-container .semester-grid .btn-semester {
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        font-size: 13px;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        font-weight: 600;
    }
    .rekap-container .semester-grid .btn-semester:hover { 
        background: #f1f5f9; 
        border-color: #64748b; 
    }
    .rekap-container .semester-grid .btn-semester.active { 
        background: #0c4a6e; 
        color: white; 
        border-color: #0c4a6e; 
    }
    .rekap-container .semester-grid .btn-semester .sem-range { 
        display: block; 
        font-size: 11px; 
        font-weight: 400; 
        margin-top: 2px; 
    }

    /* Table */
    .rekap-container .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 14px;
    }
    .rekap-container .table-modern thead th {
        background: #f8fafc;
        padding: 14px 16px;
        font-weight: 600;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }
    .rekap-container .table-modern tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }
    .rekap-container .table-modern tbody tr { 
        transition: background 0.15s ease; 
    }
    .rekap-container .table-modern tbody tr:hover { 
        background: #f8fafc; 
    }
    .rekap-container .table-modern tbody tr:last-child td { 
        border-bottom: none; 
    }

    /* Monthly & Semester Summary */
    .rekap-container .monthly-summary {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }
    .rekap-container .monthly-summary .month-item {
        background: #f8fafc;
        border-radius: 10px;
        padding: 12px 16px;
        text-align: center;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .rekap-container .monthly-summary .month-item:hover { 
        background: #f1f5f9; 
        transform: translateY(-2px); 
        box-shadow: 0 4px 12px rgba(14,165,233,0.05); 
    }
    .rekap-container .monthly-summary .month-item .month-name { 
        font-weight: 600; 
        font-size: 13px; 
        color: #0f172a; 
    }
    .rekap-container .monthly-summary .month-item .month-total { 
        font-size: 20px; 
        font-weight: 700; 
        color: #0ea5e9; 
        margin-top: 4px; 
    }
    .rekap-container .monthly-summary .month-item .month-detail { 
        font-size: 11px; 
        color: #64748b; 
        margin-top: 2px; 
    }

    .rekap-container .semester-summary {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-top: 16px;
    }
    .rekap-container .semester-summary .semester-item {
        background: #f8fafc;
        border-radius: 10px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .rekap-container .semester-summary .semester-item:hover { 
        background: #f1f5f9; 
        transform: translateY(-2px); 
        box-shadow: 0 4px 12px rgba(14,165,233,0.05); 
    }
    .rekap-container .semester-summary .semester-item .sem-name { 
        font-weight: 700; 
        font-size: 13px; 
        color: #0f172a; 
    }
    .rekap-container .semester-summary .semester-item .sem-range { 
        font-size: 11px; 
        color: #64748b; 
    }
    .rekap-container .semester-summary .semester-item .sem-total { 
        font-size: 22px; 
        font-weight: 700; 
        color: #0ea5e9; 
        margin-top: 6px; 
    }
    .rekap-container .semester-summary .semester-item .sem-detail { 
        font-size: 11px; 
        color: #64748b; 
        margin-top: 2px; 
    }

    /* Avatar */
    .rekap-container .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
        flex-shrink: 0;
        background: rgba(14,165,233,0.06);
        color: #0ea5e9;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .rekap-container .card-body-modern { padding: 16px !important; }
        .rekap-container .stat-card { padding: 16px 18px; }
        .rekap-container .stat-number { font-size: 22px; }
        .rekap-container .stat-icon { width: 44px; height: 44px; font-size: 18px; }
        .rekap-container .table-modern { font-size: 12px; }
        .rekap-container .table-modern thead th, 
        .rekap-container .table-modern tbody td { padding: 10px 12px; }
        .rekap-container .filter-row { flex-direction: column; align-items: stretch; }
        .rekap-container .filter-group { min-width: unset; }
        .rekap-container .month-grid { grid-template-columns: repeat(3, 1fr); }
        .rekap-container .month-grid .btn-month.all-month { grid-column: span 3; }
        .rekap-container .semester-summary { grid-template-columns: 1fr; }
        .rekap-container .monthly-summary { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); }
        .rekap-container .type-selector { flex-direction: row; }
        .rekap-container .type-selector .btn-type { padding: 8px 12px; font-size: 12px; }
        .rekap-container .hero-gradient { padding: 20px !important; }
    }
    @media (max-width: 480px) {
        .rekap-container .month-grid { grid-template-columns: repeat(2, 1fr); }
        .rekap-container .month-grid .btn-month.all-month { grid-column: span 2; }
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

    $selectedType = $type ?? 'monthly';
    $selectedYear = $year ?? now()->year;
    $selectedMonth = $month ?? 'all';
    $selectedSemester = $semester ?? 'ganjil';
    $titleText = $selectedType == 'monthly' ? 'Rekap Bulanan' : ($selectedType == 'semester' ? 'Rekap Semester' : 'Rekap Tahunan');
    $periodBadge = $selectedType == 'monthly'
        ? ($selectedMonth != 'all' ? $bulanIndo[str_pad($selectedMonth, 2, '0', STR_PAD_LEFT)] ?? 'Bulanan' : 'Semua Bulan')
        : ($selectedType == 'semester' ? ($selectedSemester == 'genap' ? 'Semester Genap' : 'Semester Ganjil') : 'Tahunan');
@endphp

<div class="rekap-container">
    <!-- Header - Biru Cerah -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header border-0 py-4 px-5 hero-gradient">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3" style="flex-shrink: 0;">
                        <i class="fas fa-chart-bar fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">{{ $titleText }}</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">
                            {{ $ekskul->nama_ekskul ?? 'Ekskul' }} — {{ $selectedYear }}
                            @if(($selectedType == 'semester' || ($selectedType == 'monthly' && $selectedMonth != 'all')) && !empty($periodBadge))
                                - {{ $periodBadge }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('pelatih.kehadiran.rekap.export', [
                        'type' => $selectedType,
                        'year' => $selectedYear,
                        'month' => $selectedMonth,
                        'semester' => $selectedSemester,
                    ]) }}" class="btn" style="background: #10b981; border: none; color: #fff; font-weight: 600; padding: 10px 20px; border-radius: 10px; box-shadow: 0 4px 16px rgba(16,185,129,0.3);">
                        <i class="fas fa-download me-2"></i>Unduh File
                    </a>
                    <a href="{{ route('pelatih.kehadiran') }}" class="btn-outline-light-custom">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card-modern mb-4">
        <div class="card-body-modern">
            <form method="GET" action="{{ route('pelatih.kehadiran.rekap') }}" id="filterForm" onsubmit="return validateYear()">
                <div class="filter-container">
                    <div class="filter-row">
                        <div class="filter-group" style="flex: 0 0 360px;">
                            <label>Jenis Rekap</label>
                            <div class="type-selector">
                                <button type="button" class="btn-type type-btn {{ $selectedType == 'monthly' ? 'active' : '' }}" data-type="monthly">
                                    <i class="fas fa-calendar-alt"></i> Bulanan
                                </button>
                                <button type="button" class="btn-type type-btn {{ $selectedType == 'semester' ? 'active' : '' }}" data-type="semester">
                                    <i class="fas fa-layer-group"></i> Semester
                                </button>
                                <button type="button" class="btn-type type-btn {{ $selectedType == 'yearly' ? 'active' : '' }}" data-type="yearly">
                                    <i class="fas fa-calendar"></i> Tahunan
                                </button>
                            </div>
                            <input type="hidden" name="type" id="typeInput" value="{{ $selectedType }}">
                        </div>

                        <div class="filter-group" style="flex: 0 0 180px;">
                            <label>Tahun</label>
                            <div style="position: relative;">
                                <i class="fas fa-calendar" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; pointer-events: none;"></i>
                                <input type="text" name="year" id="yearInput" class="filter-input" value="{{ $selectedYear }}"
                                       placeholder="cth: {{ now()->year }}" inputmode="numeric" autocomplete="off"
                                       maxlength="4" style="padding-left: 36px;">
                            </div>
                            <span class="input-hint">Ketik tahun (misal: {{ now()->year }})</span>
                        </div>

                        <div class="filter-group" style="flex: 1 1 auto;">
                            <button type="submit" class="btn-primary-gradient">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                        </div>
                    </div>

                    @if($selectedType == 'monthly')
                    <div class="filter-row" style="margin-top: 16px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                        <div class="filter-group" style="flex: 1;">
                            <label>Pilih Bulan</label>
                            <div class="month-grid">
                                <button type="button" class="btn-month all-month month-btn {{ $selectedMonth == 'all' ? 'active' : '' }}" data-month="all">
                                    📅 Semua Bulan
                                </button>
                                @foreach($bulanIndo as $num => $name)
                                    <button type="button" class="btn-month month-btn {{ $selectedMonth == $num ? 'active' : '' }}" data-month="{{ $num }}">
                                        {{ $name }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="month" id="monthInput" value="{{ $selectedMonth }}">
                        </div>
                    </div>
                    @endif

                    @if($selectedType == 'semester')
                    <div class="filter-row" style="margin-top: 16px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                        <div class="filter-group" style="flex: 1;">
                            <label>Pilih Semester</label>
                            <div class="semester-grid">
                                <button type="button" class="btn-semester semester-btn {{ $selectedSemester == 'ganjil' ? 'active' : '' }}" data-semester="ganjil">
                                    Semester Ganjil <span class="sem-range">Juli - Desember</span>
                                </button>
                                <button type="button" class="btn-semester semester-btn {{ $selectedSemester == 'genap' ? 'active' : '' }}" data-semester="genap">
                                    Semester Genap <span class="sem-range">Januari - Juni</span>
                                </button>
                            </div>
                            <input type="hidden" name="semester" id="semesterInput" value="{{ $selectedSemester }}">
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
                <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                <div class="stat-body">
                    <span class="stat-label">Total Kehadiran</span>
                    <h3 class="stat-number">{{ $statistik['total'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md col-sm-6">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
                <div class="stat-body">
                    <span class="stat-label">Hadir</span>
                    <h3 class="stat-number">{{ $statistik['hadir'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md col-sm-6">
            <div class="stat-card">
                <div class="stat-icon gold"><i class="fas fa-notes-medical"></i></div>
                <div class="stat-body">
                    <span class="stat-label">Izin</span>
                    <h3 class="stat-number">{{ $statistik['izin'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md col-sm-6">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-thermometer-half"></i></div>
                <div class="stat-body">
                    <span class="stat-label">Sakit</span>
                    <h3 class="stat-number">{{ $statistik['sakit'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md col-sm-6">
            <div class="stat-card">
                <div class="stat-icon red"><i class="fas fa-user-times"></i></div>
                <div class="stat-body">
                    <span class="stat-label">Alpa</span>
                    <h3 class="stat-number">{{ $statistik['alpa'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Summary (Semua Bulan / Tahunan) -->
    @if(($selectedType == 'monthly' && $selectedMonth == 'all') || $selectedType == 'yearly')
        @php
            $hasMonthly = is_array($monthlySummary) && count($monthlySummary) > 0;
        @endphp
        @if($hasMonthly)
        <div class="card-modern mb-4">
            <div class="card-body-modern">
                <h6 class="fw-bold mb-3" style="color: #0f172a;">
                    <i class="fas fa-calendar-alt me-2" style="color: #0ea5e9;"></i>
                    Rekap Per Bulan - {{ $selectedYear }}
                </h6>
                <div class="monthly-summary">
                    @foreach($monthlySummary as $bulanNum => $md)
                        <div class="month-item">
                            <div class="month-name">{{ $bulanIndo[str_pad($bulanNum, 2, '0', STR_PAD_LEFT)] ?? $bulanNum }}</div>
                            <div class="month-total">{{ $md['total'] }}</div>
                            <div class="month-detail">
                                H:{{ $md['hadir'] }} I:{{ $md['izin'] }} S:{{ $md['sakit'] }} A:{{ $md['alpa'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    @endif

    <!-- Semester Summary (Tahunan) -->
    @if($selectedType == 'yearly')
    <div class="card-modern mb-4">
        <div class="card-body-modern">
            <h6 class="fw-bold mb-3" style="color: #0f172a;">
                <i class="fas fa-layer-group me-2" style="color: #0ea5e9;"></i>
                Rekap Per Semester - {{ $selectedYear }}
            </h6>
            @php
                $ranges = ['ganjil' => range(7, 12), 'genap' => range(1, 6)];
                $semData = [];
                foreach ($ranges as $semKey => $range) {
                    $hadir = $izin = $sakit = $alpa = 0;
                    foreach ($monthlySummary as $bulanNum => $md) {
                        if (in_array((int) $bulanNum, $range, true)) {
                            $hadir += (int) $md['hadir'];
                            $izin += (int) $md['izin'];
                            $sakit += (int) $md['sakit'];
                            $alpa += (int) $md['alpa'];
                        }
                    }
                    $total = $hadir + $izin + $sakit + $alpa;
                    $semData[$semKey] = ['total' => $total, 'hadir' => $hadir, 'izin' => $izin, 'sakit' => $sakit, 'alpa' => $alpa];
                }
            @endphp
            <div class="semester-summary">
                <div class="semester-item">
                    <div class="sem-name">Semester Ganjil</div>
                    <div class="sem-range">Juli - Desember</div>
                    <div class="sem-total">{{ $semData['ganjil']['total'] }}</div>
                    <div class="sem-detail">
                        H:{{ $semData['ganjil']['hadir'] }} I:{{ $semData['ganjil']['izin'] }} S:{{ $semData['ganjil']['sakit'] }} A:{{ $semData['ganjil']['alpa'] }}
                    </div>
                </div>
                <div class="semester-item">
                    <div class="sem-name">Semester Genap</div>
                    <div class="sem-range">Januari - Juni</div>
                    <div class="sem-total">{{ $semData['genap']['total'] }}</div>
                    <div class="sem-detail">
                        H:{{ $semData['genap']['hadir'] }} I:{{ $semData['genap']['izin'] }} S:{{ $semData['genap']['sakit'] }} A:{{ $semData['genap']['alpa'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Data Table -->
    <div class="card-modern">
        <div class="card-body-modern">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="fw-bold mb-0" style="color: #0f172a;">
                    <i class="fas fa-list-ul me-2" style="color: #0ea5e9;"></i>
                    Data Kehadiran Anggota
                </h5>
                <span class="badge" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 6px 16px; border-radius: 20px; font-weight: 600;">
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ $selectedYear }} - {{ $periodBadge }}
                    @if($selectedType == 'monthly' && $selectedMonth != 'all')
                        <span class="ms-1" style="background: rgba(14,165,233,0.12); padding: 1px 8px; border-radius: 10px; font-size: 11px;">
                            {{ (int) $selectedMonth >= 7 ? 'Semester Ganjil' : 'Semester Genap' }}
                        </span>
                    @endif
                </span>
            </div>

            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Hadir</th>
                            <th>Izin</th>
                            <th>Sakit</th>
                            <th>Alpa</th>
                            <th>Total</th>
                            <th>% Hadir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekap as $i => $r)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr($r->anggota->name ?? '?', 0, 1)) }}
                                        </div>
                                        {{ $r->anggota->name ?? '-' }}
                                    </div>
                                </td>
                                <td><span class="badge" style="background: #10b981; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $r->hadir ?? 0 }}</span></td>
                                <td><span class="badge" style="background: #f59e0b; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $r->izin ?? 0 }}</span></td>
                                <td><span class="badge" style="background: #0ea5e9; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $r->sakit ?? 0 }}</span></td>
                                <td><span class="badge" style="background: #ef4444; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $r->alpa ?? 0 }}</span></td>
                                <td><strong style="color: #0f172a;">{{ $r->total ?? 0 }}</strong></td>
                                <td>
                                    @php
                                        $persentase = $r->persentase_hadir ?? 0;
                                        $badgeColor = $persentase >= 80 ? '#10b981' : ($persentase >= 60 ? '#f59e0b' : '#ef4444');
                                    @endphp
                                    <span class="badge" style="background: {{ $badgeColor }}; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px;">{{ $persentase }}%</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4" style="color: #64748b;">
                                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                    Belum ada data kehadiran untuk periode ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(count($rekap) > 0)
                <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-color: #e2e8f0;">
                    <small class="text-muted" style="color: #64748b;">
                        <i class="fas fa-users me-1"></i>
                        Total {{ count($rekap) }} anggota
                    </small>
                    <small class="text-muted" style="color: #64748b;">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Periode: {{ $selectedYear }} - {{ $periodBadge }}
                    </small>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        const monthInput = document.getElementById('monthInput');
        const typeInput = document.getElementById('typeInput');
        const semesterInput = document.getElementById('semesterInput');
        const yearInput = document.getElementById('yearInput');

        yearInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 4);
            this.classList.remove('input-error');
            const hint = this.closest('.filter-group').querySelector('.input-hint');
            if (hint) {
                hint.textContent = 'Ketik tahun (misal: ' + new Date().getFullYear() + ')';
                hint.classList.remove('error');
            }
        });

        window.validateYear = function() {
            const val = yearInput.value.trim();
            if (!/^\d{4}$/.test(val)) {
                yearInput.classList.add('input-error');
                yearInput.focus();
                const hint = yearInput.closest('.filter-group').querySelector('.input-hint');
                if (hint) {
                    hint.textContent = 'Masukkan 4 digit tahun, misal ' + new Date().getFullYear();
                    hint.classList.add('error');
                }
                return false;
            }
            return true;
        };

        document.querySelectorAll('.type-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                typeInput.value = this.dataset.type;
                form.submit();
            });
        });

        document.querySelectorAll('.month-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.month-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                monthInput.value = this.dataset.month;
                form.submit();
            });
        });

        document.querySelectorAll('.semester-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.semester-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                semesterInput.value = this.dataset.semester;
                form.submit();
            });
        });
    });
</script>
@endpush