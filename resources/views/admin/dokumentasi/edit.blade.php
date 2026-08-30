@extends('layouts.app')

@section('title', 'Edit Dokumentasi')
@section('subtitle', 'Perbarui dokumentasi kegiatan')

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
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <div class="card-header border-0 py-4 px-5 hero-gradient">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-edit fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Edit Dokumentasi</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Perbarui dokumentasi kegiatan ekstrakurikuler</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('admin.dokumentasi.update', $dokumentasi->id) }}" method="POST" enctype="multipart/form-data" id="dokumentasiEditForm">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-heading me-2" style="color: #0ea5e9;"></i>Judul Dokumentasi
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('judul') is-invalid @enderror" 
                                       name="judul" value="{{ old('judul', $dokumentasi->judul) }}" required>
                                @error('judul')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-calendar-day me-2" style="color: #0ea5e9;"></i>Tanggal Kegiatan
                                </label>
                                <input type="date" class="form-control form-control-modern @error('tanggal_kegiatan') is-invalid @enderror" 
                                       name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', optional($dokumentasi->tanggal_kegiatan)->format('Y-m-d')) }}">
                                @error('tanggal_kegiatan')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-align-left me-2" style="color: #0ea5e9;"></i>Deskripsi
                                </label>
                                <textarea class="form-control form-control-modern @error('deskripsi') is-invalid @enderror" 
                                          name="deskripsi" rows="4">{{ old('deskripsi', $dokumentasi->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-images me-2" style="color: #0ea5e9;"></i>Foto Dokumentasi
                                    <span class="text-muted" style="font-weight: 400; font-size: 12px;">(Opsional, upload baru untuk mengganti foto)</span>
                                </label>

                                @if($dokumentasi->foto_path || $dokumentasi->foto_lainnya)
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-2" style="font-weight: 500;">
                                            <i class="fas fa-camera me-1"></i>Foto Saat Ini
                                        </small>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @if($dokumentasi->foto_path)
                                                @php
                                                    $normalizedPath = App\Models\Dokumentasi::normalizeFotoPath($dokumentasi->foto_path);
                                                    $imagePath = asset('storage/' . $normalizedPath);
                                                @endphp
                                                <img src="{{ $imagePath }}" alt="Foto utama" class="rounded-3" style="width: 90px; height: 90px; object-fit: cover; border: 2px solid #40a7ff;">
                                            @endif
                                            @if($dokumentasi->foto_lainnya)
                                                @php $fotoLainnya = json_decode($dokumentasi->foto_lainnya, true); @endphp
                                                @if(is_array($fotoLainnya))
                                                    @foreach($fotoLainnya as $foto)
                                                        <img src="{{ asset('storage/' . App\Models\Dokumentasi::normalizeFotoPath($foto)) }}" 
                                                             alt="Foto lainnya" class="rounded-3" 
                                                             style="width: 90px; height: 90px; object-fit: cover; border: 2px solid #e2e8f0;">
                                                    @endforeach
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="upload-area" id="uploadArea">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #0ea5e9; opacity: 0.6;"></i>
                                    <p class="mt-3 mb-0 fw-bold" style="color: #0f172a;">Klik atau seret foto ke sini</p>
                                    <small class="text-muted" style="font-size: 12px;">Format JPG, PNG, WEBP maksimal 5MB per foto</small>
                                    <input type="file" class="d-none" name="fotos[]" id="fileInput" accept="image/*" multiple>
                                </div>
                                @error('fotos.*')
                                    <div class="invalid-feedback d-block" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="divider-custom">
                                <span style="background: #ffffff; padding: 0 16px; color: #0ea5e9;">
                                    <i class="fas fa-save"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.dokumentasi.show', $dokumentasi->id) }}" class="btn-outline-secondary-custom">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-primary-gradient">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
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
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');

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
            uploadArea.querySelector('p').textContent = '📸 ' + e.dataTransfer.files.length + ' foto dipilih';
        }
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length) {
            uploadArea.querySelector('p').textContent = '📸 ' + this.files.length + ' foto dipilih (akan mengganti foto lama)';
        }
    });
</script>
@endsection