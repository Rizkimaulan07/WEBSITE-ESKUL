@extends('layouts.app')

@section('title', 'Edit Template Surat')
@section('subtitle', 'Ubah template surat yang sudah ada')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header - Hijau Tua -->
            <div class="card-header border-0 py-4 px-5 hero-gradient">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-file-edit fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Edit Template Surat</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Ubah data template surat</p>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2" style="font-weight: 500;">
                            <i class="fas fa-id-card me-2"></i>ID: #{{ str_pad($templateSurat->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('admin.template-surat.update', $templateSurat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Judul Template -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-heading" style="color: #0ea5e9; margin-right: 8px;"></i>Judul Template
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('judul_template') is-invalid @enderror" 
                                       name="judul_template" value="{{ old('judul_template', $templateSurat->judul_template) }}" 
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
                                    <span class="text-muted" style="font-weight: 400; font-size: 12px;">(Kosongkan jika tidak ingin mengubah)</span>
                                </label>
                                
                                @if($templateSurat->file_template)
                                    <div class="mb-2 p-3 rounded-3" style="background: #f0f9ff; border: 1px solid #7dd3fc;">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fas fa-file-word fa-2x" style="color: #0ea5e9;"></i>
                                            <div class="flex-grow-1">
                                                <span style="font-size: 13px; color: #0f172a; font-weight: 500;">{{ $templateSurat->file_template }}</span>
                                            </div>
                                            <a href="{{ route('admin.template-surat.download', $templateSurat->id) }}" 
                                               class="btn btn-sm" style="background: rgba(16,185,129,0.06); color: #10b981; border-radius: 8px; padding: 4px 14px; text-decoration: none; font-weight: 500; font-size: 12px;">
                                                <i class="fas fa-download me-1"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="upload-area" id="uploadArea" style="border: 2px dashed #7dd3fc; border-radius: 16px; padding: 40px 20px; text-align: center; transition: all 0.3s ease; background: #f0f9ff; cursor: pointer;">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #0ea5e9; opacity: 0.6;"></i>
                                    <p class="mt-3 mb-0 fw-bold" style="color: #0f172a;">Klik untuk ganti file</p>
                                    <small class="text-muted" style="font-size: 12px;">Format: .doc, .docx, .pdf | Maks: 2MB</small>
                                    <input type="file" class="d-none" name="file_template" id="fileInput" accept=".doc,.docx,.pdf">
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
                                          name="keterangan" rows="4" placeholder="Masukkan keterangan template surat...">{{ old('keterangan', $templateSurat->keterangan) }}</textarea>
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
                                <button type="submit" class="btn-primary-gradient" style="padding: 12px 40px; border-radius: 12px; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-save me-2"></i>Perbarui
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
        box-shadow: 0 0 0 4px rgba(21, 128, 61, 0.12);
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
        uploadArea.querySelector('p').textContent = 'Klik untuk ganti file';
    });
</script>
@endsection