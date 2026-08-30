@extends('layouts.app')

@section('title', 'Rekap Data Anggota')
@section('subtitle', 'Rekap bulanan dan tahunan anggota ekskul')

@push('styles')
<style>
    .card-modern {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(14,165,233,0.06);
        border: 1px solid rgba(14,165,233,0.04);
        transition: all 0.3s ease;
    }
    .card-modern:hover {
        box-shadow: 0 8px 30px rgba(14,165,233,0.08);
    }
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
    .stat-body { flex: 1; min-width: 0; }
    .stat-label { font-size: 13px; color: #6b7280; font-weight: 500; display: block; margin-bottom: 4px; }
    .stat-number { font-size: 28px; font-weight: 700; color: #111827; margin: 0; line-height: 1.2; }

    .filter-container {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px 24px;
    }
    .filter-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .filter-group {
        flex: 1;
        min-width: 180px;
    }
    .filter-group label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
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
        padding: 8px 20px;
        border-radius: 8px;
        border: none;
        font-size: 14px;
        font-weight: 500;
        color: #64748b;
        background: transparent;
        cursor: pointer;
        transition: all 0.2s;
        flex: 1;
    }
    .type-selector .btn-type:hover { color: #0f172a; background: #f1f5f9; }
    .type-selector .btn-type.active { background: #0c4a6e; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .type-selector .btn-type.active:hover { background: #0c4a6e; }
    .type-selector .btn-type i { margin-right: 8px; }

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
    .filter-input::placeholder { color: #64748b; font-size: 13px; }
    .filter-input.input-error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
    .input-hint { font-size: 11px; color: #64748b; margin-top: 4px; display: block; }
    .input-hint.error { color: #ef4444; }

    .month-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
        margin-top: 4px;
    }
    .month-grid .btn-month {
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
    .month-grid .btn-month:hover { background: #f1f5f9; border-color: #64748b; }
    .month-grid .btn-month.active { background: #0c4a6e; color: white; border-color: #0c4a6e; }
    .month-grid .btn-month.active:hover { background: #0c4a6e; }
    .month-grid .btn-month.all-month { grid-column: span 4; font-weight: 600; background: #f1f5f9; border-color: #cbd5e1; }
    .month-grid .btn-month.all-month:hover { background: #e2e8f0; }
    .month-grid .btn-month.all-month.active { background: #0c4a6e; color: white; border-color: #0c4a6e; }

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

    .btn-primary-custom {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        border: none;
        color: white;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(14,165,233,0.25);
    }
    .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(14,165,233,0.35); }

    .btn-outline-light-custom {
        padding: 10px 24px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.2);
        background: transparent;
        color: #e2e8f0;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-outline-light-custom:hover { background: rgba(255,255,255,0.1); color: #fff; }

    @media (max-width: 768px) {
        .card-body-modern { padding: 16px !important; }
        .stat-card { padding: 16px 18px; }
        .stat-number { font-size: 22px; }
        .stat-icon { width: 44px; height: 44px; font-size: 18px; }
        .table-modern { font-size: 12px; }
        .table-modern thead th, .table-modern tbody td { padding: 10px 12px; }
        .filter-row { flex-direction: column; align-items: stretch; }
        .filter-group { min-width: unset; }
        .month-grid { grid-template-columns: repeat(3, 1fr); }
        .month-grid .btn-month.all-month { grid-column: span 3; }
        .monthly-summary { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); }
        .type-selector { flex-direction: row; }
        .type-selector .btn-type { padding: 8px 12px; font-size: 13px; }
    }
    @media (max-width: 480px) {
        .month-grid { grid-template-columns: repeat(2, 1fr); }
        .month-grid .btn-month.all-month { grid-column: span 2; }
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
    $titleText = $selectedType == 'monthly' ? 'Rekap Bulanan' : 'Rekap Tahunan';
@endphp

<!-- Header - Biru Cerah -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header border-0 py-4 px-5 hero-gradient">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-4">
                <div class="bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="fas fa-chart-bar fa-2x text-white"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">{{ $titleText }}</h4>
                    <p class="text-white-50 mb-0 small" style="font-weight: 400;">
                        {{ $ekskul->nama_ekskul ?? 'Ekskul' }} — {{ $selectedYear }}
                        @if($selectedType == 'monthly' && $selectedMonth != 'all')
                            - {{ $bulanIndo[$selectedMonth] ?? '' }}
                        @endif
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('pelatih.kehadiran') }}" class="btn-outline-light-custom">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
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
                    <div class="filter-group" style="flex: 0 0 200px;">
                        <label>Jenis Rekap</label>
                        <div class="type-selector">
                            <button type="button" class="btn-type type-btn {{ $selectedType == 'monthly' ? 'active' : '' }}" data-type="monthly">
                                <i class="fas fa-calendar-alt"></i> Bulanan
                            </button>
                            <button type="button" class="btn-type type-btn {{ $selectedType == 'yearly' ? 'active' : '' }}" data-type="yearly">
                                <i class="fas fa-calendar"></i> Tahunan
                            </button>
                        </div>
                        <input type="hidden" name="type" id="typeInput" value="{{ $selectedType }}">
                    </div>
                    
                    <div class="filter-group" style="flex: 1;">
                        <label>Tahun</label>
                        <input type="text" 
                               name="year" 
                               id="yearInput" 
                               class="filter-input" 
                               placeholder="Contoh: 2026" 
                               value="{{ $selectedYear }}"
                               maxlength="4"
                               inputmode="numeric"
                               pattern="[0-9]*"
                               autocomplete="off">
                        <span class="input-hint" id="yearHint">Masukkan tahun 4 digit (contoh: 2026)</span>
                    </div>
                    
                    <div class="filter-group" style="flex: 0 0 auto;">
                        <button type="submit" class="btn-primary-gradient">
                            <i class="fas fa-search me-2"></i>Tampilkan
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

<!-- Monthly Summary -->
@if($selectedType == 'monthly' && $selectedMonth == 'all' && isset($monthlySummary) && count($monthlySummary) > 0)
<div class="card-modern mb-4">
    <div class="card-body-modern">
        <h6 class="fw-bold mb-3" style="color: #0f172a;">
            <i class="fas fa-calendar-alt me-2" style="color: #0ea5e9;"></i>
            Rekap Per Bulan - {{ $selectedYear }}
        </h6>
        <div class="monthly-summary">
            @foreach($monthlySummary as $month)
                <div class="month-item">
                    <div class="month-name">{{ $bulanIndo[str_pad($month->bulan, 2, '0', STR_PAD_LEFT)] ?? $month->bulan }}</div>
                    <div class="month-total">{{ $month->total }}</div>
                    <div class="month-detail">
                        H:{{ $month->hadir }} I:{{ $month->izin }} S:{{ $month->sakit }} A:{{ $month->alpa }}
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
                <i class="fas fa-list-ul me-2" style="color: #0ea5e9;"></i>
                Data Kehadiran Anggota
            </h5>
            <span class="badge" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 6px 16px; border-radius: 20px; font-weight: 600;">
                <i class="fas fa-calendar-alt me-1"></i>
                {{ $selectedYear }}
                @if($selectedType == 'monthly' && $selectedMonth != 'all')
                    - {{ $bulanIndo[$selectedMonth] ?? '' }}
                @elseif($selectedType == 'monthly')
                    (Semua Bulan)
                @else
                    (Tahunan)
                @endif
            </span>
        </div>
        
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Nilai</th>
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
                                    <div class="avatar-circle bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 13px; font-weight: 600; flex-shrink: 0; background: rgba(14,165,233,0.06); color: #0ea5e9;">
                                        {{ strtoupper(substr($r->anggota->name ?? '?', 0, 1)) }}
                                    </div>
                                    {{ $r->anggota->name ?? '-' }}
                                </div>
                            </td>
                            <td>
                                @if($r->nilai_avg !== null)
                                    <span class="fw-semibold" style="color: #0f172a;">{{ $r->nilai_avg }}</span>
                                @else
                                    <span class="text-muted" style="color: #64748b;">-</span>
                                @endif
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
                            <td colspan="9" class="text-center text-muted py-4" style="color: #64748b;">
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
                    Periode: {{ $selectedYear }}
                    @if($selectedType == 'monthly' && $selectedMonth != 'all')
                        - {{ $bulanIndo[$selectedMonth] ?? '' }}
                    @elseif($selectedType == 'monthly')
                        (Semua Bulan)
                    @else
                        (Tahunan)
                    @endif
                </small>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        const monthInput = document.getElementById('monthInput');
        const typeInput = document.getElementById('typeInput');
        const yearInput = document.getElementById('yearInput');
        const yearHint = document.getElementById('yearHint');
        
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
        
        yearInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 4) {
                this.value = this.value.slice(0, 4);
            }
            validateYearInput(this.value);
        });
        
        function validateYearInput(value) {
            const errorClass = 'input-error';
            const hint = document.getElementById('yearHint');
            
            if (value.length === 0) {
                yearInput.classList.remove(errorClass);
                hint.textContent = 'Masukkan tahun 4 digit (contoh: 2026)';
                hint.className = 'input-hint';
                return false;
            }
            
            if (value.length !== 4) {
                yearInput.classList.add(errorClass);
                hint.textContent = '⚠️ Tahun harus 4 digit!';
                hint.className = 'input-hint error';
                return false;
            }
            
            const year = parseInt(value);
            if (year < 1900 || year > 2100) {
                yearInput.classList.add(errorClass);
                hint.textContent = '⚠️ Tahun harus antara 1900 - 2100!';
                hint.className = 'input-hint error';
                return false;
            }
            
            yearInput.classList.remove(errorClass);
            hint.textContent = '✅ Tahun valid';
            hint.className = 'input-hint';
            return true;
        }
        
        window.validateYear = function() {
            const value = yearInput.value;
            
            if (value.length === 0) {
                yearInput.classList.add('input-error');
                yearHint.textContent = '⚠️ Tahun wajib diisi!';
                yearHint.className = 'input-hint error';
                return false;
            }
            
            if (value.length !== 4) {
                yearInput.classList.add('input-error');
                yearHint.textContent = '⚠️ Tahun harus 4 digit!';
                yearHint.className = 'input-hint error';
                return false;
            }
            
            const year = parseInt(value);
            if (year < 1900 || year > 2100) {
                yearInput.classList.add('input-error');
                yearHint.textContent = '⚠️ Tahun harus antara 1900 - 2100!';
                yearHint.className = 'input-hint error';
                return false;
            }
            
            return true;
        };
        
        yearInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (validateYearInput(this.value)) {
                    form.submit();
                }
            }
        });
    });
</script>
@endpush