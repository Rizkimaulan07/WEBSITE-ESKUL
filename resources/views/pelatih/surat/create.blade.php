@extends('layouts.app')

@section('title', 'Buat Surat')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Generate Surat Kegiatan</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('surat.export') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Pilih Template Surat</label>
                <select name="template_id" class="form-control" required>
                    <option value="">-- Pilih Template --</option>
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->judul_template }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Nomor Surat (Otomatis)</label>
                <input type="text" class="form-control" value="SK/{{ date('Y') }}/{{ str_pad(App\Models\SuratKeluar::count() + 1, 3, '0', STR_PAD_LEFT) }}" disabled>
            </div>

            <div class="form-group">
                <label>Tujuan Surat</label>
                <input type="text" name="tujuan" class="form-control" placeholder="Yth. ..." required>
            </div>

            <div class="form-group">
                <label>Tanggal Surat</label>
                <input type="date" name="tanggal_surat" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label>Isi Surat</label>
                <textarea name="isi_surat" class="form-control" rows="10" required placeholder="Tulis isi surat lengkap..."></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-file-word"></i> Generate & Download Word
                </button>
                <button type="submit" formaction="{{ route('surat.export-pdf') }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Generate & Download PDF
                </button>
                <a href="{{ route('surat.history') }}" class="btn btn-info">
                    <i class="fas fa-history"></i> Riwayat Surat
                </a>
            </div>
        </form>
    </div>
</div>
@endsection