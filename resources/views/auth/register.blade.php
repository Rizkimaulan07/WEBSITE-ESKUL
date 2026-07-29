@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="logo">
    <div class="logo-icon animate-float" style="background: linear-gradient(135deg, #2ED573, #059669);">
        <i class="bi bi-person-plus-fill"></i>
    </div>
    <h3 class="fw-bold">Daftar Akun</h3>
    <p class="subtitle">Bergabunglah dengan komunitas kami</p>
</div>

@if ($errors->any())
    <div class="alert-custom shake">
        <i class="bi bi-exclamation-circle-fill alert-icon"></i>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="row g-3">
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       placeholder="Masukkan nama Anda"
                       required>
                <i class="bi bi-person input-icon"></i>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="Masukkan email Anda"
                       required>
                <i class="bi bi-envelope input-icon"></i>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="Minimal 8 karakter"
                       required>
                <i class="bi bi-lock input-icon"></i>
                <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="Ketik ulang password"
                       required>
                <i class="bi bi-check-circle input-icon"></i>
            </div>
        </div>
    </div>

    <button type="submit" class="btn-auth mt-3">
        <span class="btn-text">Daftar <i class="bi bi-arrow-right ms-2"></i></span>
        <span class="spinner"></span>
    </button>
</form>

<div class="auth-footer">
    <p>Sudah punya akun? 
        <a href="{{ route('login') }}">Login di sini</a>
    </p>
</div>
@endsection