@extends('layouts.app')

@section('title', 'Tambah Ekstrakurikuler')
@section('subtitle', 'Buat ekstrakurikuler baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Card Utama -->
        <div class="card-modern">
            <!-- Header -->
            <div class="card-header-modern">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Tambah Ekstrakurikuler</h5>
                        <p class="text-muted small mb-0">Isi data ekstrakurikuler dengan lengkap</p>
                    </div>
                </div>
                <a href="{{ route('admin.ekskul.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <!-- Body Form -->
            <div class="card-body-modern">
                <form action="{{ route('admin.ekskul.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Nama Ekskul & Pembina -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag text-primary me-2"></i>Nama Ekskul
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama_ekskul') is-invalid @enderror" 
                                       id="nama_ekskul" 
                                       name="nama_ekskul" 
                                       value="{{ old('nama_ekskul') }}" 
                                       placeholder="Contoh: Paskibra, Pramuka, Basket" 
                                       required>
                                <small class="form-text">Masukkan nama ekstrakurikuler</small>
                                @error('nama_ekskul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user-tie text-primary me-2"></i>Pembina
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('pembina') is-invalid @enderror" 
                                       id="pembina" 
                                       name="pembina" 
                                       value="{{ old('pembina') }}" 
                                       placeholder="Contoh: Bpk. Andi Susanto, S.Pd" 
                                       required>
                                <small class="form-text">Masukkan nama pembina ekskul</small>
                                @error('pembina')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left text-primary me-2"></i>Deskripsi
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" 
                                          name="deskripsi" 
                                          rows="4" 
                                          placeholder="Tuliskan deskripsi lengkap tentang ekstrakurikuler ini..." 
                                          required>{{ old('deskripsi') }}</textarea>
                                <small class="form-text">Deskripsi singkat tentang ekstrakurikuler</small>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Hari, Jam, Tempat -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-day text-primary me-2"></i>Hari Latihan
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('hari_latihan') is-invalid @enderror" 
                                        id="hari_latihan" 
                                        name="hari_latihan" 
                                        required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin" {{ old('hari_latihan') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                    <option value="Selasa" {{ old('hari_latihan') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                    <option value="Rabu" {{ old('hari_latihan') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Kamis" {{ old('hari_latihan') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                    <option value="Jumat" {{ old('hari_latihan') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                    <option value="Sabtu" {{ old('hari_latihan') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                    <option value="Minggu" {{ old('hari_latihan') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                </select>
                                <small class="form-text">Pilih hari latihan</small>
                                @error('hari_latihan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-clock text-primary me-2"></i>Jam Mulai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time" 
                                       class="form-control @error('jam_mulai') is-invalid @enderror" 
                                       id="jam_mulai" 
                                       name="jam_mulai" 
                                       value="{{ old('jam_mulai') }}" 
                                       required>
                                <small class="form-text">Waktu mulai latihan</small>
                                @error('jam_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-clock text-primary me-2"></i>Jam Selesai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time" 
                                       class="form-control @error('jam_selesai') is-invalid @enderror" 
                                       id="jam_selesai" 
                                       name="jam_selesai" 
                                       value="{{ old('jam_selesai') }}" 
                                       required>
                                <small class="form-text">Waktu selesai latihan</small>
                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tempat -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>Tempat Latihan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('tempat_latihan') is-invalid @enderror" 
                                       id="tempat_latihan" 
                                       name="tempat_latihan" 
                                       value="{{ old('tempat_latihan') }}" 
                                       placeholder="Contoh: Lapangan Upacara, GOR, Ruang Musik" 
                                       required>
                                <small class="form-text">Lokasi tempat latihan</small>
                                @error('tempat_latihan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Logo -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-image text-primary me-2"></i>Logo Ekskul
                                </label>
                                <div class="upload-zone" onclick="document.getElementById('logo').click()">
                                    <div id="uploadPreview">
                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                        <p class="upload-text">
                                            <strong>Klik untuk upload</strong> atau drag and drop
                                        </p>
                                        <small class="upload-hint">Format: jpeg, png, jpg, webp | Maks: 2MB</small>
                                    </div>
                                    <div id="uploadPreviewImage" style="display: none;">
                                        <img id="logoPreview" src="#" alt="Preview" class="upload-preview-img">
                                        <br>
                                        <small class="upload-hint">Klik untuk mengganti</small>
                                    </div>
                                </div>
                                <input type="file" 
                                       class="d-none @error('logo') is-invalid @enderror" 
                                       id="logo" 
                                       name="logo" 
                                       accept="image/*"
                                       onchange="previewLogo(event)">
                                @error('logo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <hr class="form-divider">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.ekskul.index') }}" class="btn-cancel">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn-submit">
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

    .form-select {
        width: 100%;
        padding: 10px 16px;
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 10px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        background: #f8fafc;
        color: #0f172a;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        cursor: pointer;
    }

    .form-select:focus {
        outline: none;
        border-color: #6366f1;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.04);
    }

    .form-select.is-invalid {
        border-color: #ef4444;
    }

    .form-select.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.04);
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

    /* ===== UPLOAD ZONE ===== */
    .upload-zone {
        border: 2px dashed rgba(0,0,0,0.04);
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        min-height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .upload-zone:hover {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.02);
        transform: scale(1.01);
    }

    .upload-zone .upload-icon {
        font-size: 32px;
        color: #94a3b8;
        margin-bottom: 8px;
        display: block;
    }

    .upload-zone .upload-text {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 2px;
    }

    .upload-zone .upload-text strong {
        color: #6366f1;
    }

    .upload-zone .upload-hint {
        font-size: 11px;
        color: #94a3b8;
    }

    .upload-preview-img {
        max-height: 120px;
        border-radius: 8px;
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
    }
</style>

<script>
    function previewLogo(event) {
        const input = event.target;
        const preview = document.getElementById('logoPreview');
        const previewContainer = document.getElementById('uploadPreview');
        const previewImageContainer = document.getElementById('uploadPreviewImage');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'none';
                previewImageContainer.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Drag and drop
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.querySelector('.upload-zone');

        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#6366f1';
            this.style.background = 'rgba(99, 102, 241, 0.02)';
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = 'rgba(0,0,0,0.04)';
            this.style.background = '#f8fafc';
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = 'rgba(0,0,0,0.04)';
            this.style.background = '#f8fafc';
            const files = e.dataTransfer.files;
            document.getElementById('logo').files = files;
            previewLogo({ target: document.getElementById('logo') });
        });
    });
</script>
@endsection