@extends('layouts.app')

@section('title', 'Tambah Anggota')
@section('subtitle', 'Tambahkan anggota baru ke ekstrakurikuler')

@section('content')
@php
    $user = Auth::user();
    if ($user->role == 'admin') {
        $ekskuls = App\Models\Ekstrakurikuler::where('status', 'aktif')->get();
        $selectedEkskul = old('ekskul_id') ?? ($ekskuls->first()->id ?? null);
        $isPelatih = false;
    } else {
        $ekskuls = collect([$user->ekskul])->filter();
        $selectedEkskul = $user->ekskul_id;
        $isPelatih = true;
    }
@endphp

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Header Card - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5 hero-gradient">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-user-plus fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Tambah Anggota</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Tambahkan anggota baru ke ekstrakurikuler</p>
                    </div>
                    @if($isPelatih && $ekskuls->isNotEmpty())
                    <div class="ms-auto">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2" style="font-weight: 500;">
                            <i class="fas fa-trophy me-2"></i>{{ $ekskuls->first()->nama_ekskul }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card-body p-5">
                @if($ekskuls->isEmpty())
                    <div class="alert alert-warning rounded-4 border-0 shadow-sm" role="alert" style="background: #fef3c7; border-left: 4px solid #f59e0b;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                            <div>
                                <strong style="color: #92400e;">Perhatian!</strong>
                                <span style="color: #78350f;">
                                @if($isPelatih)
                                    Anda belum memiliki ekskul. Silakan hubungi admin.
                                @else
                                    Belum ada ekstrakurikuler aktif. Silakan tambahkan ekskul terlebih dahulu.
                                @endif
                                </span>
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
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-user text-blue-500 me-2" style="color: #0ea5e9;"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- NIS -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-id-card text-blue-500 me-2" style="color: #0ea5e9;"></i>NIS
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('nis') is-invalid @enderror" 
                                       name="nis" value="{{ old('nis') }}" placeholder="Masukkan NIS" required>
                                @error('nis')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-envelope text-blue-500 me-2" style="color: #0ea5e9;"></i>Email
                                </label>
                                <input type="email" class="form-control form-control-modern @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" placeholder="contoh: siswa@gmail.com">
                                @error('email')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-lock text-blue-500 me-2" style="color: #0ea5e9;"></i>Password
                                </label>
                                <input type="password" class="form-control form-control-modern @error('password') is-invalid @enderror" 
                                       name="password" placeholder="Kosongkan untuk default dari NIS" autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kelas -->
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-graduation-cap text-blue-500 me-2" style="color: #0ea5e9;"></i>Kelas
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
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jurusan -->
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-building text-blue-500 me-2" style="color: #0ea5e9;"></i>Jurusan
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('jurusan') is-invalid @enderror" 
                                        name="jurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="PPLG" {{ old('jurusan') == 'PPLG' ? 'selected' : '' }}>PPLG</option>
                                    <option value="TJKT" {{ old('jurusan') == 'TJKT' ? 'selected' : '' }}>TJKT</option>
                                    <option value="AKL" {{ old('jurusan') == 'AKL' ? 'selected' : '' }}>AKL</option>
                                    <option value="AXIO" {{ old('jurusan') == 'AXIO' ? 'selected' : '' }}>AXIO</option>
                                </select>
                                @error('jurusan')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- No HP -->
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-phone text-blue-500 me-2" style="color: #0ea5e9;"></i>No HP
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('no_hp') is-invalid @enderror" 
                                       name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789" required>
                                @error('no_hp')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pilih Ekskul (hanya untuk admin, boleh lebih dari satu) -->
                        @if(!$isPelatih)
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-trophy text-blue-500 me-2" style="color: #0ea5e9;"></i>Ekstrakurikuler
                                    <span class="text-danger">*</span>
                                    <small style="color: #64748b; font-weight: 400;">(boleh pilih lebih dari satu)</small>
                                </label>
                                <div class="ekskul-check-list" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    @foreach($ekskuls as $ekskul)
                                        <label class="ekskul-check-option" style="flex: 1 1 calc(50% - 10px); min-width: 200px; display: flex; align-items: center; gap: 10px; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; background: #fafbfc; cursor: pointer; transition: all 0.3s ease;">
                                            <input type="checkbox" name="ekskul_ids[]" value="{{ $ekskul->id }}" class="form-check-input" style="cursor: pointer; margin: 0;"
                                                {{ ((is_array(old('ekskul_ids')) && in_array($ekskul->id, old('ekskul_ids'))) || old('ekskul_id', $selectedEkskul) == $ekskul->id) ? 'checked' : '' }}>
                                            <span style="font-size: 13px; font-weight: 500; color: #1e293b;">
                                                {{ $ekskul->nama_ekskul }} <small style="color: #64748b;">({{ $ekskul->pembina }})</small>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('ekskul_ids')
                                    <div class="invalid-feedback d-block" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                                @error('ekskul_id')
                                    <div class="invalid-feedback d-block" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @else
                        <input type="hidden" name="ekskul_id" value="{{ $selectedEkskul }}">
                        @endif

                        <!-- Foto Anggota -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-camera text-blue-500 me-2" style="color: #0ea5e9;"></i>Foto Anggota
                                </label>
                                <div class="border-2 border-dashed rounded-4 p-3 text-center" style="border-color: #7dd3fc; background: #f0f9ff;">
                                    <input type="file" class="form-control form-control-modern @error('avatar') is-invalid @enderror" 
                                           name="avatar" accept="image/*">
                                    <small class="d-block mt-2" style="color: #64748b; font-size: 12px;">
                                        <i class="fas fa-info-circle me-1" style="color: #0ea5e9;"></i>Format JPG, PNG, atau WEBP maksimal 2MB
                                    </small>
                                    @error('avatar')
                                        <div class="invalid-feedback d-block" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                @if($isPelatih)
                                    <a href="{{ route('pelatih.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2" style="border-color: #e2e8f0; color: #64748b; font-weight: 500;">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2" style="border-color: #e2e8f0; color: #64748b; font-weight: 500;">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                @endif
                                @if($ekskuls->isNotEmpty())
                                <button type="submit" class="btn-primary-gradient px-5 py-2" style="border-radius: 12px; font-weight: 600; font-size: 14px;">
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

    .form-control-modern {
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
        background: #fafbfc;
        color: #0f172a;
        font-weight: 500;
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

    .form-control-modern.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.08);
    }

    .form-select-modern {
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 14px;
        background: #fafbfc;
        color: #0f172a;
        font-weight: 500;
        appearance: auto;
    }

    .form-select-modern:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
        background: #ffffff;
    }

    .form-select-modern.is-invalid {
        border-color: #dc2626;
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
    }
</style>
@endsection