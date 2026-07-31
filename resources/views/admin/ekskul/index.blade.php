@extends('layouts.app')

@section('title', 'Ekstrakurikuler')
@section('subtitle', 'Kelola semua ekstrakurikuler')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card blue">
            <div class="stat-icon blue">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Ekskul</span>
                <h3 class="stat-number">{{ $ekskuls->total() }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-arrow-up me-1"></i> {{ $ekskuls->where('status', 'aktif')->count() }} aktif
                </span>
            </div>
            <div class="stat-progress">
                <div class="progress-bar" style="width: {{ $ekskuls->total() > 0 ? ($ekskuls->where('status', 'aktif')->count() / $ekskuls->total()) * 100 : 0 }}%;"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card gold">
            <div class="stat-icon gold">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Anggota</span>
                <h3 class="stat-number">{{ $ekskuls->sum('users_count') }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-user-plus me-1"></i> Terdaftar
                </span>
            </div>
            <div class="stat-meta">
                <span class="badge-soft">Rata-rata {{ $ekskuls->total() > 0 ? round($ekskuls->sum('users_count') / $ekskuls->total()) : 0 }} per ekskul</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Pembina</span>
                <h3 class="stat-number">{{ $ekskuls->pluck('pembina')->unique()->count() }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-star me-1"></i> Profesional
                </span>
            </div>
            <div class="stat-meta">
                <span class="badge-soft">Pembina berpengalaman</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card purple">
            <div class="stat-icon purple">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Status Ekskul</span>
                <div class="d-flex gap-2 mt-1">
                    <span class="status-badge active">🟢 Aktif</span>
                    <span class="status-badge inactive">🔴 Nonaktif</span>
                </div>
                <span class="stat-change up">
                    <i class="fas fa-percent me-1"></i> 
                    {{ $ekskuls->total() > 0 ? round(($ekskuls->where('status', 'aktif')->count() / $ekskuls->total()) * 100) : 0 }}% aktif
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter -->
<div class="card-modern mb-4">
    <div class="card-body-modern">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Cari ekstrakurikuler..." id="searchInput">
                </div>
            </div>
            <div class="col-md-7">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                    <select class="filter-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="aktif">🟢 Aktif</option>
                        <option value="nonaktif">🔴 Nonaktif</option>
                    </select>
                    <button class="btn-reset" onclick="resetFilters()">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <a href="{{ route('admin.ekskul.create') }}" class="btn-primary-custom">
                        <i class="fas fa-plus me-2"></i> Tambah Ekskul
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card-modern">
    <div class="card-header-modern">
        <div class="d-flex align-items-center gap-3">
            <h6><i class="fas fa-list me-2" style="color: #6366f1;"></i>Daftar Ekstrakurikuler</h6>
            <span class="badge-count">{{ $ekskuls->total() }} total</span>
        </div>
    </div>
    <div class="card-body-modern p-0">
        <div class="table-responsive">
            <table class="table-modern" id="ekskulTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Logo</th>
                        <th>Nama Ekskul</th>
                        <th>Pembina</th>
                        <th>Jadwal</th>
                        <th>Tempat</th>
                        <th>Anggota</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ekskuls as $index => $ekskul)
                    <tr data-status="{{ $ekskul->status }}">
                        <td>
                            <span class="number-badge">{{ $ekskuls->firstItem() + $index }}</span>
                        </td>
                        <td>
                            <div class="logo-wrapper" onclick="showLogo('{{ asset('storage/' . $ekskul->logo) }}')">
                                @if($ekskul->logo)
                                    <img src="{{ asset('storage/' . $ekskul->logo) }}" 
                                         alt="{{ $ekskul->nama_ekskul }}" 
                                         class="logo-img">
                                @else
                                    <div class="logo-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="ekskul-name">
                                <span class="fw-semibold">{{ $ekskul->nama_ekskul }}</span>
                                <span class="ekskul-slug">{{ $ekskul->slug }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="pembina-wrapper">
                                <div class="pembina-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <span>{{ $ekskul->pembina }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="jadwal-wrapper">
                                <span class="badge-soft">{{ $ekskul->hari_latihan }}</span>
                                <span class="jam-wrapper">
                                    {{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="tempat-wrapper">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $ekskul->tempat_latihan }}
                            </span>
                        </td>
                        <td>
                            <span class="anggota-badge">
                                <i class="fas fa-user me-1"></i>
                                {{ $ekskul->users_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $ekskul->status == 'aktif' ? 'active' : 'inactive' }}">
                                {{ $ekskul->status == 'aktif' ? '🟢 Aktif' : '🔴 Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.ekskul.show', $ekskul) }}" class="btn-action view" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.ekskul.edit', $ekskul) }}" class="btn-action edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.ekskul.destroy', $ekskul) }}" 
                                      method="POST" 
                                      style="display:inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus ekskul {{ $ekskul->nama_ekskul }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="9" class="text-center py-5">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <h5 class="empty-title">Belum ada data ekstrakurikuler</h5>
                                <p class="empty-desc">Mulai tambahkan ekstrakurikuler pertama Anda</p>
                                <a href="{{ route('admin.ekskul.create') }}" class="btn-primary-custom mt-2">
                                    <i class="fas fa-plus me-2"></i> Tambah Ekskul
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer-modern">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <span class="footer-info">
                <i class="fas fa-list me-1"></i>
                Menampilkan {{ $ekskuls->firstItem() }} - {{ $ekskuls->lastItem() }} 
                dari {{ $ekskuls->total() }} data
            </span>
            <div>
                {{ $ekskuls->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Logo -->
<div class="modal fade" id="logoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Preview Logo</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <img src="" id="logoPreviewModal" alt="Logo" class="modal-logo-preview">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== STAT CARDS ===== */
    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 22px 24px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
        border-color: rgba(99, 102, 241, 0.04);
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
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.05) rotate(-2deg);
    }

    .stat-card .stat-icon.blue { background: rgba(99, 102, 241, 0.06); color: #6366f1; }
    .stat-card .stat-icon.gold { background: rgba(245, 158, 11, 0.06); color: #f59e0b; }
    .stat-card .stat-icon.green { background: rgba(16, 185, 129, 0.06); color: #10b981; }
    .stat-card .stat-icon.purple { background: rgba(139, 92, 246, 0.06); color: #8b5cf6; }

    .stat-card .stat-body {
        flex: 1;
    }

    .stat-card .stat-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin: 2px 0;
        letter-spacing: -0.5px;
    }

    .stat-change {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-change.up {
        background: rgba(16, 185, 129, 0.06);
        color: #10b981;
    }

    .stat-change.down {
        background: rgba(239, 68, 68, 0.06);
        color: #ef4444;
    }

    .stat-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(0,0,0,0.03);
    }

    .stat-progress .progress-bar {
        height: 100%;
        border-radius: 0;
        transition: width 0.6s ease;
    }

    .stat-card.blue .progress-bar { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .stat-card.gold .progress-bar { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-card.green .progress-bar { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-card.purple .progress-bar { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

    .stat-meta {
        margin-top: 8px;
    }

    .badge-soft {
        background: rgba(99, 102, 241, 0.05);
        color: #6366f1;
        padding: 2px 14px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    /* ===== CARD MODERN ===== */
    .card-modern {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .card-modern:hover {
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.06);
    }

    .card-body-modern {
        padding: 20px 24px;
    }

    .card-header-modern {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        background: rgba(248, 250, 252, 0.3);
    }

    .card-header-modern h6 {
        font-weight: 600;
        font-size: 14px;
        color: #0f172a;
        margin: 0;
    }

    .card-footer-modern {
        padding: 14px 24px;
        border-top: 1px solid rgba(0,0,0,0.02);
        background: rgba(248, 250, 252, 0.2);
    }

    .badge-count {
        background: rgba(99, 102, 241, 0.06);
        color: #6366f1;
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    /* ===== SEARCH ===== */
    .search-wrapper {
        position: relative;
    }

    .search-wrapper .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-wrapper .search-input {
        width: 100%;
        padding: 10px 16px 10px 42px;
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 10px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        background: #f8fafc;
        transition: all 0.3s ease;
        color: #0f172a;
    }

    .search-wrapper .search-input:focus {
        outline: none;
        border-color: #6366f1;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.04);
    }

    .search-wrapper .search-input::placeholder {
        color: #94a3b8;
    }

    /* ===== FILTER ===== */
    .filter-select {
        padding: 10px 16px;
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 10px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        background: #f8fafc;
        color: #0f172a;
        transition: all 0.3s ease;
        cursor: pointer;
        min-width: 140px;
    }

    .filter-select:focus {
        outline: none;
        border-color: #6366f1;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.04);
    }

    .btn-reset {
        padding: 10px 20px;
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 10px;
        background: #f8fafc;
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-reset:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .btn-primary-custom {
        padding: 10px 24px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(99, 102, 241, 0.35);
        color: #fff;
        text-decoration: none;
    }

    /* ===== TABLE ===== */
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

    .table-modern tbody tr {
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover {
        background: rgba(99, 102, 241, 0.012);
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== NUMBER BADGE ===== */
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

    /* ===== LOGO ===== */
    .logo-wrapper {
        cursor: pointer;
    }

    .logo-img {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid rgba(99, 102, 241, 0.04);
        transition: all 0.3s ease;
    }

    .logo-img:hover {
        transform: scale(1.05);
        border-color: #6366f1;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.15);
    }

    .logo-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(99, 102, 241, 0.04);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        border: 1px dashed rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }

    .logo-placeholder:hover {
        background: rgba(99, 102, 241, 0.06);
        transform: scale(1.05);
    }

    /* ===== EKSKUL NAME ===== */
    .ekskul-name {
        display: flex;
        flex-direction: column;
    }

    .ekskul-name .fw-semibold {
        font-weight: 600;
        color: #0f172a;
    }

    .ekskul-name .ekskul-slug {
        font-size: 11px;
        color: #94a3b8;
    }

    /* ===== PEMBINA ===== */
    .pembina-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pembina-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(99, 102, 241, 0.04);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        font-size: 12px;
    }

    /* ===== JADWAL ===== */
    .jadwal-wrapper {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .jam-wrapper {
        font-size: 11px;
        color: #94a3b8;
    }

    /* ===== TEMPAT ===== */
    .tempat-wrapper {
        font-size: 12px;
        color: #475569;
    }

    /* ===== ANGGOTA BADGE ===== */
    .anggota-badge {
        background: rgba(99, 102, 241, 0.04);
        color: #6366f1;
        padding: 2px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 500;
    }

    /* ===== STATUS BADGE ===== */
    .status-badge {
        padding: 3px 14px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 500;
    }

    .status-badge.active {
        background: rgba(16, 185, 129, 0.06);
        color: #10b981;
    }

    .status-badge.inactive {
        background: rgba(239, 68, 68, 0.06);
        color: #ef4444;
    }

    /* ===== ACTION BUTTONS ===== */
    .action-buttons {
        display: flex;
        gap: 4px;
        justify-content: center;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        background: transparent;
        color: #94a3b8;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-action.view:hover {
        background: rgba(99, 102, 241, 0.06);
        color: #6366f1;
    }

    .btn-action.edit:hover {
        background: rgba(245, 158, 11, 0.06);
        color: #f59e0b;
    }

    .btn-action.delete:hover {
        background: rgba(239, 68, 68, 0.06);
        color: #ef4444;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        padding: 40px 0;
    }

    .empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(99, 102, 241, 0.04);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #94a3b8;
        margin-bottom: 16px;
    }

    .empty-title {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .empty-desc {
        color: #94a3b8;
        font-size: 13px;
        margin-bottom: 16px;
    }

    /* ===== FOOTER INFO ===== */
    .footer-info {
        font-size: 12px;
        color: #94a3b8;
    }

    /* ===== MODAL ===== */
    .modal-content {
        border: none;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.08);
    }

    .modal-header {
        border-bottom: 1px solid rgba(0,0,0,0.02);
        padding: 16px 20px;
    }

    .modal-footer {
        border-top: 1px solid rgba(0,0,0,0.02);
        padding: 12px 20px;
    }

    .modal-logo-preview {
        max-width: 100%;
        max-height: 300px;
        border-radius: 10px;
    }

    .btn-modal-close {
        padding: 8px 24px;
        border: none;
        border-radius: 8px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-modal-close:hover {
        background: #e2e8f0;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .stat-card {
            padding: 16px 18px;
        }
        .stat-card .stat-number {
            font-size: 22px;
        }
        .card-header-modern {
            flex-direction: column;
            align-items: stretch;
            padding: 14px 16px;
        }
        .card-body-modern {
            padding: 14px 16px;
        }
        .card-footer-modern {
            padding: 12px 16px;
        }
        .action-buttons {
            gap: 2px;
        }
        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }
    }
</style>

<script>
    // Search Function
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        filterTable();
    });

    document.getElementById('filterStatus')?.addEventListener('change', function() {
        filterTable();
    });

    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('filterStatus').value;
        
        const rows = document.querySelectorAll('.table-modern tbody tr');
        let visibleCount = 0;
        let visibleNumber = 0;
        
        rows.forEach(row => {
            if (row.id === 'emptyRow') return;
            
            const text = row.textContent.toLowerCase();
            const rowStatus = row.dataset.status || '';
            
            const matchSearch = text.includes(search);
            const matchStatus = !statusFilter || rowStatus === statusFilter;
            
            if (matchSearch && matchStatus) {
                row.style.display = '';
                visibleCount++;
                visibleNumber++;
                const numberBadge = row.querySelector('.number-badge');
                if (numberBadge) {
                    numberBadge.textContent = visibleNumber;
                }
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('filterStatus').value = '';
        filterTable();
    }
    
    // Logo Preview Modal
    function showLogo(src) {
        if (src && src !== '') {
            document.getElementById('logoPreviewModal').src = src;
            new bootstrap.Modal(document.getElementById('logoModal')).show();
        }
    }
</script>
@endsection