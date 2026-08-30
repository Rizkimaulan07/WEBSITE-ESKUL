@extends('layouts.app')

@section('title', 'Template Surat')
@section('subtitle', 'Kelola template surat untuk berbagai keperluan')

@section('content')
<!-- ===== HERO SECTION ===== -->
<div class="hero-section mb-4 hero-gradient" style="border-radius: 24px; padding: 32px 40px; position: relative; overflow: hidden; box-shadow: 0 8px 40px rgba(14,165,233,0.25);">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <div class="d-flex align-items-center gap-4">
                <div class="hero-icon" style="width: 64px; height: 64px; border-radius: 16px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-file-alt fa-2x text-white"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-1" style="font-size: 22px; letter-spacing: -0.5px;">Template Surat</h4>
                    <p class="text-white-75 mb-0" style="color: rgba(255,255,255,0.75); font-size: 14px;">Kelola template surat untuk berbagai keperluan</p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 text-lg-end mt-3 mt-lg-0">
            <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                <span class="hero-badge" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(12px); color: #e2e8f0; padding: 6px 20px; border-radius: 20px; font-size: 13px; font-weight: 500; border: 1px solid rgba(255,255,255,0.08);">
                    <i class="fas fa-file me-2"></i>{{ $templates->total() }} Template
                </span>
                <span class="hero-badge" style="background: #d1fae5; color: #065f46; padding: 6px 20px; border-radius: 20px; font-size: 13px; font-weight: 700; letter-spacing: 0.3px; border: 1px solid #10b981; box-shadow: 0 2px 8px rgba(6,95,70,0.2);">
                    <i class="fas fa-check-circle me-2" style="color: #065f46;"></i>{{ $templates->whereNotNull('file_template')->count() }} Siap Pakai
                </span>
            </div>
        </div>
    </div>
    <div class="hero-shapes">
        <div class="shape-circle" style="position: absolute; width: 250px; height: 250px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.05), transparent 70%); top: -120px; right: 10%; pointer-events: none;"></div>
        <div class="shape-circle" style="position: absolute; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.04), transparent 70%); bottom: -75px; left: 15%; pointer-events: none;"></div>
        <div class="shape-circle" style="position: absolute; width: 80px; height: 80px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.06), transparent 70%); top: 20%; right: 25%; pointer-events: none; animation: float 8s ease-in-out infinite;"></div>
    </div>
</div>

<!-- ===== STATS CARDS ===== -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #0ea5e9; --glow: rgba(14,165,233,0.15);">
            <div class="stat-icon" style="background: rgba(14,165,233,0.08); color: #0ea5e9;">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Template</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $templates->total() }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-arrow-up me-1"></i> Tersedia
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #10b981; --glow: rgba(16,185,129,0.15);">
            <div class="stat-icon" style="background: rgba(16,185,129,0.08); color: #10b981;">
                <i class="fas fa-file-pdf"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Dengan File</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $templates->whereNotNull('file_template')->count() }}</h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-check-circle me-1"></i> Siap digunakan
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #f59e0b; --glow: rgba(245,158,11,0.15);">
            <div class="stat-icon" style="background: rgba(245,158,11,0.08); color: #f59e0b;">
                <i class="fas fa-file-word"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Tanpa File</span>
                <h3 class="stat-number" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 2px 0; letter-spacing: -1px;">{{ $templates->whereNull('file_template')->count() }}</h3>
                <span class="stat-trend {{ $templates->whereNull('file_template')->count() > 0 ? 'down' : 'up' }}" style="{{ $templates->whereNull('file_template')->count() > 0 ? 'background: rgba(239,68,68,0.06); color: #ef4444;' : 'background: rgba(16,185,129,0.06); color: #10b981;' }} font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas {{ $templates->whereNull('file_template')->count() > 0 ? 'fa-arrow-down' : 'fa-check-circle' }}"></i>
                    {{ $templates->whereNull('file_template')->count() > 0 ? 'Perlu dilengkapi' : 'Semua lengkap' }}
                </span>
            </div>
            <div class="stat-progress" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent)); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
            <div class="stat-glow" style="position: absolute; top: -50%; right: -20%; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, var(--accent), transparent 70%); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card" style="--accent: #0ea5e9; --glow: rgba(14,165,233,0.15);">
            <div class="stat-icon" style="background: rgba(14,165,233,0.08); color: #0ea5e9;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Terakhir Dibuat</span>
                <h3 class="stat-number" style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 2px 0; letter-spacing: -0.5px;">
                    {{ $templates->first() ? $templates->first()->created_at->diffForHumans() : '-' }}
                </h3>
                <span class="stat-trend up" style="background: rgba(16,185,129,0.06); color: #10b981; font-size: 11px; font-weight: 600; padding: 2px 12px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fas fa-calendar me-1"></i> Terbaru
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
                    <input type="text" class="search-input" placeholder="Cari template surat..." id="searchInput" style="width: 100%; padding: 12px 16px 12px 44px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: rgba(255,255,255,0.8); transition: all 0.3s ease; color: #0f172a;">
                </div>
            </div>
            <div class="col-md-7">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                    <select class="filter-select" id="filterFile" style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13px; background: rgba(255,255,255,0.8); color: #0f172a; transition: all 0.3s ease; cursor: pointer; min-width: 140px;">
                        <option value="">📋 Semua File</option>
                        <option value="Word">📄 Word</option>
                        <option value="PDF">📝 PDF</option>
                    </select>
                    <button class="btn-reset" onclick="resetFilters()" style="padding: 12px 20px; border: 2px solid #e2e8f0; border-radius: 12px; background: rgba(255,255,255,0.8); color: #64748b; font-size: 13px; font-weight: 500; transition: all 0.3s ease; cursor: pointer;">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <a href="{{ route('admin.template-surat.create') }}" class="btn-primary-gradient" style="padding: 12px 24px; border-radius: 12px; font-size: 13px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                        <i class="fas fa-plus me-2"></i> Tambah Template
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
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="font-weight: 700; font-size: 14px; color: #0f172a;">Daftar Template Surat</h6>
                <small class="text-muted" style="font-size: 12px; color: #64748b;">{{ $templates->total() }} total data</small>
            </div>
        </div>
        <div>
            <span class="badge-count" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $templates->total() }}</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table premium-table" id="templateTable" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th width="5%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">#</th>
                        <th width="25%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Judul Template</th>
                        <th width="28%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Keterangan</th>
                        <th width="15%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">File</th>
                        <th width="15%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Dibuat</th>
                        <th width="12%" style="background: rgba(248,250,252,0.2); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $index => $template)
                    @php $hasFile = $template->file_template ? true : false; @endphp
                    <tr class="table-row" data-file="{{ $template->file_template ? $template->file_type : 'tidak' }}" style="transition: all 0.3s ease; animation: fadeRow 0.5s ease forwards;">
                        <td>
                            <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.06); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $templates->firstItem() + $index }}</span>
                        </td>
                        <td>
                            <div class="template-name" style="display: flex; align-items: center; gap: 12px;">
                                <div class="template-icon" style="width: 38px; height: 38px; border-radius: 10px; background: rgba(14,165,233,0.06); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 16px; flex-shrink: 0;">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <span class="fw-bold" style="font-weight: 700; color: #0f172a; font-size: 14px;">{{ $template->judul_template }}</span>
                                    <span class="template-slug" style="font-size: 11px; color: #64748b; display: block;">{{ Str::slug($template->judul_template) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="template-desc" style="font-size: 13px; color: #475569;">{{ Str::limit($template->keterangan ?? '-', 60) }}</span>
                        </td>
                        <td>
                            @if($hasFile)
                                @php $fileType = $template->file_type; $isPdf = $fileType === 'PDF'; @endphp
                                <span class="badge-file ada" style="{{ $isPdf ? 'background: rgba(239,68,68,0.08); color: #dc2626;' : 'background: rgba(37,99,235,0.08); color: #2563eb;' }} padding: 5px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fas {{ $isPdf ? 'fa-file-pdf' : 'fa-file-word' }}"></i> {{ $fileType }}
                                </span>
                            @else
                                <span class="badge-file tidak" style="background: rgba(239,68,68,0.06); color: #ef4444; padding: 4px 14px; border-radius: 8px; font-size: 12px; font-weight: 500; display: inline-block;">
                                    <i class="fas fa-times-circle me-1"></i> Tidak Ada
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="date-info" style="display: flex; flex-direction: column;">
                                <span class="date-human" style="font-size: 13px; color: #0f172a; font-weight: 500;">{{ $template->created_at->diffForHumans() }}</span>
                                <span class="date-full" style="font-size: 11px; color: #64748b;">{{ $template->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="action-group" style="display: flex; gap: 4px; justify-content: center;">
                                @if($hasFile)
                                    <a href="{{ route('admin.template-surat.download', $template->id) }}" 
                                       class="btn-action download" title="Download" style="width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; background: transparent; color: #64748b;">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.template-surat.edit', $template->id) }}" 
                                   class="btn-action edit" title="Edit" style="width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; background: transparent; color: #64748b;">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.template-surat.destroy', $template->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus template {{ $template->judul_template }}?')">
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
                        <td colspan="6">
                            <div class="empty-state" style="padding: 50px 0; text-align: center;">
                                <div class="empty-icon" style="font-size: 56px; color: #d1d5db; margin-bottom: 16px; opacity: 0.5;"><i class="fas fa-file-alt"></i></div>
                                <h6 class="empty-title" style="color: #64748b; margin-bottom: 4px; font-weight: 600;">Belum ada template</h6>
                                <p class="empty-desc" style="color: #64748b; font-size: 13px;">Tambahkan template surat pertama Anda</p>
                                <a href="{{ route('admin.template-surat.create') }}" class="btn-primary-gradient mt-3" style="padding: 12px 24px; border-radius: 12px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-block;">
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
    <div class="card-footer premium-table-footer" style="padding: 14px 24px; border-top: 1px solid rgba(0,0,0,0.02); background: rgba(248,250,252,0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="footer-info" style="font-size: 12px; color: #64748b;">
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
    .btn-action:hover { transform: translateY(-3px); }
    .btn-action.download:hover { background: rgba(16,185,129,0.06); color: #10b981; }
    .btn-action.edit:hover { background: rgba(245,158,11,0.06); color: #f59e0b; }
    .btn-action.delete:hover { background: rgba(239,68,68,0.06); color: #ef4444; }
    .pagination .page-item .page-link { border: none; border-radius: 10px; margin: 0 3px; color: #64748b; transition: all 0.3s ease; font-size: 13px; padding: 8px 14px; }
    .pagination .page-item .page-link:hover { background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; transform: translateY(-2px); box-shadow: 0 4px 16px rgba(14,165,233,0.3); }
    .pagination .page-item.active .page-link { background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border: none; box-shadow: 0 4px 16px rgba(14,165,233,0.3); }
    @keyframes float { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(10px, -20px); } }
    @media (max-width: 768px) {
        .hero-section { padding: 24px 20px; }
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