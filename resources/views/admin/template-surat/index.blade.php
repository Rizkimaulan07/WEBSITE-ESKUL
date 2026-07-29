{{-- resources/views/admin/template-surat/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Template Surat')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <i class="bi bi-file-text me-2"></i> Template Surat
                    <span class="badge bg-primary ms-2">{{ $templates->count() }}</span>
                </div>
                <a href="{{ route('template-surat.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Template
                </a>
            </div>
            <div class="card-body">
                @if($templates->count() > 0)
                <div class="table-responsive-custom">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Template</th>
                                <th>Keterangan</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($templates as $index => $template)
                            <tr data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-word me-2" style="color: #2B5797; font-size: 20px;"></i>
                                        {{ $template->judul_template }}
                                    </div>
                                </td>
                                <td>{{ $template->keterangan ?? '-' }}</td>
                                <td>{{ $template->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('template-surat.download', $template->id) }}" 
                                           class="btn btn-success btn-sm"
                                           target="_blank">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <form action="{{ route('template-surat.destroy', $template->id) }}" 
                                              method="POST" 
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark-text fs-1 d-block mb-3" style="color: var(--text-secondary);"></i>
                    <h5>Belum Ada Template Surat</h5>
                    <p class="text-muted">Tambahkan template surat untuk memudahkan pembuatan surat</p>
                    <a href="{{ route('template-surat.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Template
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Template surat akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection