@extends('layouts.guest')

@section('title', 'Verifikasi Email')

@section('content')
<div class="logo">
    <div class="logo-icon" style="background: linear-gradient(135deg, #2ED573, #059669);">
        <i class="bi bi-envelope-check-fill"></i>
    </div>
    <h3>Verifikasi Email</h3>
    <p class="subtitle">Kami telah mengirim link verifikasi ke email Anda</p>
</div>

<div class="alert-custom success">
    <i class="bi bi-check-circle-fill alert-icon"></i>
    Link verifikasi telah dikirim ke <strong>{{ Auth::user()->email }}</strong>
</div>

<p class="text-muted text-center mb-4" style="font-size: 14px;">
    Sebelum melanjutkan, silakan cek email Anda untuk link verifikasi.
    Jika tidak menerima email, klik tombol di bawah untuk mengirim ulang.
</p>

@if (session('status') == 'verification-link-sent')
    <div class="alert-custom success">
        <i class="bi bi-check-circle-fill alert-icon"></i>
        Link verifikasi baru telah dikirim ke email Anda.
    </div>
@endif

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="btn-auth">
        <span class="btn-text">Kirim Ulang Verifikasi <i class="bi bi-arrow-right ms-2"></i></span>
        <span class="spinner"></span>
    </button>
</form>

<!-- Footer -->
<div class="auth-footer">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link text-decoration-none p-0" style="color: var(--primary); font-weight: 600;">
            Logout
        </button>
    </form>
</div>
@endsection