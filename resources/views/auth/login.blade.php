@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="logo">
    <div class="logo-icon animate-float">
        <i class="bi bi-grid-1x2-fill"></i>
    </div>
    <h3 class="fw-bold">Selamat Datang</h3>
    <p class="subtitle">Silakan login untuk melanjutkan</p>
</div>

<!-- Session Status -->
@if (session('status'))
    <div class="alert-custom success fade-in-up">
        <i class="bi bi-check-circle-fill alert-icon"></i>
        {{ session('status') }}
    </div>
@endif

<!-- Error Message -->
@if ($errors->any())
    <div class="alert-custom shake">
        <i class="bi bi-exclamation-circle-fill alert-icon"></i>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('login') }}" id="loginForm">
    @csrf

    <!-- Email -->
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email', 'admin@mail.com') }}" 
               placeholder="Masukkan email Anda"
               required 
               autofocus>
        <i class="bi bi-envelope input-icon"></i>
        @error('email')
            <small class="text-danger mt-1 d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- Password -->
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               id="password" 
               name="password" 
               placeholder="Masukkan password Anda"
               value="password"
               required>
        <i class="bi bi-lock input-icon"></i>
        <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
            <i class="bi bi-eye"></i>
        </button>
        @error('password')
            <small class="text-danger mt-1 d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- Remember & Forgot -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="form-check-custom">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">Ingat Saya</label>
        </div>
        @if (Route::has('password.request'))
            <a class="forgot-link" href="{{ route('password.request') }}">
                Lupa Password?
            </a>
        @endif
    </div>

    <!-- Button -->
    <button type="submit" class="btn-auth" id="loginBtn">
        <span class="btn-text">Login <i class="bi bi-arrow-right ms-2"></i></span>
        <span class="spinner"></span>
    </button>
</form>

<!-- Footer -->
<div class="auth-footer">
    <p class="mb-2">
        <span class="badge-role admin"><i class="bi bi-shield-check me-1"></i>Admin</span>
        <span class="badge-role pelatih"><i class="bi bi-person-badge me-1"></i>Pelatih</span>
        <span class="badge-role anggota"><i class="bi bi-person me-1"></i>Anggota</span>
    </p>
    <p class="mt-2">
        <small class="text-muted">Demo: <strong>admin@mail.com</strong> / <strong>password</strong></small>
    </p>
    <div class="mt-2 d-flex justify-content-center gap-2">
        <span class="badge bg-light text-dark px-3 py-2">
            <i class="bi bi-arrow-right me-1"></i> Login sebagai:
        </span>
        <button class="badge bg-primary px-3 py-2 border-0 quick-login" data-email="admin@mail.com" data-password="password">
            Admin
        </button>
        <button class="badge bg-success px-3 py-2 border-0 quick-login" data-email="pelatih@mail.com" data-password="password">
            Pelatih
        </button>
        <button class="badge bg-warning px-3 py-2 border-0 quick-login" data-email="anggota1@mail.com" data-password="password">
            Anggota
        </button>
    </div>
    <p class="mt-3" style="font-size: 11px; color: #d1d5db;">
        &copy; {{ date('Y') }} Sistem Ekskul v3.0
    </p>
</div>

@push('scripts')
<script>
    // Quick Login
    document.querySelectorAll('.quick-login').forEach(btn => {
        btn.addEventListener('click', function() {
            const email = this.dataset.email;
            const password = this.dataset.password;
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            document.getElementById('loginForm').submit();
        });
    });

    // Loading state
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('loginBtn');
        btn.classList.add('loading');
        btn.disabled = true;
    });
</script>
@endpush
@endsection