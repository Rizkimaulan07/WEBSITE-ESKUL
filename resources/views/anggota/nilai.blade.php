@extends('layouts.app')

@section('title', 'Nilai Saya')
@section('subtitle', 'Lihat nilai Anda')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card blue">
            <div class="stat-icon blue">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Nilai</span>
                <h3 class="stat-number">{{ $statistik['total'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Rata-rata</span>
                <h3 class="stat-number">{{ number_format($statistik['rata_rata'] ?? 0, 1) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card gold">
            <div class="stat-icon gold">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Tertinggi</span>
                <h3 class="stat-number">{{ $statistik['tertinggi'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="stat-icon danger">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Terendah</span>
                <h3 class="stat-number">{{ $statistik['terendah'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-list me-2"></i>Daftar Nilai</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nilai</th>
                        <th>Keterangan</th>
                        <th>Tanggal Input</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="badge bg-{{ $item->nilai >= 80 ? 'success' : ($item->nilai >= 70 ? 'warning' : 'danger') }}">
                                {{ $item->nilai }}
                            </span>
                        </td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data nilai</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $nilai->links() }}
    </div>
</div>

<style>
    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px 24px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }
    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-card .stat-icon.blue { background: rgba(99, 102, 241, 0.06); color: #6366f1; }
    .stat-card .stat-icon.green { background: rgba(16, 185, 129, 0.06); color: #10b981; }
    .stat-card .stat-icon.gold { background: rgba(245, 158, 11, 0.06); color: #f59e0b; }
    .stat-card .stat-icon.danger { background: rgba(239, 68, 68, 0.06); color: #ef4444; }
    .stat-card .stat-body { flex: 1; }
    .stat-card .stat-label { font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-card .stat-number { font-size: 28px; font-weight: 700; color: #0f172a; margin: 2px 0; letter-spacing: -0.5px; }
</style>
@endsection