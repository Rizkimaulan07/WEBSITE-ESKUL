@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
<div class="logo">
    <div class="logo-icon animate-float" style="background: linear-gradient(135deg, #FF6B6B, #FF4757);">
        <i class="bi bi-key-fill"></i>
    </div>
    <h3 class="fw-bold">Lupa Password</h3>
    <p class="subtitle">Kami akan kirim link reset ke email Anda</p>
</div>

@if (session('status'))
    <div class="alert-custom success fade-in-up">
        <i class="bi bi-check-circle-fill alert-icon"></i>
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert-custom shake">
        <i class="bi bi-exclamation-circle-fill alert-icon"></i>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

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

    <button type="submit" class="btn-auth">
        <span class="btn-text">Kirim Link Reset <i class="bi bi-send ms-2"></i></span>
        <span class="spinner"></span>
    </button>
</form>

<div class="auth-footer">
    <p>Ingat password? 
        <a href="{{ route('login') }}">Kembali Login</a>
    </p>
</div>
@endsection