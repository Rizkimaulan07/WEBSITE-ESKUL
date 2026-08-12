@extends('layouts.app')

@section('title', 'Tambah Anggota')
@section('subtitle', 'Tambahkan anggota baru ke ekstrakurikuler')

@section('content')
@php
    $user = Auth::user();
    // Jika admin, tampilkan semua ekskul
    // Jika pelatih, hanya tampilkan ekskulnya sendiri
    if ($user->role == 'admin') {
        $ekskuls = App\Models\Ekstrakurikuler::where('status', 'aktif')->get();
        $selectedEkskul = old('ekskul_id') ?? ($ekskuls->first()->id ?? null);
        $isPelatih = false;
    } else {
        // Pelatih hanya bisa melihat ekskulnya sendiri
        $ekskuls = collect([$user->ekskul])->filter();
        $selectedEkskul = $user->ekskul_id;
        $isPelatih = true;
    }
@endphp

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Header Card -->
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3">
                        <i class="fas fa-user-plus fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0">Tambah Anggota</h4>
                        <p class="text-white-50 mb-0 small">Tambahkan anggota baru ke ekstrakurikuler</p>
                    </div>
                    @if($isPelatih && $ekskuls->isNotEmpty())
                    <div class="ms-auto">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2">
                            <i class="fas fa-trophy me-2"></i>{{ $ekskuls->first()->nama_ekskul }}
                        </span>
                    </div>
                    @endif
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

                @if($ekskuls->isEmpty())
                    <div class="alert alert-warning rounded-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                            <div>
                                <strong>Perhatian!</strong> 
                                @if($isPelatih)
                                    Anda belum memiliki ekskul. Silakan hubungi admin.
                                @else
                                    Belum ada ekstrakurikuler aktif. Silakan tambahkan ekskul terlebih dahulu.
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ $isPelatih ? route('pelatih.anggota.store') : route('admin.anggota.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-user text-primary me-2"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- NIS -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-id-card text-primary me-2"></i>NIS
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('nis') is-invalid @enderror" 
                                       name="nis" value="{{ old('nis') }}" placeholder="Masukkan NIS" required>
                                @error('nis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-envelope text-primary me-2"></i>Email
                                </label>
                                <input type="email" class="form-control form-control-modern @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" placeholder="contoh: siswa@gmail.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-lock text-primary me-2"></i>Password
                                </label>
                                <input type="password" class="form-control form-control-modern @error('password') is-invalid @enderror" 
                                       name="password" placeholder="Kosongkan untuk default dari NIS" autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kelas -->
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-graduation-cap text-primary me-2"></i>Kelas
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('kelas') is-invalid @enderror" 
                                        name="kelas" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>10</option>
                                    <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>11</option>
                                    <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>12</option>
                                </select>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jurusan -->
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-building text-primary me-2"></i>Jurusan
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('jurusan') is-invalid @enderror" 
                                        name="jurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="PPPLG" {{ old('jurusan') == 'PPPLG' ? 'selected' : '' }}>PPPLG</option>
                                    <option value="TJKT" {{ old('jurusan') == 'TJKT' ? 'selected' : '' }}>TJKT</option>
                                    <option value="AKL" {{ old('jurusan') == 'AKL' ? 'selected' : '' }}>AKL</option>
                                    <option value="AXIO" {{ old('jurusan') == 'AXIO' ? 'selected' : '' }}>AXIO</option>
                                </select>
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- No HP -->
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>No HP
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('no_hp') is-invalid @enderror" 
                                       name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789" required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pilih Ekskul (hanya untuk admin) -->
                        @if(!$isPelatih)
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-trophy text-primary me-2"></i>Ekstrakurikuler
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('ekskul_id') is-invalid @enderror" 
                                        name="ekskul_id" required>
                                    <option value="">-- Pilih Ekstrakurikuler --</option>
                                    @foreach($ekskuls as $ekskul)
                                        <option value="{{ $ekskul->id }}" {{ old('ekskul_id', $selectedEkskul) == $ekskul->id ? 'selected' : '' }}>
                                            {{ $ekskul->nama_ekskul }} ({{ $ekskul->pembina }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('ekskul_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @else
                        <!-- Hidden input untuk pelatih -->
                        <input type="hidden" name="ekskul_id" value="{{ $selectedEkskul }}">
                        @endif

                        <!-- Foto Anggota -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2">
                                    <i class="fas fa-camera text-primary me-2"></i>Foto Anggota
                                </label>
                                <div class="border-2 border-dashed rounded-4 p-3 text-center bg-light-subtle">
                                    <input type="file" class="form-control form-control-modern @error('avatar') is-invalid @enderror" 
                                           name="avatar" accept="image/*">
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle me-1"></i>Format JPG, PNG, atau WEBP maksimal 2MB
                                    </small>
                                    @error('avatar')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <div class="divider-custom">
                                <span><i class="fas fa-user-plus text-primary"></i></span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                @if($isPelatih)
                                    <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                @endif
                                @if($ekskuls->isNotEmpty())
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 btn-gradient">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-group-modern {
        margin-bottom: 0;
    }

    .form-group-modern label {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .form-control-modern {
        padding: 12px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
        background: #fafbfc;
        color: #0f172a;
    }

    .form-control-modern:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
        background: #ffffff;
    }

    .form-control-modern.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .form-control-modern.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.08);
    }

    .form-select-modern {
        padding: 12px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
        background: #fafbfc;
        color: #0f172a;
        appearance: auto;
    }

    .form-select-modern:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
        background: #ffffff;
    }

    .form-select-modern.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
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
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
    }

    .divider-custom span {
        background: #ffffff;
        padding: 0 16px;
        position: relative;
        color: #6366f1;
        font-size: 16px;
    }

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

    .info-ekskul {
        animation: fadeSlide 0.5s ease;
    }

    @keyframes fadeSlide {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

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
        .info-ekskul .d-flex {
            flex-wrap: wrap;
        }
        .info-ekskul .ms-auto {
            margin-left: 0 !important;
            margin-top: 8px;
        }
    }
</style>
@endsection