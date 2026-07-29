@extends('layouts.app')

@section('title', 'Input Kehadiran')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Input Kehadiran - {{ $ekskul->nama_ekskul }}</h3>
        <div class="card-tools">
            <a href="{{ route('kehadiran.rekap') }}" class="btn btn-info btn-sm">
                <i class="fas fa-chart-bar"></i> Lihat Rekap
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('kehadiran.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Tanggal Latihan</label>
                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Anggota</th>
                        <th>Kelas</th>
                        <th width="100">Hadir</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anggota as $index => $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $a->name }}</td>
                        <td>{{ $a->kelas }}</td>
                        <td class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" 
                                       name="anggota_ids[]" 
                                       value="{{ $a->id }}"
                                       id="anggota_{{ $a->id }}"
                                       class="custom-control-input"
                                       {{ isset($kehadiranHariIni[$a->id]) && $kehadiranHariIni[$a->id]->status == 'hadir' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="anggota_{{ $a->id }}"></label>
                            </div>
                        </td>
                        <td>
                            <input type="text" 
                                   name="keterangan[{{ $a->id }}]" 
                                   class="form-control form-control-sm"
                                   placeholder="Catatan (opsional)"
                                   value="{{ isset($kehadiranHariIni[$a->id]) ? $kehadiranHariIni[$a->id]->keterangan : '' }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Kehadiran
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-check all
    $('#checkAll').on('change', function() {
        $('input[name="anggota_ids[]"]').prop('checked', this.checked);
    });
</script>
@endpush
@endsection