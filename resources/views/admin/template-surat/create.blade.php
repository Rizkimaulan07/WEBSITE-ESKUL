@extends('layouts.app')

@section('title', 'Tambah Template Surat')
@section('subtitle', 'Buat template surat baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-modern" style="background: #ffffff; border-radius: 16px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);">
            
            <!-- Header - Biru Cerah -->
            <div class="card-header-modern" style="padding: 20px 28px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon" style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #2563eb, #3b82f6); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; box-shadow: 0 4px 16px rgba(59,130,246,0.25);">
                        <i class="fas fa-file-plus"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0" style="color: #0f172a; font-size: 18px;">Tambah Template Surat</h5>
                        <p class="text-muted small mb-0" style="color: #64748b; font-size: 13px;">Buat template surat baru</p>
                    </div>
                </div>
                <a href="{{ route('admin.template-surat.index') }}" class="btn-back" style="padding: 8px 20px; border: 1px solid #e2e8f0; border-radius: 10px; background: transparent; color: #64748b; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center;">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <!-- Body Form -->
            <div class="card-body-modern" style="padding: 28px 32px;">
                <form action="{{ route('admin.template-surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Judul Template -->
                        <div class="col-12">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 6px; display: block;">
                                    <i class="fas fa-heading" style="color: #3b82f6; margin-right: 8px;"></i>Judul Template
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('judul_template') is-invalid @enderror" 
                                       name="judul_template" 
                                       value="{{ old('judul_template') }}" 
                                       placeholder="Contoh: Surat Izin Kegiatan, Surat Keterangan Aktif" 
                                       required
                                       style="width: 100%; padding: 10px 16px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 13px; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                                <small class="form-text" style="display: block; font-size: 11px; color: #94a3b8; margin-top: 4px;">Masukkan judul template surat</small>
                                @error('judul_template')
                                    <div class="invalid-feedback" style="display: block; font-size: 12px; color: #ef4444; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- File Template -->
                        <div class="col-12">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 6px; display: block;">
                                    <i class="fas fa-file-upload" style="color: #3b82f6; margin-right: 8px;"></i>File Template
                                </label>
                                <div class="file-upload-wrapper" style="position: relative;">
                                    <div class="file-upload-zone" onclick="document.getElementById('fileInput').click()" style="border: 2px dashed #bfdbfe; border-radius: 12px; padding: 32px 24px; text-align: center; background: #eff6ff; cursor: pointer; transition: all 0.3s ease; min-height: 160px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <div class="file-upload-icon" style="font-size: 40px; color: #3b82f6; margin-bottom: 12px; transition: all 0.3s ease;">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <div class="file-upload-text">
                                            <span class="file-upload-main" style="display: block; font-weight: 600; font-size: 14px; color: #0f172a;">Klik untuk upload</span>
                                            <span class="file-upload-sub" style="display: block; font-size: 12px; color: #94a3b8;">atau drag and drop file disini</span>
                                        </div>
                                        <div class="file-upload-info" id="fileInfo" style="display: none; width: 100%; margin-top: 12px; padding: 12px 16px; background: rgba(59,130,246,0.04); border-radius: 8px; border: 1px solid rgba(59,130,246,0.06);">
                                            <div class="file-upload-preview" style="display: flex; align-items: center; gap: 10px;">
                                                <i class="fas fa-file-word file-icon" style="font-size: 24px; color: #3b82f6;"></i>
                                                <span class="file-name" id="fileName" style="font-size: 13px; color: #0f172a; font-weight: 500;">Tidak ada file yang dipilih</span>
                                            </div>
                                            <div class="file-upload-size" id="fileSize" style="font-size: 11px; color: #94a3b8; margin-top: 4px;"></div>
                                        </div>
                                        <div class="file-upload-hint" id="fileHint" style="font-size: 11px; color: #94a3b8; margin-top: 8px;">
                                            <i class="fas fa-info-circle me-1" style="color: #3b82f6;"></i>
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
                                        <div class="file-preview-card" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; background: rgba(59,130,246,0.04); border-radius: 10px; border: 1px solid rgba(59,130,246,0.06); margin-top: 12px; animation: slideDown 0.3s ease;">
                                            <i class="fas fa-file-alt file-preview-icon" style="font-size: 28px; color: #3b82f6;"></i>
                                            <div class="file-preview-info" style="flex: 1;">
                                                <span class="file-preview-name" id="previewFileName" style="display: block; font-size: 13px; font-weight: 500; color: #0f172a;"></span>
                                                <span class="file-preview-size" id="previewFileSize" style="display: block; font-size: 11px; color: #94a3b8;"></span>
                                            </div>
                                            <button type="button" class="file-preview-remove" onclick="removeFile()" style="width: 28px; height: 28px; border-radius: 50%; border: none; background: rgba(239,68,68,0.06); color: #ef4444; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('file_template')
                                        <div class="invalid-feedback d-block" style="display: block; font-size: 12px; color: #ef4444; margin-top: 4px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 6px; display: block;">
                                    <i class="fas fa-align-left" style="color: #3b82f6; margin-right: 8px;"></i>Keterangan
                                </label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                          name="keterangan" 
                                          rows="4" 
                                          placeholder="Masukkan keterangan template surat..." 
                                          style="width: 100%; padding: 10px 16px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 13px; background: #f8fafc; color: #0f172a; transition: all 0.3s ease; resize: vertical; min-height: 100px;">{{ old('keterangan') }}</textarea>
                                <small class="form-text" style="display: block; font-size: 11px; color: #94a3b8; margin-top: 4px;">Deskripsi singkat tentang template surat</small>
                                @error('keterangan')
                                    <div class="invalid-feedback" style="display: block; font-size: 12px; color: #ef4444; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <hr class="form-divider" style="border: none; border-top: 1px solid rgba(0,0,0,0.02); margin: 8px 0 16px;">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.template-surat.index') }}" class="btn-cancel" style="padding: 10px 32px; border: 1px solid #e2e8f0; border-radius: 10px; background: transparent; color: #64748b; font-size: 14px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center;">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn-submit" style="padding: 10px 40px; border: none; border-radius: 10px; background: linear-gradient(135deg, #2563eb, #3b82f6); color: #fff; font-size: 14px; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; cursor: pointer; box-shadow: 0 4px 16px rgba(59,130,246,0.3);">
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

<style>
    .form-control:focus {
        outline: none;
        border-color: #3b82f6 !important;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(59,130,246,0.06);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239,68,68,0.04);
    }

    .file-upload-zone:hover {
        border-color: #3b82f6 !important;
        background: rgba(59,130,246,0.02) !important;
        transform: scale(1.01);
    }

    .file-upload-zone:hover .file-upload-icon {
        color: #3b82f6;
        transform: translateY(-4px);
    }

    .file-preview-remove:hover {
        background: rgba(239,68,68,0.12);
        transform: scale(1.1);
    }

    .btn-cancel:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        color: #0f172a;
        text-decoration: none;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(59,130,246,0.4);
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

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
            min-height: 140px;
        }
        .file-upload-icon {
            font-size: 32px;
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

    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.querySelector('.file-upload-zone');
        if (dropZone) {
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#3b82f6';
                this.style.background = 'rgba(59,130,246,0.04)';
            });

            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = '#bfdbfe';
                this.style.background = '#eff6ff';
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#bfdbfe';
                this.style.background = '#eff6ff';
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    document.getElementById('fileInput').files = files;
                    previewFile(document.getElementById('fileInput'));
                }
            });
        }
    });
</script>
@endsection@extends('layouts.app')

@section('title', 'Tambah Template Surat')
@section('subtitle', 'Buat template surat baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 40%, #7dd3fc 80%, #bae6fd 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-file-plus fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Tambah Template Surat</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Buat template surat baru</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
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

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert" style="background: #fee2e2; border-left: 4px solid #ef4444;">
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                            </div>
                            <div>
                                <strong style="color: #991b1b;">Gagal!</strong> 
                                <span style="color: #7f1d1d;">Silakan periksa data berikut:</span>
                                <ul class="mb-0 mt-1" style="color: #7f1d1d;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.template-surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Judul Template -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-heading" style="color: #0ea5e9; margin-right: 8px;"></i>Judul Template
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('judul_template') is-invalid @enderror" 
                                       name="judul_template" value="{{ old('judul_template') }}" 
                                       placeholder="Contoh: Surat Izin Kegiatan, Surat Keterangan Aktif" required>
                                @error('judul_template')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- File Template -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-file-upload" style="color: #0ea5e9; margin-right: 8px;"></i>File Template
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="upload-area" id="uploadArea" style="border: 2px dashed #7dd3fc; border-radius: 16px; padding: 40px 20px; text-align: center; transition: all 0.3s ease; background: #f0f9ff; cursor: pointer;">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #0ea5e9; opacity: 0.6;"></i>
                                    <p class="mt-3 mb-0 fw-bold" style="color: #0f172a;">Klik atau seret file ke sini</p>
                                    <small class="text-muted" style="font-size: 12px;">Format: .doc, .docx, .pdf | Maks: 2MB</small>
                                    <input type="file" class="d-none" name="file_template" id="fileInput" accept=".doc,.docx,.pdf" required>
                                </div>
                                <div id="filePreview" class="mt-3 d-none">
                                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f0f9ff; border: 1px solid #7dd3fc;">
                                        <i class="fas fa-file-word fa-2x" style="color: #0ea5e9;"></i>
                                        <div>
                                            <p class="mb-0 fw-bold" id="fileName" style="color: #0f172a;">file.docx</p>
                                            <small class="text-muted" id="fileSize">0 KB</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger ms-auto" id="removeFile">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('file_template')
                                    <div class="invalid-feedback d-block" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-align-left" style="color: #0ea5e9; margin-right: 8px;"></i>Keterangan
                                </label>
                                <textarea class="form-control form-control-modern @error('keterangan') is-invalid @enderror" 
                                          name="keterangan" rows="4" placeholder="Masukkan keterangan template surat...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
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
                                <a href="{{ route('admin.template-surat.index') }}" class="btn-outline-secondary-custom" style="padding: 12px 32px; border-radius: 12px; border: 2px solid #e2e8f0; background: transparent; color: #64748b; font-weight: 500; transition: all 0.3s ease; text-decoration: none;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-primary-gradient" style="padding: 12px 40px; border: none; border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(14,165,233,0.3);">
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

<style>
    .form-group-modern { margin-bottom: 0; }
    .form-group-modern label { font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px; }
    .form-control-modern {
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
        background: #fafbfc;
        color: #0f172a;
        font-weight: 500;
        width: 100%;
    }
    .form-control-modern:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
        background: #ffffff;
    }
    .form-control-modern.is-invalid {
        border-color: #dc2626;
        background: #fef2f2;
    }
    .divider-custom { text-align: center; position: relative; margin: 8px 0; }
    .divider-custom::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }
    .divider-custom span { background: #ffffff; padding: 0 16px; position: relative; color: #0ea5e9; font-size: 16px; }
    .btn-outline-secondary-custom:hover { border-color: #0ea5e9; background: rgba(14,165,233,0.04); transform: translateY(-3px); color: #0f172a; }
    .btn-primary-gradient:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(14,165,233,0.4); color: #fff; }
    .upload-area:hover { border-color: #0ea5e9; background: #e0f2fe; }
    .upload-area.dragover { border-color: #0ea5e9; background: #bae6fd; }
</style>

<script>
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFile = document.getElementById('removeFile');

    uploadArea.addEventListener('click', () => fileInput.click());
    uploadArea.addEventListener('dragover', (e) => { e.preventDefault(); uploadArea.classList.add('dragover'); });
    uploadArea.addEventListener('dragleave', () => { uploadArea.classList.remove('dragover'); });
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            updateFilePreview(e.dataTransfer.files[0]);
        }
    });
    fileInput.addEventListener('change', function() { if (this.files.length) updateFilePreview(this.files[0]); });
    function updateFilePreview(file) {
        fileName.textContent = file.name;
        fileSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
        filePreview.classList.remove('d-none');
        uploadArea.querySelector('p').textContent = '📄 ' + file.name;
    }
    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.add('d-none');
        uploadArea.querySelector('p').textContent = 'Klik atau seret file ke sini';
    });
</script>
@endsection