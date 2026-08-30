@extends('layouts.app')

@section('title', 'Unduh Aplikasi')
@section('subtitle', 'Kelola file aplikasi untuk diunduh pengguna')

@push('styles')
<style>
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
    .upload-area {
        border: 2px dashed #7dd3fc;
        border-radius: 16px;
        padding: 40px 20px;
        text-align: center;
        transition: all 0.3s ease;
        background: #f0f9ff;
        cursor: pointer;
    }
    .upload-area:hover {
        border-color: #0ea5e9;
        background: #e0f2fe;
    }
    .upload-area.dragover {
        border-color: #0ea5e9;
        background: #bae6fd;
    }
    .btn-primary-gradient {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px 32px;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
    }
    .btn-primary-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(14, 165, 233, 0.4);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 30%, #38bdf8 60%, #7dd3fc 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-download fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Unduh Aplikasi</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">Kelola file aplikasi (APK) untuk pengguna</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('admin.downloads.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group-modern">
                        <label class="fw-semibold mb-2" style="color: #1e293b; font-size: 14px;">
                            <i class="fas fa-mobile-alt me-2" style="color: #0ea5e9;"></i>File Aplikasi (.apk)
                            <span class="text-danger">*</span>
                            <span class="text-muted" style="font-weight: 400; font-size: 12px;">(Maksimal 100MB)</span>
                        </label>
                        <div class="upload-area" id="uploadArea">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #0ea5e9; opacity: 0.6;"></i>
                            <p class="mt-3 mb-0 fw-bold" style="color: #0f172a;">Klik atau seret file APK ke sini</p>
                            <small class="text-muted" style="font-size: 12px;">Format: .apk</small>
                            <input type="file" class="d-none" name="apk" id="fileInput" accept=".apk" required>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-end mt-4">
                        <button type="submit" class="btn-primary-gradient">
                            <i class="fas fa-upload me-2"></i>Upload Aplikasi
                        </button>
                    </div>
                </form>

                <hr class="my-5">

                <h6 class="fw-bold mb-3" style="color: #0f172a;">
                    <i class="fas fa-folder-open me-2" style="color: #0ea5e9;"></i>File Terupload
                </h6>

                @php
                    $downloadDir = public_path('downloads');
                    $files = is_dir($downloadDir) ? array_diff(scandir($downloadDir), ['.', '..']) : [];
                @endphp

                @if(count($files) > 0)
                <div class="list-group">
                    @foreach($files as $file)
                    <div class="list-group-item d-flex align-items-center gap-3 border-0 rounded-3 mb-2" style="background: #f8fafc;">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-2" style="background: rgba(14, 165, 233, 0.08);">
                            <i class="fas fa-file-archive" style="color: #0ea5e9; font-size: 20px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-semibold text-truncate" style="color: #0f172a; font-size: 14px;">{{ $file }}</p>
                            <small class="text-muted">
                                {{ number_format(filesize(public_path('downloads/' . $file)) / 1048576, 2) }} MB
                            </small>
                        </div>
                        <a href="{{ asset('downloads/' . $file) }}" class="btn btn-sm" download style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border: none; border-radius: 8px;">
                            <i class="fas fa-download me-1"></i> Unduh
                        </a>
                        <form action="{{ route('admin.downloads.delete', $file) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus file ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" style="border: none; border-radius: 8px; background: rgba(239, 68, 68, 0.9);">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-2" style="opacity: 0.4;"></i>
                        <p class="text-muted mb-0">Belum ada file aplikasi yang diupload</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');

    uploadArea.addEventListener('click', () => fileInput.click());

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            uploadArea.querySelector('p').textContent = '📦 ' + e.dataTransfer.files[0].name;
        }
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length) {
            uploadArea.querySelector('p').textContent = '📦 ' + this.files[0].name;
        }
    });
</script>
@endsection