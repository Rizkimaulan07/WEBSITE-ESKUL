@extends('layouts.app')

@section('title', 'Ekstrakurikuler')
@section('subtitle', 'Kelola semua ekstrakurikuler')

@section('content')
<!-- ===== STATS CARDS PREMIUM ===== -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #0ea5e9; --glow: rgba(14,165,233,0.15);">
            <div class="stat-icon" style="background: rgba(14,165,233,0.08); color: #0ea5e9;">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Ekskul</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $ekskuls->total() }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-arrow-up me-1"></i> {{ $ekskuls->where('status', 'aktif')->count() }} aktif
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #0ea5e9; --glow: rgba(14,165,233,0.15);">
            <div class="stat-icon" style="background: rgba(14,165,233,0.08); color: #0ea5e9;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Anggota</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $totalAnggota ?? 0 }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-user-plus me-1"></i> Terdaftar
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #10b981; --glow: rgba(16,185,129,0.15);">
            <div class="stat-icon" style="background: rgba(16,185,129,0.08); color: #10b981;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Pembina</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $ekskuls->pluck('pembina')->unique()->count() }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-star me-1"></i> Profesional
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #f59e0b; --glow: rgba(245,158,11,0.15);">
            <div class="stat-icon" style="background: rgba(245,158,11,0.08); color: #f59e0b;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Status Ekskul</span>
                <div class="d-flex gap-2 mt-1">
                    <span class="status-badge active" style="background: rgba(16,185,129,0.08); color: #10b981; padding: 2px 12px; border-radius: 12px; font-size: 11px; font-weight: 500;">● {{ $ekskuls->where('status', 'aktif')->count() }} Aktif</span>
                    <span class="status-badge inactive" style="background: rgba(239,68,68,0.06); color: #ef4444; padding: 2px 12px; border-radius: 12px; font-size: 11px; font-weight: 500;">● {{ $ekskuls->where('status', 'nonaktif')->count() }} Nonaktif</span>
                </div>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-percent me-1"></i> 
                    {{ $ekskuls->total() > 0 ? round(($ekskuls->where('status', 'aktif')->count() / $ekskuls->total()) * 100) : 0 }}% aktif
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
                    <i class="fas fa-search search-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 14px;"></i>
                    <input type="text" class="search-input" placeholder="Cari ekstrakurikuler..." id="searchInput" style="width: 100%; padding: 12px 16px 12px 44px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: rgba(255,255,255,0.8); transition: all 0.3s ease; color: #0f172a;">
                </div>
            </div>
            <div class="col-md-7">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                    <select class="filter-select" id="filterStatus" style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13px; background: rgba(255,255,255,0.8); color: #0f172a; transition: all 0.3s ease; cursor: pointer; min-width: 140px;">
                        <option value="">Semua Status</option>
                        <option value="aktif">● Aktif</option>
                        <option value="nonaktif">● Nonaktif</option>
                    </select>
                    <button class="btn-reset" onclick="resetFilters()" style="padding: 12px 20px; border: 2px solid #e2e8f0; border-radius: 12px; background: rgba(255,255,255,0.8); color: #64748b; font-size: 13px; font-weight: 500; transition: all 0.3s ease; cursor: pointer;">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <a href="{{ route('admin.ekskul.create') }}" class="btn-primary-gradient" style="padding: 12px 24px; border-radius: 12px; font-size: 13px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                        <i class="fas fa-plus me-2"></i> Tambah Ekskul
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== TABLE PREMIUM ===== -->
<div class="card premium-table-card" style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; transition: all 0.4s ease;">
    <div class="card-header premium-table-header" style="padding: 18px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; background: rgba(248,250,252,0.2);">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(14,165,233,0.08); color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fas fa-list-ul"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="font-weight: 700; font-size: 14px; color: #0f172a;">Daftar Ekstrakurikuler</h6>
                <small class="text-muted" style="font-size: 12px; color: #64748b;">{{ $ekskuls->total() }} total data</small>
            </div>
        </div>
        <div>
            <span class="badge-count" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $ekskuls->total() }}</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table premium-table" id="ekskulTable" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th width="5%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">#</th>
                        <th width="8%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Logo</th>
                        <th width="18%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Nama Ekskul</th>
                        <th width="15%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Pembina</th>
                        <th width="15%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Jadwal</th>
                        <th width="10%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Tempat</th>
                        <th width="10%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Anggota</th>
                        <th width="10%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Status</th>
                        <th width="12%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ekskuls as $index => $ekskul)
                    <tr data-status="{{ $ekskul->status }}" class="table-row" style="transition: all 0.3s ease; animation: fadeRow 0.5s ease forwards;">
                        <td>
                            <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.06); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $ekskuls->firstItem() + $index }}</span>
                        </td>
                        <td>
                            @if($ekskul->logo)
                                <img src="{{ asset($ekskul->logo) }}" 
                                     alt="{{ $ekskul->nama_ekskul }}" 
                                     class="logo-img" style="width: 42px; height: 42px; border-radius: 12px; object-fit: cover; border: 2px solid rgba(0,0,0,0.02); transition: all 0.3s ease; cursor: pointer;"
                                     onclick="showLogo('{{ asset($ekskul->logo) }}')">
                            @else
                                <div class="logo-placeholder" style="width: 42px; height: 42px; border-radius: 12px; background: rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: center; color: #64748b; border: 1px dashed #d1d5db; transition: all 0.3s ease;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="ekskul-name" style="display: flex; flex-direction: column;">
                                <span class="fw-bold" style="font-weight: 700; color: #0f172a; font-size: 14px;">{{ $ekskul->nama_ekskul }}</span>
                                <span class="ekskul-slug" style="font-size: 11px; color: #64748b;">{{ $ekskul->slug }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="pembina-wrapper" style="display: flex; align-items: center; gap: 10px;">
                                <div class="pembina-avatar" style="width: 32px; height: 32px; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 12px; flex-shrink: 0;">
                                    {{ strtoupper(substr($ekskul->pembina, 0, 1)) }}
                                </div>
                                <span style="color: #1e293b; font-size: 13px;">{{ $ekskul->pembina }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="jadwal-wrapper" style="display: flex; flex-direction: column; gap: 2px;">
                                @foreach(array_map('trim', explode(',', $ekskul->hari_latihan ?? '')) as $day)
                                    <span class="badge-day" style="background: rgba(14,165,233,0.08); color: #0ea5e9; padding: 2px 12px; border-radius: 8px; font-size: 12px; font-weight: 500; display: inline-block; width: fit-content;">{{ $day }}</span>
                                @endforeach
                                <span class="time" style="font-size: 12px; color: #64748b;">
                                    <i class="far fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="place" style="font-size: 12px; color: #475569;">
                                <i class="fas fa-map-pin me-1" style="color: #0ea5e9;"></i>
                                {{ $ekskul->tempat_latihan }}
                            </span>
                        </td>
                        <td>
                            <span class="member-badge" style="background: rgba(16,185,129,0.06); color: #10b981; padding: 2px 12px; border-radius: 8px; font-size: 12px; font-weight: 500;">
                                <i class="fas fa-user me-1"></i>
                                {{ $ekskul->users_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $ekskul->status == 'aktif' ? 'active' : 'inactive' }}" style="padding: 3px 14px; border-radius: 12px; font-size: 12px; font-weight: 500; {{ $ekskul->status == 'aktif' ? 'background: rgba(16,185,129,0.08); color: #10b981;' : 'background: rgba(239,68,68,0.06); color: #ef4444;' }}">
                                {{ $ekskul->status == 'aktif' ? '● Aktif' : '● Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group" style="display: flex; gap: 4px; justify-content: center;">
                                <a href="{{ route('admin.ekskul.show', $ekskul) }}" class="btn-action view" title="Detail" style="width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; background: transparent; color: #64748b;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.ekskul.edit', $ekskul) }}" class="btn-action edit" title="Edit" style="width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; background: transparent; color: #64748b;">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.dokumentasi.eskul', $ekskul->id) }}" class="btn-action dokumentasi" title="Dokumentasi" style="width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; background: transparent; color: #64748b;">
                                    <i class="fas fa-images"></i>
                                </a>
                                <form action="{{ route('admin.ekskul.destroy', $ekskul) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus ekskul {{ $ekskul->nama_ekskul }}?')">
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
                        <td colspan="9">
                            <div class="empty-state" style="padding: 50px 0; text-align: center;">
                                <div class="empty-icon" style="font-size: 56px; color: #d1d5db; margin-bottom: 16px; opacity: 0.5;"><i class="fas fa-folder-open"></i></div>
                                <h6 class="empty-title" style="color: #64748b; margin-bottom: 4px; font-weight: 600;">Belum ada data</h6>
                                <p class="empty-desc" style="color: #64748b; font-size: 13px;">Tambahkan ekstrakurikuler pertama Anda</p>
                                <a href="{{ route('admin.ekskul.create') }}" class="btn-primary-gradient mt-3" style="padding: 12px 24px; border-radius: 12px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-block;">
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
    <div class="card-footer premium-table-footer" style="padding: 14px 24px; border-top: 1px solid rgba(0,0,0,0.02); background: rgba(248,250,252,0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="footer-info" style="font-size: 12px; color: #64748b;">
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

<!-- ===== MODAL PREVIEW LOGO ===== -->
<div class="modal fade" id="logoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content glass-modal" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.2); border-radius: 20px;">
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold" style="color: #0f172a; font-size: 16px;">Preview Logo</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <img src="" id="logoPreviewModal" alt="Logo" class="modal-logo-preview" style="max-width: 100%; max-height: 300px; border-radius: 12px;">
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn-modal-close" data-bs-dismiss="modal" style="padding: 8px 24px; border: none; border-radius: 10px; background: rgba(0,0,0,0.02); color: #64748b; font-size: 13px; font-weight: 500; transition: all 0.3s ease;">Tutup</button>
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
    .logo-img:hover { transform: scale(1.08); border-color: #0ea5e9; box-shadow: 0 4px 20px rgba(14,165,233,0.2); }
    .btn-action:hover { transform: translateY(-3px); }
    .btn-action.view:hover { background: rgba(14,165,233,0.06); color: #0ea5e9; }
    .btn-action.edit:hover { background: rgba(245,158,11,0.06); color: #f59e0b; }
    .btn-action.dokumentasi:hover { background: rgba(139,92,246,0.08); color: #8b5cf6; box-shadow: 0 4px 12px rgba(139,92,246,0.15); }
    .btn-action.delete:hover { background: rgba(239,68,68,0.06); color: #ef4444; }
    .pagination .page-item .page-link { border: none; border-radius: 10px; margin: 0 3px; color: #64748b; transition: all 0.3s ease; font-size: 13px; padding: 8px 14px; }
    .pagination .page-item .page-link:hover { background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; transform: translateY(-2px); box-shadow: 0 4px 16px rgba(14,165,233,0.3); }
    .pagination .page-item.active .page-link { background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border: none; box-shadow: 0 4px 16px rgba(14,165,233,0.3); }
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
    document.getElementById('filterStatus')?.addEventListener('change', filterTable);

    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('filterStatus').value;
        const rows = document.querySelectorAll('.table-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const rowStatus = row.dataset.status || '';
            const matchSearch = text.includes(search);
            const matchStatus = !statusFilter || rowStatus === statusFilter;

            if (matchSearch && matchStatus) {
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
        document.getElementById('filterStatus').value = '';
        filterTable();
    }

    function showLogo(src) {
        if (src && src !== '' && src !== 'null') {
            document.getElementById('logoPreviewModal').src = src;
            new bootstrap.Modal(document.getElementById('logoModal')).show();
        }
    }
</script>
@endsection