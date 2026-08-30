@extends('layouts.app')

@section('title', 'Dokumentasi Kegiatan Ekstrakulikuler')
@section('subtitle', 'Lihat detail dokumentasi kegiatan Ekstrakulikuler')

@push('styles')
<style>
    /* ===== Modern Glassmorphism Effect ===== */
    .modern-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .modern-card:hover {
        box-shadow: 0 30px 80px rgba(59, 130, 246, 0.10);
        transform: translateY(-4px);
    }

    /* ===== Modern Button Styling ===== */
    .btn-modern {
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(59, 130, 246, 0.25);
    }
    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.35);
    }
    .btn-modern-outline {
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 2px solid #e2e8f0;
    }
    .btn-modern-outline:hover {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.04);
        transform: translateY(-3px);
    }

    /* ===== Meta Data Icons ===== */
    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 13px;
        color: #475569;
    }
    .meta-item i {
        color: #3b82f6;
    }

    /* ===== Deskripsi Box ===== */
    .desc-box {
        background: #f8fafc;
        border-radius: 16px;
        border-left: 5px solid #3b82f6;
        padding: 20px 24px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }

    /* ===== Image Hover ===== */
    .doc-image-wrap {
        position: relative;
        overflow: hidden;
        max-height: 500px;
        background: #f1f5f9;
    }
    .doc-image-wrap img {
        transition: transform 0.6s ease;
    }
    .doc-image-wrap:hover img {
        transform: scale(1.02);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- ===== TOMBOL KEMBALI MODERN ===== -->
    <div class="mb-4 d-flex align-items-center gap-2">
        <a href="{{ route('admin.dokumentasi.index') }}" class="btn btn-modern-outline">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Galeri
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- ===== CARD MODERN ===== -->
            <div class="modern-card">
                
                <!-- ===== IMAGE SECTION ===== -->
                <div class="doc-image-wrap" style="max-height: 500px; overflow: hidden; background: #f1f5f9; border-radius: 24px 24px 0 0;">
                    @if($dokumentasi->foto_path)
                        <img src="{{ asset('storage/' . $dokumentasi->foto_path) }}" 
                             alt="{{ $dokumentasi->judul }}" 
                             class="w-100" 
                             style="object-fit: cover; max-height: 500px; display: block;">
                    @else
                        <div class="d-flex align-items-center justify-content-center" style="height: 300px; background: #f8fafc; color: #94a3b8;">
                            <div class="text-center">
                                <div style="font-size: 60px; opacity: 0.3; margin-bottom: 12px;">
                                    <i class="fas fa-image"></i>
                                </div>
                                <p class="mb-0 fw-medium" style="font-size: 16px;">Belum ada gambar yang diunggah</p>
                                <small class="text-muted">Tambahkan foto untuk mempercantik dokumentasi</small>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ===== CONTENT BODY ===== -->
                <div class="p-4 p-lg-5">
                    
                    <!-- ===== HEADER: Judul & Badge ===== -->
                    <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="fw-bold mb-0" style="color: #0f172a; font-size: 30px; letter-spacing: -0.5px;">
                                {{ $dokumentasi->judul }}
                            </h1>
                        </div>
                        <span class="badge bg-gradient-primary text-white px-3 py-2 rounded-pill shadow-sm" style="font-size: 14px; font-weight: 600; background: linear-gradient(135deg, #3b82f6, #60a5fa);">
                            <i class="fas fa-trophy me-1"></i> {{ $dokumentasi->ekskul->nama_ekskul ?? 'Umum' }}
                        </span>
                    </div>

                    <!-- ===== METADATA (Modern Chips) ===== -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="meta-item">
                            <i class="far fa-calendar-alt"></i> {{ $dokumentasi->created_at->format('d F Y') }}
                        </span>
                        <span class="meta-item">
                            <i class="far fa-clock"></i> {{ $dokumentasi->created_at->format('H:i') }}
                        </span>
                        <span class="meta-item">
                            <i class="far fa-user"></i> {{ $dokumentasi->user->name ?? 'Admin' }}
                        </span>
                    </div>

                    <!-- ===== DESKRIPSI BOX ===== -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-pen-fancy text-primary"></i>
                            <h5 class="fw-bold mb-0" style="color: #334155;">Deskripsi Kegiatan</h5>
                        </div>
                        <div class="desc-box">
                            <p class="mb-0 text-secondary" style="line-height: 1.8; font-size: 15px;">
                                {{ $dokumentasi->deskripsi ?: 'Tidak ada deskripsi untuk dokumentasi ini.' }}
                            </p>
                        </div>
                    </div>

                    <!-- ===== FOOTER ACTION ===== -->
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top flex-wrap gap-2" style="border-color: #f1f5f9 !important;">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.dokumentasi.edit', $dokumentasi->id) }}" class="btn btn-modern-outline">
                                <i class="fas fa-edit me-2"></i> Edit
                            </a>
                            <form action="{{ route('admin.dokumentasi.destroy', $dokumentasi->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-modern" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.25);">
                                    <i class="fas fa-trash-alt me-2"></i> Hapus
                                </button>
                            </form>
                        </div>
                        <a href="{{ route('admin.dokumentasi.index') }}" class="btn btn-modern btn-primary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Galeri
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection