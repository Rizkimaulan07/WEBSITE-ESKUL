@extends('layouts.app')

@section('title', 'Edit Ekstrakurikuler')
@section('subtitle', 'Ubah data ekstrakurikuler')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5 hero-gradient">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-edit fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Edit Ekstrakurikuler</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Ubah data ekstrakurikuler</p>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-4 py-2" style="font-weight: 500;">
                            <i class="fas fa-trophy me-2"></i>{{ $ekskul->nama_ekskul }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('admin.ekskul.update', $ekskul->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Logo Upload -->
                        <div class="col-12">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    @if($ekskul->logo)
                                        <img src="{{ asset($ekskul->logo) }}" 
                                             class="rounded-circle border border-4 border-white shadow-lg" 
                                             style="width: 120px; height: 120px; object-fit: cover;"
                                             id="logoPreview">
                                    @else
                                        <div class="logo-upload-placeholder rounded-circle d-inline-flex align-items-center justify-content-center"
                                             style="width: 120px; height: 120px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: 4px solid white; box-shadow: 0 8px 30px rgba(14,165,233,0.2);">
                                            <i class="fas fa-image fa-4x text-white opacity-75"></i>
                                        </div>
                                    @endif
                                    <label for="logo" class="btn-upload-logo" style="position: absolute; bottom: 5px; right: 5px; width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border: 3px solid white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(14,165,233,0.3);">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" class="d-none" id="logo" name="logo" accept="image/*" onchange="previewLogo(event)">
                                </div>
                                <p class="text-muted small mt-2" style="color: #64748b; font-size: 13px;">
                                    <i class="fas fa-info-circle me-1" style="color: #0ea5e9;"></i>
                                    Klik ikon kamera untuk mengubah logo
                                </p>
                            </div>
                        </div>

                        <!-- Nama Ekskul & Pembina -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b;">
                                    <i class="fas fa-tag me-2" style="color: #0ea5e9;"></i>Nama Ekskul
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('nama_ekskul') is-invalid @enderror" 
                                       name="nama_ekskul" value="{{ old('nama_ekskul', $ekskul->nama_ekskul) }}" placeholder="Contoh: Paskibra, Pramuka" required>
                                @error('nama_ekskul')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b;">
                                    <i class="fas fa-user-tie me-2" style="color: #0ea5e9;"></i>Pembina
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('pembina') is-invalid @enderror" 
                                       name="pembina" value="{{ old('pembina', $ekskul->pembina) }}" placeholder="Contoh: Bpk. Andi Susanto, S.Pd" required>
                                @error('pembina')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b;">
                                    <i class="fas fa-align-left me-2" style="color: #0ea5e9;"></i>Deskripsi
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control form-control-modern @error('deskripsi') is-invalid @enderror" 
                                          name="deskripsi" rows="4" placeholder="Tuliskan deskripsi lengkap tentang ekstrakurikuler ini..." required>{{ old('deskripsi', $ekskul->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Hari, Jam, Tempat -->
                        @php $currentDays = old('hari_latihan', array_map('trim', explode(',', $ekskul->hari_latihan ?? ''))); @endphp
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b;">
                                    <i class="fas fa-calendar-day me-2" style="color: #0ea5e9;"></i>Hari Latihan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="day-picker @error('hari_latihan') is-invalid @enderror" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    @php $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; @endphp
                                    @foreach($days as $day)
                                        <label class="day-chip" style="cursor: pointer; user-select: none;">
                                            <input type="checkbox" name="hari_latihan[]" value="{{ $day }}" class="day-checkbox"
                                                   {{ in_array($day, $currentDays) ? 'checked' : '' }}>
                                            <span class="day-label">{{ $day }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('hari_latihan')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b;">
                                    <i class="fas fa-clock me-2" style="color: #0ea5e9;"></i>Jam Mulai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time" class="form-control form-control-modern @error('jam_mulai') is-invalid @enderror" 
                                       name="jam_mulai" value="{{ old('jam_mulai', $ekskul->jam_mulai) }}" required>
                                @error('jam_mulai')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b;">
                                    <i class="fas fa-clock me-2" style="color: #0ea5e9;"></i>Jam Selesai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time" class="form-control form-control-modern @error('jam_selesai') is-invalid @enderror" 
                                       name="jam_selesai" value="{{ old('jam_selesai', $ekskul->jam_selesai) }}" required>
                                @error('jam_selesai')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tempat & Status -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b;">
                                    <i class="fas fa-map-marker-alt me-2" style="color: #0ea5e9;"></i>Tempat Latihan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('tempat_latihan') is-invalid @enderror" 
                                       name="tempat_latihan" value="{{ old('tempat_latihan', $ekskul->tempat_latihan) }}" placeholder="Contoh: Lapangan Upacara, GOR" required>
                                @error('tempat_latihan')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="font-size: 14px; color: #1e293b;">
                                    <i class="fas fa-toggle-on me-2" style="color: #0ea5e9;"></i>Status
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('status') is-invalid @enderror" 
                                        name="status" required>
                                    <option value="aktif" {{ old('status', $ekskul->status) == 'aktif' ? 'selected' : '' }}>🟢 Aktif</option>
                                    <option value="nonaktif" {{ old('status', $ekskul->status) == 'nonaktif' ? 'selected' : '' }}>🔴 Nonaktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <div class="divider-custom">
                                <span style="background: #ffffff; padding: 0 16px; color: #0ea5e9;">
                                    <i class="fas fa-save"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.ekskul.index') }}" class="btn-outline-secondary-custom" style="padding: 12px 32px; border-radius: 12px; border: 2px solid #e2e8f0; background: transparent; color: #64748b; font-weight: 500; transition: all 0.3s ease; text-decoration: none;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-primary-gradient" style="padding: 12px 40px; border-radius: 12px; font-weight: 600; transition: all 0.3s ease;">
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
    .btn-upload-logo:hover { transform: scale(1.1); box-shadow: 0 6px 24px rgba(14,165,233,0.5); }
    .day-checkbox { display: none; }
    .day-chip { position: relative; }
    .day-label { display: inline-block; padding: 10px 22px; border-radius: 12px; font-size: 13px; font-weight: 600; border: 2px solid #e2e8f0; background: #fafbfc; color: #64748b; transition: all 0.2s ease; }
    .day-chip:hover > .day-label { border-color: #0ea5e9; color: #0c4a6e; }
    .day-chip.active > .day-label { border-color: #0ea5e9; background: rgba(14,165,233,0.1); color: #0c4a6e; box-shadow: 0 0 0 4px rgba(14,165,233,0.08); }
    .day-chip.active .day-label::after { content: '\f00c'; font-family: 'Font Awesome 6 Free'; font-weight: 900; margin-left: 8px; font-size: 11px; color: #0ea5e9; }
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

    // ===== DAY PICKER (pilih beberapa hari) =====
    function initDayPicker() {
        document.querySelectorAll('.day-chip').forEach(function(chip) {
            var checkbox = chip.querySelector('.day-checkbox');
            if (!checkbox) return;
            function sync() {
                if (checkbox.checked) chip.classList.add('active');
                else chip.classList.remove('active');
            }
            sync();
            chip.addEventListener('click', function(e) {
                e.preventDefault();
                checkbox.checked = !checkbox.checked;
                sync();
            });
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDayPicker);
    } else {
        initDayPicker();
    }
</script>
@endsection