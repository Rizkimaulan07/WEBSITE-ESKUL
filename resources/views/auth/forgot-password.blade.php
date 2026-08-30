@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
<div class="logo">
    <div class="logo-icon animate-float" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); box-shadow: 0 8px 30px rgba(14,165,233,0.25);">
        <i class="bi bi-key-fill"></i>
    </div>
    <h3 class="fw-bold" style="color: #0f172a;">Lupa Password</h3>
    <p class="subtitle" style="color: #64748b;">Masukkan email dan kode OTP untuk mengganti password</p>
</div>

@if (session('status'))
    <div class="alert-custom success" style="background: #d1fae5; border-left: 4px solid #10b981; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; color: #065f46;">
        <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 18px;"></i>
        <span>{!! session('status') !!}</span>
    </div>
@endif

@if ($errors->any())
    <div class="alert-custom error" style="background: #fee2e2; border-left: 4px solid #dc2626; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px;">
        <i class="bi bi-exclamation-circle-fill" style="color: #dc2626; font-size: 18px;"></i>
        <div style="color: #991b1b;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
@endif

@if (!session('reset_otp'))
    <!-- ===== FORM 1: MASUKKAN EMAIL ===== -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="email" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block;">
                <i class="bi bi-envelope me-2" style="color: #0ea5e9;"></i> Alamat Email
            </label>
            <div class="input-wrapper" style="position: relative;">
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="Masukkan alamat email Anda"
                       required
                       style="width: 100%; padding: 14px 16px 14px 48px; border: 2px solid #e5e7eb; border-radius: 14px; font-size: 14px; font-family: 'Inter', sans-serif; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                <i class="bi bi-envelope input-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 16px;"></i>
                @error('email')
                    <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn-auth" style="width: 100%; padding: 16px; border: none; border-radius: 14px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 15px; font-weight: 600; font-family: 'Inter', sans-serif; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer; box-shadow: 0 4px 24px rgba(14,165,233,0.25);">
            <span class="btn-text"><i class="bi bi-send me-2"></i>Kirim Kode OTP</span>
            <span class="spinner"></span>
        </button>
    </form>

@else
    <!-- ===== FORM 2: GANTI PASSWORD ===== -->
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="email" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block;">
                <i class="bi bi-envelope me-2" style="color: #0ea5e9;"></i> Alamat Email
            </label>
            <div class="input-wrapper" style="position: relative;">
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', session('reset_email')) }}" 
                       placeholder="Masukkan alamat email Anda"
                       required
                       style="width: 100%; padding: 14px 16px 14px 48px; border: 2px solid #e5e7eb; border-radius: 14px; font-size: 14px; font-family: 'Inter', sans-serif; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                <i class="bi bi-envelope input-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 16px;"></i>
                @error('email')
                    <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="otp" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block;">
                <i class="bi bi-shield-lock me-2" style="color: #0ea5e9;"></i> Kode OTP
            </label>
            <div class="input-wrapper" style="position: relative;">
                <input type="text" 
                       class="form-control @error('otp') is-invalid @enderror" 
                       id="otp" 
                       name="otp" 
                       placeholder="Masukkan 6 digit kode"
                       required
                       style="width: 100%; padding: 14px 16px 14px 48px; border: 2px solid #e5e7eb; border-radius: 14px; font-size: 14px; font-family: 'Inter', sans-serif; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                <i class="bi bi-shield-lock input-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 16px;"></i>
                @error('otp')
                    <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="password" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block;">
                <i class="bi bi-lock me-2" style="color: #0ea5e9;"></i> Password Baru
            </label>
            <div class="input-wrapper" style="position: relative;">
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="Minimal 6 karakter"
                       required
                       style="width: 100%; padding: 14px 16px 14px 48px; border: 2px solid #e5e7eb; border-radius: 14px; font-size: 14px; font-family: 'Inter', sans-serif; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                <i class="bi bi-lock input-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 16px;"></i>
                <button type="button" class="toggle-password" onclick="togglePassword('password', this)" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; cursor: pointer; padding: 8px; border-radius: 8px; transition: all 0.3s ease;">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')
                    <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="password_confirmation" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block;">
                <i class="bi bi-check-circle me-2" style="color: #0ea5e9;"></i> Konfirmasi Password
            </label>
            <div class="input-wrapper" style="position: relative;">
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="Ketik ulang password"
                       required
                       style="width: 100%; padding: 14px 16px 14px 48px; border: 2px solid #e5e7eb; border-radius: 14px; font-size: 14px; font-family: 'Inter', sans-serif; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
                <i class="bi bi-check-circle input-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 16px;"></i>
                <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; cursor: pointer; padding: 8px; border-radius: 8px; transition: all 0.3s ease;">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-auth" style="width: 100%; padding: 16px; border: none; border-radius: 14px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 15px; font-weight: 600; font-family: 'Inter', sans-serif; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer; box-shadow: 0 4px 24px rgba(14,165,233,0.25);">
            <span class="btn-text"><i class="bi bi-arrow-right me-2"></i>Reset Password</span>
            <span class="spinner"></span>
        </button>
    </form>

    <div class="auth-footer" style="text-align: center; margin-top: 20px; color: #64748b; font-size: 13px;">
        <p id="countdownText">Kode OTP salah? <a href="{{ route('password.request') }}" style="color: #0ea5e9; text-decoration: none; font-weight: 600;">Kirim ulang</a></p>
        <p id="cooldownText" style="display: none; color: #64748b;">Mohon tunggu <span id="timer">60</span> detik untuk mengirim ulang.</p>
    </div>
@endif

<div class="auth-footer" style="text-align: center; margin-top: 20px; color: #64748b; font-size: 13px;">
    <p>Ingat password? 
        <a href="{{ route('login') }}" style="color: #0ea5e9; text-decoration: none; font-weight: 600;">Kembali Login</a>
    </p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownText = document.getElementById('countdownText');
        const cooldownText = document.getElementById('cooldownText');
        const timerSpan = document.getElementById('timer');
        
        let timeLeft = 60;
        
        if (countdownText) {
            countdownText.style.display = 'none';
        }
        
        if (cooldownText) {
            cooldownText.style.display = 'block';
        }
        
        const interval = setInterval(function() {
            timeLeft--;
            
            if (timerSpan) {
                timerSpan.textContent = timeLeft;
            }
            
            if (timeLeft <= 0) {
                clearInterval(interval);
                
                if (countdownText) {
                    countdownText.style.display = 'block';
                }
                
                if (cooldownText) {
                    cooldownText.style.display = 'none';
                }
            }
        }, 1000);
    });

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