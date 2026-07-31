@extends('layouts.app')

@section('title', 'Template Surat')
@section('subtitle', 'Kelola template surat')

@section('content')
<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card blue">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Template</div>
                    <div class="stat-number">{{ $templates->count() }}</div>
                </div>
                <div class="stat-icon blue"><i class="fas fa-file-alt"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card gold">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Dengan File</div>
                    <div class="stat-number">{{ $templates->whereNotNull('file_template')->count() }}</div>
                </div>
                <div class="stat-icon gold"><i class="fas fa-file-pdf"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card green">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Tanpa File</div>
                    <div class="stat-number">{{ $templates->whereNull('file_template')->count() }}</div>
                </div>
                <div class="stat-icon green"><i class="fas fa-file-word"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <div class="table-header">
        <h6><i class="fas fa-list text-gold me-2"></i>Daftar Template Surat</h6>
        <div class="d-flex gap-2">
            <a href="{{ route('template-surat.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus me-1"></i> Tambah
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Keterangan</th>
                    <th>File</th>
                    <th>Dibuat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $index => $template)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="fw-semibold">{{ $template->judul_template }}</span>
                    </td>
                    <td>{{ $template->keterangan ?? '-' }}</td>
                    <td>
                        @if($template->file_template)
                            <span class="badge-custom active">
                                <i class="fas fa-check-circle me-1"></i> Ada
                            </span>
                        @else
                            <span class="badge-custom" style="background: rgba(0,0,0,0.05); color: #999;">
                                <i class="fas fa-times-circle me-1"></i> Tidak ada
                            </span>
                        @endif
                    </td>
                    <td>{{ $template->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="action-btns d-flex gap-1 justify-content-center">
                            @if($template->file_template)
                                <a href="{{ route('template-surat.download', $template->id) }}" 
                                   class="btn btn-view" 
                                   title="Download"
                                   target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                            @endif
                            <a href="{{ route('template-surat.edit', $template->id) }}" 
                               class="btn btn-edit" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('template-surat.destroy', $template->id) }}" 
                                  method="POST" 
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete" title="Hapus" onclick="return confirm('Yakin hapus?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada template surat</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection