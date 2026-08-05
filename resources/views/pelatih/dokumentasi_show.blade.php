@extends('layouts.app')

@section('title', $dokumentasi->judul)
@section('subtitle', 'Detail dokumentasi kegiatan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3">
                        <i class="fas fa-images fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0">{{ $dokumentasi->judul }}</h4>
                        <p class="text-white-50 mb-0 small">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($dokumentasi->created_at)->format('l, d F Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                @if($dokumentasi->foto_path)
                    <div class="dokumentasi-image mb-4">
                        <img src="{{ asset('storage/' . $dokumentasi->foto_path) }}" 
                             alt="{{ $dokumentasi->judul }}"
                             class="img-fluid rounded-3">
                    </div>
                @endif

                <div class="info-ekskul mb-4">
                    <div class="d-flex align-items-center gap-3 p-3" 
                         style="background: rgba(79,70,229,0.03); border-radius: 12px; border: 1px solid rgba(79,70,229,0.06);">
                        <div class="ekskul-icon" 
                             style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #4f46e5, #818cf8); display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; flex-shrink: 0;">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <div class="text-muted small text-uppercase" style="letter-spacing: 0.5px; font-weight: 600;">
                                <i class="fas fa-building me-1"></i> Ekstrakurikuler
                            </div>
                            <h5 class="fw-bold mb-0" style="color: #0f172a;">
                                {{ $dokumentasi->ekskul->nama_ekskul ?? 'Ekskul' }}
                            </h5>
                            <small class="text-muted">
                                <i class="fas fa-user-tie me-1"></i>
                                {{ $dokumentasi->ekskul->pembina ?? '-' }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-calendar-day me-1"></i>
                                {{ $dokumentasi->ekskul->hari_latihan ?? '-' }}
                            </small>
                        </div>
                        <div class="ms-auto">
                            <span class="badge" style="background: rgba(79,70,229,0.06); color: #4f46e5; padding: 4px 14px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($dokumentasi->created_at)->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="dokumentasi-deskripsi">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-align-left me-2" style="color: #4f46e5;"></i>
                        Deskripsi
                    </h5>
                    <div class="deskripsi-content" style="font-size: 16px; line-height: 1.8; color: #1e293b;">
                        {{ $dokumentasi->deskripsi ?? 'Tidak ada deskripsi' }}
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex gap-3 justify-content-between flex-wrap">
                        <div class="d-flex gap-2">
                            <a href="{{ route('pelatih.dokumentasi') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn btn-outline-primary rounded-pill px-4">
                                <i class="fas fa-plus me-2"></i> Tambah Dokumentasi
                            </a>
                        </div>
                        <form action="{{ route('pelatih.dokumentasi.destroy', $dokumentasi->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                <i class="fas fa-trash-alt me-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dokumentasi-image {
        border-radius: 12px;
        overflow: hidden;
        background: #f8fafc;
    }
    .dokumentasi-image img {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
    }
    .deskripsi-content {
        background: #f8fafc;
        padding: 20px 24px;
        border-radius: 12px;
        border-left: 4px solid #4f46e5;
    }
    @media (max-width: 768px) {
        .card-body { padding: 20px !important; }
        .dokumentasi-image img { max-height: 250px; }
        .btn { width: 100%; }
        .d-flex.gap-3 { flex-direction: column; }
        .d-flex.gap-3.justify-content-between { flex-direction: column; }
    }
</style>
@endsection