@extends('layouts.app')

@section('title', 'Semua Dokumentasi')
@section('subtitle', 'Jelajahi semua dokumentasi kegiatan ekstrakurikuler')

@push('styles')
<style>
    /* ===== CARD PREMIUM ===== */
    .premium-doc-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid rgba(0, 0, 0, 0.02);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        overflow: hidden;
        height: 100%;
    }
    .premium-doc-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(14, 165, 233, 0.12);
        border-color: rgba(14, 165, 233, 0.06);
    }

    /* ===== IMAGE SECTION ===== */
    .doc-image-wrapper {
        height: 200px;
        overflow: hidden;
        background: #f8fafc;
        position: relative;
    }
    .doc-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    .premium-doc-card:hover .doc-image-wrapper img {
        transform: scale(1.08);
    }

    /* ===== OVERLAY ===== */
    .img-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.4), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .premium-doc-card:hover .img-overlay {
        opacity: 1;
    }

    /* ===== BADGE ===== */
    .badge-eskul {
        background: rgba(14, 165, 233, 0.08);
        color: #0ea5e9;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* ===== HEADER GLASS ===== */
    .header-glass {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 16px;
        padding: 16px 24px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
    }

    /* ===== PAGINATION ===== */
    .pagination .page-item .page-link {
        border: none;
        border-radius: 10px;
        margin: 0 3px;
        color: #64748b;
        font-size: 13px;
        padding: 8px 14px;
        transition: all 0.3s ease;
    }
    .pagination .page-item .page-link:hover {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: white;
        border: none;
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        border: none;
        color: white;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 12px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
    }
    .btn-primary-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(14, 165, 233, 0.4);
        color: white;
        text-decoration: none;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 20px 24px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.4s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(14, 165, 233, 0.08);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-number {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }
    .stat-label {
        font-size: 13px;
        color: #94a3b8;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- ===== HEADER GLASS ===== -->
    <div class="header-glass mb-4 d-flex flex-wrap align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 p-3 rounded-circle" style="background: rgba(14, 165, 233, 0.08);">
                <i class="fas fa-images text-primary fa-lg" style="color: #0ea5e9;"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="color: #0f172a; font-size: 20px;">Semua Dokumentasi</h5>
                <span class="text-muted" style="font-size: 14px;">Total <strong>{{ $dokumentasis->total() }}</strong> dokumentasi dari semua eskul</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
            <a href="{{ route('admin.dokumentasi.create', $selectedEskulId ?? 1) }}" class="btn-primary-gradient">
                <i class="fas fa-plus"></i> Tambah Dokumentasi
            </a>
        </div>
    </div>

    <!-- ===== STATS ===== -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(14, 165, 233, 0.08); color: #0ea5e9;">
                    <i class="fas fa-images"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $dokumentasis->total() }}</div>
                    <div class="stat-label">Total Dokumentasi</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.08); color: #10b981;">
                    <i class="fas fa-trophy"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $totalEskuls ?? 0 }}</div>
                    <div class="stat-label">Total Eskul</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.08); color: #f59e0b;">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $dokumentasis->count() > 0 ? $dokumentasis->first()->created_at->format('d M Y') : '-' }}</div>
                    <div class="stat-label">Terbaru</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.08); color: #ef4444;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $dokumentasis->count() > 0 ? $dokumentasis->first()->created_at->diffForHumans() : '-' }}</div>
                    <div class="stat-label">Diunggah</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== CARD WRAPPER ===== -->
    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden; background: #ffffff;">
        <div class="card-body p-4">
            
            @if($dokumentasis->isEmpty())
                <div class="text-center py-5">
                    <div class="empty-icon mb-3" style="font-size: 64px; color: #d1d5db; opacity: 0.6;">
                        <i class="fas fa-images"></i>
                    </div>
                    <h5 class="text-muted fw-bold">Belum ada dokumentasi.</h5>
                    <p class="text-muted small">Mulai dokumentasikan kegiatan ekstrakurikuler sekarang!</p>
                    <a href="{{ route('admin.dokumentasi.create', $selectedEskulId ?? 1) }}" class="btn-primary-gradient mt-3">
                        <i class="fas fa-plus"></i> Tambah Dokumentasi
                    </a>
                </div>
            @else
                <div class="row g-4" id="dokumentasiContainer">
                    @foreach($dokumentasis as $dok)
                    <div class="col-xl-3 col-lg-4 col-md-6 dokumentasi-item" data-eskul-id="{{ $dok->ekskul_id ?? '' }}">
                        <div class="premium-doc-card">
                            
                            <!-- ===== IMAGE ===== -->
                            <div class="doc-image-wrapper">
                                @if($dok->foto_path)
                                    <img src="{{ asset('storage/' . $dok->foto_path) }}" alt="{{ $dok->judul }}">
                                    <div class="img-overlay">
                                        <div class="position-absolute top-50 start-50 translate-middle text-white">
                                            <i class="fas fa-search-plus fa-2x"></i>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-muted" style="color: #94a3b8;">
                                        <i class="fas fa-image fa-3x" style="opacity: 0.4;"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- ===== BODY ===== -->
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 text-truncate" style="color: #0f172a; font-size: 14px;" title="{{ $dok->judul }}">
                                        {{ $dok->judul }}
                                    </h6>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge-eskul">
                                        <i class="fas fa-trophy"></i>
                                        {{ $dok->ekskul->nama_ekskul ?? 'Umum' }}
                                    </span>
                                    <small class="text-muted" style="font-size: 11px;">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $dok->created_at->format('d M Y') }}
                                    </small>
                                </div>

                                <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $dok->deskripsi ?: 'Tidak ada deskripsi.' }}
                                </p>
                            </div>

                            <!-- ===== FOOTER ===== -->
                            <div class="card-footer bg-white border-0 p-3" style="border-top: 1px solid #f1f5f9;">
                                <a href="{{ route('admin.dokumentasi.show', $dok->id) }}" class="btn btn-sm w-100" style="border-radius: 8px; font-weight: 500; padding: 8px 0; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border: none;">
                                    <i class="fas fa-eye me-1"></i> Lihat Detail
                                </a>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- ===== PAGINATION ===== -->
                <div class="d-flex justify-content-end mt-4">
                    {{ $dokumentasis->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection