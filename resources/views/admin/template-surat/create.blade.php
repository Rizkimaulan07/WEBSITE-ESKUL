@extends('layouts.app')

@section('title', 'Tambah Template Surat')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card-modern">
            <div class="card-header">
                <i class="bi bi-file-plus me-2"></i> Tambah Template Surat
            </div>
            <div class="card-body">
                <form action="{{ route('template-surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="judul_template">Judul Template <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('judul_template') is-invalid @enderror" 
                               id="judul_template" 
                               name="judul_template" 
                               value="{{ old('judul_template') }}" 
                               placeholder="Contoh: Surat Izin Kegiatan"
                               required>
                        <i class="bi bi-tag input-icon"></i>
                        @error('judul_template')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="file_template">File Template <span class="text-danger">*</span></label>
                        <input type="file" 
                               class="form-control @error('file_template') is-invalid @enderror" 
                               id="file_template" 
                               name="file_template" 
                               accept=".doc,.docx"
                               required>
                        <i class="bi bi-file-earmark-word input-icon"></i>
                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-info-circle me-1"></i> 
                            Format: .doc, .docx | Maks: 2MB
                        </small>
                        @error('file_template')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" 
                                  name="keterangan" 
                                  rows="3"
                                  placeholder="Deskripsi template surat ini...">{{ old('keterangan') }}</textarea>
                        <i class="bi bi-chat input-icon" style="top: 60px;"></i>
                        @error('keterangan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('template-surat.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview file name
    document.getElementById('file_template').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
        const label = document.querySelector('label[for="file_template"]');
        const small = document.querySelector('.form-group small');
        if (small) {
            small.innerHTML = `<i class="bi bi-file-earmark-word me-1"></i> ${fileName}`;
        }
    });
</script>
@endpush
@endsection