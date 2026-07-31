@extends('layouts.app')

@section('title', 'Edit Template Surat')
@section('subtitle', 'Ubah template surat yang sudah ada')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-modern">
            <!-- Header -->
            <div class="card-header-modern">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="fas fa-file-edit"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Edit Template Surat</h5>
                        <p class="text-muted small mb-0">Ubah data template surat</p>
                    </div>
                </div>
                <a href="{{ route('admin.template-surat.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <!-- Body Form -->
            <div class="card-body-modern">
                {{-- PERBAIKAN UTAMA: Gunakan route dengan prefix admin. --}}
                <form action="{{ route('admin.template-surat.update', $templateSurat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Judul Template -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-heading text-primary me-2"></i>Judul Template
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('judul_template') is-invalid @enderror" 
                                       name="judul_template" 
                                       value="{{ old('judul_template', $templateSurat->judul_template) }}" 
                                       placeholder="Contoh: Surat Izin Kegiatan, Surat Keterangan Aktif" 
                                       required>
                                <small class="form-text">Masukkan judul template surat</small>
                                @error('judul_template')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- File Template -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-file-upload text-primary me-2"></i>File Template
                                    <span class="text-muted small">(Kosongkan jika tidak ingin mengubah)</span>
                                </label>
                                
                                @if($templateSurat->file_template)
                                    <div class="current-file mb-2">
                                        <div class="file-info-card">
                                            <i class="fas fa-file-word me-2" style="color: #6366f1;"></i>
                                            <span class="file-name">{{ $templateSurat->file_template }}</span>
                                            <a href="{{ route('admin.template-surat.download', $templateSurat->id) }}" 
                                               class="btn-download-small">
                                                <i class="fas fa-download me-1"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="file-upload-wrapper">
                                    <div class="file-upload-zone" onclick="document.getElementById('fileInput').click()">
                                        <div class="file-upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <div class="file-upload-text">
                                            <span class="file-upload-main">Klik untuk upload file baru</span>
                                            <span class="file-upload-sub">atau drag and drop file disini</span>
                                        </div>
                                        <div class="file-upload-hint">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Format: .doc, .docx, .pdf | Maks: 2MB
                                        </div>
                                    </div>
                                    <input type="file" 
                                           class="d-none @error('file_template') is-invalid @enderror" 
                                           id="fileInput" 
                                           name="file_template" 
                                           accept=".doc,.docx,.pdf"
                                           onchange="previewFile(this)">
                                    <div id="filePreviewContainer" style="display: none;">
                                        <div class="file-preview-card">
                                            <i class="fas fa-file-alt file-preview-icon"></i>
                                            <div class="file-preview-info">
                                                <span class="file-preview-name" id="previewFileName"></span>
                                                <span class="file-preview-size" id="previewFileSize"></span>
                                            </div>
                                            <button type="button" class="file-preview-remove" onclick="removeFile()">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('file_template')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left text-primary me-2"></i>Keterangan
                                </label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                          name="keterangan" 
                                          rows="4" 
                                          placeholder="Masukkan keterangan template surat...">{{ old('keterangan', $templateSurat->keterangan) }}</textarea>
                                <small class="form-text">Deskripsi singkat tentang template surat</small>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <hr class="form-divider">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.template-surat.index') }}" class="btn-cancel">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-save me-2"></i>Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Tambahkan style yang sama seperti di create.blade.php --}}
