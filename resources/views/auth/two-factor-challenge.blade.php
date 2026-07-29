@extends('layouts.guest')

@section('title', 'Verifikasi 2FA')

@section('content')
<div class="logo">
    <div class="logo-icon" style="background: linear-gradient(135deg, #6C63FF, #3D3B8A);">
        <i class="bi bi-shield-check"></i>
    </div>
    <h3>Verifikasi Dua Faktor</h3>
    <p class="subtitle">Masukkan kode dari aplikasi authenticator Anda</p>
</div>

<!-- Error Message -->
@if ($errors->any())
    <div class="alert-custom">
        <i class="bi bi-exclamation-circle-fill alert-icon"></i>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('two-factor.login') }}">
    @csrf

    <!-- Code -->
    <div class="form-group">
        <label for="code">Kode Authenticator</label>
        <input type="text" 
               class="form-control @error('code') is-invalid @enderror" 
               id="code" 
               name="code" 
               placeholder="Masukkan 6 digit kode"
               required>
        <i class="bi bi-shield-lock input-icon"></i>
        @error('code')
            <small class="text-danger mt-1 d-block">{{ $message }}</small>
        @enderror
    </div>

    <div class="text-center mb-3">
        <small class="text-muted">Atau gunakan salah satu recovery code</small>
    </div>

    <!-- Recovery Code -->
    <div class="form-group">
        <label for="recovery_code">Recovery Code</label>
        <input type="text" 
               class="form-control @error('recovery_code') is-invalid @enderror" 
               id="recovery_code" 
               name="recovery_code" 
               placeholder="Masukkan recovery code"
               required>
        <i class="bi bi-key input-icon"></i>
        @error('recovery_code')
            <small class="text-danger mt-1 d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- Button -->
    <button type="submit" class="btn-auth">
        <span class="btn-text">Verifikasi <i class="bi bi-arrow-right ms-2"></i></span>
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