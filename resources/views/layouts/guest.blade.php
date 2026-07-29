<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Sistem Ekskul</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6C63FF;
            --primary-dark: #5A52D5;
            --primary-light: #8B83FF;
            --secondary: #FF6B6B;
            --bg-gradient-start: #6C63FF;
            --bg-gradient-end: #3D3B8A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #6C63FF 0%, #3D3B8A 50%, #1a1a3e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Animasi */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .bg-animation .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: floatBg 20s infinite ease-in-out;
        }

        .bg-animation .circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        .bg-animation .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -50px;
            left: -50px;
            animation-delay: -5s;
        }

        .bg-animation .circle:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
        }

        @keyframes floatBg {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(20px, 30px) scale(1.05); }
        }

        /* Kartu Login */
        .login-card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 48px 40px;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.8s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-card .logo-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: white;
            margin-bottom: 16px;
            box-shadow: 0 10px 30px rgba(108, 99, 255, 0.3);
            animation: pulseIcon 2s infinite;
        }

        @keyframes pulseIcon {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .login-card h3 {
            font-weight: 800;
            color: #1a1a2e;
            font-size: 28px;
            margin-bottom: 6px;
        }

        .login-card p.subtitle {
            color: #636e72;
            font-size: 14px;
            margin-bottom: 28px;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            font-weight: 600;
            font-size: 13px;
            color: #2d3436;
            margin-bottom: 6px;
            display: block;
        }

        .form-group .input-icon {
            position: absolute;
            left: 14px;
            top: 42px;
            color: #adb5bd;
            font-size: 18px;
            transition: 0.3s;
        }

        .form-group .form-control {
            padding: 12px 16px 12px 46px;
            border: 2px solid #e1e8ed;
            border-radius: 14px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            color: #2d3436;
            height: 52px;
            width: 100%;
        }

        .form-group .form-control:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.1);
            outline: none;
        }

        .form-group .form-control:focus + .input-icon {
            color: var(--primary);
        }

        .form-group .toggle-password {
            position: absolute;
            right: 14px;
            top: 42px;
            background: none;
            border: none;
            color: #adb5bd;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
            padding: 0;
        }

        .form-group .toggle-password:hover {
            color: var(--primary);
        }

        /* Checkbox */
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            border: 2px solid #d1d5db;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 0;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            font-size: 14px;
            color: #4b5563;
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            font-size: 14px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            margin-left: auto;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Button Login */
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 52px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(108, 99, 255, 0.4);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .btn-login.loading .btn-text {
            display: none;
        }

        .btn-login.loading .spinner {
            display: block;
        }

        /* Error */
        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
            margin-bottom: 16px;
            display: none;
        }

        .alert-error.show {
            display: block;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .login-footer p {
            font-size: 13px;
            color: #9ca3af;
            margin: 0;
        }

        .login-footer .badge-role {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: #e5e7eb;
            color: #4b5563;
            margin: 0 3px;
        }

        .login-footer .badge-role.admin {
            background: #dbeafe;
            color: #2563eb;
        }

        .login-footer .badge-role.pelatih {
            background: #d1fae5;
            color: #059669;
        }

        .login-footer .badge-role.anggota {
            background: #fef3c7;
            color: #d97706;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 20px;
                border-radius: 24px;
            }

            .login-card h3 {
                font-size: 24px;
            }

            .login-card .logo-icon {
                width: 60px;
                height: 60px;
                font-size: 28px;
            }

            .form-group .form-control {
                height: 48px;
                padding: 10px 14px 10px 42px;
                font-size: 13px;
            }

            .form-group .input-icon {
                top: 40px;
                font-size: 16px;
            }

            .btn-login {
                height: 48px;
                font-size: 15px;
            }

            .form-check-label {
                font-size: 13px;
            }

            .forgot-link {
                font-size: 13px;
            }
        }

        @media (max-width: 360px) {
            .login-card {
                padding: 24px 16px;
            }

            .login-card h3 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <!-- Login Card -->
    <div class="login-card" data-aos="fade-up" data-aos-duration="800">
        <div class="logo">
            <div class="logo-icon">
                <i class="bi bi-grid-1x2-fill"></i>
            </div>
            <h3>Selamat Datang</h3>
            <p class="subtitle">Silakan login untuk melanjutkan</p>
        </div>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="alert-error show">
                @foreach ($errors->all() as $error)
                    <div><i class="bi bi-exclamation-circle me-2"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
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
                       required>
                <i class="bi bi-lock input-icon"></i>
                <button type="button" class="toggle-password" id="togglePassword">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')
                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>

            <!-- Remember & Forgot -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Ingat Saya
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>

            <!-- Button -->
            <button type="submit" class="btn-login mt-3" id="loginBtn">
                <span class="btn-text">Login <i class="bi bi-arrow-right ms-2"></i></span>
                <span class="spinner"></span>
            </button>
        </form>

        <!-- Footer -->
        <div class="login-footer">
            <p>
                <span class="badge-role admin">Admin</span>
                <span class="badge-role pelatih">Pelatih</span>
                <span class="badge-role anggota">Anggota</span>
            </p>
            <p class="mt-2">
                <small>Demo: admin@mail.com / password</small>
            </p>
            <p class="mt-1" style="font-size: 11px; color: #d1d5db;">
                &copy; {{ date('Y') }} Sistem Ekskul v2.0
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init();

        // Toggle Password
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });

        // Loading State
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');

        loginForm.addEventListener('submit', function() {
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;
        });

        // Auto dismiss error
        setTimeout(() => {
            const alert = document.querySelector('.alert-error');
            if (alert) {
                alert.classList.remove('show');
            }
        }, 5000);

        console.log('🚀 Login Page v2.0 Loaded!');
    </script>
</body>
</html>