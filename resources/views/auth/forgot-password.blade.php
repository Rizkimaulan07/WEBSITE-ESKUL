@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
@if (session('status'))
    <div class="alert-custom success" style="background: #d1fae5; border-left: 4px solid #10b981; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px; color: #065f46;">
        <i class="fas fa-envelope-circle-check" style="color: #10b981; font-size: 18px; flex-shrink: 0;"></i>
        <span>{!! session('status') !!}</span>
    </div>
@endif

@if (session('error'))
    <div class="alert-custom" style="background: #fee2e2; border-left: 4px solid #dc2626; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px;">
        <i class="fas fa-clock-rotate-left" style="color: #dc2626; font-size: 18px; flex-shrink: 0;"></i>
        <span style="color: #991b1b;">{{ session('error') }}</span>
    </div>
@endif

@if (session('dev_otp'))
    <div class="alert-custom" style="background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; color: #92400e;">
        <i class="fas fa-circle-info" style="color: #f59e0b; font-size: 18px; flex-shrink: 0;"></i>
        <span>
            <strong>Mode Pengembangan:</strong> Email tidak terkirim otomatis (SMTP belum dikonfigurasi).<br>
            Kode OTP Anda: <strong style="font-size: 20px; letter-spacing: 4px; color: #b45309;">{{ session('dev_otp') }}</strong>
        </span>
    </div>
@endif

@if ($errors->any())
    <div class="alert-custom" style="background: #fee2e2; border-left: 4px solid #dc2626; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px;">
        <i class="fas fa-exclamation-circle" style="color: #dc2626; font-size: 18px; flex-shrink: 0;"></i>
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

        <div class="form-group">
            <label for="email"><i class="fas fa-envelope me-2" style="color: #0ea5e9;"></i> Alamat Email</label>
            <div class="input-wrapper">
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="Masukkan alamat email Anda"
                       required>
                <i class="fas fa-envelope input-icon"></i>
                @error('email')
                    <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn-auth" style="width: 100%; padding: 16px; border: none; border-radius: 14px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 15px; font-weight: 600; font-family: 'Inter', sans-serif; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer; box-shadow: 0 4px 24px rgba(14,165,233,0.25); display: flex; align-items: center; justify-content: center; gap: 10px;">
            <span class="btn-text"><i class="fas fa-paper-plane me-2"></i>Kirim Kode OTP</span>
            <span class="spinner"></span>
        </button>
    </form>

@else
    <!-- ===== FORM 2: GANTI PASSWORD ===== -->
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <div class="info-box" style="background: #f0f9ff; border: 1px solid rgba(14,165,233,0.15); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 13px; color: #0c4a6e;">
            <i class="fas fa-shield-check" style="color: #0ea5e9; font-size: 18px; flex-shrink: 0;"></i>
            <span>Kode OTP telah dikirim ke email Anda. Masukkan kode 6 digit untuk melanjutkan.</span>
        </div>

        <div class="form-group">
            <label for="email"><i class="fas fa-envelope me-2" style="color: #0ea5e9;"></i> Alamat Email</label>
            <div class="input-wrapper">
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       value="{{ old('email', session('reset_email')) }}"
                       placeholder="Masukkan alamat email Anda"
                       required>
                <i class="fas fa-envelope input-icon"></i>
                @error('email')
                    <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="otp"><i class="fas fa-lock me-2" style="color: #0ea5e9;"></i> Kode OTP</label>
            <div class="input-wrapper">
                <input type="text"
                       class="form-control @error('otp') is-invalid @enderror"
                       id="otp"
                       name="otp"
                       placeholder="Masukkan 6 digit kode"
                       maxlength="6"
                       inputmode="numeric"
                       required>
                <i class="fas fa-lock input-icon"></i>
                @error('otp')
                    <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="password"><i class="fas fa-lock me-2" style="color: #0ea5e9;"></i> Password Baru</label>
            <div class="input-wrapper">
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       placeholder="Minimal 6 karakter"
                       required>
                <i class="fas fa-lock input-icon"></i>
                <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                    <i class="fas fa-eye"></i>
                </button>
                @error('password')
                    <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirmation"><i class="fas fa-circle-check me-2" style="color: #0ea5e9;"></i> Konfirmasi Password</label>
            <div class="input-wrapper">
                <input type="password"
                       class="form-control"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Ketik ulang password"
                       required>
                <i class="fas fa-circle-check input-icon"></i>
                <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        @php
            $remaining = 60;
            $sentAt = session('reset_otp_sent_at');
            if ($sentAt) {
                $sentTs = is_numeric($sentAt) ? (int) $sentAt : now()->timestamp;
                $remaining = max(0, 60 - (now()->timestamp - $sentTs));
            }
        @endphp
        <div class="resend-section" style="text-align: center; margin: 8px 0 14px; color: #64748b; font-size: 13px;">
            <p id="cooldownText" style="{{ $remaining > 0 ? 'display: block;' : 'display: none;' }}; color: #64748b; margin-bottom: 10px;">
                <i class="fas fa-clock-rotate-left" style="color: #0ea5e9; margin-right: 6px;"></i>
                Kirim ulang dalam <span id="timer" style="font-weight: 700; color: #0ea5e9;">{{ $remaining }}</span> detik
            </p>

            <input type="hidden" name="resend_email" id="resendEmail" value="{{ session('reset_email') }}">
            <button type="button" id="resendBtn" class="btn-resend" onclick="resendOtp(this)" {{ $remaining > 0 ? 'disabled' : '' }}
                style="width: 100%; background: {{ $remaining > 0 ? 'linear-gradient(135deg, #94a3b8, #cbd5e1)' : 'linear-gradient(135deg, #0ea5e9, #38bdf8)' }}; color: {{ $remaining > 0 ? '#f1f5f9' : '#fff' }}; padding: 12px 28px; border: none; border-radius: 14px; font-weight: 600; font-family: 'Inter', sans-serif; font-size: 14px; cursor: {{ $remaining > 0 ? 'not-allowed' : 'pointer' }}; transition: all 0.3s ease; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: {{ $remaining > 0 ? 'none' : '0 4px 16px rgba(14,165,233,0.3)' }}; margin-bottom: 12px; opacity: 1;">
                <i class="fas fa-rotate-left"></i> Reset Kode OTP
            </button>
        </div>

        <button type="submit" class="btn-auth" style="width: 100%; padding: 16px; border: none; border-radius: 14px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 15px; font-weight: 600; font-family: 'Inter', sans-serif; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer; box-shadow: 0 4px 24px rgba(14,165,233,0.25); display: flex; align-items: center; justify-content: center; gap: 10px;">
            <span class="btn-text"><i class="fas fa-arrow-right me-2"></i>Reset Password</span>
            <span class="spinner"></span>
        </button>
    </form>
@endif

<div class="auth-footer" style="text-align: center; margin-top: 20px; color: #64748b; font-size: 13px;">
    <p>Ingat password?
        <a href="{{ route('login') }}" style="color: #0ea5e9; text-decoration: none; font-weight: 600;">Kembali Login</a>
    </p>
</div>

<script>
    function togglePassword(fieldId, button) {
        const input = document.getElementById(fieldId);
        const icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }
</script>

@if (session('reset_otp'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cooldownText = document.getElementById('cooldownText');
        const resendBtn = document.getElementById('resendBtn');
        const timerSpan = document.getElementById('timer');

        if (!cooldownText || !resendBtn || !timerSpan) return;

        let timeLeft = {{ $remaining ?? 0 }};

        function render() {
            if (timerSpan) timerSpan.textContent = Math.max(0, timeLeft);

            if (timeLeft <= 0) {
                cooldownText.style.display = 'none';
                resendBtn.disabled = false;
                resendBtn.style.cursor = 'pointer';
                resendBtn.style.background = 'linear-gradient(135deg, #0ea5e9, #38bdf8)';
                resendBtn.style.color = '#fff';
                resendBtn.style.boxShadow = '0 4px 16px rgba(14,165,233,0.3)';
                return true;
            }
            return false;
        }

        if (render()) return;

        const interval = setInterval(function() {
            timeLeft--;
            if (render()) clearInterval(interval);
        }, 1000);
    });

    function resendOtp(btn) {
        const email = document.getElementById('resendEmail').value;
        const token = document.querySelector('meta[name="csrf-token"]').content;

        if (btn) {
            const original = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-repeat" style="display:inline-block;animation:fa-spin 1s linear infinite;"></i> Mengirim...';
        }

        fetch('{{ route("password.resend") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.success !== undefined && !data.success) {
                alert(data.message || 'Gagal mengirim ulang kode.');
                if (btn) { btn.disabled = false; btn.innerHTML = original; }
                return;
            }
            location.reload();
        })
        .catch(function() {
            if (btn) { btn.disabled = false; btn.innerHTML = original; }
            alert('Terjadi kesalahan. Coba lagi.');
        });
    }
</script>
@endif
@endsection
