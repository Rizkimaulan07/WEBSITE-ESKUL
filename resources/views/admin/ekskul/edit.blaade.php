@extends('layouts.app')

@section('title', 'Edit Ekstrakurikuler')
@section('subtitle', 'Ubah data ekstrakurikuler')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Header Card dengan Gradient -->
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 40%, #b45309 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3">
                        <i class="fas fa-edit fa-2x text-white"></i>
                    </div>
                    <div>
                        <h5 class="text-white fw-bold mb-0">Edit Ekstrakurikuler</h5>
                        <p class="text-white-50 small mb-0">Ubah data ekstrakurikuler</p>
                    </div>
                </div>
            </div>

            <!-- Body Form -->
            <div class="card-body p-5">
                <form action="{{ route('ekskul.update', $ekskul->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Nama Ekskul & Pembina -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-tag text-primary me-2"></i>Nama Ekskul
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('nama_ekskul') is-invalid @enderror" 
                                       id="nama_ekskul" 
                                       name="nama_ekskul" 
                                       value="{{ old('nama_ekskul', $ekskul->nama_ekskul) }}" 
                                       placeholder="Contoh: Paskibra, Pramuka, Basket" 
                                       required>
                                <small class="text-muted">Masukkan nama ekstrakurikuler</small>
                                @error('nama_ekskul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-user-tie text-primary me-2"></i>Pembina
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('pembina') is-invalid @enderror" 
                                       id="pembina" 
                                       name="pembina" 
                                       value="{{ old('pembina', $ekskul->pembina) }}" 
                                       placeholder="Contoh: Bpk. Andi Susanto, S.Pd" 
                                       required>
                                <small class="text-muted">Masukkan nama pembina ekskul</small>
                                @error('pembina')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-align-left text-primary me-2"></i>Deskripsi
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" 
                                          name="deskripsi" 
                                          rows="3" 
                                          placeholder="Tuliskan deskripsi lengkap tentang ekstrakurikuler ini..." 
                                          required>{{ old('deskripsi', $ekskul->deskripsi) }}</textarea>
                                <small class="text-muted">Deskripsi singkat tentang ekstrakurikuler</small>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Hari, Jam, Tempat -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-calendar-day text-primary me-2"></i>Hari Latihan
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg @error('hari_latihan') is-invalid @enderror" 
                                        id="hari_latihan" 
                                        name="hari_latihan" 
                                        required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                    <option value="Selasa" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                    <option value="Rabu" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Kamis" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                    <option value="Jumat" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                    <option value="Sabtu" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                    <option value="Minggu" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                </select>
                                <small class="text-muted">Pilih hari latihan</small>
                                @error('hari_latihan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>Jam Mulai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time" 
                                       class="form-control form-control-lg @error('jam_mulai') is-invalid @enderror" 
                                       id="jam_mulai" 
                                       name="jam_mulai" 
                                       value="{{ old('jam_mulai', $ekskul->jam_mulai) }}" 
                                       required>
                                <small class="text-muted">Waktu mulai latihan</small>
                                @error('jam_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>Jam Selesai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time" 
                                       class="form-control form-control-lg @error('jam_selesai') is-invalid @enderror" 
                                       id="jam_selesai" 
                                       name="jam_selesai" 
                                       value="{{ old('jam_selesai', $ekskul->jam_selesai) }}" 
                                       required>
                                <small class="text-muted">Waktu selesai latihan</small>
                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tempat -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>Tempat Latihan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('tempat_latihan') is-invalid @enderror" 
                                       id="tempat_latihan" 
                                       name="tempat_latihan" 
                                       value="{{ old('tempat_latihan', $ekskul->tempat_latihan) }}" 
                                       placeholder="Contoh: Lapangan Upacara, GOR, Ruang Musik" 
                                       required>
                                <small class="text-muted">Lokasi tempat latihan</small>
                                @error('tempat_latihan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Logo dengan Drag & Drop -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-image text-primary me-2"></i>Logo Ekskul
                                </label>
                                <div class="upload-zone border-2 border-dashed rounded-4 p-4 text-center" 
                                     style="border-color: #e5e7eb; background: #fafbfc; cursor: pointer; transition: all 0.3s ease;"
                                     onclick="document.getElementById('logo').click()"
                                     ondragover="event.preventDefault(); this.style.borderColor='#4f46e5'; this.style.background='rgba(79,70,229,0.05)';"
                                     ondrop="event.preventDefault(); this.style.borderColor='#e5e7eb'; this.style.background='#fafbfc';">
                                    @if($ekskul->logo)
                                        <div id="uploadPreviewImage">
                                            <img src="{{ asset('storage/' . $ekskul->logo) }}" 
                                                 alt="{{ $ekskul->nama_ekskul }}" 
                                                 class="img-fluid rounded-3" 
                                                 style="max-height: 150px;">
                                            <br>
                                            <small class="text-muted">Klik untuk mengganti</small>
                                        </div>
                                        <div id="uploadPreview" style="display: none;">
                                    @else
                                        <div id="uploadPreview">
                                    @endif
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">
                                            <strong class="text-primary">Klik untuk upload</strong> atau drag and drop
                                        </p>
                                        <small class="text-muted">Format: jpeg, png, jpg, webp | Maks: 2MB</small>
                                    </div>
                                    <div id="uploadNewPreview" style="display: none;">
                                        <img id="logoPreview" src="#" alt="Preview" class="img-fluid rounded-3" style="max-height: 150px;">
                                        <br>
                                        <small class="text-muted">Preview baru</small>
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

                        <!-- Status -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-toggle-on text-primary me-2"></i>Status
                                </label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_aktif" value="aktif"
                                               {{ old('status', $ekskul->status) == 'aktif' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_aktif">
                                            <span class="badge-custom active">🟢 Aktif</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_nonaktif" value="nonaktif"
                                               {{ old('status', $ekskul->status) == 'nonaktif' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_nonaktif">
                                            <span class="badge-custom inactive">🔴 Nonaktif</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12 mt-4">
                            <hr>
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('ekskul.index') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2" 
                                        style="background: linear-gradient(135deg, #f59e0b, #d97706); border: none;">
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

<style>
    .upload-zone {
        transition: all 0.3s ease;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .upload-zone:hover {
        border-color: #4f46e5 !important;
        background: rgba(79, 70, 229, 0.03) !important;
        transform: scale(1.01);
    }

    .form-control-lg, .form-select-lg {
        padding: 12px 20px;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
        border-radius: 12px;
    }

    .form-control-lg:focus, .form-select-lg:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
    }

    .form-control-lg.is-invalid, .form-select-lg.is-invalid {
        border-color: #ef4444;
    }

    .form-control-lg.is-invalid:focus, .form-select-lg.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.08);
    }

    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(245, 158, 11, 0.3);
    }

    .btn-outline-secondary {
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        background: #f8fafc;
    }

    textarea.form-control {
        padding: 12px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s ease;
        resize: vertical;
    }

    textarea.form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
    }

    textarea.form-control.is-invalid {
        border-color: #ef4444;
    }

    .badge-custom.active { background: rgba(16, 185, 129, 0.08); color: #10b981; }
    .badge-custom.inactive { background: rgba(239, 68, 68, 0.08); color: #ef4444; }

    .form-group label {
        font-size: 14px;
        color: #1e293b;
    }

    .form-group small {
        font-size: 11px;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 20px !important;
        }
        
        .btn {
            width: 100%;
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
    const previewNewContainer = document.getElementById('uploadNewPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            if (previewContainer) previewContainer.style.display = 'none';
            if (previewImageContainer) previewImageContainer.style.display = 'none';
            previewNewContainer.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection