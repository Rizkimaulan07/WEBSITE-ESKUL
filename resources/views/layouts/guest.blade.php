<!-- resources/views/layouts/guest.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- PWA META TAGS --}}
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0ea5e9">
    <link rel="apple-touch-icon" href="/images/logo-smk-bppi.png">

    <title>{{ config('app.name', 'SIMSKUL') }} - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>

    @php
        $__hotFile = file_exists(public_path('hot'));
        $__manifestFile = file_exists(public_path('build/manifest.json'));
    @endphp
    @if($__hotFile || $__manifestFile)
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @endif

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

        .text-muted {
            color: #475569 !important;
        }

        /* ===== BACKGROUND ANIMATION - BIRU CERAH ===== */
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

        .orb-1 {
            width: 600px;
            height: 600px;
            background: #0ea5e9;
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: #38bdf8;
            bottom: -150px;
            right: -150px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 400px;
            height: 400px;
            background: #7dd3fc;
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

        /* ===== AUTH CARD ===== */
        .auth-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }

        .auth-card {
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

        .auth-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at 100% 0%, rgba(14,165,233,0.02), transparent 60%);
            pointer-events: none;
        }

        .auth-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 40px 120px rgba(14,165,233,0.15);
        }

        /* Brand */
        .brand {
            text-align: center;
            margin-bottom: 28px;
            position: relative;
        }

        .brand-logo-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 14px;
        }

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

        .brand-logo-container:hover {
            transform: rotate(-4deg) scale(1.03);
        }

        .brand-logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 12px;
        }

        .brand h2 {
            color: #0f172a;
            font-weight: 800;
            font-size: 26px;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .brand h2 span {
            color: #0ea5e9;
        }

        .brand p {
            color: #475569;
            font-size: 13px;
            margin: 4px 0 0;
            letter-spacing: 1.5px;
        }

        .brand .brand-line {
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #0ea5e9, #38bdf8);
            border-radius: 4px;
            margin: 10px auto 0;
        }

        .school-name {
            font-size: 13px;
            color: #475569;
            font-weight: 500;
            margin-top: 6px;
            letter-spacing: 0.5px;
        }

        .school-name strong {
            color: #0f172a;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            color: #475569;
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
        .form-group .input-wrapper input:focus ~ .input-icon {
            color: #0ea5e9;
        }

        .form-group .input-wrapper input::placeholder {
            color: #94a3b8;
        }

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

        /* Alert */
        .alert-custom {
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            font-weight: 500;
            border-left: 4px solid;
        }

        .alert-custom.error {
            background: #fee2e2;
            color: #dc2626;
            border-left-color: #dc2626;
        }

        .alert-custom.success {
            background: #d1fae5;
            color: #059669;
            border-left-color: #059669;
        }

        .alert-custom.warning {
            background: #fef3c7;
            color: #d97706;
            border-left-color: #d97706;
        }

        /* Button Auth */
        .btn-auth {
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

        .btn-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 48px rgba(14,165,233,0.4);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        .btn-auth .btn-shine {
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

        /* Footer */
        .auth-footer {
            text-align: center;
            margin-top: 20px;
            color: #475569;
            font-size: 13px;
        }

        .auth-footer a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            color: #0284c7;
        }

        /* ===== RESPONSIVE ===== */

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo .logo-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 28px;
            margin: 0 auto 12px;
            box-shadow: 0 8px 30px rgba(14,165,233,0.25);
            transition: all 0.3s ease;
        }

        .logo .logo-icon:hover {
            transform: scale(1.05) rotate(-5deg);
        }

        .logo h3 {
            color: #0f172a;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 4px;
        }

        .logo .subtitle {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .auth-card {
                padding: 30px 22px;
                border-radius: 20px;
            }
            .brand-logo-container {
                width: 72px;
                height: 72px;
                padding: 8px;
            }
            .brand h2 {
                font-size: 22px;
            }
            .btn-auth {
                padding: 14px;
                font-size: 14px;
            }
            .school-name {
                font-size: 11px;
            }
            .logo h3 {
                font-size: 20px;
            }
            .logo .subtitle {
                font-size: 13px;
            }
            .sport-icon {
                font-size: 30px !important;
            }
            .orb-1 { width: 250px; height: 250px; }
            .orb-2 { width: 200px; height: 200px; }
            .orb-3 { width: 150px; height: 150px; }
        }
    </style>
</head>
<body>

    <div id="loadingOverlayRoot"></div>

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

    <!-- ===== AUTH CARD ===== -->
    <div class="auth-wrapper">
        <div class="auth-card">
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

            <!-- ===== CONTENT ===== -->
            @yield('content')

            <!-- Footer -->
            <div class="auth-footer">
                &copy; {{ date('Y') }} <span style="color: #0ea5e9; font-weight: 600;">SIMSKUL</span> v3.0
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ===== REGISTER SERVICE WORKER =====
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registered: ', registration.scope);
                }).catch(function(error) {
                    console.log('ServiceWorker registration failed: ', error);
                });
            });
        }
    </script>
    @stack('scripts')
</body>
</html>