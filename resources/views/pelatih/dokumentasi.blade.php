@extends('layouts.app')

@section('title', 'Dokumentasi')
@section('subtitle', 'Kelola dokumentasi kegiatan')

@section('content')
<!-- Header -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header border-0 py-4 px-5" 
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="fas fa-images fa-2x text-white"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-0">Dokumentasi Kegiatan</h4>
                    <p class="text-white-50 mb-0 small">Kelola dokumentasi kegiatan ekstrakurikuler</p>
                </div>
            </div>
            <div>
                <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn btn-light rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i>Tambah Dokumentasi
                </a>
                <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-light rounded-pill px-4 ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Alert -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-success bg-opacity-10 rounded-circle p-2">
                <i class="fas fa-check-circle fa-2x text-success"></i>
            </div>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
            </div>
            <div>
                <strong>Gagal!</strong> {{ session('error') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Galeri Dokumentasi -->
<div class="row g-4">
    @forelse($dokumentasi as $item)
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-card">
            <div class="position-relative">
                @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" 
                         class="card-img-top" 
                         alt="{{ $item->judul }}"
                         style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" 
                         style="height: 200px;">
                        <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                @endif
                <div class="position-absolute top-0 end-0 p-2">
                    <span class="badge bg-dark bg-opacity-50 rounded-pill px-3 py-2">
                        <i class="far fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <h6 class="fw-bold mb-1">{{ $item->judul }}</h6>
                <p class="text-muted small mb-2">{{ Str::limit($item->deskripsi ?? '', 80) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="far fa-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                    </small>
                    <form action="{{ route('pelatih.dokumentasi.destroy', $item->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 100px; height: 100px;">
                    <i class="fas fa-images fa-4x text-muted"></i>
                </div>
                <h5 class="text-muted mb-2">Belum ada dokumentasi</h5>
                <p class="text-muted small">Mulai tambahkan dokumentasi kegiatan Anda</p>
                <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn btn-primary rounded-pill mt-3 px-5"
                   style="background: linear-gradient(135deg, #0f172a 0%, #312e81 50%, #4f46e5 100%); border: none;">
                    <i class="fas fa-plus me-2"></i>Tambah Dokumentasi
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12) !important;
    }
    .btn-outline-light {
        color: white;
        border-color: rgba(255,255,255,0.3);
    }
    .btn-outline-light:hover {
        background: rgba(255,255,255,0.1);
        color: white;
        border-color: rgba(255,255,255,0.5);
    }
    .btn-light {
        color: #0f172a;
    }
    .btn-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(255,255,255,0.3);
    }
</style>
@endsection