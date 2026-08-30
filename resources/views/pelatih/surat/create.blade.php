@extends('layouts.app')

@section('title', 'Buat Surat')
@section('subtitle', 'Buat surat untuk anggota')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header - Hijau Tua -->
            <div class="card-header border-0 py-4 px-5 hero-gradient-green">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-file-alt fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Buat Surat</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Buat surat untuk anggota ekstrakurikuler</p>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2" style="font-weight: 500;">
                            <i class="fas fa-trophy me-2"></i>{{ $ekskul->nama_ekskul ?? 'Ekskul' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('pelatih.surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Judul Surat -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-heading" style="color: #15803d; margin-right: 8px;"></i>Judul Surat
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('judul') is-invalid @enderror" 
                                       name="judul" value="{{ old('judul') }}" 
                                       placeholder="Contoh: Surat Izin Kegiatan, Surat Keterangan Aktif" required>
                                @error('judul')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pilih Anggota -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-user" style="color: #15803d; margin-right: 8px;"></i>Pilih Anggota
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('anggota_id') is-invalid @enderror" 
                                        name="anggota_id" required>
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach($anggotas as $anggota)
                                        <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                            {{ $anggota->name }} ({{ $anggota->kelas ?? 'Kelas' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('anggota_id')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-align-left" style="color: #15803d; margin-right: 8px;"></i>Deskripsi
                                </label>
                                <textarea class="form-control form-control-modern @error('deskripsi') is-invalid @enderror" 
                                          name="deskripsi" rows="4" 
                                          placeholder="Masukkan deskripsi surat...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload File Surat -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-file-upload" style="color: #15803d; margin-right: 8px;"></i>File Surat
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="upload-area" id="uploadArea" style="border: 2px dashed #86efac; border-radius: 16px; padding: 40px 20px; text-align: center; transition: all 0.3s ease; background: #f0fdf4; cursor: pointer;">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #15803d; opacity: 0.6;"></i>
                                    <p class="mt-3 mb-0 fw-bold" style="color: #0f172a;">Klik atau seret file ke sini</p>
                                    <small class="text-muted" style="font-size: 12px;">Format: .doc, .docx, .pdf | Maks: 2MB</small>
                                    <input type="file" class="d-none" name="file_surat" id="fileInput" accept=".doc,.docx,.pdf" required>
                                </div>
                                <div id="filePreview" class="mt-3 d-none">
                                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f0fdf4; border: 1px solid #86efac;">
                                        <i class="fas fa-file-pdf fa-2x" style="color: #15803d;"></i>
                                        <div>
                                            <p class="mb-0 fw-bold" id="fileName" style="color: #0f172a;">file.pdf</p>
                                            <small class="text-muted" id="fileSize">0 KB</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger ms-auto" id="removeFile">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('file_surat')
                                    <div class="invalid-feedback d-block" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ===== MULTIPLE FOTO ===== -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-images" style="color: #15803d; margin-right: 8px;"></i>Foto Pendukung
                                    <span class="text-muted" style="font-weight: 400; font-size: 12px;">(Bisa upload lebih dari 1 foto)</span>
                                </label>
                                <div class="upload-area-multiple" id="uploadAreaMultiple" 
                                     style="border: 2px dashed #86efac; border-radius: 16px; padding: 30px 20px; text-align: center; transition: all 0.3s ease; background: #f0fdf4; cursor: pointer;">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #15803d; opacity: 0.6;"></i>
                                    <p class="mt-2 mb-0 fw-bold" style="color: #0f172a;">Klik atau seret foto ke sini</p>
                                    <small class="text-muted" style="font-size: 12px;">Format: jpeg, png, jpg, webp | Maks: 5MB per foto</small>
                                    <input type="file" class="d-none" name="fotos[]" id="fileInputMultiple" accept="image/*" multiple>
                                </div>
                                
                                <!-- Preview Multiple Foto -->
                                <div id="fotoPreviewContainer" class="mt-3">
                                    <div class="row g-2" id="fotoPreviewGrid"></div>
                                </div>
                                @error('fotos.*')
                                    <div class="invalid-feedback d-block" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <div class="divider-custom">
                                <span style="background: #ffffff; padding: 0 16px; color: #15803d;">
                                    <i class="fas fa-paper-plane"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('pelatih.dashboard') }}" class="btn-secondary-custom" style="padding: 12px 32px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-primary-gradient" style="padding: 12px 40px; border: none; border-radius: 12px; background: linear-gradient(135deg, #15803d, #22c55e); color: #fff; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(21,128,61,0.3);">
                                    <i class="fas fa-save me-2"></i>Kirim Surat
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
    .form-control-modern, .form-select-modern {
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
    .form-control-modern:focus, .form-select-modern:focus {
        border-color: #15803d;
        box-shadow: 0 0 0 4px rgba(21, 128, 61, 0.12);
        background: #ffffff;
    }
    .form-control-modern.is-invalid, .form-select-modern.is-invalid {
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
    .divider-custom span { background: #ffffff; padding: 0 16px; position: relative; color: #15803d; font-size: 16px; }
    .btn-outline-secondary-custom:hover { border-color: #15803d; background: rgba(21,128,61,0.04); transform: translateY(-3px); color: #0f172a; }
    .btn-primary-gradient:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(21,128,61,0.4); color: #fff; }
    
    .upload-area:hover, .upload-area-multiple:hover { border-color: #15803d; background: #dcfce7; }
    .upload-area.dragover, .upload-area-multiple.dragover { border-color: #15803d; background: #bbf7d0; }

    /* Foto Preview Grid */
    .foto-preview-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        aspect-ratio: 1;
        background: #f8fafc;
    }
    .foto-preview-item:hover { border-color: #15803d; transform: scale(1.02); }
    .foto-preview-item img { width: 100%; height: 100%; object-fit: cover; }
    .foto-preview-item .btn-remove-foto {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .foto-preview-item .btn-remove-foto:hover { background: #dc2626; transform: scale(1.1); }
    .foto-preview-item .foto-index {
        position: absolute;
        bottom: 6px;
        left: 6px;
        background: rgba(0,0,0,0.6);
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        backdrop-filter: blur(4px);
    }

    @media (max-width: 768px) {
        .card-body { padding: 20px !important; }
        .card-header { padding: 16px 20px !important; }
        .btn { width: 100%; }
        .d-flex.gap-3 { flex-direction: column; }
        .upload-area, .upload-area-multiple { padding: 20px !important; }
        .foto-preview-item { aspect-ratio: 4/3; }
    }
</style>

<script>
    // ===== SINGLE FILE UPLOAD =====
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

    // ===== MULTIPLE FOTO UPLOAD =====
    const uploadAreaMultiple = document.getElementById('uploadAreaMultiple');
    const fileInputMultiple = document.getElementById('fileInputMultiple');
    const fotoPreviewGrid = document.getElementById('fotoPreviewGrid');
    let fotoFiles = [];

    uploadAreaMultiple.addEventListener('click', () => fileInputMultiple.click());
    uploadAreaMultiple.addEventListener('dragover', (e) => { e.preventDefault(); uploadAreaMultiple.classList.add('dragover'); });
    uploadAreaMultiple.addEventListener('dragleave', () => { uploadAreaMultiple.classList.remove('dragover'); });
    uploadAreaMultiple.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadAreaMultiple.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            addFiles(e.dataTransfer.files);
        }
    });
    fileInputMultiple.addEventListener('change', function() { if (this.files.length) addFiles(this.files); });

    function addFiles(files) {
        for (let file of files) {
            if (!file.type.startsWith('image/')) {
                alert('File ' + file.name + ' bukan gambar!');
                continue;
            }
            if (file.size > 5 * 1024 * 1024) {
                alert('File ' + file.name + ' melebihi 5MB!');
                continue;
            }
            fotoFiles.push(file);
        }
        renderFotoPreviews();
        fileInputMultiple.value = '';
        updateFotoCount();
    }

    function renderFotoPreviews() {
        fotoPreviewGrid.innerHTML = '';
        fotoFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-4 col-md-3 col-lg-2';
                col.innerHTML = `
                    <div class="foto-preview-item">
                        <img src="${e.target.result}" alt="Foto ${index + 1}">
                        <button type="button" class="btn-remove-foto" onclick="removeFoto(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                        <span class="foto-index">#${index + 1}</span>
                    </div>
                `;
                fotoPreviewGrid.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
        if (fotoFiles.length === 0) {
            fotoPreviewGrid.innerHTML = `
                <div class="col-12 text-center text-muted py-3" style="color: #64748b;">
                    <small>Belum ada foto yang dipilih</small>
                </div>
            `;
        }
        updateFotoCount();
    }

    function removeFoto(index) {
        fotoFiles.splice(index, 1);
        renderFotoPreviews();
        updateFotoCount();
    }

    function updateFotoCount() {
        const text = uploadAreaMultiple.querySelector('p');
        if (fotoFiles.length > 0) {
            text.textContent = '📸 ' + fotoFiles.length + ' foto dipilih';
            uploadAreaMultiple.querySelector('small').textContent = 'Klik untuk tambah foto lagi';
        } else {
            text.textContent = 'Klik atau seret foto ke sini';
            uploadAreaMultiple.querySelector('small').textContent = 'Format: jpeg, png, jpg, webp | Maks: 5MB per foto';
        }
    }

    // Update form submit untuk include multiple files
    document.querySelector('form').addEventListener('submit', function(e) {
        // Hapus input file multiple yang lama
        const oldInputs = this.querySelectorAll('input[name="fotos[]"]');
        oldInputs.forEach(input => input.remove());
        
        // Buat input baru untuk setiap file
        const dataTransfer = new DataTransfer();
        fotoFiles.forEach(file => dataTransfer.items.add(file));
        
        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.name = 'fotos[]';
        newInput.multiple = true;
        newInput.files = dataTransfer.files;
        newInput.style.display = 'none';
        this.appendChild(newInput);
    });
</script>
@endsection