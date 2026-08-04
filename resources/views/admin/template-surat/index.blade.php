@extends('layouts.app')

@section('title', 'Template Surat')
@section('subtitle', 'Kelola template surat untuk berbagai keperluan')

@section('content')
<!-- ===== STATS CARDS PREMIUM ===== -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #4f46e5;">
            <div class="stat-icon" style="background: rgba(79,70,229,0.08); color: #4f46e5;">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Template</span>
                <h3 class="stat-number">{{ $templates->total() }}</h3>
                <span class="stat-trend up">
                    <i class="fas fa-arrow-up me-1"></i> Tersedia
                </span>
            </div>
            <div class="stat-progress" style="--accent: #4f46e5;"></div>
            <div class="stat-glow" style="--accent: #4f46e5;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #10b981;">
            <div class="stat-icon" style="background: rgba(16,185,129,0.08); color: #10b981;">
                <i class="fas fa-file-pdf"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Dengan File</span>
                <h3 class="stat-number">{{ $templates->whereNotNull('file_template')->count() }}</h3>
                <span class="stat-trend up">
                    <i class="fas fa-check-circle me-1"></i> Siap digunakan
                </span>
            </div>
            <div class="stat-progress" style="--accent: #10b981;"></div>
            <div class="stat-glow" style="--accent: #10b981;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #f59e0b;">
            <div class="stat-icon" style="background: rgba(245,158,11,0.08); color: #f59e0b;">
                <i class="fas fa-file-word"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Tanpa File</span>
                <h3 class="stat-number">{{ $templates->whereNull('file_template')->count() }}</h3>
                <span class="stat-trend {{ $templates->whereNull('file_template')->count() > 0 ? 'down' : 'up' }}">
                    <i class="fas {{ $templates->whereNull('file_template')->count() > 0 ? 'fa-arrow-down' : 'fa-check-circle' }} me-1"></i>
                    {{ $templates->whereNull('file_template')->count() > 0 ? 'Perlu dilengkapi' : 'Semua lengkap' }}
                </span>
            </div>
            <div class="stat-progress" style="--accent: #f59e0b;"></div>
            <div class="stat-glow" style="--accent: #f59e0b;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #8b5cf6;">
            <div class="stat-icon" style="background: rgba(139,92,246,0.08); color: #8b5cf6;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Terakhir Dibuat</span>
                <h3 class="stat-number" style="font-size: 18px;">
                    {{ $templates->first() ? $templates->first()->created_at->diffForHumans() : '-' }}
                </h3>
                <span class="stat-trend up">
                    <i class="fas fa-calendar me-1"></i> Terbaru
                </span>
            </div>
            <div class="stat-progress" style="--accent: #8b5cf6;"></div>
            <div class="stat-glow" style="--accent: #8b5cf6;"></div>
        </div>
    </div>
</div>

