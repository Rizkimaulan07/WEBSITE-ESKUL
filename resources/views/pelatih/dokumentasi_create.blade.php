@extends('layouts.app')

@section('title', 'Tambah Dokumentasi')
@section('subtitle', 'Tambahkan dokumentasi kegiatan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3">
                        <i class="fas fa-camera fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0">Tambah Dokumentasi</h4>
                        <p class="text-white-50 mb-0 small">Tambahkan dokumentasi kegiatan</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('pelatih.dokumentasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="fw-semibold mb-2">
                            <i class="fas fa-heading text-primary me-2"></i>Judul
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                               name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul dokumentasi" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold mb-2">
                            <i class="fas fa-align-left text-primary me-2"></i>Deskripsi
                        </label>
                        <textarea class="form-control form-control-lg @error('deskripsi') is-invalid @enderror" 
                                  name="deskripsi" rows="4" placeholder="Tuliskan deskripsi kegiatan...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold mb-2">
                            <i class="fas fa-image text-primary me-2"></i>Foto
                            <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control form-control-lg @error('foto') is-invalid @enderror" 
                               name="foto" accept="image/*" required>
                        <small class="text-muted">Format: jpeg, png, jpg, webp | Max: 2MB</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('pelatih.dokumentasi') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2" 
                                style="background: linear-gradient(135deg, #0f172a 0%, #312e81 50%, #4f46e5 100%); border: none;">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control-lg {
        padding: 12px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    .form-control-lg:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
    }
    .form-control-lg.is-invalid {
        border-color: #ef4444;
    }
    .btn-primary {
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(79, 70, 229, 0.35);
    }
    .btn-outline-secondary {
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    .btn-outline-secondary:hover {
        transform: translateY(-3px);
        background: #f8fafc;
    }
    @media (max-width: 768px) {
        .card-body {
            padding: 20px !important;
        }
        .btn {
            width: 100%;
        }
        .d-flex.gap-3 {
            flex-direction: column;
        }
        .d-flex.gap-3.justify-content-end {
            flex-direction: column-reverse;
        }
    }
</style>
@endsection