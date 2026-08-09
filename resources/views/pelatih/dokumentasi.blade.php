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
                {{-- TAMPILKAN GAMBAR DARI MULTIPLE PATH --}}
                @if($item->foto_path)
                    @php
                        // Cek beberapa kemungkinan path
                        $possiblePaths = [
                            $item->foto_path, // original
                            'foto/' . basename($item->foto_path), // foto/
                            str_replace('dokumentasi/', 'foto/', $item->foto_path), // ganti prefix
                        ];
                        
                        $foundPath = null;
                        foreach ($possiblePaths as $p) {
                            if (file_exists(public_path($p))) {
                                $foundPath = $p;
                                break;
                            }
                        }
                        
                        // Jika masih tidak ditemukan, coba di storage
                        if (!$foundPath) {
                            $storagePath = str_replace('foto/', 'dokumentasi/', $item->foto_path);
                            if (file_exists(storage_path('app/public/' . $storagePath))) {
                                // Copy file ke public/foto
                                if (!file_exists(public_path('foto'))) {
                                    mkdir(public_path('foto'), 0777, true);
                                }
                                copy(storage_path('app/public/' . $storagePath), public_path('foto/' . basename($item->foto_path)));
                                $foundPath = 'foto/' . basename($item->foto_path);
                            }
                        }
                    @endphp
                    
                    @if($foundPath)
                        <img src="{{ asset($foundPath) }}" 
                             class="card-img-top" 
                             alt="{{ $item->judul }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex flex-column align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="fas fa-image fa-4x text-muted mb-2"></i>
                            <small class="text-muted">Gambar tidak ditemukan</small>
                            <small class="text-danger" style="font-size: 10px;">{{ $item->foto_path }}</small>
                            <small class="text-muted" style="font-size: 9px; margin-top: 4px;">
                                Coba: {{ implode(', ', array_map(function($p) { return basename($p); }, $possiblePaths)) }}
                            </small>
                        </div>
                    @endif
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" 
                         style="height: 200px;">
                        <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                @endif

                {{-- Badge tanggal --}}
                <div class="position-absolute top-0 end-0 p-2">
                    <span class="badge bg-dark bg-opacity-50 rounded-pill px-3 py-2">
                        <i class="far fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') }}
                    </span>
                </div>

                {{-- Tombol Aksi: Edit & Hapus --}}
                <div class="position-absolute bottom-0 start-0 end-0 p-2" 
                     style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                    <div class="d-flex gap-2 justify-content-end">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('pelatih.dokumentasi.edit', $item->id) }}" 
                           class="btn btn-warning btn-sm rounded-circle"
                           style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;"
                           title="Edit Dokumentasi">
                            <i class="fas fa-edit fa-xs"></i>
                        </a>
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('pelatih.dokumentasi.destroy', $item->id) }}" 
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-circle" 
                                    style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                    title="Hapus Dokumentasi">
                                <i class="fas fa-trash-alt fa-xs"></i>
                            </button>
                        </form>
                    </div>
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
                    <a href="{{ route('pelatih.dokumentasi.show', $item->id) }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        <i class="fas fa-eye me-1"></i> Detail
                    </a>
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

<!-- Pagination -->
@if(method_exists($dokumentasi, 'links'))
    <div class="mt-4">
        {{ $dokumentasi->links('pagination::bootstrap-5') }}
    </div>
@endif

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
    .btn-warning {
        opacity: 0.8;
        transition: all 0.3s ease;
        color: #fff;
    }
    .btn-warning:hover {
        opacity: 1;
        transform: scale(1.1);
        color: #fff;
    }
    .btn-danger {
        opacity: 0.8;
        transition: all 0.3s ease;
    }
    .btn-danger:hover {
        opacity: 1;
        transform: scale(1.1);
    }
    .btn-outline-primary {
        border-color: #e5e7eb;
        color: #64748b;
    }
    .btn-outline-primary:hover {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #fff;
    }
</style>
@endsection