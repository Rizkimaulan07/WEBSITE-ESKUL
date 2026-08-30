@extends('layouts.app')

@section('title', 'Dokumentasi ' . ($eskul->nama_ekskul ?? 'Ekskul'))
@section('subtitle', 'Dokumentasi kegiatan ekstrakurikuler')

@push('styles')
<style>
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
    .header-glass {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 16px;
        padding: 16px 24px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
    }
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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="header-glass mb-4 d-flex flex-wrap align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 p-3 rounded-circle" style="background: rgba(14, 165, 233, 0.08);">
                <i class="fas fa-images text-primary fa-lg" style="color: #0ea5e9;"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="color: #0f172a; font-size: 20px;">
                    Dokumentasi {{ $eskul->nama_ekskul }}
                </h5>
                <span class="text-muted" style="font-size: 14px;">
                    Total <strong>{{ $dokumentasis->total() }}</strong> dokumentasi kegiatan
                </span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3 mt-2 mt-md-0">
            <a href="{{ route('admin.dokumentasi.create', $eskul->id) }}" class="btn" style="border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; font-weight: 600; padding: 10px 24px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 4px 16px rgba(14,165,233,0.25); transition: all 0.3s ease;">
                <i class="fas fa-plus me-2"></i> Tambah Dokumentasi
            </a>
            <a href="{{ route('admin.ekskul.index') }}" class="btn" style="border-radius: 12px; border: 2px solid #e2e8f0; background: transparent; color: #64748b; font-weight: 500; padding: 10px 24px; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden; background: #ffffff;">
        <div class="card-body p-4">
            @if($dokumentasis->isEmpty())
                <div class="text-center py-5">
                    <div class="empty-icon mb-3" style="font-size: 64px; color: #d1d5db; opacity: 0.6;">
                        <i class="fas fa-images"></i>
                    </div>
                    <h5 class="text-muted fw-bold">Belum ada dokumentasi untuk {{ $eskul->nama_ekskul }}</h5>
                    <p class="text-muted small">Klik tombol "Tambah Dokumentasi" untuk mengunggah kegiatan</p>
                    <a href="{{ route('admin.dokumentasi.create', $eskul->id) }}" class="btn mt-3 px-5" style="border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 4px 16px rgba(14,165,233,0.25);">
                        <i class="fas fa-plus me-2"></i> Tambah Dokumentasi
                    </a>
                </div>
            @else
                <div class="row g-4">
                    @foreach($dokumentasis as $dok)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="premium-doc-card">
                            <div class="doc-image-wrapper">
                                @if($dok->foto_path)
                                    @php
                                        $normalizedPath = App\Models\Dokumentasi::normalizeFotoPath($dok->foto_path);
                                        $imagePath = null;
                                        if (!empty($normalizedPath) && Storage::disk('public')->exists($normalizedPath)) {
                                            $imagePath = Storage::url($normalizedPath);
                                        } elseif (!empty($normalizedPath) && file_exists(storage_path('app/public/' . $normalizedPath))) {
                                            $imagePath = asset('storage/' . $normalizedPath);
                                        } elseif (!empty($normalizedPath) && file_exists(public_path('storage/' . $normalizedPath))) {
                                            $imagePath = asset('storage/' . $normalizedPath);
                                        }
                                    @endphp
                                    @if($imagePath)
                                        <img src="{{ $imagePath }}" alt="{{ $dok->judul }}">
                                        <div class="img-overlay">
                                            <div class="position-absolute top-50 start-50 translate-middle text-white">
                                                <i class="fas fa-search-plus fa-2x"></i>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-muted" style="color: #64748b;">
                                            <i class="fas fa-image fa-3x" style="opacity: 0.4;"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-muted" style="color: #64748b;">
                                        <i class="fas fa-image fa-3x" style="opacity: 0.4;"></i>
                                    </div>
                                @endif
                            </div>

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
                                        {{ $dok->tanggal_kegiatan?->format('d M Y') ?? $dok->created_at->format('d M Y') }}
                                    </small>
                                </div>

                                <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $dok->deskripsi ?: 'Tidak ada deskripsi.' }}
                                </p>
                            </div>

                            <div class="card-footer bg-white border-0 p-3" style="border-top: 1px solid #f1f5f9;">
                                <a href="{{ route('admin.dokumentasi.show', $dok->id) }}" class="btn btn-sm w-100" style="border-radius: 8px; font-weight: 500; padding: 8px 0; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border: none;">
                                    <i class="fas fa-eye me-1"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end mt-4">
                    {{ $dokumentasis->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection