@extends('layouts.app')

@section('title', 'Data Pelatih')
@section('subtitle', 'Kelola semua data pelatih ekstrakurikuler')

@section('content')
<!-- ===== STATS CARDS ===== -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #0ea5e9; --glow: rgba(14,165,233,0.15);">
            <div class="stat-icon" style="background: rgba(14,165,233,0.08); color: #0ea5e9;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Pelatih</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $pelatihs->total() }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-arrow-up me-1"></i> Terdaftar
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #0ea5e9; --glow: rgba(14,165,233,0.15);">
            <div class="stat-icon" style="background: rgba(14,165,233,0.08); color: #0ea5e9;">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Ekskul</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $totalEkskul ?? 0 }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-check me-1"></i> Aktif
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #10b981; --glow: rgba(16,185,129,0.15);">
            <div class="stat-icon" style="background: rgba(16,185,129,0.08); color: #10b981;">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Aktif</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $pelatihs->count() }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-percent me-1"></i> 100% aktif
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #f59e0b; --glow: rgba(245,158,11,0.15);">
            <div class="stat-icon" style="background: rgba(245,158,11,0.08); color: #f59e0b;">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Terbaru</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">
                    {{ $pelatihs->count() > 0 ? $pelatihs->first()->created_at->format('d M Y') : '-' }}
                </h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-clock me-1"></i> Bergabung
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
</div>