<style>
    /* ===== CARD MODERN ===== */
    .card-modern {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .card-modern:hover {
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.06);
    }

    /* ===== HEADER ===== */
    .card-header-modern {
        padding: 20px 28px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        background: rgba(248, 250, 252, 0.3);
    }

    .header-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.25);
    }

    .btn-back {
        padding: 8px 20px;
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 10px;
        background: transparent;
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-back:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        color: #0f172a;
        text-decoration: none;
    }

    /* ===== BODY ===== */
    .card-body-modern {
        padding: 28px 32px;
    }

    /* ===== FORM GROUP ===== */
    .form-group {
        margin-bottom: 0;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 6px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 10px 16px;
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 10px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        background: #f8fafc;
        color: #0f172a;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.04);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.04);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-text {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }

    .invalid-feedback {
        display: block;
        font-size: 12px;
        color: #ef4444;
        margin-top: 4px;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* ===== FILE UPLOAD ===== */
    .file-upload-wrapper {
        position: relative;
    }

    .file-upload-zone {
        border: 2px dashed rgba(0,0,0,0.04);
        border-radius: 12px;
        padding: 32px 24px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        min-height: 140px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .file-upload-zone:hover {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.02);
        transform: scale(1.01);
    }

    .file-upload-icon {
        font-size: 40px;
        color: #94a3b8;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .file-upload-zone:hover .file-upload-icon {
        color: #6366f1;
        transform: translateY(-4px);
    }

    .file-upload-main {
        display: block;
        font-weight: 600;
        font-size: 14px;
        color: #0f172a;
    }

    .file-upload-sub {
        display: block;
        font-size: 12px;
        color: #94a3b8;
    }

    .file-upload-hint {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 8px;
    }

    /* ===== CURRENT FILE ===== */
    .current-file {
        margin-bottom: 12px;
    }

    .file-info-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        background: rgba(99, 102, 241, 0.04);
        border-radius: 8px;
        border: 1px solid rgba(99, 102, 241, 0.06);
    }

    .file-info-card .file-name {
        flex: 1;
        font-size: 13px;
        color: #0f172a;
        font-weight: 500;
    }

    .btn-download-small {
        padding: 4px 14px;
        border: none;
        border-radius: 6px;
        background: rgba(16, 185, 129, 0.06);
        color: #10b981;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-download-small:hover {
        background: rgba(16, 185, 129, 0.12);
        transform: translateY(-1px);
        color: #10b981;
        text-decoration: none;
    }

    /* ===== FILE PREVIEW ===== */
    .file-preview-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: rgba(99, 102, 241, 0.04);
        border-radius: 10px;
        border: 1px solid rgba(99, 102, 241, 0.06);
        margin-top: 12px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .file-preview-icon {
        font-size: 28px;
        color: #6366f1;
    }

    .file-preview-info {
        flex: 1;
    }

    .file-preview-name {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #0f172a;
    }

    .file-preview-size {
        display: block;
        font-size: 11px;
        color: #94a3b8;
    }

    .file-preview-remove {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: rgba(239, 68, 68, 0.06);
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-preview-remove:hover {
        background: rgba(239, 68, 68, 0.12);
        transform: scale(1.1);
    }

    /* ===== DIVIDER ===== */
    .form-divider {
        border: none;
        border-top: 1px solid rgba(0,0,0,0.02);
        margin: 8px 0 16px;
    }

    /* ===== BUTTONS ===== */
    .btn-cancel {
        padding: 10px 32px;
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 10px;
        background: transparent;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        color: #0f172a;
        text-decoration: none;
    }

    .btn-submit {
        padding: 10px 40px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(99, 102, 241, 0.35);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-header-modern {
            padding: 16px 18px;
            flex-direction: column;
            align-items: stretch;
        }

        .card-body-modern {
            padding: 18px;
        }

        .btn-back {
            justify-content: center;
        }

        .btn-cancel,
        .btn-submit {
            width: 100%;
            justify-content: center;
        }

        .d-flex.gap-3 {
            flex-direction: column;
        }

        .file-upload-zone {
            padding: 24px 16px;
            min-height: 120px;
        }

        .file-upload-icon {
            font-size: 32px;
        }

        .file-info-card {
            flex-wrap: wrap;
        }

        .file-info-card .file-name {
            width: 100%;
            margin-bottom: 4px;
        }
    }
</style>

<script>
    function previewFile(input) {
        const file = input.files[0];
        if (!file) return;

        const validExtensions = ['.doc', '.docx', '.pdf'];
        const fileExt = '.' + file.name.split('.').pop().toLowerCase();

        if (!validExtensions.includes(fileExt)) {
            alert('Format file tidak didukung. Gunakan .doc, .docx, atau .pdf');
            input.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB');
            input.value = '';
            return;
        }

        const fileSize = (file.size / 1024).toFixed(1) + ' KB';
        document.getElementById('previewFileName').textContent = file.name;
        document.getElementById('previewFileSize').textContent = fileSize;
        document.getElementById('filePreviewContainer').style.display = 'block';
        document.querySelector('.file-upload-zone').style.display = 'none';
    }

    function removeFile() {
        document.getElementById('fileInput').value = '';
        document.getElementById('filePreviewContainer').style.display = 'none';
        document.querySelector('.file-upload-zone').style.display = 'flex';
    }

    // Drag and drop
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.querySelector('.file-upload-zone');
        if (dropZone) {
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    document.getElementById('fileInput').files = files;
                    previewFile(document.getElementById('fileInput'));
                }
            });
        }
    });
</script>
@endsection