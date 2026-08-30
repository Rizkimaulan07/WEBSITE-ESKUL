@extends('layouts.app')

@section('title', $dokumentasi->judul)
@section('subtitle', 'Detail dokumentasi kegiatan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header - Biru Cerah -->
            <div class="card-header border-0 py-4 px-5" 
                 style="background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 30%, #38bdf8 60%, #7dd3fc 100%);">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-images fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0" style="font-size: 22px; letter-spacing: -0.5px;">{{ $dokumentasi->judul }}</h4>
                        <p class="text-white-50 mb-0 small" style="font-weight: 400;">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($dokumentasi->created_at)->format('l, d F Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-body p-5">
                <!-- Galeri Foto -->
                @if($dokumentasi->foto_path)
                    <div class="dokumentasi-image mb-4" style="border-radius: 12px; overflow: hidden; background: #f8fafc;">
                        <img src="{{ asset('storage/' . $dokumentasi->foto_path) }}" 
                             alt="{{ $dokumentasi->judul }}"
                             class="img-fluid rounded-3"
                             style="width: 100%; max-height: 500px; object-fit: cover;">
                    </div>
                @endif

                <!-- Info Ekskul - Biru Cerah -->
                <div class="info-ekskul mb-4">
                    <div class="d-flex align-items-center gap-3 p-3" 
                         style="background: rgba(14,165,233,0.03); border-radius: 12px; border: 1px solid rgba(14,165,233,0.06);">
                        <div class="ekskul-icon" 
                             style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; flex-shrink: 0;">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <div class="text-muted small text-uppercase" style="letter-spacing: 0.5px; font-weight: 600; color: #64748b;">
                                <i class="fas fa-building me-1"></i> Ekstrakurikuler
                            </div>
                            <h5 class="fw-bold mb-0" style="color: #0f172a;">
                                {{ $dokumentasi->ekskul->nama_ekskul ?? 'Ekskul' }}
                            </h5>
                            <small class="text-muted" style="color: #64748b;">
                                <i class="fas fa-user-tie me-1"></i>
                                {{ $dokumentasi->ekskul->pembina ?? '-' }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-calendar-day me-1"></i>
                                {{ $dokumentasi->ekskul->hari_latihan ?? '-' }}
                            </small>
                        </div>
                        <div class="ms-auto">
                            <span class="badge" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 4px 14px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($dokumentasi->created_at)->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="dokumentasi-deskripsi">
                    <h5 class="fw-bold mb-3" style="color: #0f172a;">
                        <i class="fas fa-align-left me-2" style="color: #0ea5e9;"></i>
                        Deskripsi
                    </h5>
                    <div class="deskripsi-content" style="font-size: 16px; line-height: 1.8; color: #1e293b; background: #f8fafc; padding: 20px 24px; border-radius: 12px; border-left: 4px solid #0ea5e9;">
                        {{ $dokumentasi->deskripsi ?? 'Tidak ada deskripsi' }}
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-4 pt-3 border-top" style="border-color: #e2e8f0;">
                    <div class="d-flex gap-3 justify-content-between flex-wrap">
                        <div class="d-flex gap-2">
                            <a href="{{ route('pelatih.dokumentasi') }}" class="btn-outline-secondary-custom" style="padding: 12px 32px; border-radius: 12px; border: 2px solid #e2e8f0; background: transparent; color: #64748b; font-weight: 500; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center;">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn-primary-gradient" style="padding: 12px 32px; border: none; border-radius: 12px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 4px 16px rgba(14,165,233,0.25);">
                                <i class="fas fa-plus me-2"></i> Tambah Dokumentasi
                            </a>
                        </div>
                        <form action="{{ route('pelatih.dokumentasi.destroy', $dokumentasi->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger-gradient" style="padding: 12px 32px; border: none; border-radius: 12px; background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; font-weight: 600; transition: all 0.3s ease; cursor: pointer; box-shadow: 0 4px 16px rgba(239,68,68,0.25);">
                                <i class="fas fa-trash-alt me-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-danger-gradient:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(239,68,68,0.4); }
    .btn-primary-gradient:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(14,165,233,0.4); color: #fff; text-decoration: none; }
    .btn-outline-secondary-custom:hover { border-color: #0ea5e9; background: rgba(14,165,233,0.04); transform: translateY(-3px); color: #0f172a; }
    @media (max-width: 768px) {
        .card-body { padding: 20px !important; }
        .dokumentasi-image img { max-height: 250px; }
        .btn { width: 100%; }
        .d-flex.gap-3 { flex-direction: column; }
        .d-flex.gap-3.justify-content-between { flex-direction: column; }
    }
</style>
@endsection