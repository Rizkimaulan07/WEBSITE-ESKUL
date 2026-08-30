@extends('layouts.app')

@section('title', 'Tambah Dokumentasi')
@section('subtitle', 'Tambahkan dokumentasi kegiatan')

@section('content')
@php
    $user = Auth::user();
    $allEkskuls = App\Models\Ekstrakurikuler::all();
    $selectedEkskul = old('ekskul_id') ? $allEkskuls->firstWhere('id', old('ekskul_id')) : null;
@endphp

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 30%, #38bdf8 60%, #7dd3fc 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-camera fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Tambah Dokumentasi</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Tambahkan dokumentasi kegiatan ekstrakurikuler</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('pelatih.dokumentasi.store') }}" method="POST" enctype="multipart/form-data" id="dokumentasiForm">
                    @csrf

                    <div class="row g-4">
                        <!-- Pilih Ekskul Dropdown -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-trophy" style="color: #0ea5e9; margin-right: 8px;"></i>Ekstrakurikuler
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('ekskul_id') is-invalid @enderror" 
                                        name="ekskul_id" id="ekskulSelect" required>
                                    <option value="">-- Pilih Ekstrakurikuler --</option>
                                    @foreach($allEkskuls as $ekskul)
                                        <option value="{{ $ekskul->id }}" 
                                            {{ old('ekskul_id') == $ekskul->id ? 'selected' : '' }}>
                                            {{ $ekskul->nama_ekskul }} ({{ $ekskul->pembina }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('ekskul_id')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                                @if($allEkskuls->count() == 0)
                                    <small class="text-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        Belum ada ekstrakurikuler. Silakan tambahkan melalui admin.
                                    </small>
                                @endif
                            </div>
                        </div>

                        <!-- Judul -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-heading" style="color: #0ea5e9; margin-right: 8px;"></i>Judul Dokumentasi
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('judul') is-invalid @enderror" 
                                       name="judul" value="{{ old('judul') }}" 
                                       placeholder="Contoh: Kegiatan Latihan Paskibra" required>
                                @error('judul')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-align-left" style="color: #0ea5e9; margin-right: 8px;"></i>Deskripsi
                                </label>
                                <textarea class="form-control form-control-modern @error('deskripsi') is-invalid @enderror" 
                                          name="deskripsi" rows="4" 
                                          placeholder="Tuliskan deskripsi kegiatan...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Multiple Foto Upload -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-images" style="color: #0ea5e9; margin-right: 8px;"></i>Foto Dokumentasi
                                    <span class="text-danger">*</span>
                                    <span class="text-muted" style="font-weight: 400; font-size: 12px;">(Bisa upload lebih dari 1 foto)</span>
                                </label>
                                <div class="upload-area-multiple" id="uploadAreaMultiple" 
                                     style="border: 2px dashed #7dd3fc; border-radius: 16px; padding: 30px 20px; text-align: center; transition: all 0.3s ease; background: #f0f9ff; cursor: pointer;">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #0ea5e9; opacity: 0.6;"></i>
                                    <p class="mt-2 mb-0 fw-bold" style="color: #0f172a;">Klik atau seret foto ke sini</p>
                                    <small class="text-muted" style="font-size: 12px;">Format: jpeg, png, jpg, webp | Maks: 5MB per foto</small>
                                    <input type="file" class="d-none" name="fotos[]" id="fileInputMultiple" accept="image/*" multiple required>
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
                                <span style="background: #ffffff; padding: 0 16px; color: #0ea5e9;">
                                    <i class="fas fa-camera"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('pelatih.dokumentasi') }}" class="btn-outline-secondary-custom" style="padding: 12px 32px; border-radius: 12px; border: 2px solid #e2e8f0; background: transparent; color: #64748b; font-weight: 500; transition: all 0.3s ease; text-decoration: none;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-primary-gradient" style="padding: 12px 40px; border: none; border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(14,165,233,0.3);">
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
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
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
    .divider-custom span { background: #ffffff; padding: 0 16px; position: relative; color: #0ea5e9; font-size: 16px; }
    .btn-outline-secondary-custom:hover { border-color: #0ea5e9; background: rgba(14,165,233,0.04); transform: translateY(-3px); color: #0f172a; }
    .btn-primary-gradient:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(14,165,233,0.4); color: #fff; }
    .upload-area-multiple:hover { border-color: #0ea5e9; background: #e0f2fe; }
    .upload-area-multiple.dragover { border-color: #0ea5e9; background: #bae6fd; }

    .foto-preview-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        aspect-ratio: 1;
        background: #f8fafc;
    }
    .foto-preview-item:hover { border-color: #0ea5e9; transform: scale(1.02); }
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
        .upload-area-multiple { padding: 20px !important; }
        .foto-preview-item { aspect-ratio: 4/3; }
    }
</style>

<script>
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
        if (fotoFiles.length === 0) {
            fotoPreviewGrid.innerHTML = `
                <div class="col-12 text-center text-muted py-3" style="color: #64748b;">
                    <small>Belum ada foto yang dipilih</small>
                </div>
            `;
            return;
        }
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
    document.getElementById('dokumentasiForm').addEventListener('submit', function(e) {
        const input = document.getElementById('fileInputMultiple');
        const dataTransfer = new DataTransfer();
        fotoFiles.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;
    });
</script>
@endsection