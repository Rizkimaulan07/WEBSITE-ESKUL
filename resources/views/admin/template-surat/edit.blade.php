@extends('layouts.app')

@section('title', 'Edit Template Surat')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card-modern">
            <div class="card-header">
                <i class="bi bi-pencil me-2"></i> Edit Template Surat
            </div>
            <div class="card-body">
                <form action="{{ route('template-surat.update', $templateSurat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="judul_template">Judul Template <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('judul_template') is-invalid @enderror" 
                               id="judul_template" 
                               name="judul_template" 
                               value="{{ old('judul_template', $templateSurat->judul_template) }}" 
                               required>
                        <i class="bi bi-tag input-icon"></i>
                        @error('judul_template')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="file_template">File Template (Kosongkan jika tidak diubah)</label>
                        <input type="file" 
                               class="form-control @error('file_template') is-invalid @enderror" 
                               id="file_template" 
                               name="file_template" 
                               accept=".doc,.docx">
                        <i class="bi bi-file-earmark-word input-icon"></i>
                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-info-circle me-1"></i> 
                            File saat ini: {{ basename($templateSurat->file_template) }}
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
                                  rows="3">{{ old('keterangan', $templateSurat->keterangan) }}</textarea>
                        <i class="bi bi-chat input-icon" style="top: 60px;"></i>
                        @error('keterangan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update
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
@endsection