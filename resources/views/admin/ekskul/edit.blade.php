@extends('layouts.app')

@section('title', 'Edit Ekstrakurikuler')
@section('subtitle', 'Ubah data ekstrakurikuler')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Header Premium - Warna seperti Login -->
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3">
                        <i class="fas fa-edit fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0">Edit Ekstrakurikuler</h4>
                        <p class="text-white-50 mb-0 small">Ubah data ekstrakurikuler</p>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2">
                            <i class="fas fa-trophy me-2"></i>{{ $ekskul->nama_ekskul }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <div>
                                <strong>Berhasil!</strong> {{ session('success') }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                            </div>
                            <div>
                                <strong>Gagal!</strong> Silakan periksa data berikut:
                                <ul class="mb-0 mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.ekskul.update', $ekskul->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Logo Upload -->
                        <div class="col-12">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    @if($ekskul->logo)
                                        <img src="{{ asset('storage/' . $ekskul->logo) }}" 
                                             class="rounded-circle border border-4 border-white shadow-lg" 
                                             style="width: 120px; height: 120px; object-fit: cover;"
                                             id="logoPreview">
                                    @else
                                        <div class="logo-upload-placeholder rounded-circle d-inline-flex align-items-center justify-content-center"
                                             style="width: 120px; height: 120px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); border: 4px solid white; box-shadow: 0 8px 30px rgba(99,102,241,0.2);">
                                            <i class="fas fa-image fa-4x text-white opacity-75"></i>
                                        </div>
                                    @endif
                                    <label for="logo" class="btn-upload-logo">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" class="d-none" id="logo" name="logo" accept="image/*" onchange="previewLogo(event)">
                                </div>
                                <p class="text-muted small mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Klik ikon kamera untuk mengubah logo
                                </p>
                            </div>
                        </div>

                        <!-- Nama Ekskul & Pembina -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-tag text-primary me-2"></i>Nama Ekskul
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('nama_ekskul') is-invalid @enderror" 
                                       name="nama_ekskul" value="{{ old('nama_ekskul', $ekskul->nama_ekskul) }}" 
                                       placeholder="Contoh: Paskibra, Pramuka" required>
                                @error('nama_ekskul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-user-tie text-primary me-2"></i>Pembina
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('pembina') is-invalid @enderror" 
                                       name="pembina" value="{{ old('pembina', $ekskul->pembina) }}" 
                                       placeholder="Contoh: Bpk. Andi Susanto, S.Pd" required>
                                @error('pembina')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-align-left text-primary me-2"></i>Deskripsi
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control form-control-modern @error('deskripsi') is-invalid @enderror" 
                                          name="deskripsi" rows="4" 
                                          placeholder="Tuliskan deskripsi lengkap tentang ekstrakurikuler ini..." 
                                          required>{{ old('deskripsi', $ekskul->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Hari, Jam, Tempat -->
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-calendar-day text-primary me-2"></i>Hari Latihan
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('hari_latihan') is-invalid @enderror" 
                                        name="hari_latihan" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                    <option value="Selasa" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                    <option value="Rabu" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Kamis" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                    <option value="Jumat" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                    <option value="Sabtu" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                    <option value="Minggu" {{ old('hari_latihan', $ekskul->hari_latihan) == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                </select>
                                @error('hari_latihan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>Jam Mulai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time" class="form-control form-control-modern @error('jam_mulai') is-invalid @enderror" 
                                       name="jam_mulai" value="{{ old('jam_mulai', $ekskul->jam_mulai) }}" required>
                                @error('jam_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>Jam Selesai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time" class="form-control form-control-modern @error('jam_selesai') is-invalid @enderror" 
                                       name="jam_selesai" value="{{ old('jam_selesai', $ekskul->jam_selesai) }}" required>
                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tempat & Status -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>Tempat Latihan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('tempat_latihan') is-invalid @enderror" 
                                       name="tempat_latihan" value="{{ old('tempat_latihan', $ekskul->tempat_latihan) }}" 
                                       placeholder="Contoh: Lapangan Upacara, GOR" required>
                                @error('tempat_latihan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-toggle-on text-primary me-2"></i>Status
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('status') is-invalid @enderror" 
                                        name="status" required>
                                    <option value="aktif" {{ old('status', $ekskul->status) == 'aktif' ? 'selected' : '' }}>
                                        🟢 Aktif
                                    </option>
                                    <option value="nonaktif" {{ old('status', $ekskul->status) == 'nonaktif' ? 'selected' : '' }}>
                                        🔴 Nonaktif
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <div class="divider-custom">
                                <span><i class="fas fa-edit text-primary"></i></span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.ekskul.index') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 btn-gradient">
                                    <i class="fas fa-save me-2"></i>Update Ekskul
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
    /* ===== FORM GROUP MODERN ===== */
    .form-group-modern {
        margin-bottom: 0;
    }

    .form-group-modern label {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .form-control-modern, .form-select-modern {
        padding: 12px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
        background: #fafbfc;
        color: #0f172a;
    }

    .form-control-modern:focus, .form-select-modern:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
        background: #ffffff;
    }

    .form-control-modern.is-invalid, .form-select-modern.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .form-control-modern.is-invalid:focus, .form-select-modern.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.08);
    }

    textarea.form-control-modern {
        resize: vertical;
        min-height: 100px;
    }

    /* ===== LOGO UPLOAD ===== */
    .btn-upload-logo {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);
    }

    .btn-upload-logo:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 24px rgba(99, 102, 241, 0.5);
    }

    /* ===== DIVIDER ===== */
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
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
    }

    .divider-custom span {
        background: #ffffff;
        padding: 0 16px;
        position: relative;
        color: #6366f1;
        font-size: 16px;
    }

    /* ===== BUTTON GRADIENT ===== */
    .btn-gradient {
        background: linear-gradient(135deg, #0f172a 0%, #312e81 50%, #4f46e5 100%) !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(79, 70, 229, 0.35) !important;
    }

    .btn-outline-secondary {
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        background: #f8fafc;
        border-color: #94a3b8;
    }

    /* ===== ALERT ===== */
    .alert {
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: none;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: none;
    }

    .text-primary {
        color: #4f46e5 !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-body {
            padding: 20px !important;
        }
        .card-header {
            padding: 16px 20px !important;
        }
        .btn {
            width: 100%;
        }
        .d-flex.gap-3 {
            flex-direction: column;
        }
        .d-flex.gap-3.justify-content-end {
            flex-direction: column-reverse;
        }
        .btn-upload-logo {
            width: 32px;
            height: 32px;
            font-size: 12px;
        }
    }

    /* ===== ANIMATION ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.6s ease;
    }
</style>

<script>
    function previewLogo(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('logoPreview');
            if (preview) {
                preview.src = reader.result;
            } else {
                const container = input.closest('.position-relative');
                const img = document.createElement('img');
                img.id = 'logoPreview';
                img.className = 'rounded-circle border border-4 border-white shadow-lg';
                img.style.cssText = 'width: 120px; height: 120px; object-fit: cover;';
                img.src = reader.result;
                
                const placeholder = container.querySelector('.logo-upload-placeholder');
                if (placeholder) placeholder.remove();
                
                const existingImg = container.querySelector('#logoPreview');
                if (existingImg) existingImg.remove();
                
                container.insertBefore(img, container.querySelector('.btn-upload-logo'));
            }
        };
        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection