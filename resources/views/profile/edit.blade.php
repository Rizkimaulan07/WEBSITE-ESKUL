@extends('layouts.app')

@section('title', 'Profil')
@section('subtitle', 'Edit profil Anda')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-modern" style="background: #ffffff; border-radius: 16px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);">
            <!-- Header - Biru Cerah -->
            <div class="card-header-modern" style="padding: 20px 28px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe);">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon" style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; box-shadow: 0 4px 16px rgba(14,165,233,0.25);">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0" style="color: #0f172a; font-size: 18px;">Edit Profil</h5>
                        <p class="text-muted small mb-0" style="color: #64748b; font-size: 13px;">Ubah informasi profil Anda</p>
                    </div>
                </div>
                @php
                    $user = Auth::user();
                @endphp
                @if($user->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-back" style="padding: 8px 20px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; background: transparent; color: #64748b; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center;">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                @elseif($user->role == 'pelatih')
                    <a href="{{ route('pelatih.dashboard') }}" class="btn-back" style="padding: 8px 20px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; background: transparent; color: #64748b; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center;">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                @elseif($user->role == 'anggota')
                    <a href="{{ route('anggota.dashboard') }}" class="btn-back" style="padding: 8px 20px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; background: transparent; color: #64748b; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center;">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn-back" style="padding: 8px 20px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; background: transparent; color: #64748b; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center;">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                @endif
            </div>

            <!-- Body -->
            <div class="card-body-modern" style="padding: 28px 32px;">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="row g-4">
                        <!-- Avatar / Foto Profil -->
                        <div class="col-12">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    @if($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" 
                                             class="rounded-circle border-4 border-white shadow-lg" 
                                             style="width: 120px; height: 120px; object-fit: cover;"
                                             id="avatarPreview">
                                    @else
                                        <div class="avatar-upload-placeholder rounded-circle d-inline-flex align-items-center justify-content-center"
                                             style="width: 120px; height: 120px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: 4px solid white; box-shadow: 0 8px 30px rgba(14,165,233,0.2);">
                                            <i class="fas fa-user fa-4x text-white opacity-75"></i>
                                        </div>
                                    @endif
                                    <label for="avatar" class="btn-upload-avatar" style="position: absolute; bottom: 5px; right: 5px; width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border: 3px solid white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(14,165,233,0.3);">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" class="d-none" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(event)">
                                </div>
                                <p class="mt-2" style="color: #64748b; font-size: 13px;">
                                    <i class="fas fa-info-circle me-1" style="color: #0ea5e9;"></i>
                                    Klik ikon kamera untuk mengubah foto profil
                                </p>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 6px; display: block;">
                                    <i class="fas fa-user" style="color: #0ea5e9; margin-right: 8px;"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required
                                       style="width: 100%; padding: 10px 16px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; font-size: 13px; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                                @error('name')
                                    <div class="invalid-feedback" style="display: block; font-size: 12px; color: #ef4444; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 6px; display: block;">
                                    <i class="fas fa-envelope" style="color: #0ea5e9; margin-right: 8px;"></i>Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required
                                       style="width: 100%; padding: 10px 16px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; font-size: 13px; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                                @error('email')
                                    <div class="invalid-feedback" style="display: block; font-size: 12px; color: #ef4444; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kelas (untuk anggota) -->
                        @if($user->role == 'anggota')
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 6px; display: block;">
                                    <i class="fas fa-graduation-cap" style="color: #0ea5e9; margin-right: 8px;"></i>Kelas
                                </label>
                                <input type="text" 
                                       class="form-control @error('kelas') is-invalid @enderror" 
                                       name="kelas" 
                                       value="{{ old('kelas', $user->kelas) }}"
                                       style="width: 100%; padding: 10px 16px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; font-size: 13px; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                                @error('kelas')
                                    <div class="invalid-feedback" style="display: block; font-size: 12px; color: #ef4444; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <!-- No HP -->
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 6px; display: block;">
                                    <i class="fas fa-phone" style="color: #0ea5e9; margin-right: 8px;"></i>No HP
                                </label>
                                <input type="text" 
                                       class="form-control @error('no_hp') is-invalid @enderror" 
                                       name="no_hp" 
                                       value="{{ old('no_hp', $user->no_hp) }}"
                                       style="width: 100%; padding: 10px 16px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; font-size: 13px; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                                @error('no_hp')
                                    <div class="invalid-feedback" style="display: block; font-size: 12px; color: #ef4444; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 6px; display: block;">
                                    <i class="fas fa-lock" style="color: #0ea5e9; margin-right: 8px;"></i>Password Baru
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="Kosongkan jika tidak ingin mengubah"
                                       style="width: 100%; padding: 10px 16px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; font-size: 13px; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                                @error('password')
                                    <div class="invalid-feedback" style="display: block; font-size: 12px; color: #ef4444; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 6px; display: block;">
                                    <i class="fas fa-check-circle" style="color: #0ea5e9; margin-right: 8px;"></i>Konfirmasi Password
                                </label>
                                <input type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       name="password_confirmation" 
                                       placeholder="Konfirmasi password baru"
                                       style="width: 100%; padding: 10px 16px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; font-size: 13px; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                                @error('password_confirmation')
                                    <div class="invalid-feedback" style="display: block; font-size: 12px; color: #ef4444; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <hr class="form-divider" style="border: none; border-top: 1px solid rgba(0,0,0,0.02); margin: 8px 0 16px;">
                            <div class="d-flex gap-3 justify-content-end">
                                @php
                                    $user = Auth::user();
                                @endphp
                                @if($user->role == 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="btn-cancel" style="padding: 10px 32px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; background: transparent; color: #64748b; font-size: 14px; font-weight: 500; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                @elseif($user->role == 'pelatih')
                                    <a href="{{ route('pelatih.dashboard') }}" class="btn-cancel" style="padding: 10px 32px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; background: transparent; color: #64748b; font-size: 14px; font-weight: 500; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                @elseif($user->role == 'anggota')
                                    <a href="{{ route('anggota.dashboard') }}" class="btn-cancel" style="padding: 10px 32px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; background: transparent; color: #64748b; font-size: 14px; font-weight: 500; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="btn-cancel" style="padding: 10px 32px; border: 1px solid rgba(0,0,0,0.04); border-radius: 10px; background: transparent; color: #64748b; font-size: 14px; font-weight: 500; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                @endif
                                <button type="submit" class="btn-submit" style="padding: 10px 40px; border: none; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 14px; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; cursor: pointer; box-shadow: 0 4px 16px rgba(14,165,233,0.25);">
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
    .form-control:focus {
        outline: none;
        border-color: #0ea5e9 !important;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.06);
    }
    .form-control.is-invalid {
        border-color: #ef4444;
    }
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.04);
    }
    .form-control::placeholder {
        color: #64748b;
    }
    .btn-back:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        color: #0f172a;
        text-decoration: none;
    }
    .btn-cancel:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        color: #0f172a;
        text-decoration: none;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(14, 165, 233, 0.35);
    }
    .btn-upload-avatar:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 24px rgba(14, 165, 233, 0.5);
    }
    .avatar-upload-placeholder {
        transition: all 0.3s ease;
    }
    .avatar-upload-placeholder:hover {
        transform: scale(1.02);
    }
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
        .btn-cancel, .btn-submit {
            width: 100%;
            justify-content: center;
        }
        .d-flex.gap-3 {
            flex-direction: column;
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