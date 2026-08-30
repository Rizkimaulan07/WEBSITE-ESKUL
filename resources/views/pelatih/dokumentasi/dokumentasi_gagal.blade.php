@extends('layouts.app')

@section('title', 'Gagal Menambahkan Dokumentasi')
@section('subtitle', 'Terjadi kesalahan saat menyimpan dokumentasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #ffffff;">
            <!-- Header Premium - Gradien Merah dengan Animasi -->
            <div class="card-header border-0 py-5 px-5 text-center position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #b91c1c 0%, #dc2626 40%, #ef4444 80%, #f87171 100%);">
                <!-- Decorative Shapes -->
                <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.08; background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22white%22/></svg>') no-repeat; background-size: 300px; background-position: -50px -50px;"></div>
                <div class="position-absolute bottom-0 end-0" style="opacity: 0.06; width: 200px; height: 200px; background: radial-gradient(circle, white, transparent 70%); border-radius: 50%;"></div>
                
                <!-- Icon Gagal dengan Animasi -->
                <div class="position-relative" style="z-index: 1;">
                    <div class="bg-white bg-opacity-20 rounded-circle p-4 d-inline-block" style="backdrop-filter: blur(12px); border: 2px solid rgba(255,255,255,0.2); animation: shakeError 0.8s ease;">
                        <i class="fas fa-times-circle fa-4x text-white" style="filter: drop-shadow(0 4px 20px rgba(255,255,255,0.3));"></i>
                    </div>
                    <h3 class="text-white fw-bold mt-3 mb-1" style="font-size: 26px; letter-spacing: -0.5px;">❌ Gagal!</h3>
                    <p class="text-white-50 mb-0" style="font-weight: 400; font-size: 15px;">Terjadi kesalahan saat menyimpan dokumentasi</p>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-5">
                <!-- Alert Error -->
                <div class="alert alert-danger rounded-4 border-0 shadow-sm d-flex align-items-start gap-3" style="background: #fef2f2; border-left: 4px solid #dc2626;">
                    <i class="fas fa-exclamation-circle fa-2x text-danger mt-1"></i>
                    <div>
                        <strong style="color: #991b1b;">Mohon Maaf!</strong>
                        <p class="mb-0" style="color: #7f1d1d; font-size: 14px;">
                            {{ $error ?? 'Terjadi kesalahan saat menyimpan dokumentasi. Silakan coba lagi.' }}
                        </p>
                    </div>
                </div>

                <!-- Tips/Info -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3" style="color: #0f172a;">
                        <i class="fas fa-lightbulb me-2" style="color: #f59e0b;"></i>
                        Tips Mengatasi:
                    </h6>
                    <ul class="list-unstyled" style="color: #475569;">
                        <li class="d-flex align-items-start gap-2 mb-2">
                            <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 14px;"></i>
                            <span>Pastikan file yang diupload adalah gambar (JPG, PNG, WEBP)</span>
                        </li>
                        <li class="d-flex align-items-start gap-2 mb-2">
                            <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 14px;"></i>
                            <span>Ukuran file maksimal 5MB per foto</span>
                        </li>
                        <li class="d-flex align-items-start gap-2 mb-2">
                            <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 14px;"></i>
                            <span>Pastikan Anda memiliki ekstrakurikuler yang aktif</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 14px;"></i>
                            <span>Minimal upload 1 foto dokumentasi</span>
                        </li>
                    </ul>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex gap-3 justify-content-center mt-4 pt-3 border-top" style="border-color: #f1f5f9 !important;">
                    <a href="{{ route('pelatih.dokumentasi.create') }}" class="btn btn-primary rounded-pill px-5 py-2" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; box-shadow: 0 4px 16px rgba(14,165,233,0.25); transition: all 0.3s ease;">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                    <a href="{{ route('pelatih.dokumentasi') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2" style="border: 2px solid #e2e8f0; color: #64748b; font-weight: 500; transition: all 0.3s ease;">
                        <i class="fas fa-images me-2"></i> Lihat Dokumentasi
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer border-0 bg-transparent px-5 pb-4 text-center">
                <small class="text-muted" style="color: #94a3b8; font-size: 12px;">
                    <i class="fas fa-info-circle me-1"></i>
                    Jika masalah berlanjut, hubungi administrator
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes shakeError {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
        20%, 40%, 60%, 80% { transform: translateX(10px); }
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