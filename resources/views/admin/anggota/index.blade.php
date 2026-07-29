@extends('layouts.app')

@section('title', 'Manajemen Anggota')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <i class="bi bi-people me-2"></i> Daftar Anggota
                    <span class="badge bg-primary ms-2">{{ $anggota->count() }}</span>
                </div>
                <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Anggota
                </a>
            </div>
            <div class="card-body">
                <!-- Search -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="searchAnggota" placeholder="Cari anggota...">
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive-custom">
                    <table class="table-custom" id="anggotaTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Kelas</th>
                                <th>No HP</th>
                                <th>Ekskul</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anggota as $index => $a)
                            <tr data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                             style="width: 32px; height: 32px; font-size: 12px; font-weight: 700;">
                                            {{ substr($a->name, 0, 1) }}
                                        </div>
                                        {{ $a->name }}
                                    </div>
                                </td>
                                <td>{{ $a->email }}</td>
                                <td><span class="badge bg-info">{{ $a->kelas ?? '-' }}</span></td>
                                <td>{{ $a->no_hp ?? '-' }}</td>
                                <td>
                                    @if($a->ekskuls->count() > 0)
                                        @foreach($a->ekskuls as $ekskul)
                                            <span class="badge bg-primary">{{ $ekskul->nama_ekskul }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-secondary">Belum Bergabung</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('anggota.edit', $a->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('anggota.destroy', $a->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2" style="color: var(--text-secondary);"></i>
                                    <p class="text-muted">Belum ada anggota terdaftar</p>
                                    <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-lg me-1"></i> Tambah Anggota
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchAnggota').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('#anggotaTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data anggota akan dihapus permanen!",
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