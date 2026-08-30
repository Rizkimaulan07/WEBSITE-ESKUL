@extends('layouts.app')

@section('title', 'Tambah Pelatih')
@section('subtitle', 'Tambahkan pelatih baru untuk ekstrakurikuler')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header Premium - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5 hero-gradient">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-user-plus fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Tambah Pelatih</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Tambahkan pelatih baru untuk ekstrakurikuler</p>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2" style="font-weight: 500;">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Pelatih
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('admin.pelatih.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- ===== UPLOAD FOTO ===== -->
                    <div class="col-12 mb-4">
                        <div class="text-center">
                            <div class="position-relative d-inline-block">
                                <div class="rounded-circle border-4 border-white shadow-lg d-flex align-items-center justify-content-center"
                                     style="width: 140px; height: 140px; background: linear-gradient(135deg, #0ea5e9, #38bdf8);" id="fotoPreviewContainer">
                                    <i class="fas fa-user fa-5x text-white"></i>
                                </div>
                                <label for="avatar" class="btn-upload-avatar" style="position: absolute; bottom: 5px; right: 5px; width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border: 3px solid white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(14,165,233,0.3);">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" class="d-none" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(event)">
                            </div>
                            <p class="text-muted small mt-3" style="color: #64748b; font-size: 13px;">
                                <i class="fas fa-info-circle me-1" style="color: #0ea5e9;"></i>
                                Klik ikon kamera untuk mengubah foto profil
                            </p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-user" style="color: #0ea5e9; margin-right: 8px;"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- No HP -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-phone" style="color: #0ea5e9; margin-right: 8px;"></i>No HP
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('no_hp') is-invalid @enderror" 
                                       name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukkan nomor HP" required>
                                @error('no_hp')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-envelope" style="color: #0ea5e9; margin-right: 8px;"></i>Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control form-control-modern @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" placeholder="contoh: pelatih@gmail.com" required>
                                @error('email')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-lock" style="color: #0ea5e9; margin-right: 8px;"></i>Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control form-control-modern @error('password') is-invalid @enderror" 
                                       name="password" placeholder="Masukkan password untuk login" required>
                                @error('password')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Ekskul -->
                        <div class="col-md-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b; font-weight: 600; letter-spacing: 0.3px;">
                                    <i class="fas fa-trophy" style="color: #0ea5e9; margin-right: 8px;"></i>Ekstrakurikuler
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('ekskul_id') is-invalid @enderror" 
                                        name="ekskul_id" required>
                                    <option value="">-- Pilih Ekstrakurikuler --</option>
                                    @foreach($ekskuls as $ekskul)
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

                        <!-- Divider -->
                        <div class="col-12">
                            <div class="divider-custom">
                                <span style="background: #ffffff; padding: 0 16px; color: #0ea5e9;">
                                    <i class="fas fa-user-plus"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.pelatih.index') }}" class="btn-outline-secondary-custom" style="padding: 12px 32px; border-radius: 12px; border: 2px solid #e2e8f0; background: transparent; color: #64748b; font-weight: 500; transition: all 0.3s ease; text-decoration: none;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-primary-gradient" style="padding: 12px 40px; border-radius: 12px; font-weight: 600; transition: all 0.3s ease;">
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
    .btn-upload-avatar:hover { transform: scale(1.1); box-shadow: 0 6px 24px rgba(14,165,233,0.5); }
</style>

<script>
    function previewAvatar(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function() {
            const container = document.getElementById('fotoPreviewContainer');
            container.innerHTML = `<img src="${reader.result}" class="rounded-circle" style="width: 140px; height: 140px; object-fit: cover;">`;
        };
        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection