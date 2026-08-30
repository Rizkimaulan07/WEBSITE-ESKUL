@extends('layouts.app')

@section('title', 'Tambah Dokumentasi Baru')
@section('subtitle', 'Tambahkan dokumentasi kegiatan ekstrakurikuler')

@push('styles')
<style>
    .form-control-modern, .form-select-modern {
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
        background: #fafbfc;
        color: #0f172a;
        font-weight: 500;
    }
    .form-control-modern:focus, .form-select-modern:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
        background: #ffffff;
    }
    .form-control-modern.is-invalid, .form-select-modern.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
    }

    .upload-area {
        border: 2px dashed #7dd3fc;
        border-radius: 16px;
        padding: 40px 20px;
        text-align: center;
        transition: all 0.3s ease;
        background: #f0f9ff;
        cursor: pointer;
    }
    .upload-area:hover {
        border-color: #0ea5e9;
        background: #e0f2fe;
    }
    .upload-area.dragover {
        border-color: #0ea5e9;
        background: #bae6fd;
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px 32px;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
    }
    .btn-primary-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(14, 165, 233, 0.4);
        color: white;
    }

    .btn-outline-secondary-custom {
        padding: 12px 32px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        background: transparent;
        color: #64748b;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .btn-outline-secondary-custom:hover {
        border-color: #0ea5e9;
        background: rgba(14, 165, 233, 0.04);
        transform: translateY(-3px);
        color: #0f172a;
    }

    .divider-custom {
        text-align: center;
        position: relative;
        margin: 8px 0;
    }
    .divider-custom::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }
    .divider-custom span {
        background: #ffffff;
        padding: 0 16px;
        position: relative;
        color: #0ea5e9;
        font-size: 16px;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 30%, #38bdf8 60%, #7dd3fc 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-plus-circle fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Tambah Dokumentasi Baru</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Tambahkan dokumentasi kegiatan ekstrakurikuler</p>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2" style="font-weight: 500;">
                            <i class="fas fa-trophy me-2"></i>{{ $eskul->nama_ekskul ?? 'Eskul' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('admin.dokumentasi.store', $eskul->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="eskul_id" value="{{ $eskul->id }}">

                    <div class="row g-4">
                        <!-- Judul -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-heading me-2" style="color: #0ea5e9;"></i>Judul Dokumentasi
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('judul') is-invalid @enderror" 
                                       name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul dokumentasi" required>
                                @error('judul')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-align-left me-2" style="color: #0ea5e9;"></i>Deskripsi
                                </label>
                                <textarea class="form-control form-control-modern @error('deskripsi') is-invalid @enderror" 
                                          name="deskripsi" rows="4" placeholder="Masukkan deskripsi kegiatan">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Multiple Foto Upload -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-images me-2" style="color: #0ea5e9;"></i>Foto Dokumentasi
                                    <span class="text-danger">*</span>
                                    <span class="text-muted" style="font-weight: 400; font-size: 12px;">(Bisa upload lebih dari 1 foto)</span>
                                </label>
                                <div class="upload-area" id="uploadArea">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #0ea5e9; opacity: 0.6;"></i>
                                    <p class="mt-3 mb-0 fw-bold" style="color: #0f172a;">Klik atau seret foto ke sini</p>
                                    <small class="text-muted" style="font-size: 12px;">Format JPG, PNG, WEBP maksimal 5MB per foto</small>
                                    <input type="file" class="d-none" name="fotos[]" id="fileInput" accept="image/*" multiple required>
                                </div>
                                <div id="filePreview" class="mt-3 d-none">
                                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f0f9ff; border: 1px solid #7dd3fc;">
                                        <i class="fas fa-file-image fa-2x" style="color: #0ea5e9;"></i>
                                        <div>
                                            <p class="mb-0 fw-bold" id="fileName" style="color: #0f172a;">file.png</p>
                                            <small class="text-muted" id="fileSize">0 KB</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger ms-auto" id="removeFile">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('fotos.*')
                                    <div class="invalid-feedback d-block" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <div class="divider-custom">
                                <span style="background: #ffffff; padding: 0 16px; color: #0ea5e9;">
                                    <i class="fas fa-save"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.dokumentasi.index') }}" class="btn-outline-secondary-custom">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-primary-gradient">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Upload area
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFile = document.getElementById('removeFile');

    uploadArea.addEventListener('click', () => fileInput.click());

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            updateFilePreview(e.dataTransfer.files);
        }
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length) {
            updateFilePreview(this.files);
        }
    });

    function updateFilePreview(files) {
        if (files.length > 0) {
            const file = files[0];
            fileName.textContent = file.name + (files.length > 1 ? ' + ' + (files.length - 1) + ' file lainnya' : '');
            fileSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
            filePreview.classList.remove('d-none');
            uploadArea.querySelector('p').textContent = '📸 ' + files.length + ' foto dipilih';
        }
    }

    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.add('d-none');
        uploadArea.querySelector('p').textContent = 'Klik atau seret foto ke sini';
    });
</script>
@endsection