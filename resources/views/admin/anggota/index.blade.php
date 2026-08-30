@extends('layouts.app')

@section('title', 'Data Anggota')
@section('subtitle', 'Kelola semua anggota ekstrakurikuler')

@section('content')
<!-- ===== STATS CARDS ===== -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #0ea5e9; --glow: rgba(14,165,233,0.15);">
            <div class="stat-icon" style="background: rgba(14,165,233,0.08); color: #0ea5e9;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b;">Total Anggota</span>
                <h3 class="stat-number" style="color: #0f172a;">{{ $anggotas->total() }}</h3>
                <span class="stat-trend up" style="color: #10b981;">
                    <i class="fas fa-arrow-up me-1"></i> Terdaftar
                </span>
            </div>
            <div class="stat-progress" style="--accent: #0ea5e9;"></div>
            <div class="stat-glow" style="--accent: #0ea5e9;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #0ea5e9; --glow: rgba(14,165,233,0.15);">
            <div class="stat-icon" style="background: rgba(14,165,233,0.08); color: #0ea5e9;">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b;">Total Ekskul</span>
                <h3 class="stat-number" style="color: #0f172a;">{{ $ekskuls->count() ?? 0 }}</h3>
                <span class="stat-trend up" style="color: #10b981;">
                    <i class="fas fa-check me-1"></i> Aktif
                </span>
            </div>
            <div class="stat-progress" style="--accent: #0ea5e9;"></div>
            <div class="stat-glow" style="--accent: #0ea5e9;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #10b981; --glow: rgba(16,185,129,0.15);">
            <div class="stat-icon" style="background: rgba(16,185,129,0.08); color: #10b981;">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b;">Anggota Aktif</span>
                <h3 class="stat-number" style="color: #0f172a;">{{ $anggotas->count() }}</h3>
                <span class="stat-trend up" style="color: #10b981;">
                    <i class="fas fa-percent me-1"></i> 100% aktif
                </span>
            </div>
            <div class="stat-progress" style="--accent: #10b981;"></div>
            <div class="stat-glow" style="--accent: #10b981;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #f59e0b; --glow: rgba(245,158,11,0.15);">
            <div class="stat-icon" style="background: rgba(245,158,11,0.08); color: #f59e0b;">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b;">Kelas</span>
                <h3 class="stat-number" style="color: #0f172a;">{{ $anggotas->pluck('kelas')->unique()->count() }}</h3>
                <span class="stat-trend up" style="color: #10b981;">
                    <i class="fas fa-layer-group me-1"></i> Variasi
                </span>
            </div>
            <div class="stat-progress" style="--accent: #f59e0b;"></div>
            <div class="stat-glow" style="--accent: #f59e0b;"></div>
        </div>
    </div>
</div>

<!-- ===== SEARCH & FILTER ===== -->
<div class="card glass-card mb-4" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.04);">
    <div class="card-body p-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon" style="color: #64748b;"></i>
                    <input type="text" class="search-input" placeholder="Cari anggota berdasarkan nama, email, atau kelas..." id="searchInput" style="border: 2px solid rgba(0,0,0,0.02); border-radius: 12px; padding: 12px 16px 12px 44px; font-size: 14px; background: rgba(255,255,255,0.8);">
                </div>
            </div>
            <div class="col-md-7">
                <div class="d-flex flex-wrap gap-3 justify-content-md-end">
                    <select class="filter-select" id="filterEkskul" style="border: 2px solid rgba(0,0,0,0.02); border-radius: 12px; padding: 12px 16px; font-size: 13px; background: rgba(255,255,255,0.8);">
                        <option value="">Semua Ekskul</option>
                        @foreach($ekskuls ?? [] as $ekskul)
                            <option value="{{ $ekskul->id }}">{{ $ekskul->nama_ekskul }}</option>
                        @endforeach
                    </select>
                    <select class="filter-select" id="filterKelas" style="border: 2px solid rgba(0,0,0,0.02); border-radius: 12px; padding: 12px 16px; font-size: 13px; background: rgba(255,255,255,0.8);">
                        <option value="">Semua Kelas</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <button class="btn-reset" onclick="resetFilters()" style="border: 2px solid rgba(0,0,0,0.02); border-radius: 12px; padding: 12px 20px; background: rgba(255,255,255,0.8); color: #64748b; font-size: 13px; font-weight: 500;">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <a href="{{ route('admin.anggota.create') }}" class="btn-primary-gradient" style="padding: 12px 24px; border-radius: 12px; font-size: 13px; font-weight: 600; text-decoration: none;">
                        <i class="fas fa-user-plus me-2"></i> Tambah Anggota
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== TABLE ===== -->
<div class="card premium-table-card" style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-header premium-table-header" style="padding: 18px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; background: rgba(248,250,252,0.2);">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(14,165,233,0.08); color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="color: #0f172a; font-size: 14px;">Daftar Anggota</h6>
                <small class="text-muted" style="color: #64748b; font-size: 12px;">{{ $anggotas->total() }} total data</small>
            </div>
        </div>
        <div>
            <span class="badge-count" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $anggotas->total() }}</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table premium-table" id="anggotaTable" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th width="5%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">#</th>
                        <th width="8%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Foto</th>
                        <th width="18%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Nama</th>
                        <th width="20%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Email</th>
                        <th width="12%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Kelas</th>
                        <th width="12%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">No HP</th>
                        <th width="15%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02);">Ekskul</th>
                        <th width="12%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotas as $index => $anggota)
                    <tr class="table-row" data-ekskul="{{ $anggota->ekskuls->pluck('id')->implode(' ') }}" data-kelas="{{ $anggota->kelas ?? '' }}" style="transition: all 0.3s ease; animation: fadeRow 0.5s ease forwards;">
                        <td>
                            <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.06); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $anggotas->firstItem() + $index }}</span>
                        </td>
                        <td>
                            @if($anggota->avatar)
                                <img src="{{ asset($anggota->avatar) }}" 
                                     alt="{{ $anggota->name }}" 
                                     class="avatar-img" style="width: 42px; height: 42px; border-radius: 12px; object-fit: cover; border: 2px solid rgba(0,0,0,0.02); transition: all 0.3s ease;">
                            @else
                                <div class="avatar-placeholder" style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 16px; transition: all 0.3s ease;">
                                    {{ strtoupper(substr($anggota->name, 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="user-name" style="display: flex; flex-direction: column;">
                                <span class="fw-bold" style="font-weight: 700; color: #0f172a; font-size: 14px;">{{ $anggota->name }}</span>
                                <span class="user-id" style="font-size: 11px; color: #64748b;">ID: {{ $anggota->id }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="user-email" style="font-size: 13px; color: #475569;">
                                <i class="fas fa-envelope me-2 text-muted"></i>
                                {{ $anggota->email }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-kelas" style="background: rgba(245,158,11,0.06); color: #f59e0b; padding: 4px 14px; border-radius: 8px; font-size: 12px; font-weight: 500;">{{ $anggota->kelas ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="user-phone" style="font-size: 13px; color: #475569;">
                                <i class="fas fa-phone me-2 text-muted"></i>
                                {{ $anggota->no_hp ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($anggota->ekskuls->isNotEmpty())
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($anggota->ekskuls as $ekskul)
                                        <span class="badge-ekskul" style="background: rgba(16,185,129,0.06); color: #10b981; padding: 4px 12px; border-radius: 8px; font-size: 12px; font-weight: 500;">
                                            <i class="fas fa-trophy me-1"></i>
                                            {{ $ekskul->nama_ekskul }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="badge-ekskul-empty" style="background: rgba(0,0,0,0.02); color: #64748b; padding: 4px 14px; border-radius: 8px; font-size: 12px; font-weight: 500;">
                                    <i class="fas fa-times me-1"></i>
                                    Belum ada
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group" style="display: flex; gap: 4px; justify-content: center;">
                                <a href="{{ route('admin.anggota.show', $anggota->id) }}" class="btn-action view" title="Detail" style="width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; background: transparent; color: #64748b;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.anggota.edit', $anggota->id) }}" class="btn-action edit" title="Edit" style="width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; background: transparent; color: #64748b;">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.anggota.destroy', $anggota->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus anggota {{ $anggota->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus" style="width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; cursor: pointer; background: transparent; color: #64748b;">
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
                                <div class="empty-icon" style="font-size: 56px; color: #d1d5db; margin-bottom: 16px; opacity: 0.5;"><i class="fas fa-user-plus"></i></div>
                                <h6 class="empty-title" style="color: #64748b; margin-bottom: 4px; font-weight: 600;">Belum ada anggota</h6>
                                <p class="empty-desc" style="color: #64748b; font-size: 13px;">Tambahkan anggota pertama Anda</p>
                                <a href="{{ route('admin.anggota.create') }}" class="btn-primary-gradient mt-3" style="padding: 12px 24px; border-radius: 12px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-block;">
                                    <i class="fas fa-user-plus me-2"></i> Tambah Anggota
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
            <span class="footer-info" style="font-size: 12px; color: #64748b;">
                <i class="fas fa-list me-1"></i>
                Menampilkan {{ $anggotas->firstItem() }} - {{ $anggotas->lastItem() }} 
                dari {{ $anggotas->total() }} data
            </span>
            <div>
                {{ $anggotas->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 60px rgba(14,165,233,0.12);
        border-color: rgba(14,165,233,0.06);
    }

    .stat-card:hover .stat-icon { transform: scale(1.1) rotate(-3deg); }

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

    .search-wrapper { position: relative; }
    .search-wrapper .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 14px;
    }
    .search-wrapper .search-input:focus {
        outline: none;
        border-color: #0ea5e9;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(14,165,233,0.06);
    }

    .filter-select:focus {
        outline: none;
        border-color: #0ea5e9;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(14,165,233,0.06);
    }

    .btn-reset:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
        border-color: transparent;
    }

    .btn-primary-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(14,165,233,0.4);
        color: #fff;
        text-decoration: none;
    }

    @keyframes fadeRow {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .table-row:hover { background: rgba(14,165,233,0.015); }

    .avatar-img:hover {
        transform: scale(1.08);
        border-color: #0ea5e9;
        box-shadow: 0 4px 20px rgba(14,165,233,0.2);
    }

    .avatar-placeholder:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 20px rgba(14,165,233,0.2);
    }

    .btn-action:hover { transform: translateY(-3px); }
    .btn-action.view:hover { background: rgba(14,165,233,0.06); color: #0ea5e9; }
    .btn-action.edit:hover { background: rgba(245,158,11,0.06); color: #f59e0b; }
    .btn-action.delete:hover { background: rgba(239,68,68,0.06); color: #ef4444; }

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
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(14,165,233,0.3);
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: white;
        border: none;
        box-shadow: 0 4px 16px rgba(14,165,233,0.3);
    }

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
    document.getElementById('filterKelas')?.addEventListener('change', filterTable);

    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const filterEkskul = document.getElementById('filterEkskul').value;
        const filterKelas = document.getElementById('filterKelas').value;
        const rows = document.querySelectorAll('.table-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const rowEkskul = row.dataset.ekskul || '';
            const rowKelas = row.dataset.kelas || '';
            const matchSearch = text.includes(search);
            const matchEkskul = !filterEkskul || (rowEkskul.split(' ').indexOf(filterEkskul) !== -1);
            const matchKelas = !filterKelas || rowKelas.includes(filterKelas);

            if (matchSearch && matchEkskul && matchKelas) {
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
        document.getElementById('filterKelas').value = '';
        filterTable();
    }
</script>
@endsection