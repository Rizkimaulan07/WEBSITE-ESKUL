@extends('layouts.app')

@section('title', 'Dokumentasi Berhasil Ditambahkan')
@section('subtitle', 'Selamat, dokumentasi Anda telah berhasil disimpan!')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header Premium - Gradien Hijau dengan Animasi -->
            <div class="card-header border-0 py-5 px-5 text-center position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #059669 0%, #10b981 40%, #34d399 80%, #6ee7b7 100%);">
                <!-- Decorative Shapes -->
                <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.08; background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22white%22/></svg>') no-repeat; background-size: 300px; background-position: -50px -50px;"></div>
                <div class="position-absolute bottom-0 end-0" style="opacity: 0.06; width: 200px; height: 200px; background: radial-gradient(circle, white, transparent 70%); border-radius: 50%;"></div>
                
                <!-- Icon Sukses dengan Animasi -->
                <div class="position-relative" style="z-index: 1;">
                    <div class="bg-white bg-opacity-20 rounded-circle p-4 d-inline-block" style="backdrop-filter: blur(12px); border: 2px solid rgba(255,255,255,0.2); animation: pulseSuccess 2s infinite;">
                        <i class="fas fa-check-circle fa-4x text-white" style="filter: drop-shadow(0 4px 20px rgba(255,255,255,0.3));"></i>
                    </div>
                    <h3 class="text-white fw-bold mt-3 mb-1" style="font-size: 26px; letter-spacing: -0.5px;">✅ Dokumentasi Berhasil!</h3>
                    <p class="text-white-50 mb-0" style="font-weight: 400; font-size: 15px;">Dokumentasi telah berhasil ditambahkan</p>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-5">
                <!-- Detail Dokumentasi -->
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f0f9ff; border: 1px solid #bae6fd;">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2" style="background: rgba(14,165,233,0.08);">
                                <i class="fas fa-file-alt" style="color: #0ea5e9;"></i>
                            </div>
                            <div>
                                <span class="text-muted small" style="color: #94a3b8; font-size: 12px;">Judul Dokumentasi</span>
                                <p class="fw-bold mb-0" style="color: #0f172a;">{{ $dokumentasi->judul ?? 'Dokumentasi Baru' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-calendar" style="color: #10b981;"></i>
                            </div>
                            <div>
                                <span class="text-muted small" style="color: #94a3b8; font-size: 12px;">Tanggal Kegiatan</span>
                                <p class="fw-bold mb-0" style="color: #0f172a;">{{ $dokumentasi->tanggal_kegiatan ? \Carbon\Carbon::parse($dokumentasi->tanggal_kegiatan)->format('d F Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-trophy" style="color: #f59e0b;"></i>
                            </div>
                            <div>
                                <span class="text-muted small" style="color: #94a3b8; font-size: 12px;">Ekstrakurikuler</span>
                                <p class="fw-bold mb-0" style="color: #0f172a;">{{ $dokumentasi->ekskul->nama_ekskul ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($dokumentasi->deskripsi)
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                            <span class="text-muted small" style="color: #94a3b8; font-size: 12px;">Deskripsi</span>
                            <p class="mb-0" style="color: #475569;">{{ $dokumentasi->deskripsi }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Preview Foto -->
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                            <span class="text-muted small" style="color: #94a3b8; font-size: 12px;">
                                <i class="fas fa-image me-1"></i> Foto
                            </span>
                            <div class="d-flex gap-2 mt-2 flex-wrap">
                                @if($dokumentasi->foto_path)
                                    <img src="{{ asset('storage/' . $dokumentasi->foto_path) }}" 
                                         alt="Foto" 
                                         class="rounded-3" 
                                         style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #e2e8f0;">
                                @endif
                                @if($dokumentasi->foto_lainnya)
                                    @php
                                        $fotoLainnya = json_decode($dokumentasi->foto_lainnya, true);
                                    @endphp
                                    @if(is_array($fotoLainnya) && count($fotoLainnya) > 0)
                                        @foreach($fotoLainnya as $foto)
                                            <img src="{{ asset('storage/' . $foto) }}" 
                                                 alt="Foto lainnya" 
                                                 class="rounded-3" 
                                                 style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #e2e8f0;">
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Proses</span>
                        <span>100%</span>
                    </div>
                    <div class="progress" style="height: 6px; border-radius: 10px; background: #e2e8f0; overflow: hidden;">
                        <div class="progress-bar" role="progressbar" style="width: 100%; background: linear-gradient(90deg, #059669, #34d399); border-radius: 10px;"></div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex gap-3 justify-content-center mt-4 pt-3 border-top" style="border-color: #f1f5f9 !important;">
                    <a href="{{ route('pelatih.dokumentasi') }}" class="btn btn-primary rounded-pill px-5 py-2" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; box-shadow: 0 4px 16px rgba(14,165,233,0.25); transition: all 0.3s ease;">
                        <i class="fas fa-images me-2"></i> Lihat Dokumentasi
                    </a>
                    <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2" style="border: 2px solid #e2e8f0; color: #64748b; font-weight: 500; transition: all 0.3s ease;">
                        <i class="fas fa-plus me-2"></i> Tambah Lagi
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer border-0 bg-transparent px-5 pb-4 text-center">
                <small class="text-muted" style="color: #94a3b8; font-size: 12px;">
                    <i class="far fa-clock me-1"></i>
                    Diunggah pada {{ $dokumentasi->created_at->format('d F Y, H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulseSuccess {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(14,165,233,0.4) !important;
    }
    
    .btn-outline-secondary:hover {
        background: #f8fafc;
        transform: translateY(-3px);
        border-color: #94a3b8;
    }
    
    @media (max-width: 768px) {
        .card-body { padding: 20px !important; }
        .card-header { padding: 30px 20px !important; }
        .btn { width: 100%; justify-content: center; }
        .d-flex.gap-3 { flex-direction: column; }
    }
</style>
@endsection