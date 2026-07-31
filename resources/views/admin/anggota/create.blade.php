@extends('layouts.app')

@section('title', 'Tambah Anggota')
@section('subtitle', 'Tambah anggota baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-modern">
            <!-- Header -->
            <div class="card-header-modern">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Tambah Anggota Baru</h5>
                        <p class="text-muted small mb-0">Isi data anggota dengan lengkap</p>
                    </div>
                </div>
                <a href="{{ route('admin.anggota.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <!-- Body Form -->
            <div class="card-body-modern">
                <form action="{{ route('admin.anggota.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user text-primary me-2"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Masukkan nama lengkap" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-envelope text-primary me-2"></i>Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="admin@bk.sch.id" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-lock text-primary me-2"></i>Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="Minimal 8 karakter" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-check-circle text-primary me-2"></i>Konfirmasi Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       name="password_confirmation" 
                                       placeholder="Konfirmasi password" 
                                       required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kelas -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-graduation-cap text-primary me-2"></i>Kelas
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('kelas') is-invalid @enderror" 
                                       name="kelas" 
                                       value="{{ old('kelas') }}" 
                                       placeholder="Contoh: XI - A" 
                                       required>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- No HP -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-phone text-primary me-2"></i>No HP
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('no_hp') is-invalid @enderror" 
                                       name="no_hp" 
                                       value="{{ old('no_hp') }}" 
                                       placeholder="Contoh: 08123456789" 
                                       required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Ekstrakurikuler -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-trophy text-primary me-2"></i>Ekstrakurikuler
                                </label>
                                <select class="form-select @error('ekskul_id') is-invalid @enderror" 
                                        name="ekskul_id">
                                    <option value="">-- Pilih Ekskul --</option>
                                    @foreach($ekskuls as $ekskul)
                                        <option value="{{ $ekskul->id }}" {{ old('ekskul_id') == $ekskul->id ? 'selected' : '' }}>
                                            {{ $ekskul->nama_ekskul }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ekskul_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <hr class="form-divider">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.anggota.index') }}" class="btn-cancel">
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
@endsection