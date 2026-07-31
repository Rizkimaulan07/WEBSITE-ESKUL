@extends('layouts.app')

@section('title', 'Tambah Dokumentasi')
@section('subtitle', 'Upload dokumentasi kegiatan ekstrakurikuler')

@section('content')
<div class="card-modern">
    <div class="card-header-modern">
        <h6><i class="fas fa-upload me-2" style="color: #6366f1;"></i>Tambah Dokumentasi</h6>
        <a href="{{ route('pelatih.dokumentasi') }}" class="btn-secondary-custom">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
    <div class="card-body-modern">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('pelatih.dokumentasi.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Dokumentasi</label>
                        <input type="text" 
                               name="judul" 
                               id="judul" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               placeholder="Masukkan judul dokumentasi"
                               value="{{ old('judul') }}"
                               required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" 
                                  id="deskripsi" 
                                  class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="Masukkan deskripsi dokumentasi">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal Kegiatan</label>
                        <input type="date" 
                               name="tanggal" 
                               id="tanggal" 
                               class="form-control @error('tanggal') is-invalid @enderror"
                               value="{{ old('tanggal', date('Y-m-d')) }}">
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="foto" class="form-label fw-semibold">Upload Foto</label>
                        <div class="upload-area" id="uploadArea">
                            <input type="file" 
                                   name="foto" 
                                   id="foto" 
                                   class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/*"
                                   style="display: none;">
                            <div class="upload-preview text-center py-4" id="uploadPreview">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Klik atau drag & drop untuk upload</p>
                                <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                            </div>
                            <div class="upload-result text-center py-3" id="uploadResult" style="display: none;">
                                <img id="imagePreview" src="#" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                                <button type="button" class="btn btn-sm btn-danger mt-2" id="removeImage">
                                    <i class="fas fa-times"></i> Hapus
                                </button>
                            </div>
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-save me-2"></i> Simpan Dokumentasi
                </button>
                <a href="{{ route('pelatih.dokumentasi') }}" class="btn-secondary-custom ms-2">
                    <i class="fas fa-times me-2"></i> Batal
                </a>
            </div>
        </form>
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
        padding: 10px 24px;
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
        padding: 10px 24px;
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

    .upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fafbfc;
    }

    .upload-area:hover {
        border-color: #6366f1;
        background: #f8f9ff;
    }

    .upload-area.dragover {
        border-color: #6366f1;
        background: #f8f9ff;
    }

    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .form-label {
        font-size: 13px;
        color: #0f172a;
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
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('foto');
    const uploadPreview = document.getElementById('uploadPreview');
    const uploadResult = document.getElementById('uploadResult');
    const imagePreview = document.getElementById('imagePreview');
    const removeImage = document.getElementById('removeImage');

    uploadArea.addEventListener('click', function(e) {
        if (!e.target.closest('#removeImage')) {
            fileInput.click();
        }
    });

    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                uploadPreview.style.display = 'none';
                uploadResult.style.display = 'block';
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    removeImage.addEventListener('click', function(e) {
        e.stopPropagation();
        fileInput.value = '';
        uploadPreview.style.display = 'block';
        uploadResult.style.display = 'none';
        imagePreview.src = '#';
    });

    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endsection