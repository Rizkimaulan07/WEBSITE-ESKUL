@extends('layouts.app')

@section('title', 'Manajemen Anggota')

@section('content')
<div class="container-fluid px-4">
    <!-- Header dengan Background Gradient -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm overflow-hidden" 
                 style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="text-white fw-bold display-6 mb-2">
                                <i class="fas fa-users me-3"></i>Manajemen Anggota
                            </h1>
                            <p class="text-white-50 mb-0 fs-5">
                                Kelola semua anggota ekstrakurikuler di sekolah Anda
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('anggota.create') }}" 
                               class="btn btn-light btn-lg rounded-pill px-5 shadow-sm">
                                <i class="fas fa-user-plus me-2"></i>Tambah Anggota
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-lg mb-4" 
             style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);" role="alert">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-check-circle fa-2x text-white"></i>
                </div>
                <div class="text-white">
                    <h5 class="fw-bold mb-0">Berhasil!</h5>
                    <p class="mb-0">{{ session('success') }}</p>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistik Cards Premium -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Anggota</p>
                            <h2 class="fw-bold mb-0 text-primary">{{ $anggotas->total() }}</h2>
                        </div>
                        <div class="icon-wrapper bg-primary">
                            <i class="fas fa-user-graduate text-white fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                            <i class="fas fa-arrow-up me-1"></i>+{{ $anggotas->count() }} anggota baru
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Ekskul</p>
                            <h2 class="fw-bold mb-0 text-success">{{ $anggotas->pluck('ekskul_id')->unique()->count() }}</h2>
                        </div>
                        <div class="icon-wrapper bg-success">
                            <i class="fas fa-school text-white fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                            <i class="fas fa-users me-1"></i>Ekskul aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Kelas Terbanyak</p>
                            <h2 class="fw-bold mb-0 text-info">{{ $anggotas->pluck('kelas')->mode()->first() ?? '-' }}</h2>
                        </div>
                        <div class="icon-wrapper bg-info">
                            <i class="fas fa-chart-bar text-white fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill">
                            <i class="fas fa-users me-1"></i>Kelas terbanyak
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Anggota Aktif</p>
                            <h2 class="fw-bold mb-0 text-warning">{{ $anggotas->count() }}</h2>
                        </div>
                        <div class="icon-wrapper bg-warning">
                            <i class="fas fa-user-check text-white fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">
                            <i class="fas fa-percent me-1"></i>100% aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-0 bg-light rounded-pill ps-0" 
                               placeholder="Cari anggota berdasarkan nama, email, atau kelas..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                        <select class="form-select form-select-sm rounded-pill bg-light border-0" style="width: auto;" id="filterEkskul">
                            <option value="">Semua Ekskul</option>
                            @foreach($ekskuls ?? [] as $ekskul)
                                <option value="{{ $ekskul->id }}">{{ $ekskul->nama_ekskul }}</option>
                            @endforeach
                        </select>
                        <select class="form-select form-select-sm rounded-pill bg-light border-0" style="width: auto;" id="filterKelas">
                            <option value="">Semua Kelas</option>
                            <option value="X-A">X-A</option>
                            <option value="X-B">X-B</option>
                            <option value="X-C">X-C</option>
                            <option value="XI-A">XI-A</option>
                            <option value="XI-B">XI-B</option>
                            <option value="XI-C">XI-C</option>
                            <option value="XII-A">XII-A</option>
                            <option value="XII-B">XII-B</option>
                            <option value="XII-C">XII-C</option>
                        </select>
                        <button class="btn btn-outline-primary rounded-pill px-4" onclick="resetFilters()">
                            <i class="fas fa-undo me-1"></i>Reset
                        </button>
                        <button class="btn btn-success rounded-pill px-4">
                            <i class="fas fa-file-excel me-1"></i>Export
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Premium -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="anggotaTable">
                    <thead style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <tr>
                            <th class="ps-4 py-3 text-white" width="5%">No</th>
                            <th class="py-3 text-white" width="5%">Avatar</th>
                            <th class="py-3 text-white" width="15%">Nama</th>
                            <th class="py-3 text-white" width="20%">Email</th>
                            <th class="py-3 text-white" width="10%">Kelas</th>
                            <th class="py-3 text-white" width="12%">No HP</th>
                            <th class="py-3 text-white" width="15%">Ekskul</th>
                            <th class="py-3 text-center text-white pe-4" width="13%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggotas as $index => $anggota)
                        <tr class="table-row">
                            <td class="ps-4">
                                <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                    {{ $anggotas->firstItem() + $index }}
                                </span>
                            </td>
                            <td>
                                <div class="avatar-wrapper">
                                    @if($anggota->avatar)
                                        <img src="{{ asset('storage/' . $anggota->avatar) }}" 
                                             alt="{{ $anggota->name }}" 
                                             class="rounded-circle avatar-img"
                                             width="45" 
                                             height="45" 
                                             style="object-fit: cover; border: 3px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                    @else
                                        <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold avatar-placeholder"
                                             style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            {{ strtoupper(substr($anggota->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $anggota->name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-id-badge me-1"></i>ID: {{ $anggota->id }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    <span>{{ $anggota->email }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                    <i class="fas fa-graduation-cap me-1"></i>
                                    {{ $anggota->kelas ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone text-success me-2"></i>
                                    <span>{{ $anggota->no_hp ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($anggota->ekskul)
                                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                                        <i class="fas fa-trophy me-1"></i>
                                        {{ $anggota->ekskul->nama_ekskul }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                                        <i class="fas fa-times me-1"></i>
                                        Belum ada ekskul
                                    </span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group action-btn-group" role="group">
                                    <a href="{{ route('anggota.show', $anggota->id) }}" 
                                       class="btn btn-sm btn-outline-info rounded-start-pill" 
                                       title="Detail" data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('anggota.edit', $anggota->id) }}" 
                                       class="btn btn-sm btn-outline-warning" 
                                       title="Edit" data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('anggota.destroy', $anggota->id) }}" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('Yakin ingin menghapus anggota {{ $anggota->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-end-pill" title="Hapus" data-bs-toggle="tooltip">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                         style="width: 100px; height: 100px;">
                                        <i class="fas fa-users-slash fa-4x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">Belum ada data anggota</h5>
                                    <p class="text-muted small">Mulai tambahkan anggota pertama Anda</p>
                                    <a href="{{ route('anggota.create') }}" class="btn btn-primary rounded-pill mt-3 px-5">
                                        <i class="fas fa-user-plus me-2"></i>Tambah Anggota Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <span class="text-muted small">
                    <i class="fas fa-list me-1"></i>
                    Menampilkan {{ $anggotas->firstItem() }} - {{ $anggotas->lastItem() }} 
                    dari {{ $anggotas->total() }} anggota
                </span>
            </div>
            <div>
                {{ $anggotas->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Anggota -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Detail Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Icon Wrapper */
    .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .icon-wrapper.bg-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .icon-wrapper.bg-success { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); }
    .icon-wrapper.bg-info { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }
    .icon-wrapper.bg-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    
    /* Hover Card */
    .hover-card {
        transition: all 0.3s ease;
        cursor: default;
    }
    
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12) !important;
    }
    
    /* Avatar Styles */
    .avatar-img {
        transition: all 0.3s ease;
    }
    
    .avatar-img:hover {
        transform: scale(1.1) rotate(-5deg);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2) !important;
    }
    
    .avatar-placeholder {
        transition: all 0.3s ease;
        font-size: 18px;
        font-weight: bold;
    }
    
    .avatar-placeholder:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }
    
    /* Table Row */
    .table-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f5;
    }
    
    .table-row:hover {
        background: linear-gradient(90deg, #f8f9fa 0%, #ffffff 100%);
        transform: scale(1.005);
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    
    /* Action Buttons */
    .action-btn-group .btn {
        border-radius: 0;
        border: 1px solid #e9ecef;
        padding: 8px 14px;
        transition: all 0.3s ease;
    }
    
    .action-btn-group .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    
    .action-btn-group .btn:first-child {
        border-radius: 20px 0 0 20px;
    }
    
    .action-btn-group .btn:last-child {
        border-radius: 0 20px 20px 0;
    }
    
    .action-btn-group .btn-outline-info:hover {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white !important;
        border-color: transparent;
    }
    
    .action-btn-group .btn-outline-warning:hover {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white !important;
        border-color: transparent;
    }
    
    .action-btn-group .btn-outline-danger:hover {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white !important;
        border-color: transparent;
    }
    
    /* Search Input */
    #searchInput {
        padding: 12px 20px;
        transition: all 0.3s ease;
    }
    
    #searchInput:focus {
        box-shadow: 0 0 0 3px rgba(240, 147, 251, 0.2);
        background: white !important;
    }
    
    /* Select Filter */
    .form-select-sm {
        padding: 8px 16px;
        transition: all 0.3s ease;
        min-width: 130px;
    }
    
    .form-select-sm:focus {
        box-shadow: 0 0 0 3px rgba(240, 147, 251, 0.2);
    }
    
    /* Empty State */
    .empty-state {
        padding: 60px 0;
    }
    
    /* Pagination */
    .pagination .page-item .page-link {
        border: none;
        border-radius: 10px;
        margin: 0 3px;
        color: #6c757d;
        transition: all 0.3s ease;
    }
    
    .pagination .page-item .page-link:hover {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(240, 147, 251, 0.4);
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(240, 147, 251, 0.4);
    }
    
    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .table-row {
        animation: fadeInUp 0.5s ease forwards;
    }
    
    .table-row:nth-child(1) { animation-delay: 0.05s; }
    .table-row:nth-child(2) { animation-delay: 0.1s; }
    .table-row:nth-child(3) { animation-delay: 0.15s; }
    .table-row:nth-child(4) { animation-delay: 0.2s; }
    .table-row:nth-child(5) { animation-delay: 0.25s; }
    .table-row:nth-child(6) { animation-delay: 0.3s; }
    .table-row:nth-child(7) { animation-delay: 0.35s; }
    .table-row:nth-child(8) { animation-delay: 0.4s; }
    .table-row:nth-child(9) { animation-delay: 0.45s; }
    .table-row:nth-child(10) { animation-delay: 0.5s; }
    
    /* Responsive */
    @media (max-width: 768px) {
        .display-6 {
            font-size: 1.5rem;
        }
        
        .btn-lg {
            font-size: 1rem;
            padding: 10px 20px;
        }
    }
</style>

<script>
    // Tooltip
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    
    // Search Function
    document.getElementById('searchInput').addEventListener('keyup', function() {
        filterTable();
    });
    
    // Filter Ekskul
    document.getElementById('filterEkskul').addEventListener('change', function() {
        filterTable();
    });
    
    // Filter Kelas
    document.getElementById('filterKelas').addEventListener('change', function() {
        filterTable();
    });
    
    function filterTable() {
        var searchValue = document.getElementById('searchInput').value.toLowerCase();
        var filterEkskul = document.getElementById('filterEkskul').value;
        var filterKelas = document.getElementById('filterKelas').value;
        var rows = document.querySelectorAll('#anggotaTable tbody tr');
        
        rows.forEach(function(row) {
            var text = row.textContent.toLowerCase();
            var ekskul = row.querySelector('td:nth-child(7)')?.textContent || '';
            var kelas = row.querySelector('td:nth-child(5)')?.textContent || '';
            
            var matchSearch = text.includes(searchValue);
            var matchEkskul = !filterEkskul || ekskul.includes(filterEkskul);
            var matchKelas = !filterKelas || kelas.includes(filterKelas);
            
            row.style.display = (matchSearch && matchEkskul && matchKelas) ? '' : 'none';
        });
    }
    
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('filterEkskul').value = '';
        document.getElementById('filterKelas').value = '';
        filterTable();
    }
</script>
@endsection