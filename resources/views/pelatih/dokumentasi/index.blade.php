@extends('layouts.app')

@section('title', 'Dokumentasi')
@section('subtitle', 'Kelola dokumentasi kegiatan ekstrakurikuler')

@section('content')
<div class="card-modern">
    <div class="card-header-modern">
        <h6><i class="fas fa-images me-2" style="color: #6366f1;"></i>Dokumentasi Kegiatan</h6>
        <div class="d-flex gap-2">
            <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus me-2"></i> Tambah Dokumentasi
            </a>
            {{-- PERBAIKAN: Gunakan pelatih.dashboard --}}
            <a href="{{ route('pelatih.dashboard') }}" class="btn-secondary-custom">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
    <div class="card-body-modern">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($dokumentasis->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-images fa-4x text-muted mb-3"></i>
                <h5>Belum ada dokumentasi</h5>
                <p class="text-muted">Mulai tambahkan dokumentasi kegiatan Anda</p>
                <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn-primary-custom mt-2">
                    <i class="fas fa-plus me-2"></i> Tambah Dokumentasi
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($dokumentasis as $dokumentasi)
                <div class="col-md-4 col-lg-3">
                    <div class="dokumentasi-card">
                        <div class="dokumentasi-image">
                            @if($dokumentasi->foto)
                                <img src="{{ asset('storage/' . $dokumentasi->foto) }}" alt="{{ $dokumentasi->judul }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="dokumentasi-body">
                            <h6 class="dokumentasi-title">{{ $dokumentasi->judul }}</h6>
                            <p class="dokumentasi-desc">{{ Str::limit($dokumentasi->deskripsi, 60) }}</p>
                            <div class="dokumentasi-footer">
                                <span class="dokumentasi-date">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $dokumentasi->tanggal->format('d M Y') }}
                                </span>
                                <form action="{{ route('pelatih.dokumentasi.destroy', $dokumentasi->id) }}" 
                                      method="POST" 
                                      style="display:inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
    .card-modern {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .card-header-modern {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        background: rgba(248, 250, 252, 0.3);
    }

    .card-header-modern h6 {
        font-weight: 600;
        font-size: 14px;
        color: #0f172a;
        margin: 0;
    }

    .card-body-modern {
        padding: 24px;
    }

    .btn-primary-custom {
        padding: 8px 20px;
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35);
        color: #fff;
        text-decoration: none;
    }

    .btn-secondary-custom {
        padding: 8px 20px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-secondary-custom:hover {
        background: #f8fafc;
        color: #0f172a;
        text-decoration: none;
    }

    .dokumentasi-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dokumentasi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .dokumentasi-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
        background: #f8fafc;
    }

    .dokumentasi-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 48px;
        background: #f8fafc;
    }

    .dokumentasi-body {
        padding: 16px;
    }

    .dokumentasi-title {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
        font-size: 14px;
    }

    .dokumentasi-desc {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 12px;
    }

    .dokumentasi-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px solid rgba(0,0,0,0.02);
    }

    .dokumentasi-date {
        font-size: 12px;
        color: #94a3b8;
    }

    .btn-delete {
        border: none;
        background: none;
        color: #ef4444;
        padding: 4px 8px;
        border-radius: 6px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.06);
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .card-header-modern {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-primary-custom,
        .btn-secondary-custom {
            width: 100%;
            justify-content: center;
        }

        .dokumentasi-image {
            height: 150px;
        }
    }
</style>
@endsection