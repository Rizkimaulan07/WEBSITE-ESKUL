@extends('layouts.app')

@section('title', 'Dokumentasi')
@section('subtitle', 'Kelola dokumentasi kegiatan')

@section('content')
<!-- Header - Biru Cerah -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header border-0 py-4 px-5" 
         style="background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 30%, #38bdf8 60%, #7dd3fc 100%);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-4">
                <div class="bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="fas fa-images fa-2x text-white"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Dokumentasi Kegiatan</h4>
                    <p class="text-white-50 mb-0 small" style="font-weight: 400;">Kelola dokumentasi kegiatan ekstrakurikuler</p>
                </div>
            </div>
            <div>
                <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn btn-light rounded-pill px-4" style="color: #0f172a; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                    <i class="fas fa-plus me-2"></i>Tambah Dokumentasi
                </a>
                <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-light rounded-pill px-4 ms-2" style="color: white; border-color: rgba(255,255,255,0.3); transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Alert -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert" style="background: #d1fae5; border-left: 4px solid #10b981;">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-success bg-opacity-10 rounded-circle p-2">
                <i class="fas fa-check-circle fa-2x text-success"></i>
            </div>
            <div>
                <strong style="color: #065f46;">Berhasil!</strong> 
                <span style="color: #047857;">{{ session('success') }}</span>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert" style="background: #fee2e2; border-left: 4px solid #ef4444;">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
            </div>
            <div>
                <strong style="color: #991b1b;">Gagal!</strong> 
                <span style="color: #7f1d1d;">{{ session('error') }}</span>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Galeri Dokumentasi -->
<div class="row g-4">
    @forelse($dokumentasi as $item)
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-card" style="background: #ffffff; transition: all 0.3s ease;">
            <div class="position-relative">
                @if($item->foto_path)
                    @php
                        $normalizedPath = App\Models\Dokumentasi::normalizeFotoPath($item->foto_path);
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
                        <img src="{{ $imagePath }}"
                             class="card-img-top"
                             alt="{{ $item->judul }}"
                             style="height: 220px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex flex-column align-items-center justify-content-center" 
                             style="height: 220px; background: #f8fafc;">
                            <i class="fas fa-image fa-4x text-muted mb-2" style="color: #94a3b8;"></i>
                            <small class="text-muted" style="color: #94a3b8;">Gambar tidak ditemukan</small>
                        </div>
                    @endif
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" 
                         style="height: 220px; background: #f8fafc;">
                        <i class="fas fa-image fa-4x text-muted" style="color: #94a3b8;"></i>
                    </div>
                @endif

                <!-- Badge tanggal -->
                <div class="position-absolute top-0 end-0 p-2">
                    <span class="badge bg-dark bg-opacity-50 rounded-pill px-3 py-2" style="backdrop-filter: blur(4px);">
                        <i class="far fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($item->tanggal_kegiatan ?? $item->created_at)->format('d M Y') }}
                    </span>
                </div>

                <!-- Tombol Hapus -->
                <div class="position-absolute bottom-0 end-0 p-2">
                    <form action="{{ route('pelatih.dokumentasi.destroy', $item->id) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm rounded-circle" 
                                style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.9); border: none; transition: all 0.3s ease;"
                                title="Hapus Dokumentasi">
                            <i class="fas fa-trash-alt fa-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body" style="padding: 16px;">
                <h6 class="fw-bold mb-1 text-truncate" style="color: #0f172a;">{{ $item->judul }}</h6>
                <p class="text-muted small mb-2" style="color: #94a3b8; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ Str::limit($item->deskripsi ?? '', 80) }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted" style="color: #94a3b8;">
                        <i class="far fa-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                    </small>
                    <span class="badge rounded-pill" style="background: rgba(14,165,233,0.08); color: #0ea5e9;">
                        <i class="fas fa-user me-1"></i>
                        {{ $item->user->name ?? 'Pelatih' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4" style="background: #ffffff;">
            <div class="card-body text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 100px; height: 100px; background: #f8fafc;">
                    <i class="fas fa-images fa-4x text-muted" style="color: #94a3b8;"></i>
                </div>
                <h5 class="text-muted mb-2" style="color: #94a3b8;">Belum ada dokumentasi</h5>
                <p class="text-muted small" style="color: #94a3b8;">Mulai tambahkan dokumentasi kegiatan Anda</p>
                <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn btn-primary rounded-pill mt-3 px-5" 
                   style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; box-shadow: 0 4px 16px rgba(14,165,233,0.25); text-decoration: none; display: inline-flex; align-items: center;">
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
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(14,165,233,0.12) !important;
    }
    .btn-outline-light:hover {
        background: rgba(255,255,255,0.1);
        color: white;
        border-color: rgba(255,255,255,0.5);
    }
    .btn-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(255,255,255,0.3);
    }
    .btn-danger:hover {
        opacity: 1;
        transform: scale(1.1);
    }
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
</style>
@endsection