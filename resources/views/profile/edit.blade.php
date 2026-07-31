@extends('layouts.app')

@section('title', 'Profile')
@section('subtitle', 'Edit profile Anda')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-modern">
            <!-- Header -->
            <div class="card-header-modern">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Edit Profile</h5>
                        <p class="text-muted small mb-0">Ubah informasi profile Anda</p>
                    </div>
                </div>
                @php
                    $user = Auth::user();
                @endphp
                @if($user->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                @elseif($user->role == 'pelatih')
                    <a href="{{ route('pelatih.dashboard') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                @elseif($user->role == 'anggota')
                    <a href="{{ route('anggota.dashboard') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                @endif
            </div>

            <!-- Body -->
            <div class="card-body-modern">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user text-primary me-2"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
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
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kelas (untuk anggota) -->
                        @if($user->role == 'anggota')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-graduation-cap text-primary me-2"></i>Kelas
                                </label>
                                <input type="text" 
                                       class="form-control @error('kelas') is-invalid @enderror" 
                                       name="kelas" 
                                       value="{{ old('kelas', $user->kelas) }}">
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <!-- No HP -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-phone text-primary me-2"></i>No HP
                                </label>
                                <input type="text" 
                                       class="form-control @error('no_hp') is-invalid @enderror" 
                                       name="no_hp" 
                                       value="{{ old('no_hp', $user->no_hp) }}">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-lock text-primary me-2"></i>Password Baru
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="Kosongkan jika tidak ingin mengubah">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-check-circle text-primary me-2"></i>Konfirmasi Password
                                </label>
                                <input type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       name="password_confirmation" 
                                       placeholder="Konfirmasi password baru">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <hr class="form-divider">
                            <div class="d-flex gap-3 justify-content-end">
                                @php
                                    $user = Auth::user();
                                @endphp
                                @if($user->role == 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="btn-cancel">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                @elseif($user->role == 'pelatih')
                                    <a href="{{ route('pelatih.dashboard') }}" class="btn-cancel">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                @elseif($user->role == 'anggota')
                                    <a href="{{ route('anggota.dashboard') }}" class="btn-cancel">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="btn-cancel">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                @endif
                                <button type="submit" class="btn-submit">
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