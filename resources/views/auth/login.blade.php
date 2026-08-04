<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SISMEKUL - Login</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a0a1a;
            overflow: hidden;
        }

        /* ===== BACKGROUND ANIMATION ===== */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            overflow: hidden;
            background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 40%, #2d1b69 70%, #4f46e5 100%);
        }

        /* Animated Gradient */
        .bg-gradient-animation {
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(ellipse at 30% 50%, rgba(79,70,229,0.15) 0%, transparent 50%),
                        radial-gradient(ellipse at 70% 50%, rgba(6,182,212,0.1) 0%, transparent 50%),
                        radial-gradient(ellipse at 50% 80%, rgba(139,92,246,0.1) 0%, transparent 50%);
            animation: gradientMove 15s ease-in-out infinite alternate;
        }

        @keyframes gradientMove {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-10%, -10%) rotate(5deg); }
        }

        /* Floating Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: floatOrb 20s ease-in-out infinite;
            opacity: 0.1;
        }

        .orb-1 {
            width: 600px;
            height: 600px;
            background: #4f46e5;
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: #06b6d4;
            bottom: -150px;
            right: -150px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 400px;
            height: 400px;
            background: #8b5cf6;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(100px, -100px) scale(1.1); }
            50% { transform: translate(-50px, 150px) scale(0.9); }
            75% { transform: translate(150px, 50px) scale(1.05); }
        }

        /* Sport Icons */
        .sport-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            opacity: 0.025;
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

        /* ===== LOGIN CARD ===== */
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
            background: radial-gradient(ellipse at 100% 0%, rgba(79,70,229,0.02), transparent 60%);
            pointer-events: none;
        }

        .login-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 40px 120px rgba(79,70,229,0.15);
        }

        /* Brand */
        .brand {
            text-align: center;
            margin-bottom: 32px;
            position: relative;
        }

        .brand .brand-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 32px;
            box-shadow: 0 8px 40px rgba(79,70,229,0.3);
            margin-bottom: 14px;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
        }

        .brand .brand-icon::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 24px;
            background: linear-gradient(135deg, #4f46e5, #818cf8, #06b6d4);
            opacity: 0.3;
            filter: blur(12px);
            z-index: -1;
            animation: glowPulse 3s ease-in-out infinite;
        }

        @keyframes glowPulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.05); }
        }

        .brand .brand-icon:hover {
            transform: rotate(-8deg) scale(1.05);
        }

        .brand h2 {
            color: #0f172a;
            font-weight: 800;
            font-size: 26px;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .brand p {
            color: #94a3b8;
            font-size: 13px;
            margin: 4px 0 0;
            letter-spacing: 1.5px;
        }

        .brand .brand-line {
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #4f46e5, #818cf8);
            border-radius: 4px;
            margin: 12px auto 0;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            display: block;
        }

        .form-group .input-wrapper {
            position: relative;
        }

        .form-group .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
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
            border-color: #4f46e5;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(79,70,229,0.06);
        }

        .form-group .input-wrapper input:focus + .input-icon,
        .form-group .input-wrapper input:focus ~ .input-icon {
            color: #4f46e5;
        }

        .form-group .input-wrapper input::placeholder {
            color: #b0b8c8;
        }

        .form-group .input-wrapper .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 8px;
        }

        .form-group .input-wrapper .toggle-password:hover {
            color: #4f46e5;
            background: rgba(79,70,229,0.04);
        }

        /* Options */
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

        .form-options .remember:hover {
            color: #0f172a;
        }

        .form-options .remember input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #4f46e5;
            border-radius: 6px;
            cursor: pointer;
            border: 2px solid #d1d5db;
            transition: all 0.2s ease;
        }

        .form-options .remember input[type="checkbox"]:checked {
            border-color: #4f46e5;
        }

        .form-options .forgot-link {
            color: #94a3b8;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .form-options .forgot-link:hover {
            color: #4f46e5;
        }

        /* Button Login */
        .btn-login {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(79,70,229,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 48px rgba(79,70,229,0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

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

        .btn-login i {
            font-size: 16px;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 26px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        }

        .divider span {
            color: #94a3b8;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            white-space: nowrap;
            font-weight: 600;
        }

        /* Role Badges */
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
            border-color: #4f46e5;
            color: #4f46e5;
            background: rgba(79,70,229,0.04);
            transform: translateY(-3px);
            box-shadow: 0 4px 20px rgba(79,70,229,0.08);
        }

        .role-badge.active {
            border-color: #4f46e5;
            color: #4f46e5;
            background: rgba(79,70,229,0.04);
        }

        .role-badge .dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .role-badge .dot.admin { background: #4f46e5; }
        .role-badge .dot.pelatih { background: #10b981; }
        .role-badge .dot.anggota { background: #f59e0b; }

        .role-badge .badge-icon {
            font-size: 14px;
            opacity: 0.5;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 26px;
            color: #94a3b8;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .footer span {
            color: #4f46e5;
            font-weight: 600;
        }

        /* Alert */
        .alert {
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 20px;
            border: none;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fee2e2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
            font-weight: 500;
        }

        .alert i {
            font-size: 18px;
        }

        .alert-success {
            background: #d1fae5;
            color: #059669;
            border-left: 4px solid #059669;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 22px;
                border-radius: 20px;
            }
            .brand .brand-icon {
                width: 60px;
                height: 60px;
                font-size: 26px;
            }
            .brand h2 {
                font-size: 22px;
            }
            .form-options {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }
            .role-badges {
                gap: 6px;
            }
            .role-badge {
                font-size: 12px;
                padding: 6px 16px;
            }
            .sport-icon {
                font-size: 30px !important;
            }
            .orb-1 { width: 250px; height: 250px; }
            .orb-2 { width: 200px; height: 200px; }
            .orb-3 { width: 150px; height: 150px; }
            .btn-login {
                padding: 14px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <!-- ===== BACKGROUND ANIMATION ===== -->
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

    <!-- ===== LOGIN CARD ===== -->
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Brand -->
            <div class="brand">
                <div class="brand-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <h2>SISMEKUL</h2>
                <p>Management System</p>
                <div class="brand-line"></div>
            </div>

            <!-- Alert -->
            @if(session('error'))
                <div class="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label><i class="fas fa-envelope me-2"></i> Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" value="{{ old('email', 'admin@mail.com') }}" placeholder="Masukkan email" required autofocus>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock me-2"></i> Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" value="password" placeholder="Masukkan password" required id="password">
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
                    <a href="#" class="forgot-link">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-login">
                    <span class="btn-shine"></span>
                    <i class="fas fa-arrow-right-to-bracket"></i> Login
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>Login sebagai</span>
            </div>

            <!-- Role Badges -->
            <div class="role-badges">
                <span class="role-badge" onclick="autoFill('admin')">
                    <span class="dot admin"></span>
                    <i class="fas fa-shield-alt badge-icon"></i>
                    Admin
                </span>
                <span class="role-badge" onclick="autoFill('pelatih')">
                    <span class="dot pelatih"></span>
                    <i class="fas fa-chalkboard-user badge-icon"></i>
                    Pelatih
                </span>
                <span class="role-badge" onclick="autoFill('anggota')">
                    <span class="dot anggota"></span>
                    <i class="fas fa-user-graduate badge-icon"></i>
                    Anggota
                </span>
            </div>

            <!-- Footer -->
            <div class="footer">
                &copy; {{ date('Y') }} <span>SISMEKUL</span> v3.0
            </div>
        </div>
    </div>

    <script>
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
                
                // Highlight effect
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