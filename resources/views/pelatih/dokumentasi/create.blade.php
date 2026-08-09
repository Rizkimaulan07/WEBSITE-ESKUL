@extends('layouts.app')

@section('title', 'Tambah Dokumentasi')
@section('subtitle', 'Tambah dokumentasi kegiatan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Header Card -->
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3">
                        <i class="fas fa-camera fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0">Tambah Dokumentasi</h4>
                        <p class="text-white-50 mb-0 small">Tambahkan dokumentasi kegiatan ekstrakurikuler</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
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

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                            </div>
                            <div>
                                <strong>Gagal!</strong> Silakan periksa data berikut:
                                <ul class="mb-0 mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('pelatih.dokumentasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Ekskul ID (hidden jika pelatih sudah punya ekskul) -->
                        @if(Auth::user()->ekskul_id)
                            <input type="hidden" name="ekskul_id" value="{{ Auth::user()->ekskul_id }}">
                        @else
                            <div class="col-12">
                                <div class="form-group-modern">
                                    <label class="fw-semibold mb-2">
                                        <i class="fas fa-trophy text-primary me-2"></i>Ekstrakurikuler
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control form-control-modern @error('ekskul_id') is-invalid @enderror" 
                                            name="ekskul_id" required>
                                        <option value="">Pilih Ekstrakurikuler</option>
                                        @foreach($allEkskuls as $ekskul)
                                            <option value="{{ $ekskul->id }}" {{ old('ekskul_id') == $ekskul->id ? 'selected' : '' }}>
                                                {{ $ekskul->nama_ekskul }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ekskul_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <!-- Judul -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-heading text-primary me-2"></i>Judul Dokumentasi
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('judul') is-invalid @enderror" 
                                       name="judul" value="{{ old('judul') }}" 
                                       placeholder="Contoh: Kegiatan Latihan Paskibra" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-align-left text-primary me-2"></i>Deskripsi
                                </label>
                                <textarea class="form-control form-control-modern @error('deskripsi') is-invalid @enderror" 
                                          name="deskripsi" rows="4" 
                                          placeholder="Tuliskan deskripsi kegiatan...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Kegiatan -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-calendar text-primary me-2"></i>Tanggal Kegiatan
                                </label>
                                <input type="date" class="form-control form-control-modern @error('tanggal_kegiatan') is-invalid @enderror" 
                                       name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', date('Y-m-d')) }}">
                                @error('tanggal_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Foto -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-image text-primary me-2"></i>Foto
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="upload-zone border-2 border-dashed rounded-4 p-5 text-center" 
                                     style="border-color: #e5e7eb; background: #fafbfc; cursor: pointer; transition: all 0.3s ease;"
                                     onclick="document.getElementById('foto').click()">
                                    <div id="uploadPreview">
                                        <i class="fas fa-cloud-upload-alt fa-4x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">
                                            <strong class="text-primary">Klik untuk upload</strong> atau drag and drop
                                        </p>
                                        <small class="text-muted">Format: jpeg, png, jpg, webp | Maks: 2MB</small>
                                    </div>
                                    <div id="uploadNewPreview" style="display: none;">
                                        <img id="fotoPreview" src="#" alt="Preview" class="img-fluid rounded-3" style="max-height: 200px;">
                                        <br>
                                        <small class="text-muted">Klik untuk mengganti</small>
                                    </div>
                                </div>
                                <input type="file" class="d-none @error('foto') is-invalid @enderror" 
                                       id="foto" name="foto" accept="image/*"
                                       onchange="previewFoto(event)" required>
                                @error('foto')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('pelatih.dokumentasi') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 btn-gradient">
                                    <i class="fas fa-save me-2"></i>Simpan Dokumentasi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-group-modern {
        margin-bottom: 0;
    }

    .form-group-modern label {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .form-control-modern {
        padding: 12px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
        background: #fafbfc;
        color: #0f172a;
    }

    .form-control-modern:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
        background: #ffffff;
    }

    .form-control-modern.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .upload-zone {
        transition: all 0.3s ease;
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .upload-zone:hover {
        border-color: #4f46e5 !important;
        background: rgba(79, 70, 229, 0.03) !important;
        transform: scale(1.01);
    }

    .btn-gradient {
        background: linear-gradient(135deg, #0f172a 0%, #312e81 50%, #4f46e5 100%) !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(79, 70, 229, 0.35) !important;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 20px !important;
        }
        .card-header {
            padding: 16px 20px !important;
        }
        .btn {
            width: 100%;
        }
        .d-flex.gap-3 {
            flex-direction: column;
        }
        .upload-zone {
            min-height: 140px;
            padding: 20px !important;
        }
    }
</style>

<script>
    function previewFoto(event) {
        const input = event.target;
        const preview = document.getElementById('fotoPreview');
        const previewContainer = document.getElementById('uploadPreview');
        const previewNewContainer = document.getElementById('uploadNewPreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'none';
                previewNewContainer.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection