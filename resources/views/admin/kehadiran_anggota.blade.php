@extends('layouts.app')

@section('title', 'Kehadiran Anggota')
@section('subtitle', 'Rekap bulanan kehadiran anggota')

@section('content')
@php
    $statusColors = [
        'hadir' => 'success',
        'izin' => 'warning',
        'sakit' => 'danger',
        'alpa' => 'secondary',
    ];
@endphp

<div class="card-modern mb-4">
    <div class="card-header-modern">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
            <h6><i class="fas fa-clipboard-list me-2" style="color: #6366f1;"></i>Rekap Bulanan Kehadiran Anggota</h6>
            <form method="GET" action="{{ route('admin.kehadiran_anggota') }}" class="d-flex align-items-center gap-2">
                <input type="month" name="month" value="{{ $selectedMonth }}" class="form-control form-control-sm" style="min-width: 180px;">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
    </div>

    <div class="card-body-modern">
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="stat-box">
                    <span class="stat-label">Total Catatan</span>
                    <h4>{{ $statistikBulanan['total'] ?? 0 }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box success">
                    <span class="stat-label">Hadir</span>
                    <h4>{{ $statistikBulanan['hadir'] ?? 0 }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box warning">
                    <span class="stat-label">Izin</span>
                    <h4>{{ $statistikBulanan['izin'] ?? 0 }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box danger">
                    <span class="stat-label">Sakit & Alpa</span>
                    <h4>{{ ($statistikBulanan['sakit'] ?? 0) + ($statistikBulanan['alpa'] ?? 0) }}</h4>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="22%">Nama Anggota</th>
                        <th width="15%">Ekskul</th>
                        <th width="12%">Hadir</th>
                        <th width="12%">Izin</th>
                        <th width="12%">Sakit</th>
                        <th width="12%">Alpa</th>
                        <th width="10%">%</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapBulanan as $index => $rekap)
                        <tr>
                            <td><span class="number-badge">{{ $index + 1 }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle">{{ strtoupper(substr($rekap['anggota']->name ?? 'A', 0, 1)) }}</div>
                                    <div>
                                        <div class="fw-semibold">{{ $rekap['anggota']->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-soft">{{ $rekap['ekskul']->nama_ekskul ?? '-' }}</span></td>
                            <td><span class="badge bg-success rounded-pill">{{ $rekap['hadir'] }}</span></td>
                            <td><span class="badge bg-warning rounded-pill">{{ $rekap['izin'] }}</span></td>
                            <td><span class="badge bg-danger rounded-pill">{{ $rekap['sakit'] }}</span></td>
                            <td><span class="badge bg-secondary rounded-pill">{{ $rekap['alpa'] }}</span></td>
                            <td><strong>{{ $rekap['persentase_hadir'] }}%</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox me-2"></i>Belum ada data rekap bulanan untuk bulan ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card-modern">
    <div class="card-header-modern">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
            <h6><i class="fas fa-list me-2" style="color: #6366f1;"></i>Detail Kehadiran Anggota</h6>
            <span class="badge-soft">{{ $kehadiran->count() }} catatan</span>
        </div>
    </div>

    <div class="card-body-modern p-0">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama Anggota</th>
                        <th width="20%">Ekskul</th>
                        <th width="15%">Tanggal</th>
                        <th width="15%">Status</th>
                        <th width="20%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kehadiran as $index => $item)
                        <tr>
                            <td><span class="number-badge">{{ $index + 1 }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle">{{ strtoupper(substr($item->anggota->name ?? 'A', 0, 1)) }}</div>
                                    <div>
                                        <div class="fw-semibold">{{ $item->anggota->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-soft">{{ $item->ekskul->nama_ekskul ?? '-' }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $statusColors[$item->status] ?? 'secondary' }} rounded-pill">
                                    {{ ucfirst($item->status ?? '-') }}
                                </span>
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox me-2"></i>Belum ada data kehadiran anggota
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .card-modern {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
    }
    .card-header-modern {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        background: rgba(248, 250, 252, 0.3);
    }
    .card-body-modern {
        padding: 20px 24px;
    }
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
    .stat-box {
        background: rgba(99, 102, 241, 0.05);
        border: 1px solid rgba(99, 102, 241, 0.08);
        border-radius: 12px;
        padding: 16px;
    }
    .stat-box.success { background: rgba(16, 185, 129, 0.06); }
    .stat-box.warning { background: rgba(245, 158, 11, 0.07); }
    .stat-box.danger { background: rgba(239, 68, 68, 0.06); }
    .stat-label {
        display: block;
        color: #64748b;
        font-size: 12px;
        margin-bottom: 4px;
    }
    .stat-box h4 {
        margin: 0;
        font-weight: 700;
        color: #0f172a;
    }
</style>
@endsection
