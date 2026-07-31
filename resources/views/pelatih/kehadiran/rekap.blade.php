@extends('layouts.app')

@section('title', 'Rekap Kehadiran')
@section('subtitle', 'Rekapitulasi kehadiran anggota')

@section('content')
<div class="card-modern">
    <div class="card-header-modern">
        <h6><i class="fas fa-chart-bar me-2" style="color: #6366f1;"></i>Rekap Kehadiran</h6>
        <span class="badge-soft">{{ $ekskul->nama_ekskul }}</span>
    </div>
    <div class="card-body-modern">
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
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekap as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle">
                                    {{ strtoupper(substr($item->anggota->name, 0, 1)) }}
                                </div>
                                <span>{{ $item->anggota->name }}</span>
                            </div>
                        </td>
                        <td><span class="badge-custom active">{{ $item->hadir }}</span></td>
                        <td><span class="badge-custom" style="background: rgba(245, 158, 11, 0.08); color: #f59e0b;">{{ $item->izin }}</span></td>
                        <td><span class="badge-custom" style="background: rgba(239, 68, 68, 0.06); color: #ef4444;">{{ $item->sakit }}</span></td>
                        <td><span class="badge-custom" style="background: rgba(0,0,0,0.04); color: #94a3b8;">{{ $item->alpa }}</span></td>
                        <td><strong>{{ $item->total }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox me-2"></i>Belum ada data kehadiran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection