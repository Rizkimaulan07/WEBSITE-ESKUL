@extends('layouts.app')

@section('title', 'Tambah Dokumentasi')
@section('subtitle', 'Tambahkan dokumentasi kegiatan')

@section('content')
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
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert" style="background: #fee2e2; border-left: 4px solid #ef4444;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                            </div>
                            <div>
                                <strong style="color: #991b1b;">Gagal!</strong> 
                                <span style="color: #7f1d1d;">{{ session('error') }}</span>
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

                <form action="{{ route('pelatih.dokumentasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Ekskul ID (hidden jika pelatih sudah punya ekskul) -->
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
                                            name="ekskul_id" required>
                                        <option value="">Pilih Ekstrakurikuler</option>
                                        @foreach($allEkskuls as $ekskul)
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

                        <!-- Tanggal Kegiatan -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-calendar" style="color: #0ea5e9; margin-right: 8px;"></i>Tanggal Kegiatan
                                </label>
                                <input type="date" class="form-control form-control-modern @error('tanggal_kegiatan') is-invalid @enderror" 
                                       name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', date('Y-m-d')) }}">
                                @error('tanggal_kegiatan')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Foto -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-image" style="color: #0ea5e9; margin-right: 8px;"></i>Foto
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="upload-zone" onclick="document.getElementById('foto').click()" 
                                     style="border: 2px dashed #7dd3fc; border-radius: 16px; padding: 32px 20px; text-align: center; background: #f0f9ff; cursor: pointer; transition: all 0.3s ease; min-height: 180px; display: flex; align-items: center; justify-content: center;">
                                    <div id="uploadPreview">
                                        <i class="fas fa-cloud-upload-alt fa-4x" style="color: #0ea5e9; opacity: 0.6; margin-bottom: 12px;"></i>
                                        <p class="text-muted mb-0">
                                            <strong style="color: #0ea5e9;">Klik untuk upload</strong> atau drag and drop
                                        </p>
                                        <small class="text-muted" style="color: #94a3b8; font-size: 12px;">Format: jpeg, png, jpg, webp | Maks: 2MB</small>
                                    </div>
                                    <div id="uploadNewPreview" style="display: none;">
                                        <img id="fotoPreview" src="#" alt="Preview" class="img-fluid rounded-3" style="max-height: 200px;">
                                        <br>
                                        <small class="text-muted" style="color: #94a3b8; font-size: 12px;">Klik untuk mengganti</small>
                                    </div>
                                </div>
                                <input type="file" class="d-none @error('foto') is-invalid @enderror" 
                                       id="foto" name="foto" accept="image/*"
                                       onchange="previewFoto(event)" required>
                                @error('foto')
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
    @media (max-width: 768px) {
        .card-body { padding: 20px !important; }
        .card-header { padding: 16px 20px !important; }
        .btn { width: 100%; }
        .d-flex.gap-3 { flex-direction: column; }
        .upload-zone { min-height: 140px; padding: 20px !important; }
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