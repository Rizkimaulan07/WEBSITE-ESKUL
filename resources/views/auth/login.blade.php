<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMSKUL - Login</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a0a1a;
            overflow: hidden;
        }

        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            overflow: hidden;
            background: linear-gradient(135deg, #0a1628 0%, #1a3a6a 30%, #0ea5e9 60%, #38bdf8 100%);
        }
        .bg-gradient-animation {
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(ellipse at 30% 50%, rgba(14,165,233,0.15) 0%, transparent 50%),
                        radial-gradient(ellipse at 70% 50%, rgba(56,189,248,0.1) 0%, transparent 50%),
                        radial-gradient(ellipse at 50% 80%, rgba(14,165,233,0.1) 0%, transparent 50%);
            animation: gradientMove 15s ease-in-out infinite alternate;
        }
        @keyframes gradientMove {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-10%, -10%) rotate(5deg); }
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: floatOrb 20s ease-in-out infinite;
            opacity: 0.1;
        }
        .orb-1 { width: 600px; height: 600px; background: #0ea5e9; top: -200px; left: -200px; animation-delay: 0s; }
        .orb-2 { width: 500px; height: 500px; background: #38bdf8; bottom: -150px; right: -150px; animation-delay: -5s; }
        .orb-3 { width: 400px; height: 400px; background: #7dd3fc; top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: -10s; }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(100px, -100px) scale(1.1); }
            50% { transform: translate(-50px, 150px) scale(0.9); }
            75% { transform: translate(150px, 50px) scale(1.05); }
        }

        .sport-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            opacity: 0.015;
        }
        .sport-icon {
            position: absolute;
            font-size: 80px;
            color: #fff;
            animation: sportFloat 25s linear infinite;
        }
        .sport-icon:nth-child(1) { left: 5%; top: 10%; animation-delay: 0s; font-size: 60px; }
        .sport-icon:nth-child(2) { left: 15%; top: 30%; animation-delay: -3s; font-size: 100px; }
        .sport-icon:nth-child(3) { left: 25%; top: 60%; animation-delay: -6s; font-size: 70px; }
        .sport-icon:nth-child(4) { left: 40%; top: 15%; animation-delay: -9s; font-size: 90px; }
        .sport-icon:nth-child(5) { left: 50%; top: 45%; animation-delay: -12s; font-size: 60px; }
        .sport-icon:nth-child(6) { left: 60%; top: 70%; animation-delay: -15s; font-size: 80px; }
        .sport-icon:nth-child(7) { left: 75%; top: 20%; animation-delay: -18s; font-size: 100px; }
        .sport-icon:nth-child(8) { left: 85%; top: 55%; animation-delay: -21s; font-size: 70px; }
        .sport-icon:nth-child(9) { left: 95%; top: 80%; animation-delay: -24s; font-size: 60px; }
        .sport-icon:nth-child(10) { left: 8%; top: 85%; animation-delay: -2s; font-size: 90px; }
        .sport-icon:nth-child(11) { left: 32%; top: 90%; animation-delay: -5s; font-size: 70px; }
        .sport-icon:nth-child(12) { left: 70%; top: 5%; animation-delay: -8s; font-size: 80px; }

        @keyframes sportFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            25% { transform: translate(30px, -30px) rotate(5deg) scale(1.1); }
            50% { transform: translate(-20px, 20px) rotate(-5deg) scale(0.9); }
            75% { transform: translate(40px, 10px) rotate(3deg) scale(1.05); }
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }
        .login-card {
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 28px;
            padding: 44px 38px;
            box-shadow: 0 30px 100px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.2);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at 100% 0%, rgba(14,165,233,0.02), transparent 60%);
            pointer-events: none;
        }
        .login-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 40px 120px rgba(14,165,233,0.15);
        }

        .brand { text-align: center; margin-bottom: 28px; position: relative; }
        .brand-logo-wrapper { display: flex; justify-content: center; align-items: center; margin-bottom: 14px; }
        .brand-logo-container {
            width: 90px;
            height: 90px;
            border-radius: 20px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 40px rgba(14,165,233,0.2);
            padding: 10px;
            position: relative;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid rgba(14,165,233,0.08);
        }
        .brand-logo-container::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 24px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8, #7dd3fc);
            opacity: 0.2;
            filter: blur(12px);
            z-index: -1;
            animation: glowPulse 3s ease-in-out infinite;
        }
        @keyframes glowPulse {
            0%, 100% { opacity: 0.2; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.05); }
        }
        .brand-logo-container:hover { transform: rotate(-4deg) scale(1.03); }
        .brand-logo-container img { width: 100%; height: 100%; object-fit: contain; border-radius: 12px; }

        .brand h2 {
            color: #0f172a;
            font-weight: 800;
            font-size: 26px;
            letter-spacing: -0.5px;
            margin: 0;
        }
        .brand h2 span { color: #0ea5e9; }
        .brand p { color: #64748b; font-size: 13px; margin: 4px 0 0; letter-spacing: 1.5px; }
        .brand .brand-line { width: 40px; height: 3px; background: linear-gradient(90deg, #0ea5e9, #38bdf8); border-radius: 4px; margin: 10px auto 0; }
        .school-name { font-size: 13px; color: #64748b; font-weight: 500; margin-top: 6px; letter-spacing: 0.5px; }
        .school-name strong { color: #0f172a; }

        .form-group { margin-bottom: 20px; }
        .form-group label {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            display: block;
        }
        .form-group .input-wrapper { position: relative; }
        .form-group .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 16px;
            transition: all 0.3s ease;
            pointer-events: none;
        }
        .form-group .input-wrapper input {
            width: 100%;
            padding: 15px 16px 15px 48px;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #0f172a;
            transition: all 0.3s ease;
        }
        .form-group .input-wrapper input:focus {
            outline: none;
            border-color: #0ea5e9;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(14,165,233,0.06);
        }
        .form-group .input-wrapper input:focus + .input-icon,
        .form-group .input-wrapper input:focus ~ .input-icon { color: #0ea5e9; }
        .form-group .input-wrapper input::placeholder { color: #94a3b8; }
        .form-group .input-wrapper .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 8px;
        }
        .form-group .input-wrapper .toggle-password:hover {
            color: #0ea5e9;
            background: rgba(14,165,233,0.04);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 26px;
        }
        .form-options .remember {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #64748b;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .form-options .remember:hover { color: #0f172a; }
        .form-options .remember input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #0ea5e9;
            border-radius: 6px;
            cursor: pointer;
            border: 2px solid #d1d5db;
            transition: all 0.2s ease;
        }
        .form-options .remember input[type="checkbox"]:checked { border-color: #0ea5e9; }
        .form-options .forgot-link {
            color: #64748b;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .form-options .forgot-link:hover { color: #0ea5e9; }

        .btn-login {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(14,165,233,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 48px rgba(14,165,233,0.4);
        }
        .btn-login:active { transform: translateY(0); }
        .btn-login .btn-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shine 3s infinite;
        }
        @keyframes shine {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .divider { display: flex; align-items: center; gap: 16px; margin: 26px 0; }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        }
        .divider span {
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            white-space: nowrap;
            font-weight: 600;
        }

        .role-badges {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .role-badge {
            padding: 8px 22px;
            border-radius: 24px;
            border: 2px solid #e5e7eb;
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            background: #f8fafc;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .role-badge:hover {
            border-color: #0ea5e9;
            color: #0ea5e9;
            background: rgba(14,165,233,0.04);
            transform: translateY(-3px);
            box-shadow: 0 4px 20px rgba(14,165,233,0.08);
        }
        .role-badge.active {
            border-color: #0ea5e9;
            color: #0ea5e9;
            background: rgba(14,165,233,0.04);
        }
        .role-badge .dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; transition: all 0.3s ease; }
        .role-badge .dot.admin { background: #0ea5e9; }
        .role-badge .dot.pelatih { background: #10b981; }
        .role-badge .dot.anggota { background: #f59e0b; }

        .footer { text-align: center; margin-top: 26px; color: #64748b; font-size: 12px; letter-spacing: 0.5px; }
        .footer span { color: #0ea5e9; font-weight: 600; }

        /* ===== ALERT - BAHASA INDONESIA ===== */
        .alert {
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 20px;
            border: none;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }
        .alert-danger i { color: #dc2626; }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        .alert-success i { color: #10b981; }

        @media (max-width: 480px) {
            .login-card { padding: 30px 22px; border-radius: 20px; }
            .brand-logo-container { width: 72px; height: 72px; padding: 8px; }
            .brand h2 { font-size: 22px; }
            .form-options { flex-direction: column; gap: 12px; align-items: flex-start; }
            .role-badges { gap: 6px; }
            .role-badge { font-size: 12px; padding: 6px 16px; }
            .sport-icon { font-size: 30px !important; }
            .orb-1 { width: 250px; height: 250px; }
            .orb-2 { width: 200px; height: 200px; }
            .orb-3 { width: 150px; height: 150px; }
            .btn-login { padding: 14px; font-size: 14px; }
            .school-name { font-size: 11px; }
        }
    </style>
</head>
<body>

    <div class="bg-animation">
        <div class="bg-gradient-animation"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="sport-icons">
            <i class="fas fa-futbol sport-icon"></i>
            <i class="fas fa-basketball-ball sport-icon"></i>
            <i class="fas fa-volleyball-ball sport-icon"></i>
            <i class="fas fa-flag-checkered sport-icon"></i>
            <i class="fas fa-medal sport-icon"></i>
            <i class="fas fa-running sport-icon"></i>
            <i class="fas fa-swimmer sport-icon"></i>
            <i class="fas fa-dumbbell sport-icon"></i>
            <i class="fas fa-biking sport-icon"></i>
            <i class="fas fa-trophy sport-icon"></i>
            <i class="fas fa-skating sport-icon"></i>
            <i class="fas fa-hiking sport-icon"></i>
        </div>
    </div>

    <div class="login-wrapper">
        <div class="login-card">
            <!-- Brand -->
            <div class="brand">
                <div class="brand-logo-wrapper">
                    <div class="brand-logo-container">
                        <img src="{{ asset('images/logo-smk-bppi.png') }}" 
                             alt="Logo SMK BPPI Baleendah" 
                             loading="lazy">
                    </div>
                </div>

                <h2>SIMSKUL</h2>
                <p>Sistem Manajemen Ekstrakurikuler</p>
                <div class="brand-line"></div>
                <div class="school-name">
                    <strong>SMK BPPI Baleendah</strong>
                </div>
            </div>

            <!-- ===== ALERT ERROR - BAHASA INDONESIA ===== -->
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>
                        @if($errors->has('email'))
                            {{ $errors->first('email') }}
                        @elseif($errors->has('password'))
                            {{ $errors->first('password') }}
                        @else
                            {{ $errors->first() }}
                        @endif
                    </span>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf

                <div class="form-group">
                    <label><i class="fas fa-envelope me-2"></i> Alamat Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email Anda" required autofocus autocomplete="off">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock me-2"></i> Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" placeholder="Masukkan password Anda" required id="password" autocomplete="new-password">
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Ingat Saya
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-login">
                    <span class="btn-shine"></span>
                    <i class="fas fa-arrow-right-to-bracket"></i> Login
                </button>
            </form>

            <div class="divider">
                <span>Login sebagai</span>
            </div>

            <div class="role-badges">
                <span class="role-badge" onclick="autoFill('admin')">
                    <span class="dot admin"></span>
                    <i class="fas fa-shield-alt me-1"></i> Admin
                </span>
                <span class="role-badge" onclick="autoFill('pelatih')">
                    <span class="dot pelatih"></span>
                    <i class="fas fa-chalkboard-user me-1"></i> Pelatih
                </span>
                <span class="role-badge" onclick="autoFill('anggota')">
                    <span class="dot anggota"></span>
                    <i class="fas fa-user-graduate me-1"></i> Anggota
                </span>
            </div>

            <div class="footer">
                &copy; {{ date('Y') }} <span>SIMSKUL</span> v3.0
            </div>
        </div>
    </div>

    <script>
        (function() {
            const oldEmail = @json(old('email'));
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const emailInput = document.querySelector('input[name="email"]');
                    const passInput = document.querySelector('input[name="password"]');
                    if (emailInput && emailInput.value !== oldEmail) {
                        emailInput.value = '';
                    }
                    if (passInput) {
                        passInput.value = '';
                    }
                }, 50);
            });
        })();

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        function autoFill(role) {
            const emailInput = document.querySelector('input[name="email"]');
            const passInput = document.querySelector('input[name="password"]');
            
            const credentials = {
                admin: { email: 'admin@mail.com', pass: 'password' },
                pelatih: { email: 'pelatih@mail.com', pass: 'password' },
                anggota: { email: 'anggota@mail.com', pass: 'password' }
            };

            if (credentials[role]) {
                emailInput.value = credentials[role].email;
                passInput.value = credentials[role].pass;
                
                const badges = document.querySelectorAll('.role-badge');
                badges.forEach(b => b.classList.remove('active'));
                const clickedBadge = document.querySelector(`.role-badge .dot.${role}`)?.closest('.role-badge');
                if (clickedBadge) {
                    clickedBadge.classList.add('active');
                }
            }
        }
    </script>
</body>
</html>