<!-- ===== SEARCH & FILTER ===== -->
<div class="card glass-card mb-4">
    <div class="card-body p-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Cari template surat..." id="searchInput">
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                    <select class="filter-select" id="filterFile">
                        <option value="">Semua File</option>
                        <option value="ada">Ada File</option>
                        <option value="tidak">Tidak Ada File</option>
                    </select>
                    <button class="btn-reset" onclick="resetFilters()">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <a href="{{ route('admin.template-surat.create') }}" class="btn-primary-gradient">
                        <i class="fas fa-plus me-2"></i> Tambah Template
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== TABLE PREMIUM ===== -->
<div class="card premium-table-card">
    <div class="card-header premium-table-header">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold">Daftar Template Surat</h6>
                <small class="text-muted">{{ $templates->total() }} total data</small>
            </div>
        </div>
        <div>
            <span class="badge-count">{{ $templates->total() }}</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table premium-table" id="templateTable">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Judul Template</th>
                        <th width="30%">Keterangan</th>
                        <th width="15%">File</th>
                        <th width="15%">Dibuat</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $index => $template)
                    @php $hasFile = $template->file_template ? true : false; @endphp
                    <tr class="table-row" data-file="{{ $hasFile ? 'ada' : 'tidak' }}">
                        <td>
                            <span class="number-badge">{{ $loop->iteration }}</span>
                        </td>
                        <td>
                            <div class="template-name">
                                <div class="template-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <span class="fw-bold">{{ $template->judul_template }}</span>
                                    <span class="template-slug">{{ Str::slug($template->judul_template) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="template-desc">{{ Str::limit($template->keterangan ?? '-', 60) }}</span>
                        </td>
                        <td>
                            @if($hasFile)
                                <span class="badge-file ada">
                                    <i class="fas fa-check-circle me-1"></i> Ada File
                                </span>
                            @else
                                <span class="badge-file tidak">
                                    <i class="fas fa-times-circle me-1"></i> Tidak Ada
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="date-info">
                                <span class="date-human">{{ $template->created_at->diffForHumans() }}</span>
                                <span class="date-full">{{ $template->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="action-group">
                                @if($hasFile)
                                    <a href="{{ route('admin.template-surat.download', $template->id) }}" 
                                       class="btn-action download" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.template-surat.edit', $template->id) }}" 
                                   class="btn-action edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.template-surat.destroy', $template->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus template {{ $template->judul_template }}?')">
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
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-file-alt"></i></div>
                                <h6 class="empty-title">Belum ada template</h6>
                                <p class="empty-desc">Tambahkan template surat pertama Anda</p>
                                <a href="{{ route('admin.template-surat.create') }}" class="btn-primary-gradient mt-3">
                                    <i class="fas fa-plus me-2"></i> Tambah Template
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer premium-table-footer">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="footer-info">
                <i class="fas fa-list me-1"></i>
                Menampilkan {{ $templates->firstItem() }} - {{ $templates->lastItem() }} 
                dari {{ $templates->total() }} data
            </span>
            <div>
                {{ $templates->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== STAT CARDS ===== */
    .stat-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px 28px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 60px rgba(79,70,229,0.12);
        border-color: rgba(79,70,229,0.06);
    }

    .stat-card .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        transition: all 0.4s ease;
    }

    .stat-card:hover .stat-icon { transform: scale(1.1) rotate(-3deg); }

    .stat-card .stat-body { flex: 1; }
    .stat-card .stat-label { font-size: 12px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-card .stat-number { font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px; }

    .stat-trend {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-trend.up { background: rgba(16,185,129,0.06); color: #10b981; }
    .stat-trend.down { background: rgba(239,68,68,0.06); color: #ef4444; }

    .stat-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), var(--accent));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.6s ease;
    }

    .stat-card:hover .stat-progress { transform: scaleX(1); }

    .stat-glow {
        position: absolute;
        top: -50%;
        right: -20%;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: radial-gradient(circle, var(--accent), transparent 70%);
        opacity: 0;
        transition: opacity 0.6s ease;
        pointer-events: none;
    }

    .stat-card:hover .stat-glow { opacity: 0.06; }

    /* ===== GLASS CARD ===== */
    .glass-card {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.04);
    }

    /* ===== SEARCH ===== */
    .search-wrapper { position: relative; }
    .search-wrapper .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }
    .search-wrapper .search-input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 2px solid rgba(0,0,0,0.02);
        border-radius: 12px;
        font-size: 14px;
        background: rgba(255,255,255,0.8);
        transition: all 0.3s ease;
        color: #0f172a;
        font-family: 'Inter', sans-serif;
    }
    .search-wrapper .search-input:focus {
        outline: none;
        border-color: #4f46e5;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(79,70,229,0.06);
    }

    .filter-select {
        padding: 12px 16px;
        border: 2px solid rgba(0,0,0,0.02);
        border-radius: 12px;
        font-size: 13px;
        background: rgba(255,255,255,0.8);
        color: #0f172a;
        transition: all 0.3s ease;
        cursor: pointer;
        min-width: 140px;
        font-family: 'Inter', sans-serif;
    }
    .filter-select:focus {
        outline: none;
        border-color: #4f46e5;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(79,70,229,0.06);
    }

    .btn-reset {
        padding: 12px 20px;
        border: 2px solid rgba(0,0,0,0.02);
        border-radius: 12px;
        background: rgba(255,255,255,0.8);
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
        border-color: transparent;
    }

    .btn-primary-gradient {
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 4px 16px rgba(79,70,229,0.15);
    }
    .btn-primary-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(79,70,229,0.35);
        color: #fff;
        text-decoration: none;
    }

    /* ===== PREMIUM TABLE ===== */
    .premium-table-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .premium-table-card:hover {
        box-shadow: 0 12px 60px rgba(79,70,229,0.06);
    }

    .premium-table-header {
        padding: 18px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(248,250,252,0.2);
    }

    .premium-table-header .header-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(79,70,229,0.06);
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .premium-table-header h6 { font-weight: 700; font-size: 14px; color: #0f172a; }
    .premium-table-header small { font-size: 12px; color: #94a3b8; }

    .premium-table-footer {
        padding: 14px 24px;
        border-top: 1px solid rgba(0,0,0,0.02);
        background: rgba(248,250,252,0.2);
    }

    .badge-count {
        background: rgba(79,70,229,0.06);
        color: #4f46e5;
        padding: 2px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    /* ===== TABLE ===== */
    .premium-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .premium-table thead th {
        background: rgba(248,250,252,0.2);
        color: #64748b;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        text-align: left;
    }

    .premium-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.01);
        vertical-align: middle;
    }

    .table-row {
        transition: all 0.3s ease;
        animation: fadeRow 0.5s ease forwards;
    }

    @keyframes fadeRow {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .table-row:hover { background: rgba(79,70,229,0.015); }
    .table-row:last-child td { border-bottom: none; }

    .number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(79,70,229,0.04);
        color: #4f46e5;
        font-weight: 600;
        font-size: 12px;
    }

    /* ===== TEMPLATE NAME ===== */
    .template-name { display: flex; align-items: center; gap: 12px; }
    .template-name .template-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(79,70,229,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4f46e5;
        font-size: 16px;
        flex-shrink: 0;
    }
    .template-name .fw-bold { font-weight: 700; color: #0f172a; font-size: 14px; }
    .template-name .template-slug { font-size: 11px; color: #94a3b8; display: block; }

    .template-desc { font-size: 13px; color: #475569; }

    /* ===== BADGE FILE ===== */
    .badge-file {
        padding: 4px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }

    .badge-file.ada {
        background: rgba(16,185,129,0.06);
        color: #10b981;
    }

    .badge-file.tidak {
        background: rgba(239,68,68,0.06);
        color: #ef4444;
    }

    /* ===== DATE INFO ===== */
    .date-info { display: flex; flex-direction: column; }
    .date-info .date-human { font-size: 13px; color: #0f172a; font-weight: 500; }
    .date-info .date-full { font-size: 11px; color: #94a3b8; }

    /* ===== ACTION ===== */
    .action-group { display: flex; gap: 4px; justify-content: center; }
    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        background: transparent;
        color: #94a3b8;
    }
    .btn-action:hover { transform: translateY(-3px); }
    .btn-action.download:hover { background: rgba(16,185,129,0.06); color: #10b981; }
    .btn-action.edit:hover { background: rgba(245,158,11,0.06); color: #f59e0b; }
    .btn-action.delete:hover { background: rgba(239,68,68,0.06); color: #ef4444; }

    /* ===== EMPTY STATE ===== */
    .empty-state { padding: 50px 0; text-align: center; }
    .empty-state .empty-icon {
        font-size: 56px;
        color: #d1d5db;
        margin-bottom: 16px;
        opacity: 0.5;
    }
    .empty-state .empty-title { color: #64748b; margin-bottom: 4px; font-weight: 600; }
    .empty-state .empty-desc { color: #94a3b8; font-size: 13px; }

    /* ===== PAGINATION ===== */
    .pagination .page-item .page-link {
        border: none;
        border-radius: 10px;
        margin: 0 3px;
        color: #64748b;
        transition: all 0.3s ease;
        font-size: 13px;
        padding: 8px 14px;
    }
    .pagination .page-item .page-link:hover {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(79,70,229,0.3);
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        border: none;
        box-shadow: 0 4px 16px rgba(79,70,229,0.3);
    }

    .footer-info { font-size: 12px; color: #94a3b8; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .stat-card { padding: 16px 18px; }
        .stat-card .stat-number { font-size: 22px; }
        .premium-table-header { flex-direction: column; align-items: flex-start; gap: 8px; }
        .premium-table-footer .d-flex { flex-direction: column; gap: 12px; align-items: center; }
        .action-group { gap: 2px; }
        .btn-action { width: 28px; height: 28px; font-size: 11px; }
        .premium-table { font-size: 12px; }
        .glass-card .card-body { padding: 16px; }
        .btn-primary-gradient { width: 100%; justify-content: center; }
        .template-name { flex-wrap: wrap; }
    }
</style>

<script>
    // Search & Filter
    document.getElementById('searchInput')?.addEventListener('keyup', filterTable);
    document.getElementById('filterFile')?.addEventListener('change', filterTable);

    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const filterFile = document.getElementById('filterFile').value;
        const rows = document.querySelectorAll('.table-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const rowFile = row.dataset.file || '';
            const matchSearch = text.includes(search);
            const matchFile = !filterFile || rowFile === filterFile;

            if (matchSearch && matchFile) {
                row.style.display = '';
                visibleCount++;
                const badge = row.querySelector('.number-badge');
                if (badge) badge.textContent = visibleCount;
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('filterFile').value = '';
        filterTable();
    }
</script>
@endsection