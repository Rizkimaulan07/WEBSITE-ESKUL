@extends('layouts.app')

@section('title', 'Data Ekstrakurikuler')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Ekstrakurikuler</h3>
        <div class="card-tools">
            <a href="{{ route('ekskul.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Ekskul
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Nama Ekskul</th>
                    <th>Pembina</th>
                    <th>Jadwal</th>
                    <th>Tempat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ekskuls as $ekskul)
                <tr>
                    <td>
                        @if($ekskul->logo)
                            <img src="{{ asset('storage/' . $ekskul->logo) }}" 
                                 alt="Logo" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <i class="fas fa-building fa-2x"></i>
                        @endif
                    </td>
                    <td>{{ $ekskul->nama_ekskul }}</td>
                    <td>{{ $ekskul->pembina }}</td>
                    <td>{{ $ekskul->hari_latihan }} {{ $ekskul->jam_mulai }}-{{ $ekskul->jam_selesai }}</td>
                    <td>{{ $ekskul->tempat_latihan }}</td>
                    <td>
                        <a href="{{ route('ekskul.edit', $ekskul->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('ekskul.destroy', $ekskul->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
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