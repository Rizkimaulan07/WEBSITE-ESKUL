@extends('layouts.guest')

@section('title', 'Konfirmasi Password')

@section('content')
<div class="logo">
    <div class="logo-icon" style="background: linear-gradient(135deg, #FF6B6B, #FF4757);">
        <i class="bi bi-shield-lock-fill"></i>
    </div>
    <h3>Konfirmasi Password</h3>
    <p class="subtitle">Masukkan password Anda untuk melanjutkan</p>
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

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <!-- Password -->
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               id="password" 
               name="password" 
               placeholder="Masukkan password Anda"
               required>
        <i class="bi bi-lock input-icon"></i>
        <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
            <i class="bi bi-eye"></i>
        </button>
        @error('password')
            <small class="text-danger mt-1 d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- Button -->
    <button type="submit" class="btn-auth">
        <span class="btn-text">Konfirmasi <i class="bi bi-arrow-right ms-2"></i></span>
        <span class="spinner"></span>
    </button>
</form>

<!-- Footer -->
<div class="auth-footer">
    <p><a href="{{ route('login') }}">Kembali ke Login</a></p>
</div>
@endsection 