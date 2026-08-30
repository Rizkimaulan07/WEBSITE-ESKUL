@extends('layouts.app')

@section('title', 'Tambah Ekstrakurikuler')
@section('subtitle', 'Buat ekstrakurikuler baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5 hero-gradient">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-plus-circle fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Tambah Ekstrakurikuler</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Buat ekstrakurikuler baru</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('admin.ekskul.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Nama Ekskul & Pembina -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-tag me-2" style="color: #0ea5e9;"></i>Nama Ekskul
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('nama_ekskul') is-invalid @enderror" 
                                       name="nama_ekskul" value="{{ old('nama_ekskul') }}" placeholder="Contoh: Paskibra, Pramuka" required>
                                @error('nama_ekskul')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-user-tie me-2" style="color: #0ea5e9;"></i>Pembina
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('pembina') is-invalid @enderror" 
                                       name="pembina" value="{{ old('pembina') }}" placeholder="Contoh: Bpk. Andi Susanto, S.Pd" required>
                                @error('pembina')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-align-left me-2" style="color: #0ea5e9;"></i>Deskripsi
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control form-control-modern @error('deskripsi') is-invalid @enderror" 
                                          name="deskripsi" rows="4" placeholder="Tuliskan deskripsi lengkap tentang ekstrakurikuler ini..." required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Hari, Jam, Tempat -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-calendar-day me-2" style="color: #0ea5e9;"></i>Hari Latihan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="day-picker @error('hari_latihan') is-invalid @enderror" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    @php $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; @endphp
                                    @foreach($days as $day)
                                        <label class="day-chip" style="cursor: pointer; user-select: none;">
                                            <input type="checkbox" name="hari_latihan[]" value="{{ $day }}" class="day-checkbox"
                                                   {{ in_array($day, old('hari_latihan', [])) ? 'checked' : '' }}>
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
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-clock me-2" style="color: #0ea5e9;"></i>Jam Mulai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time" class="form-control form-control-modern @error('jam_mulai') is-invalid @enderror" 
                                       name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                                @error('jam_mulai')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-clock me-2" style="color: #0ea5e9;"></i>Jam Selesai
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time" class="form-control form-control-modern @error('jam_selesai') is-invalid @enderror" 
                                       name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                                @error('jam_selesai')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tempat -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-map-marker-alt me-2" style="color: #0ea5e9;"></i>Tempat Latihan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-modern @error('tempat_latihan') is-invalid @enderror" 
                                       name="tempat_latihan" value="{{ old('tempat_latihan') }}" placeholder="Contoh: Lapangan Upacara, GOR" required>
                                @error('tempat_latihan')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-toggle-on me-2" style="color: #0ea5e9;"></i>Status
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('status') is-invalid @enderror" 
                                        name="status" required>
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>🟢 Aktif</option>
                                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>🔴 Nonaktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Logo -->
                        <div class="col-12">
                            <div class="form-group-modern">
                                <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                                    <i class="fas fa-image me-2" style="color: #0ea5e9;"></i>Logo Ekskul
                                </label>
                                <div class="upload-area" id="uploadArea" style="border: 2px dashed #7dd3fc; border-radius: 16px; padding: 40px 20px; text-align: center; transition: all 0.3s ease; background: #f0f9ff; cursor: pointer;">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #0ea5e9; opacity: 0.6;"></i>
                                    <p class="mt-3 mb-0 fw-bold" style="color: #0f172a;">Klik atau seret logo ke sini</p>
                                    <small class="text-muted" style="font-size: 12px;">Format JPG, PNG, WEBP maksimal 2MB</small>
                                    <input type="file" class="d-none" name="logo" id="fileInput" accept="image/*">
                                </div>
                                <div id="filePreview" class="mt-3 d-none">
                                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f0f9ff; border: 1px solid #7dd3fc;">
                                        <i class="fas fa-file-image fa-2x" style="color: #0ea5e9;"></i>
                                        <div>
                                            <p class="mb-0 fw-bold" id="fileName" style="color: #0f172a;">file.png</p>
                                            <small class="text-muted" id="fileSize">0 KB</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger ms-auto" id="removeFile">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('logo')
                                    <div class="invalid-feedback d-block" style="color: #dc2626; font-size: 13px;">{{ $message }}</div>
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
    .upload-area:hover { border-color: #0ea5e9; background: #e0f2fe; }
    .upload-area.dragover { border-color: #0ea5e9; background: #bae6fd; }
    .day-checkbox { display: none; }
    .day-chip { position: relative; }
    .day-label { display: inline-block; padding: 10px 22px; border-radius: 12px; font-size: 13px; font-weight: 600; border: 2px solid #e2e8f0; background: #fafbfc; color: #64748b; transition: all 0.2s ease; }
    .day-chip:hover > .day-label { border-color: #0ea5e9; color: #0c4a6e; }
    .day-chip.active > .day-label { border-color: #0ea5e9; background: rgba(14,165,233,0.1); color: #0c4a6e; box-shadow: 0 0 0 4px rgba(14,165,233,0.08); }
    .day-chip.active .day-label::after { content: '\f00c'; font-family: 'Font Awesome 6 Free'; font-weight: 900; margin-left: 8px; font-size: 11px; color: #0ea5e9; }
</style>

<script>
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFile = document.getElementById('removeFile');

    uploadArea.addEventListener('click', () => fileInput.click());
    uploadArea.addEventListener('dragover', (e) => { e.preventDefault(); uploadArea.classList.add('dragover'); });
    uploadArea.addEventListener('dragleave', () => { uploadArea.classList.remove('dragover'); });
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            updateFilePreview(e.dataTransfer.files[0]);
        }
    });
    fileInput.addEventListener('change', function() { if (this.files.length) updateFilePreview(this.files[0]); });
    function updateFilePreview(file) {
        fileName.textContent = file.name;
        fileSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
        filePreview.classList.remove('d-none');
        uploadArea.querySelector('p').textContent = '📄 ' + file.name;
    }
    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.add('d-none');
        uploadArea.querySelector('p').textContent = 'Klik atau seret logo ke sini';
    });

    // ===== DAY PICKER (pilih beberapa hari) =====
    function initDayPicker() {
        document.querySelectorAll('.day-chip').forEach(function(chip) {
            var checkbox = chip.querySelector('.day-checkbox');
            if (!checkbox) return;
            // Sinkronkan class aktif dengan state checkbox
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