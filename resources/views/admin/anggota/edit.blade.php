@extends('layouts.app')

@section('title', 'Edit Anggota')
@section('subtitle', 'Ubah data anggota')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Header Premium - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5 hero-gradient">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-user-edit fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Edit Anggota</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Ubah data anggota ekstrakurikuler</p>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2" style="font-weight: 500;">
                            <i class="fas fa-id-card me-2"></i>ID: #{{ str_pad($anggota->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('admin.anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Profile Image Upload -->
                        <div class="col-12">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    @if($anggota->avatar)
                                        <img src="{{ asset($anggota->avatar) }}" 
                                             class="rounded-circle border-4 border-white shadow-lg" 
                                             style="width: 120px; height: 120px; object-fit: cover;"
                                             id="avatarPreview">
                                    @else
                                        <div class="avatar-upload-placeholder rounded-circle d-inline-flex align-items-center justify-content-center"
                                             style="width: 120px; height: 120px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: 4px solid white; box-shadow: 0 8px 30px rgba(14,165,233,0.2);">
                                            <i class="fas fa-user fa-4x text-white opacity-75"></i>
                                        </div>
                                    @endif
                                    <label for="avatar" class="btn-upload-avatar" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8);">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" class="d-none" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(event)">
                                </div>
                                <p class="mt-2" style="color: #64748b; font-size: 13px;">
                                    <i class="fas fa-info-circle me-1" style="color: #0ea5e9;"></i>
                                    Klik ikon kamera untuk mengubah foto
                                </p>
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-user me-2" style="color: #0ea5e9;"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $anggota->name) }}" placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-id-card me-2" style="color: #0ea5e9;"></i>NIS
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('nis') is-invalid @enderror" 
                                       name="nis" value="{{ old('nis', $anggota->nis) }}" placeholder="Masukkan NIS" required>
                                @error('nis')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kelas & Jurusan -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-graduation-cap me-2" style="color: #0ea5e9;"></i>Kelas
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('kelas') is-invalid @enderror" 
                                        name="kelas" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="10" {{ old('kelas', $anggota->kelas) == '10' ? 'selected' : '' }}>10</option>
                                    <option value="11" {{ old('kelas', $anggota->kelas) == '11' ? 'selected' : '' }}>11</option>
                                    <option value="12" {{ old('kelas', $anggota->kelas) == '12' ? 'selected' : '' }}>12</option>
                                </select>
                                @error('kelas')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-building me-2" style="color: #0ea5e9;"></i>Jurusan
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('jurusan') is-invalid @enderror" 
                                        name="jurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="PPPLG" {{ old('jurusan', $anggota->jurusan) == 'PPPLG' ? 'selected' : '' }}>PPPLG</option>
                                    <option value="TJKT" {{ old('jurusan', $anggota->jurusan) == 'TJKT' ? 'selected' : '' }}>TJKT</option>
                                    <option value="AKL" {{ old('jurusan', $anggota->jurusan) == 'AKL' ? 'selected' : '' }}>AKL</option>
                                    <option value="AXIO" {{ old('jurusan', $anggota->jurusan) == 'AXIO' ? 'selected' : '' }}>AXIO</option>
                                </select>
                                @error('jurusan')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- No HP -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-phone me-2" style="color: #0ea5e9;"></i>No HP
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('no_hp') is-invalid @enderror" 
                                       name="no_hp" value="{{ old('no_hp', $anggota->no_hp) }}" placeholder="Masukkan no HP" required>
                                @error('no_hp')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Login Otomatis -->
                        <div class="col-12">
                            <div class="alert border-0 rounded-4 shadow-sm" style="background: #f0f9ff; border-left: 4px solid #0ea5e9;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-blue-500 bg-opacity-10 rounded-circle p-2" style="background: rgba(14,165,233,0.08);">
                                        <i class="fas fa-info-circle" style="color: #0ea5e9;"></i>
                                    </div>
                                    <div>
                                        <strong style="color: #0369a1;">Informasi login otomatis:</strong>
                                        <div class="mt-1" style="color: #475569; font-size: 13px;">
                                            Email dan password anggota dibuat otomatis dari NIS, jadi admin tidak perlu mengisi manual saat menambah data.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ekskul (boleh lebih dari satu) -->
                        <div class="col-md-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-trophy me-2" style="color: #0ea5e9;"></i>Ekstrakurikuler
                                    <small style="color: #64748b; font-weight: 400;">(boleh pilih lebih dari satu)</small>
                                </label>
                                <div class="ekskul-check-list" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    @foreach($ekskuls ?? [] as $ekskul)
                                        <label class="ekskul-check-option" style="flex: 1 1 calc(50% - 10px); min-width: 200px; display: flex; align-items: center; gap: 10px; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; background: #fafbfc; cursor: pointer; transition: all 0.3s ease;">
                                            <input type="checkbox" name="ekskul_ids[]" value="{{ $ekskul->id }}" class="form-check-input" style="cursor: pointer; margin: 0;"
                                                {{ is_array(old('ekskul_ids')) ? (in_array($ekskul->id, old('ekskul_ids')) ? 'checked' : '') : ($anggota->ekskuls->contains($ekskul->id) ? 'checked' : '') }}>
                                            <span style="font-size: 13px; font-weight: 500; color: #1e293b;">{{ $ekskul->nama_ekskul }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('ekskul_ids')
                                    <div class="invalid-feedback d-block" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <div class="divider-custom">
                                <span style="background: #ffffff; padding: 0 16px; color: #0ea5e9;">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2" style="border-color: #e2e8f0; color: #64748b; font-weight: 500;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-primary-gradient px-5 py-2" style="border-radius: 12px; font-weight: 600; font-size: 14px;">
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
    /* ===== FORM GROUP MODERN ===== */
    .form-group-modern {
        margin-bottom: 0;
    }

    .form-group-modern label {
        font-size: 14px;
        color: #1e293b;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

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

    .form-control-modern.is-invalid:focus, .form-select-modern.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.08);
    }

    /* ===== AVATAR UPLOAD ===== */
    .btn-upload-avatar {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: white;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
    }

    .btn-upload-avatar:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 24px rgba(14, 165, 233, 0.5);
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
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }

    .divider-custom span {
        background: #ffffff;
        padding: 0 16px;
        position: relative;
        color: #0ea5e9;
        font-size: 16px;
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        background: #f8fafc;
        border-color: #64748b;
    }

    .btn-primary-submit {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8) !important;
        border: none !important;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
    }

    .btn-primary-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(14, 165, 233, 0.4) !important;
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
        .btn-upload-avatar {
            width: 32px;
            height: 32px;
            font-size: 12px;
        }
    }
</style>

<script>
    function previewAvatar(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('avatarPreview');
            if (preview) {
                preview.src = reader.result;
            } else {
                const container = input.closest('.position-relative');
                const img = document.createElement('img');
                img.id = 'avatarPreview';
                img.className = 'rounded-circle border-4 border-white shadow-lg';
                img.style.cssText = 'width: 120px; height: 120px; object-fit: cover;';
                img.src = reader.result;
                
                const placeholder = container.querySelector('.avatar-upload-placeholder');
                if (placeholder) placeholder.remove();
                
                const existingImg = container.querySelector('#avatarPreview');
                if (existingImg) existingImg.remove();
                
                container.insertBefore(img, container.querySelector('.btn-upload-avatar'));
            }
        };
        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection