@extends('layouts.guest')

@section('title', 'Verifikasi Email')

@section('content')
<div class="logo">
    <div class="logo-icon" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); box-shadow: 0 8px 30px rgba(14,165,233,0.25); transition: all 0.3s ease;">
        <i class="bi bi-envelope-check-fill text-white"></i>
    </div>
    <h3 style="color: #0f172a; font-weight: 700; font-size: 24px; margin-bottom: 4px;">Verifikasi Email</h3>
    <p class="subtitle" style="color: #64748b; font-size: 14px; margin-bottom: 0;">Kami telah mengirim link verifikasi ke email Anda</p>
</div>

<!-- ===== NOTIFIKASI UTAMA (SELALU TAMPIL) ===== -->
<div class="alert-custom success" style="background: #d1fae5; border-left: 4px solid #10b981; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
    <i class="bi bi-check-circle-fill alert-icon" style="color: #10b981; font-size: 20px;"></i>
    <div style="color: #065f46; font-size: 14px;">
        Link verifikasi telah dikirim ke <strong style="color: #047857;">{{ Auth::user()->email }}</strong>
    </div>
</div>

<!-- ===== NOTIFIKASI JIKA BARU DIKIRIM ULANG ===== -->
@if (session('status') == 'verification-link-sent')
    <div class="alert-custom success" style="background: #d1fae5; border-left: 4px solid #10b981; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; animation: fadeIn 0.5s ease;">
        <i class="bi bi-check-circle-fill alert-icon" style="color: #10b981; font-size: 20px;"></i>
        <span style="color: #065f46; font-size: 14px;">Link verifikasi baru telah dikirim ke email Anda.</span>
    </div>
@endif

<!-- ===== TIPS CEK SPAM ===== -->
<div class="alert-custom warning" style="background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
    <i class="bi bi-exclamation-triangle-fill alert-icon" style="color: #f59e0b; font-size: 20px;"></i>
    <div style="color: #92400e; font-size: 14px;">
        <strong>Email tidak masuk?</strong> Coba periksa folder <strong>Spam / Junk</strong> di email Anda.
    </div>
</div>

<p class="text-muted text-center mb-4" style="color: #64748b; font-size: 14px; line-height: 1.6;">
    Sebelum melanjutkan, silakan cek email Anda untuk link verifikasi.<br>
    Jika tidak menerima email, klik tombol di bawah untuk mengirim ulang.
</p>

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="btn-auth" style="width: 100%; padding: 16px; border: none; border-radius: 14px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 15px; font-weight: 600; font-family: 'Inter', sans-serif; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer; box-shadow: 0 4px 24px rgba(14,165,233,0.25); display: flex; align-items: center; justify-content: center; gap: 10px;">
        <span class="btn-text">Kirim Ulang Verifikasi <i class="bi bi-arrow-right ms-2"></i></span>
        <span class="spinner"></span>
    </button>
</form>

<!-- Footer -->
<div class="auth-footer" style="text-align: center; margin-top: 24px;">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link text-decoration-none p-0" style="color: #0ea5e9; font-weight: 600; border: none; background: none; cursor: pointer; font-size: 14px; transition: color 0.3s ease;">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </button>
    </form>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .logo-icon:hover {
        transform: scale(1.05) rotate(-5deg);
    }

    .btn-auth:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 40px rgba(14,165,233,0.4);
    }

    .btn-auth:active {
        transform: translateY(0);
    }

    .btn-link:hover {
        color: #0284c7 !important;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .logo h3 {
            font-size: 20px;
        }
        .logo .subtitle {
            font-size: 13px;
        }
        .btn-auth {
            padding: 14px;
            font-size: 14px;
        }
        .alert-custom {
            padding: 12px 14px;
            font-size: 13px;
        }
    }
</style>
@endsection