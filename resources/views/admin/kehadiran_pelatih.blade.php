@extends('layouts.app')

@section('title', 'Kehadiran Pelatih')
@section('subtitle', 'Lihat kehadiran pelatih')

@section('content')
@php
    $statusColors = [
        'hadir' => '#10b981',
        'izin' => '#f59e0b',
        'sakit' => '#ef4444',
        'alpa' => '#94a3b8',
    ];
    $statusLabels = [
        'hadir' => 'Hadir',
        'izin' => 'Izin',
        'sakit' => 'Sakit',
        'alpa' => 'Alpa',
    ];
@endphp

<div class="card-modern mb-4" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-header-modern" style="padding: 16px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); background: linear-gradient(135deg, #f0f9ff, #e0f2fe);">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
            <h6 style="font-weight: 600; font-size: 14px; color: #0f172a;">
                <i class="fas fa-user-check me-2" style="color: #0ea5e9;"></i>Rekap Bulanan Kehadiran Pelatih
            </h6>
            <form method="GET" action="{{ route('admin.kehadiran_pelatih') }}" class="d-flex align-items-center gap-2">
                <input type="month" name="month" value="{{ $selectedMonth }}" class="form-control form-control-sm" style="min-width: 180px; border: 2px solid #e2e8f0; border-radius: 10px; padding: 6px 12px; font-size: 13px;">
                <button type="submit" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; padding: 6px 20px; border-radius: 10px; color: #fff; font-weight: 500; font-size: 13px; box-shadow: 0 2px 12px rgba(14,165,233,0.25);">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </form>
        </div>
    </div>

    <div class="card-body-modern" style="padding: 20px 24px;">
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="stat-box" style="background: rgba(14,165,233,0.05); border: 1px solid rgba(14,165,233,0.08); border-radius: 12px; padding: 16px;">
                    <span class="stat-label" style="display: block; color: #64748b; font-size: 12px; margin-bottom: 4px;">Total Catatan</span>
                    <h4 style="margin: 0; font-weight: 700; color: #0f172a;">{{ $statistikBulanan['total'] ?? 0 }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box success" style="background: rgba(16,185,129,0.06); border: 1px solid rgba(16,185,129,0.08); border-radius: 12px; padding: 16px;">
                    <span class="stat-label" style="display: block; color: #64748b; font-size: 12px; margin-bottom: 4px;">Hadir</span>
                    <h4 style="margin: 0; font-weight: 700; color: #0f172a;">{{ $statistikBulanan['hadir'] ?? 0 }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box warning" style="background: rgba(245,158,11,0.07); border: 1px solid rgba(245,158,11,0.08); border-radius: 12px; padding: 16px;">
                    <span class="stat-label" style="display: block; color: #64748b; font-size: 12px; margin-bottom: 4px;">Izin</span>
                    <h4 style="margin: 0; font-weight: 700; color: #0f172a;">{{ $statistikBulanan['izin'] ?? 0 }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box danger" style="background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.08); border-radius: 12px; padding: 16px;">
                    <span class="stat-label" style="display: block; color: #64748b; font-size: 12px; margin-bottom: 4px;">Sakit & Alpa</span>
                    <h4 style="margin: 0; font-weight: 700; color: #0f172a;">{{ ($statistikBulanan['sakit'] ?? 0) + ($statistikBulanan['alpa'] ?? 0) }}</h4>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table-modern" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th width="5%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">No</th>
                        <th width="22%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Nama Pelatih</th>
                        <th width="18%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Ekskul</th>
                        <th width="12%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Hadir</th>
                        <th width="12%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Izin</th>
                        <th width="12%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Sakit</th>
                        <th width="12%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Alpa</th>
                        <th width="7%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">%</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapBulanan as $index => $rekap)
                        <tr style="transition: all 0.3s ease;">
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.04); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $index + 1 }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle" style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 13px; flex-shrink: 0; box-shadow: 0 2px 12px rgba(14,165,233,0.15);">
                                        {{ strtoupper(substr($rekap['pelatih']->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color: #0f172a;">{{ $rekap['pelatih']->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="badge-soft" style="background: rgba(14,165,233,0.05); color: #0ea5e9; padding: 2px 14px; border-radius: 12px; font-size: 11px; font-weight: 500;">{{ $rekap['ekskul']->nama_ekskul ?? '-' }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="badge bg-success rounded-pill" style="background: #10b981; color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 500;">{{ $rekap['hadir'] }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="badge bg-warning rounded-pill" style="background: #f59e0b; color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 500;">{{ $rekap['izin'] }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="badge bg-danger rounded-pill" style="background: #ef4444; color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 500;">{{ $rekap['sakit'] }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="badge bg-secondary rounded-pill" style="background: #94a3b8; color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 500;">{{ $rekap['alpa'] }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <strong style="color: #0f172a;">{{ $rekap['persentase_hadir'] }}%</strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted" style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; text-align: center; color: #94a3b8;">
                                <i class="fas fa-inbox me-2"></i>Belum ada data rekap bulanan untuk bulan ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card-modern" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-header-modern" style="padding: 16px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); background: linear-gradient(135deg, #f0f9ff, #e0f2fe);">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
            <h6 style="font-weight: 600; font-size: 14px; color: #0f172a;">
                <i class="fas fa-list me-2" style="color: #0ea5e9;"></i>Detail Kehadiran Pelatih
            </h6>
            <span class="badge-soft" style="background: rgba(14,165,233,0.05); color: #0ea5e9; padding: 2px 14px; border-radius: 12px; font-size: 11px; font-weight: 500;">{{ $kehadiran->count() }} catatan</span>
        </div>
    </div>

    <div class="card-body-modern p-0" style="padding: 0;">
        <div class="table-responsive">
            <table class="table-modern" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th width="5%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">No</th>
                        <th width="25%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Nama Pelatih</th>
                        <th width="20%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Ekskul</th>
                        <th width="15%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Tanggal</th>
                        <th width="15%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Status</th>
                        <th width="20%" style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kehadiran as $index => $item)
                        <tr style="transition: all 0.3s ease;">
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.04); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $index + 1 }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle" style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 13px; flex-shrink: 0; box-shadow: 0 2px 12px rgba(14,165,233,0.15);">
                                        {{ strtoupper(substr($item->pelatih->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color: #0f172a;">{{ $item->pelatih->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="badge-soft" style="background: rgba(14,165,233,0.05); color: #0ea5e9; padding: 2px 14px; border-radius: 12px; font-size: 11px; font-weight: 500;">{{ $item->ekskul->nama_ekskul ?? '-' }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="badge rounded-pill" style="background: {{ $statusColors[$item->status] ?? '#94a3b8' }}; color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                    {{ $statusLabels[$item->status] ?? ucfirst($item->status ?? '-') }}
                                </span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted" style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; text-align: center; color: #94a3b8;">
                                <i class="fas fa-inbox me-2"></i>Belum ada data kehadiran pelatih
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .table-modern tbody tr:hover {
        background: rgba(14,165,233,0.015);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(14,165,233,0.35);
    }
</style>
@endsection