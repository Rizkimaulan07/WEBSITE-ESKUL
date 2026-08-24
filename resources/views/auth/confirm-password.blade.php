@extends('layouts.guest')

@section('title', 'Konfirmasi Password')

@section('content')
<div class="logo">
    <div class="logo-icon" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); box-shadow: 0 8px 30px rgba(14,165,233,0.25);">
        <i class="bi bi-shield-lock-fill"></i>
    </div>
    <h3 style="color: #0f172a;">Konfirmasi Password</h3>
    <p class="subtitle" style="color: #64748b;">Masukkan password Anda untuk melanjutkan</p>
</div>

@if ($errors->any())
    <div class="alert-custom" style="background: #fee2e2; border-left: 4px solid #dc2626; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px;">
        <i class="bi bi-exclamation-circle-fill alert-icon" style="color: #dc2626; font-size: 18px;"></i>
        <div style="color: #991b1b;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
@endif

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="password" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block;">Password</label>
        <div class="input-wrapper" style="position: relative;">
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password" 
                   placeholder="Masukkan password Anda"
                   required
                   style="width: 100%; padding: 14px 16px 14px 48px; border: 2px solid #e5e7eb; border-radius: 14px; font-size: 14px; font-family: 'Inter', sans-serif; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
            <i class="bi bi-lock input-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 16px;"></i>
            <button type="button" class="toggle-password" onclick="togglePassword('password', this)" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 8px;">
                <i class="bi bi-eye"></i>
            </button>
            @error('password')
                <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn-auth" style="width: 100%; padding: 16px; border: none; border-radius: 14px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 15px; font-weight: 600; font-family: 'Inter', sans-serif; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer; box-shadow: 0 4px 24px rgba(14,165,233,0.25);">
        <span class="btn-text">Konfirmasi <i class="bi bi-arrow-right ms-2"></i></span>
        <span class="spinner"></span>
    </button>
</form>

<div class="auth-footer" style="text-align: center; margin-top: 20px; color: #94a3b8; font-size: 13px;">
    <p><a href="{{ route('login') }}" style="color: #0ea5e9; text-decoration: none; font-weight: 600;">Kembali ke Login</a></p>
</div>

<script>
    function togglePassword(fieldId, button) {
        const input = document.getElementById(fieldId);
        const icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
@endsection