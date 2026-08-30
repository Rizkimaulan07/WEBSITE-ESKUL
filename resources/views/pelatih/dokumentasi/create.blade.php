@extends('layouts.app')

@section('title', 'Tambah Dokumentasi')
@section('subtitle', 'Tambahkan dokumentasi kegiatan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5 hero-gradient">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-camera fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Tambah Dokumentasi</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Tambahkan dokumentasi kegiatan ekstrakurikuler</p>
                    </div>
                    @if(Auth::user()->ekskul_id)
                    <div class="ms-auto">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2" style="font-weight: 500;">
                            <i class="fas fa-trophy me-2"></i>{{ Auth::user()->ekskul->nama_ekskul ?? 'Eskul' }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('pelatih.dokumentasi.store') }}" method="POST" enctype="multipart/form-data" id="dokumentasiForm">
                    @csrf

                    <div class="row g-4">
                        <!-- Ekskul ID -->
                        @if(Auth::user()->ekskul_id)
                            <input type="hidden" name="ekskul_id" value="{{ Auth::user()->ekskul_id }}">
                        @else
                            <div class="col-12">
                                <div class="form-group-modern">
                                    <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                        <i class="fas fa-trophy" style="color: #0ea5e9; margin-right: 8px;"></i>Ekstrakurikuler
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control form-control-modern @error('ekskul_id') is-invalid @enderror" 
                                            name="ekskul_id" id="ekskulSelect" required>
                                        <option value="">Pilih Ekstrakurikuler</option>
                                        @foreach($allEkskuls ?? [] as $ekskul)
                                            <option value="{{ $ekskul->id }}" {{ old('ekskul_id') == $ekskul->id ? 'selected' : '' }}>
                                                {{ $ekskul->nama_ekskul }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ekskul_id')
                                        <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <!-- Judul -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-heading" style="color: #0ea5e9; margin-right: 8px;"></i>Judul Dokumentasi
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('judul') is-invalid @enderror" 
                                       name="judul" id="judulInput" value="{{ old('judul') }}" 
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
                                          name="deskripsi" id="deskripsiInput" rows="4" 
                                          placeholder="Tuliskan deskripsi kegiatan...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Kegiatan -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-calendar" style="color: #0ea5e9; margin-right: 8px;"></i>Tanggal Kegiatan
                                </label>
                                <input type="date" class="form-control form-control-modern @error('tanggal_kegiatan') is-invalid @enderror" 
                                       name="tanggal_kegiatan" id="tanggalInput" value="{{ old('tanggal_kegiatan', date('Y-m-d')) }}">
                                @error('tanggal_kegiatan')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Foto (Multiple) -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-images" style="color: #0ea5e9; margin-right: 8px;"></i>Foto Dokumentasi
                                    <span class="text-danger">*</span>
                                    <span class="text-muted" style="font-weight: 400; font-size: 12px;">(Bisa upload lebih dari 1 foto)</span>
                                </label>
                                
                                <!-- Upload Area -->
                                <div class="upload-zone" id="uploadArea" 
                                     style="border: 2px dashed #7dd3fc; border-radius: 16px; padding: 32px 20px; text-align: center; background: #f0f9ff; cursor: pointer; transition: all 0.3s ease; min-height: 180px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                    <i class="fas fa-cloud-upload-alt fa-4x" style="color: #0ea5e9; opacity: 0.6; margin-bottom: 12px;"></i>
                                    <p class="text-muted mb-0" id="uploadText">
                                        <strong style="color: #0ea5e9;">Klik untuk upload</strong> atau drag and drop
                                    </p>
                                    <small class="text-muted" style="color: #64748b; font-size: 12px;">Format: jpeg, png, jpg, webp | Maks: 5MB per foto</small>
                                </div>
                                
                                <!-- Preview Grid -->
                                <div id="fotoPreviewContainer" class="mt-3">
                                    <div class="row g-2" id="fotoPreviewGrid">
                                        <div class="col-12 text-center text-muted py-3" style="color: #94a3b8;">
                                            <small>Belum ada foto yang dipilih</small>
                                        </div>
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
                                    <i class="fas fa-camera"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end flex-wrap">
                                <a href="{{ route('pelatih.dokumentasi') }}" class="btn-secondary-custom" style="padding: 12px 32px;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-primary-gradient" id="submitBtn" style="padding: 12px 40px;">
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
    .upload-zone:hover { border-color: #0ea5e9 !important; background: rgba(14,165,233,0.03) !important; transform: scale(1.01); }
    .upload-zone.dragover { border-color: #0ea5e9; background: #bae6fd; }
    
    .foto-preview-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        aspect-ratio: 1;
        background: #f8fafc;
    }
    .foto-preview-item:hover {
        border-color: #0ea5e9;
        transform: scale(1.02);
    }
    .foto-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
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
    .foto-preview-item .btn-remove-foto:hover {
        background: #dc2626;
        transform: scale(1.1);
    }
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
        .upload-zone { min-height: 140px; padding: 20px !important; }
        .foto-preview-item { aspect-ratio: 4/3; }
    }
</style>

<script>
    // ==========================================
    // 1. ELEMEN & VARIABEL
    // ==========================================
    const uploadArea = document.getElementById('uploadArea');
    const fotoPreviewGrid = document.getElementById('fotoPreviewGrid');
    const form = document.getElementById('dokumentasiForm');
    const submitBtn = document.getElementById('submitBtn');
    let selectedFiles = [];

    // ==========================================
    // 2. EVENT LISTENER UPLOAD AREA
    // ==========================================
    uploadArea.addEventListener('click', () => {
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'fotos[]';
        input.multiple = true;
        input.accept = 'image/*';
        input.onchange = function(e) {
            if (this.files.length) {
                handleFiles(this.files);
            }
            this.remove();
        };
        input.click();
    });

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
            handleFiles(e.dataTransfer.files);
        }
    });

    // ==========================================
    // 3. FUNGSI KELOLA FILE
    // ==========================================
    function handleFiles(files) {
        let validFiles = [];
        let errorMessages = [];

        for (let file of files) {
            if (!file.type.startsWith('image/')) {
                errorMessages.push(`"${file.name}" bukan gambar.`);
                continue;
            }
            if (file.size > 5 * 1024 * 1024) {
                errorMessages.push(`"${file.name}" melebihi 5MB.`);
                continue;
            }
            validFiles.push(file);
        }

        if (errorMessages.length > 0) {
            alert('⚠️ Perbaiki kesalahan berikut:\n- ' + errorMessages.join('\n- '));
        }

        if (validFiles.length > 0) {
            selectedFiles = [...selectedFiles, ...validFiles];
            renderPreviews();
            updateUploadStatus();
        }
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        renderPreviews();
        updateUploadStatus();
    }

    // ==========================================
    // 4. RENDER PREVIEW
    // ==========================================
    function renderPreviews() {
        fotoPreviewGrid.innerHTML = '';
        if (selectedFiles.length === 0) {
            fotoPreviewGrid.innerHTML = `
                <div class="col-12 text-center text-muted py-3" style="color: #94a3b8;">
                    <small>Belum ada foto yang dipilih</small>
                </div>
            `;
            return;
        }

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-4 col-md-3 col-lg-2';
                col.innerHTML = `
                    <div class="foto-preview-item">
                        <img src="${e.target.result}" alt="Foto ${index + 1}">
                        <button type="button" class="btn-remove-foto" onclick="removeFile(${index})">
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

    // ==========================================
    // 5. UPDATE STATUS UPLOAD AREA
    // ==========================================
    function updateUploadStatus() {
        const text = document.getElementById('uploadText');
        const small = uploadArea.querySelector('small');
        if (selectedFiles.length > 0) {
            text.innerHTML = `<strong style="color: #0ea5e9;">📸 ${selectedFiles.length} foto dipilih</strong>`;
            small.textContent = 'Klik untuk tambah foto lagi';
        } else {
            text.innerHTML = `<strong style="color: #0ea5e9;">Klik untuk upload</strong> atau drag and drop`;
            small.textContent = 'Format: jpeg, png, jpg, webp | Maks: 5MB per foto';
        }
    }

    // ==========================================
    // 6. SUBMIT FORM
    // ==========================================
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validasi: minimal 1 foto
        if (selectedFiles.length === 0) {
            alert('⚠️ Silakan pilih minimal 1 foto dokumentasi!');
            return;
        }

        // Validasi: ekskul (jika tidak hidden)
        const ekskulSelect = document.getElementById('ekskulSelect');
        if (ekskulSelect && !ekskulSelect.value) {
            alert('⚠️ Silakan pilih Ekstrakurikuler terlebih dahulu!');
            ekskulSelect.focus();
            return;
        }

        // Validasi: judul
        const judulInput = document.getElementById('judulInput');
        if (!judulInput.value.trim()) {
            alert('⚠️ Silakan isi Judul Dokumentasi!');
            judulInput.focus();
            return;
        }

        // Buat FormData
        const formData = new FormData(form);
        formData.delete('fotos[]');
        selectedFiles.forEach(file => {
            formData.append('fotos[]', file, file.name);
        });

        // Loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status"></span> Menyimpan...`;
        submitBtn.style.opacity = '0.7';

        // Kirim data
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Redirect ke halaman dokumentasi
                window.location.href = data.redirect || '{{ route("pelatih.dokumentasi") }}';
            } else {
                let errors = '';
                if (data.errors) {
                    Object.values(data.errors).forEach(err => {
                        errors += '- ' + (Array.isArray(err) ? err.join(', ') : err) + '\n';
                    });
                }
                alert('⚠️ Gagal menyimpan:\n' + (errors || data.message || 'Terjadi kesalahan.'));
                resetButton();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            let errorMsg = '⚠️ Terjadi kesalahan.\n';
            if (error.errors) {
                Object.values(error.errors).forEach(err => {
                    errorMsg += '- ' + (Array.isArray(err) ? err.join(', ') : err) + '\n';
                });
            } else if (error.message) {
                errorMsg += error.message;
            } else {
                errorMsg += 'Silakan coba lagi.';
            }
            alert(errorMsg);
            resetButton();
        });
    });

    function resetButton() {
        submitBtn.disabled = false;
        submitBtn.innerHTML = `<i class="fas fa-save me-2"></i>Simpan Dokumentasi`;
        submitBtn.style.opacity = '1';
    }

    // Biarkan fungsi removeFile global
    window.removeFile = removeFile;
</script>
@endsections