<!-- ===== SEARCH & FILTER ===== -->
<div class="card glass-card mb-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.04);">
    <div class="card-body p-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="search-wrapper" style="position: relative;">
                    <i class="fas fa-search search-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px;"></i>
                    <input type="text" class="search-input" placeholder="Cari pelatih berdasarkan nama atau email..." id="searchInput" style="width: 100%; padding: 12px 16px 12px 44px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: rgba(255,255,255,0.8); transition: all 0.3s ease; color: #0f172a;">
                </div>
            </div>
            <div class="col-md-7">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                    <select class="filter-select" id="filterEkskul" style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13px; background: rgba(255,255,255,0.8); color: #0f172a; transition: all 0.3s ease; cursor: pointer; min-width: 160px;">
                        <option value="">Semua Ekskul</option>
                        @foreach($ekskuls as $ekskul)
                            <option value="{{ $ekskul->id }}">{{ $ekskul->nama_ekskul }}</option>
                        @endforeach
                    </select>
                    <button class="btn-reset" onclick="resetFilters()" style="padding: 12px 20px; border: 2px solid #e2e8f0; border-radius: 12px; background: rgba(255,255,255,0.8); color: #64748b; font-size: 13px; font-weight: 500; transition: all 0.3s ease; cursor: pointer;">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <a href="{{ route('admin.pelatih.create') }}" class="btn-primary-gradient" style="padding: 12px 24px; border: none; border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 13px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 4px 16px rgba(14,165,233,0.3);">
                        <i class="fas fa-user-plus me-2"></i> Tambah Pelatih
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== TABLE ===== -->
<div class="card premium-table-card" style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; transition: all 0.4s ease;">
    <div class="card-header premium-table-header" style="padding: 18px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; background: rgba(248,250,252,0.2);">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(14,165,233,0.08); color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="font-weight: 700; font-size: 14px; color: #0f172a;">Daftar Pelatih</h6>
                <small class="text-muted" style="font-size: 12px; color: #94a3b8;">{{ $pelatihs->total() }} total data</small>
            </div>
        </div>
        <div>
            <span class="badge-count" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $pelatihs->total() }}</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table premium-table" id="pelatihTable" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th width="5%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">#</th>
                        <th width="8%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Foto</th>
                        <th width="20%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Nama</th>
                        <th width="20%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Email</th>
                        <th width="15%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Ekskul</th>
                        <th width="12%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">No HP</th>
                        <th width="10%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Status</th>
                        <th width="12%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelatihs as $index => $pelatih)
                    <tr data-ekskul="{{ $pelatih->ekskul_id }}" class="table-row" style="transition: all 0.3s ease; animation: fadeRow 0.5s ease forwards;">
                        <td>
                            <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.06); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $pelatihs->firstItem() + $index }}</span>
                        </td>
                        <td>
                            @if($pelatih->avatar)
                                <img src="{{ asset($pelatih->avatar) }}" 
                                     alt="{{ $pelatih->name }}" 
                                     class="avatar-img" style="width: 42px; height: 42px; border-radius: 12px; object-fit: cover; border: 2px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                            @else
                                <div class="avatar-placeholder" style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 16px; transition: all 0.3s ease;">
                                    {{ strtoupper(substr($pelatih->name, 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="user-name" style="display: flex; flex-direction: column;">
                                <span class="fw-bold" style="font-weight: 700; color: #0f172a; font-size: 14px;">{{ $pelatih->name }}</span>
                                <span class="user-id" style="font-size: 11px; color: #94a3b8;">ID: #{{ str_pad($pelatih->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="user-email" style="font-size: 13px; color: #475569;">
                                <i class="fas fa-envelope me-2 text-muted"></i>
                                {{ $pelatih->email }}
                            </span>
                        </td>
                        <td>
                            @if($pelatih->ekskul)
                                <span class="badge-ekskul" style="background: rgba(16,185,129,0.06); color: #10b981; padding: 4px 14px; border-radius: 8px; font-size: 12px; font-weight: 500;">
                                    <i class="fas fa-trophy me-1"></i>
                                    {{ $pelatih->ekskul->nama_ekskul }}
                                </span>
                            @else
                                <span class="badge-ekskul-empty" style="background: rgba(0,0,0,0.02); color: #94a3b8; padding: 4px 14px; border-radius: 8px; font-size: 12px; font-weight: 500;">
                                    <i class="fas fa-times me-1"></i>
                                    Belum ada
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="user-phone" style="font-size: 13px; color: #475569;">
                                <i class="fas fa-phone me-2 text-muted"></i>
                                {{ $pelatih->no_hp ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge active" style="padding: 3px 14px; border-radius: 12px; font-size: 12px; font-weight: 500; background: rgba(16,185,129,0.08); color: #10b981;">
                                <span class="dot" style="width: 6px; height: 6px; background: #10b981; border-radius: 50%; display: inline-block; margin-right: 6px;"></span>
                                Aktif
                            </span>
                        </td>
                        <td>
                            <div class="action-group" style="display: flex; gap: 4px; justify-content: center;">
                                <a href="{{ route('admin.pelatih.edit', $pelatih->id) }}" class="btn-action edit" title="Edit" style="width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; background: transparent; color: #94a3b8;">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.pelatih.destroy', $pelatih->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus pelatih {{ $pelatih->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus" style="width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; cursor: pointer; background: transparent; color: #94a3b8;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state" style="padding: 50px 0; text-align: center;">
                                <div class="empty-icon" style="font-size: 56px; color: #d1d5db; margin-bottom: 16px; opacity: 0.5;"><i class="fas fa-chalkboard-teacher"></i></div>
                                <h6 class="empty-title" style="color: #64748b; margin-bottom: 4px; font-weight: 600;">Belum ada pelatih</h6>
                                <p class="empty-desc" style="color: #94a3b8; font-size: 13px;">Tambahkan pelatih pertama Anda</p>
                                <a href="{{ route('admin.pelatih.create') }}" class="btn-primary-gradient mt-3" style="padding: 12px 24px; border: none; border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-block; box-shadow: 0 4px 16px rgba(14,165,233,0.3);">
                                    <i class="fas fa-user-plus me-2"></i> Tambah Pelatih
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer premium-table-footer" style="padding: 14px 24px; border-top: 1px solid rgba(0,0,0,0.02); background: rgba(248,250,252,0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="footer-info" style="font-size: 12px; color: #94a3b8;">
                <i class="fas fa-list me-1"></i>
                Menampilkan {{ $pelatihs->firstItem() }} - {{ $pelatihs->lastItem() }} 
                dari {{ $pelatihs->total() }} data
            </span>
            <div>
                {{ $pelatihs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card:hover { transform: translateY(-8px); box-shadow: 0 16px 60px rgba(14,165,233,0.12); border-color: rgba(14,165,233,0.06); }
    .stat-card:hover .stat-icon { transform: scale(1.1) rotate(-3deg); }
    .stat-card:hover .stat-progress { transform: scaleX(1); }
    .stat-card:hover .stat-glow { opacity: 0.06; }
    .stat-card { background: #ffffff; border-radius: 18px; padding: 24px 28px; border: 1px solid rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden; display: flex; gap: 16px; align-items: center; }
    .search-input:focus { outline: none; border-color: #0ea5e9 !important; background: #ffffff !important; box-shadow: 0 0 0 4px rgba(14,165,233,0.06); }
    .filter-select:focus { outline: none; border-color: #0ea5e9 !important; background: #ffffff !important; box-shadow: 0 0 0 4px rgba(14,165,233,0.06); }
    .btn-reset:hover { background: #f1f5f9; transform: translateY(-2px); border-color: transparent; }
    .btn-primary-gradient:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(14,165,233,0.4); color: #fff; text-decoration: none; }
    .premium-table-card:hover { box-shadow: 0 12px 60px rgba(14,165,233,0.06); }
    @keyframes fadeRow { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .table-row:hover { background: rgba(14,165,233,0.015); }
    .avatar-img:hover { transform: scale(1.08); border-color: #0ea5e9; box-shadow: 0 4px 20px rgba(14,165,233,0.2); }
    .avatar-placeholder:hover { transform: scale(1.08); box-shadow: 0 4px 20px rgba(14,165,233,0.2); }
    .btn-action:hover { transform: translateY(-3px); }
    .btn-action.edit:hover { background: rgba(245,158,11,0.06); color: #f59e0b; }
    .btn-action.delete:hover { background: rgba(239,68,68,0.06); color: #ef4444; }
    .pagination .page-item .page-link { border: none; border-radius: 10px; margin: 0 3px; color: #64748b; transition: all 0.3s ease; font-size: 13px; padding: 8px 14px; }
    .pagination .page-item .page-link:hover { background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; transform: translateY(-2px); box-shadow: 0 4px 16px rgba(14,165,233,0.3); }
    .pagination .page-item.active .page-link { background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border: none; box-shadow: 0 4px 16px rgba(14,165,233,0.3); }
    .status-badge .dot { animation: pulse 2s infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.3; transform: scale(0.7); } }
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
    }
</style>

<script>
    document.getElementById('searchInput')?.addEventListener('keyup', filterTable);
    document.getElementById('filterEkskul')?.addEventListener('change', filterTable);

    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const filterEkskul = document.getElementById('filterEkskul').value;
        const rows = document.querySelectorAll('.table-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const rowEkskul = row.dataset.ekskul || '';
            const matchSearch = text.includes(search);
            const matchEkskul = !filterEkskul || rowEkskul == filterEkskul;

            if (matchSearch && matchEkskul) {
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
        document.getElementById('filterEkskul').value = '';
        filterTable();
    }
</script>
@endsection