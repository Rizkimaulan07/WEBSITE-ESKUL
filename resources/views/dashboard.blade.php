@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@if($user->role == 'admin')
{{-- ADMIN DASHBOARD --}}
<div class="row g-3 g-md-4">
    <!-- Welcome Banner -->
    <div class="col-12" data-aos="fade-up">
        <div class="welcome-banner p-4 p-md-5 rounded-4 text-white" 
             style="background: linear-gradient(135deg, #6C63FF, #3D3B8A, #1a1a3e); position: relative; overflow: hidden;">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="bi bi-grid-1x2-fill" style="font-size: 120px;"></i>
            </div>
            <div class="position-relative" style="z-index: 1;">
                <h2 class="fw-bold display-6">👋 Selamat Datang, {{ $user->name }}!</h2>
                <p class="opacity-75 mb-0">Kelola seluruh ekstrakurikuler dengan mudah dan profesional</p>
                <div class="mt-3 d-flex flex-wrap gap-2">
                    <span class="badge bg-white text-dark px-3 py-2">
                        <i class="bi bi-calendar me-1"></i> {{ now()->format('d F Y') }}
                    </span>
                    <span class="badge bg-white text-dark px-3 py-2">
                        <i class="bi bi-clock me-1"></i> {{ now()->format('H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card glass-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-icon" style="background: rgba(108, 99, 255, 0.15); color: var(--primary);">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                    <div class="stat-number mt-2">{{ $data['total_ekskul'] ?? 0 }}</div>
                    <div class="stat-label">Total Ekskul</div>
                </div>
                <div class="stat-trend text-success">
                    <i class="bi bi-arrow-up"></i> 12%
                </div>
            </div>
            <div class="progress-custom mt-3">
                <div class="progress-bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-card glass-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-icon" style="background: rgba(46, 213, 115, 0.15); color: #2ED573;">
                        <i class="bi bi-person-badge fs-3"></i>
                    </div>
                    <div class="stat-number mt-2">{{ $data['total_pelatih'] ?? 0 }}</div>
                    <div class="stat-label">Total Pelatih</div>
                </div>
                <div class="stat-trend text-success">
                    <i class="bi bi-arrow-up"></i> 8%
                </div>
            </div>
            <div class="progress-custom mt-3">
                <div class="progress-bar" style="width: 100%; background: linear-gradient(90deg, #2ED573, #059669);"></div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-card glass-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-icon" style="background: rgba(255, 165, 2, 0.15); color: #FFA502;">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div class="stat-number mt-2">{{ $data['total_anggota'] ?? 0 }}</div>
                    <div class="stat-label">Total Anggota</div>
                </div>
                <div class="stat-trend text-success">
                    <i class="bi bi-arrow-up"></i> 5%
                </div>
            </div>
            <div class="progress-custom mt-3">
                <div class="progress-bar" style="width: 100%; background: linear-gradient(90deg, #FFA502, #F97316);"></div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
        <div class="stat-card glass-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-icon" style="background: rgba(255, 71, 87, 0.15); color: #FF4757;">
                        <i class="bi bi-calendar-check fs-3"></i>
                    </div>
                    <div class="stat-number mt-2">{{ $data['total_kehadiran_hari_ini'] ?? 0 }}</div>
                    <div class="stat-label">Kehadiran Hari Ini</div>
                </div>
                <div class="stat-trend text-danger">
                    <i class="bi bi-arrow-down"></i> 3%
                </div>
            </div>
            <div class="progress-custom mt-3">
                <div class="progress-bar" style="width: 75%; background: linear-gradient(90deg, #FF4757, #FF6B6B);"></div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="col-12 col-lg-8" data-aos="fade-up" data-aos-delay="500">
        <div class="card-modern glass-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up me-2"></i> Statistik Kehadiran</span>
                <span class="badge bg-primary rounded-pill">Bulan Ini</span>
            </div>
            <div class="card-body">
                <canvas id="kehadiranChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4" data-aos="fade-up" data-aos-delay="600">
        <div class="card-modern glass-card">
            <div class="card-header">
                <i class="bi bi-clock-history me-2"></i> Aktivitas Terbaru
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex align-items-center gap-3" style="background: transparent; border-color: var(--border-color);">
                        <div class="bg-primary rounded-circle p-2 text-white">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Ekskul Baru</h6>
                            <small class="text-muted">Paskibra ditambahkan</small>
                        </div>
                        <span class="ms-auto text-muted small">2 jam lalu</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center gap-3" style="background: transparent; border-color: var(--border-color);">
                        <div class="bg-success rounded-circle p-2 text-white">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Anggota Baru</h6>
                            <small class="text-muted">5 anggota bergabung</small>
                        </div>
                        <span class="ms-auto text-muted small">5 jam lalu</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center gap-3" style="background: transparent; border-color: var(--border-color);">
                        <div class="bg-warning rounded-circle p-2 text-white">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Kehadiran</h6>
                            <small class="text-muted">Kehadiran hari ini</small>
                        </div>
                        <span class="ms-auto text-muted small">8 jam lalu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif($user->role == 'pelatih')
{{-- PELATIH DASHBOARD --}}
<div class="row g-3 g-md-4">
    <!-- Welcome -->
    <div class="col-12" data-aos="fade-up">
        <div class="welcome-banner p-4 p-md-5 rounded-4 text-white" 
             style="background: linear-gradient(135deg, #6C63FF, #3D3B8A, #1a1a3e); position: relative; overflow: hidden;">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="bi bi-trophy" style="font-size: 100px;"></i>
            </div>
            <div class="position-relative" style="z-index: 1;">
                <h2 class="fw-bold display-6">🎯 Selamat Datang, {{ $user->name }}!</h2>
                <p class="opacity-75 mb-0">Ekskul {{ $data['ekskul']->nama_ekskul ?? 'Belum ada ekskul' }}</p>
                <div class="mt-3">
                    <span class="badge bg-white text-dark px-3 py-2">
                        <i class="bi bi-people me-1"></i> {{ $data['jumlah_anggota'] ?? 0 }} Anggota
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: rgba(108, 99, 255, 0.15); color: var(--primary);">
                <i class="bi bi-people fs-3"></i>
            </div>
            <div class="stat-number">{{ $data['jumlah_anggota'] ?? 0 }}</div>
            <div class="stat-label">Jumlah Anggota</div>
        </div>
    </div>

    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: rgba(46, 213, 115, 0.15); color: #2ED573;">
                <i class="bi bi-calendar-check fs-3"></i>
            </div>
            <div class="stat-number">{{ $data['kehadiran_bulan_ini'] ?? 0 }}</div>
            <div class="stat-label">Kehadiran Bulan Ini</div>
        </div>
    </div>

    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: rgba(46, 213, 115, 0.15); color: #2ED573;">
                <i class="bi bi-check-circle fs-3"></i>
            </div>
            <div class="stat-number">{{ $data['hadir'] ?? 0 }}</div>
            <div class="stat-label">Hadir</div>
        </div>
    </div>

    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: rgba(255, 71, 87, 0.15); color: #FF4757;">
                <i class="bi bi-x-circle fs-3"></i>
            </div>
            <div class="stat-number">{{ $data['alpa'] ?? 0 }}</div>
            <div class="stat-label">Alpa</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-12" data-aos="fade-up" data-aos-delay="500">
        <div class="card-modern glass-card">
            <div class="card-header">
                <i class="bi bi-lightning me-2"></i> Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('kehadiran.index') }}" class="btn btn-primary w-100 py-3 rounded-3 hover-lift">
                            <i class="bi bi-clipboard-check fs-2 d-block mb-1"></i>
                            <small>Input Kehadiran</small>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('dokumentasi.create') }}" class="btn btn-success w-100 py-3 rounded-3 hover-lift">
                            <i class="bi bi-camera fs-2 d-block mb-1"></i>
                            <small>Upload Foto</small>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('surat.create') }}" class="btn btn-warning w-100 py-3 rounded-3 hover-lift">
                            <i class="bi bi-file-word fs-2 d-block mb-1"></i>
                            <small>Buat Surat</small>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('kehadiran.rekap') }}" class="btn btn-info w-100 py-3 rounded-3 hover-lift">
                            <i class="bi bi-bar-chart fs-2 d-block mb-1"></i>
                            <small>Lihat Rekap</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif($user->role == 'anggota')
{{-- ANGGOTA DASHBOARD --}}
<div class="row g-3 g-md-4">
    <!-- Welcome -->
    <div class="col-12" data-aos="fade-up">
        <div class="welcome-banner p-4 p-md-5 rounded-4 text-white" 
             style="background: linear-gradient(135deg, #6C63FF, #3D3B8A, #1a1a3e); position: relative; overflow: hidden;">
            <div class="position-absolute top-0 end-0 opacity-25">
                <i class="bi bi-person" style="font-size: 100px;"></i>
            </div>
            <div class="position-relative" style="z-index: 1;">
                <h2 class="fw-bold display-6">👋 Halo, {{ $user->name }}!</h2>
                <p class="opacity-75 mb-0">Pantau progress kehadiranmu di sini</p>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: rgba(108, 99, 255, 0.15); color: var(--primary);">
                <i class="bi bi-calendar3 fs-3"></i>
            </div>
            <div class="stat-number">{{ $data['total_kehadiran'] ?? 0 }}</div>
            <div class="stat-label">Total Kehadiran</div>
        </div>
    </div>

    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: rgba(46, 213, 115, 0.15); color: #2ED573;">
                <i class="bi bi-check-circle fs-3"></i>
            </div>
            <div class="stat-number">{{ $data['hadir'] ?? 0 }}</div>
            <div class="stat-label">Hadir</div>
        </div>
    </div>

    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: rgba(255, 165, 2, 0.15); color: #FFA502;">
                <i class="bi bi-clock fs-3"></i>
            </div>
            <div class="stat-number">{{ $data['izin'] ?? 0 }}</div>
            <div class="stat-label">Izin</div>
        </div>
    </div>

    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: rgba(255, 71, 87, 0.15); color: #FF4757;">
                <i class="bi bi-x-circle fs-3"></i>
            </div>
            <div class="stat-number">{{ $data['alpa'] ?? 0 }}</div>
            <div class="stat-label">Alpa</div>
        </div>
    </div>

    <!-- Progress -->
    <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="card-modern glass-card">
            <div class="card-header">
                <i class="bi bi-graph-up me-2"></i> Progress Kehadiran
            </div>
            <div class="card-body text-center">
                <div class="position-relative d-inline-block">
                    <svg width="150" height="150" viewBox="0 0 150 150">
                        <circle cx="75" cy="75" r="60" fill="none" stroke="var(--border-color)" stroke-width="12"/>
                        <circle cx="75" cy="75" r="60" fill="none" stroke="#6C63FF" stroke-width="12"
                                stroke-dasharray="376.99" 
                                stroke-dashoffset="{{ 376.99 - (376.99 * ($data['persentase_hadir'] ?? 0) / 100) }}"
                                stroke-linecap="round"
                                transform="rotate(-90 75 75)"/>
                    </svg>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <span class="display-6 fw-bold" style="color: var(--primary);">
                            {{ $data['persentase_hadir'] ?? 0 }}%
                        </span>
                        <br>
                        <small class="text-muted">Kehadiran</small>
                    </div>
                </div>
                <div class="row g-2 mt-3">
                    <div class="col-3"><span class="badge-status badge-hadir">Hadir {{ $data['hadir'] ?? 0 }}</span></div>
                    <div class="col-3"><span class="badge-status badge-izin">Izin {{ $data['izin'] ?? 0 }}</span></div>
                    <div class="col-3"><span class="badge-status badge-sakit">Sakit {{ $data['sakit'] ?? 0 }}</span></div>
                    <div class="col-3"><span class="badge-status badge-alpa">Alpa {{ $data['alpa'] ?? 0 }}</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat -->
    <div class="col-12 col-md-6" data-aos="fade-up" data-aos-delay="600">
        <div class="card-modern glass-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i> Riwayat Terbaru</span>
                <a href="{{ route('anggota.dashboard') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($data['riwayat_terbaru'] ?? [] as $kehadiran)
                    <div class="list-group-item d-flex justify-content-between align-items-center" 
                         style="background: transparent; border-color: var(--border-color);">
                        <div>
                            <span class="badge-status badge-{{ $kehadiran->status }} me-2">
                                {{ ucfirst($kehadiran->status) }}
                            </span>
                            <span>{{ $kehadiran->tanggal->format('d M Y') }}</span>
                        </div>
                        <small class="text-muted">{{ $kehadiran->ekskul->nama_ekskul ?? '-' }}</small>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted" style="background: transparent;">
                        Belum ada riwayat kehadiran
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
@if($user->role == 'admin')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('kehadiranChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Kehadiran',
                data: [12, 19, 15, 17, 14, 10, 8],
                backgroundColor: 'rgba(108, 99, 255, 0.7)',
                borderColor: 'rgba(108, 99, 255, 1)',
                borderWidth: 2,
                borderRadius: 8,
                barPercentage: 0.6,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'var(--border-color)' }
                },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endif
@endpush