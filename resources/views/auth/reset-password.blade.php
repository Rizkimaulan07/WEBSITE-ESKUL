@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<div class="logo">
    <div class="logo-icon" style="background: linear-gradient(135deg, #FFA502, #F97316);">
        <i class="bi bi-arrow-repeat"></i>
    </div>
    <h3>Reset Password</h3>
    <p class="subtitle">Buat password baru untuk akun Anda</p>
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

<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <!-- Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Email -->
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email', $request->email) }}" 
               placeholder="Masukkan email Anda"
               required>
        <i class="bi bi-envelope input-icon"></i>
        @error('email')
            <small class="text-danger mt-1 d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- Password -->
    <div class="form-group">
        <label for="password">Password Baru</label>
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
            <small class="text-danger mt-1 d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password Baru</label>
        <input type="password" 
               class="form-control" 
               id="password_confirmation" 
               name="password_confirmation" 
               placeholder="Ketik ulang password"
               required>
        <i class="bi bi-check-circle input-icon"></i>
    </div>

    <!-- Button -->
    <button type="submit" class="btn-auth">
        <span class="btn-text">Reset Password <i class="bi bi-arrow-right ms-2"></i></span>
        <span class="spinner"></span>
    </button>
</form>

<!-- Footer -->
<div class="auth-footer">
    <p>Ingat password? 
        <a href="{{ route('login') }}">Kembali Login</a>
    </p>
</div>
@endsection