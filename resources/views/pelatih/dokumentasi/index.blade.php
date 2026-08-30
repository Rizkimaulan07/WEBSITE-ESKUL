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
            <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn-primary-gradient" style="padding: 8px 20px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-plus me-2"></i> Tambah Dokumentasi
            </a>
            <a href="{{ route('pelatih.dashboard') }}" class="btn-secondary-custom" style="padding: 8px 20px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff; color: #64748b; font-size: 13px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-body-modern" style="padding: 24px;">
        @if($dokumentasi->isEmpty())
            <div class="text-center py-5">
                <div class="empty-icon" style="font-size: 64px; color: #d1d5db; margin-bottom: 16px; opacity: 0.5;">
                    <i class="fas fa-images"></i>
                </div>
                <h5 style="color: #64748b; margin-bottom: 4px; font-weight: 600;">Belum ada dokumentasi</h5>
                <p class="text-muted" style="color: #64748b; font-size: 13px;">Mulai tambahkan dokumentasi kegiatan Anda</p>
                <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn-primary-gradient mt-2" style="padding: 12px 24px; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-plus me-2"></i> Tambah Dokumentasi
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($dokumentasi as $item)
                <div class="col-md-4 col-lg-3">
                    <div class="dokumentasi-card" style="background: #fff; border-radius: 12px; border: 1px solid rgba(0,0,0,0.04); overflow: hidden; transition: all 0.3s ease;">
                        <div class="dokumentasi-image" style="width: 100%; height: 200px; overflow: hidden; background: #f8fafc; position: relative;">
                            @php
                                $normalizedPath = App\Models\Dokumentasi::normalizeFotoPath($item->foto_path);
                                $imageSource = null;
                                if (!empty($normalizedPath) && Storage::disk('public')->exists($normalizedPath)) {
                                    $imageSource = asset('storage/' . $normalizedPath);
                                }
                            @endphp
                            @if($imageSource)
                                <img src="{{ $imageSource }}" alt="{{ $item->judul }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;">
                            @else
                                <div class="no-image" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 48px; background: #f8fafc;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            @if($item->ekskul)
                            <div class="dokumentasi-badge" style="position: absolute; top: 12px; left: 12px; background: rgba(14,165,233,0.9); backdrop-filter: blur(4px); color: #fff; padding: 4px 14px; border-radius: 12px; font-size: 11px; font-weight: 500; border: 1px solid rgba(255,255,255,0.1);">
                                <i class="fas fa-trophy me-1"></i>
                                {{ $item->ekskul->nama_ekskul ?? 'Eskul' }}
                            </div>
                            @endif
                            <!-- Badge jumlah foto -->
                            @if($item->foto_lainnya)
                                @php
                                    $fotoLainnya = json_decode($item->foto_lainnya, true);
                                    $totalFoto = is_array($fotoLainnya) ? count($fotoLainnya) + 1 : 1;
                                @endphp
                                <div class="foto-count-badge" style="position: absolute; bottom: 12px; right: 12px; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); color: #fff; padding: 2px 10px; border-radius: 12px; font-size: 11px; font-weight: 500;">
                                    <i class="fas fa-images me-1"></i> {{ $totalFoto }}
                                </div>
                            @endif
                        </div>
                        <div class="dokumentasi-body" style="padding: 16px;">
                            <h6 class="dokumentasi-title" style="font-weight: 600; color: #0f172a; margin-bottom: 4px; font-size: 14px;">{{ $item->judul }}</h6>
                            <p class="dokumentasi-desc" style="font-size: 13px; color: #64748b; margin-bottom: 12px;">{{ Str::limit($item->deskripsi, 60) }}</p>
                            <div class="dokumentasi-footer" style="display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px solid rgba(0,0,0,0.02);">
                                <span class="dokumentasi-date" style="font-size: 12px; color: #64748b;">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $item->tanggal_kegiatan ? $item->tanggal_kegiatan->format('d M Y') : '-' }}
                                </span>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('pelatih.dokumentasi.edit', $item->id) }}" class="btn-edit" style="border: none; background: none; color: #0ea5e9; padding: 4px 8px; border-radius: 6px; transition: all 0.3s ease; text-decoration: none;">
                                        <i class="fas fa-pen"></i>
                                    </a>
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
    .btn-edit:hover { background: rgba(14, 165, 233, 0.08); transform: scale(1.1); }
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
    .foto-count-badge {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }
    @media (max-width: 768px) {
        .card-header-modern { flex-direction: column; align-items: stretch; }
        .btn-primary-custom, .btn-secondary-custom { width: 100%; justify-content: center; }
        .dokumentasi-image { height: 150px; }
    }
</style>
@endsection