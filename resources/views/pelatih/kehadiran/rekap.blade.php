@extends('layouts.app')

@section('title', 'Rekap Kehadiran Anggota')
@section('subtitle', 'Rekap bulanan dan tahunan anggota ekskul')

@push('styles')
<style>
    /* Card Modern */
    .card-modern {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }
    
    .card-modern:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }
    
    .card-body-modern {
        padding: 24px 28px;
    }

    /* Stat Cards */
    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }
    
    .stat-icon.blue { background: #eff6ff; color: #3b82f6; }
    .stat-icon.green { background: #ecfdf5; color: #10b981; }
    .stat-icon.gold { background: #fffbeb; color: #f59e0b; }
    .stat-icon.red { background: #fef2f2; color: #ef4444; }
    
    .stat-body {
        flex: 1;
        min-width: 0;
    }
    
    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        display: block;
        margin-bottom: 4px;
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        margin: 0;
        line-height: 1.2;
    }

    /* Modern Table */
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
    
    .table-modern tbody tr {
        transition: background 0.15s ease;
    }
    
    .table-modern tbody tr:hover {
        background: #f8fafc;
    }
    
    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    /* Animations */
    @keyframes fadeSlide {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card-modern {
        animation: fadeSlide 0.5s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body-modern {
            padding: 16px 16px !important;
        }
        .card-header {
            padding: 16px 20px !important;
        }
        .stat-card {
            padding: 16px 18px;
        }
        .stat-number {
            font-size: 22px;
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            font-size: 18px;
        }
        .table-modern {
            font-size: 12px;
        }
        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 12px;
        }
        .btn {
            width: 100%;
        }
        .d-flex.gap-3 {
            flex-direction: column;
        }
        .d-flex.gap-3.justify-content-end {
            flex-direction: column-reverse;
        }
        .info-ekskul .d-flex {
            flex-wrap: wrap;
        }
        .info-ekskul .ms-auto {
            margin-left: 0 !important;
            margin-top: 8px;
        }
    }
</style>
@endpush

@section('content')
@php
    $bulanIndo = [
        '01' => 'Januari','02' => 'Februari','03' => 'Maret','04' => 'April','05' => 'Mei','06' => 'Juni',
        '07' => 'Juli','08' => 'Agustus','09' => 'September','10' => 'Oktober','11' => 'November','12' => 'Desember'
    ];
    $displayPeriod = ($type ?? 'monthly') === 'yearly' ? ($selectedYear ?? now()->year) : ($selectedMonth ?? now()->format('Y-m'));
@endphp

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header border-0 py-4 px-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="fas fa-chart-bar fa-2x text-white"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-0">Rekap Kehadiran</h4>
                    <p class="text-white-50 mb-0 small">{{ $ekskul->nama_ekskul ?? '-' }} — {{ $displayPeriod }}</p>
                </div>
            </div>
            <div>
                <a href="{{ route('pelatih.kehadiran') }}" class="btn btn-outline-light rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card-modern mb-4">
    <div class="card-body-modern">
        <form method="GET" action="{{ route('pelatih.kehadiran.rekap') }}" class="row g-3 align-items-end">
            <div class="col-auto">
                <label class="form-label fw-semibold">Tipe</label>
                <select name="type" id="rekapType" class="form-select">
                    <option value="monthly" {{ (isset($type) && $type==='monthly')? 'selected' : '' }}>Bulanan</option>
                    <option value="yearly" {{ (isset($type) && $type==='yearly')? 'selected' : '' }}>Tahunan</option>
                </select>
            </div>

            <div class="col-auto" id="monthPicker" style="display: {{ (isset($type) && $type==='yearly') ? 'none' : 'block' }};">
                <label class="form-label fw-semibold">Bulan</label>
                <input type="month" name="month" class="form-control" value="{{ $selectedMonth ?? now()->format('Y-m') }}">
            </div>

            <div class="col-auto" id="yearPicker" style="display: {{ (isset($type) && $type==='yearly') ? 'block' : 'none' }};">
                <label class="form-label fw-semibold">Tahun</label>
                <input type="number" name="year" class="form-control" min="2000" max="2099" value="{{ $selectedYear ?? now()->year }}">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-search me-2"></i>Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card blue">
            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
            <div class="stat-body">
                <span class="stat-label">Total Kehadiran</span>
                <h3 class="stat-number">{{ $statistik['total'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
            <div class="stat-body">
                <span class="stat-label">Hadir</span>
                <h3 class="stat-number">{{ $statistik['hadir'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card gold">
            <div class="stat-icon gold"><i class="fas fa-notes-medical"></i></div>
            <div class="stat-body">
                <span class="stat-label">Izin</span>
                <h3 class="stat-number">{{ $statistik['izin'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card red">
            <div class="stat-icon red"><i class="fas fa-user-times"></i></div>
            <div class="stat-body">
                <span class="stat-label">Alpa / Sakit</span>
                <h3 class="stat-number">{{ ($statistik['alpa'] ?? 0) + ($statistik['sakit'] ?? 0) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card-modern">
    <div class="card-body-modern">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Nilai (Avg)</th>
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
                            <td>{{ $r->anggota->name }}</td>
                            <td>{{ $r->nilai_avg !== null ? number_format($r->nilai_avg, 2) : '-' }}</td>
                            <td><span class="badge bg-success">{{ $r->hadir }}</span></td>
                            <td><span class="badge bg-warning text-dark">{{ $r->izin }}</span></td>
                            <td><span class="badge bg-info">{{ $r->sakit }}</span></td>
                            <td><span class="badge bg-danger">{{ $r->alpa }}</span></td>
                            <td><strong>{{ $r->total }}</strong></td>
                            <td>
                                @php
                                    $persentase = $r->persentase_hadir ?? 0;
                                    $badgeColor = $persentase >= 80 ? 'success' : ($persentase >= 60 ? 'warning' : 'danger');
                                @endphp
                                <span class="badge bg-{{ $badgeColor }}">{{ $persentase }}%</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                Belum ada data kehadiran
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
        const rekapType = document.getElementById('rekapType');
        const monthPicker = document.getElementById('monthPicker');
        const yearPicker = document.getElementById('yearPicker');

        function togglePickers() {
            const isYearly = rekapType.value === 'yearly';
            monthPicker.style.display = isYearly ? 'none' : 'block';
            yearPicker.style.display = isYearly ? 'block' : 'none';
        }

        rekapType.addEventListener('change', togglePickers);
        
        // Auto-submit when type changes
        rekapType.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endpush