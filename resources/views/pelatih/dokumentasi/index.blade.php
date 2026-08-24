@extends('layouts.app')

@section('title', 'Dokumentasi')
@section('subtitle', 'Kelola dokumentasi kegiatan ekstrakurikuler')

@section('content')
<div class="card-modern" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-header-modern" style="padding: 16px 24px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe);">
        <h6 style="font-weight: 600; font-size: 14px; color: #0f172a; margin: 0;">
            <i class="fas fa-images me-2" style="color: #0ea5e9;"></i>Dokumentasi Kegiatan
        </h6>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn-primary-custom" style="padding: 8px 20px; border: none; border-radius: 8px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 13px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 4px 16px rgba(14,165,233,0.25);">
                <i class="fas fa-plus me-2"></i> Tambah Dokumentasi
            </a>
            <a href="{{ route('pelatih.dashboard') }}" class="btn-secondary-custom" style="padding: 8px 20px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff; color: #64748b; font-size: 13px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-body-modern" style="padding: 24px;">
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

        @if($dokumentasi->isEmpty())
            <div class="text-center py-5">
                <div class="empty-icon" style="font-size: 64px; color: #d1d5db; margin-bottom: 16px; opacity: 0.5;">
                    <i class="fas fa-images"></i>
                </div>
                <h5 style="color: #64748b; margin-bottom: 4px; font-weight: 600;">Belum ada dokumentasi</h5>
                <p class="text-muted" style="color: #94a3b8; font-size: 13px;">Mulai tambahkan dokumentasi kegiatan Anda</p>
                <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn-primary-custom mt-2" style="padding: 12px 24px; border: none; border-radius: 8px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 13px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 4px 16px rgba(14,165,233,0.25);">
                    <i class="fas fa-plus me-2"></i> Tambah Dokumentasi
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($dokumentasi as $item)
                <div class="col-md-4 col-lg-3">
                    <div class="dokumentasi-card" style="background: #fff; border-radius: 12px; border: 1px solid rgba(0,0,0,0.04); overflow: hidden; transition: all 0.3s ease;">
                        <div class="dokumentasi-image" style="width: 100%; height: 200px; overflow: hidden; background: #f8fafc;">
                            @php
                                $normalizedPath = App\Models\Dokumentasi::normalizeFotoPath($item->foto_path);
                                $imageSource = null;
                                if (!empty($normalizedPath) && Storage::disk('public')->exists($normalizedPath)) {
                                    $imageSource = asset('storage/' . $normalizedPath);
                                }
                            @endphp
                            @if($imageSource)
                                <img src="{{ $imageSource }}" alt="{{ $item->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="no-image" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 48px; background: #f8fafc;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            @if($item->ekskul)
                            <div class="dokumentasi-badge" style="position: absolute; top: 12px; left: 12px; background: rgba(14,165,233,0.9); backdrop-filter: blur(4px); color: #fff; padding: 4px 14px; border-radius: 12px; font-size: 11px; font-weight: 500; border: 1px solid rgba(255,255,255,0.1);">
                                <i class="fas fa-trophy me-1"></i>
                                {{ $item->ekskul->nama_ekskul ?? 'Eskul' }}
                            </div>
                            @endif
                        </div>
                        <div class="dokumentasi-body" style="padding: 16px;">
                            <h6 class="dokumentasi-title" style="font-weight: 600; color: #0f172a; margin-bottom: 4px; font-size: 14px;">{{ $item->judul }}</h6>
                            <p class="dokumentasi-desc" style="font-size: 13px; color: #64748b; margin-bottom: 12px;">{{ Str::limit($item->deskripsi, 60) }}</p>
                            <div class="dokumentasi-footer" style="display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px solid rgba(0,0,0,0.02);">
                                <span class="dokumentasi-date" style="font-size: 12px; color: #94a3b8;">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $item->tanggal_kegiatan ? $item->tanggal_kegiatan->format('d M Y') : '-' }}
                                </span>
                                <form action="{{ route('pelatih.dokumentasi.destroy', $item->id) }}" 
                                      method="POST" 
                                      style="display:inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" style="border: none; background: none; color: #ef4444; padding: 4px 8px; border-radius: 6px; transition: all 0.3s ease; cursor: pointer;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $dokumentasi->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<style>
    .dokumentasi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(14, 165, 233, 0.08);
        border-color: rgba(14, 165, 233, 0.06);
    }
    .dokumentasi-card:hover .dokumentasi-image img {
        transform: scale(1.05);
    }
    .dokumentasi-image { position: relative; }
    .dokumentasi-image img { transition: transform 0.4s ease; }
    .btn-delete:hover { background: rgba(239, 68, 68, 0.06); transform: scale(1.1); }
    .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(14,165,233,0.35); color: #fff; text-decoration: none; }
    .btn-secondary-custom:hover { background: #f8fafc; color: #0f172a; text-decoration: none; }
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
        .card-header-modern { flex-direction: column; align-items: stretch; }
        .btn-primary-custom, .btn-secondary-custom { width: 100%; justify-content: center; }
        .dokumentasi-image { height: 150px; }
    }
</style>
@endsection