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
    <link rel="apple-touch-icon" href="/images/logo-simskul.png">

    <title>{{ config('app.name', 'SIMSKUL') }} - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

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
            align-items: safe center;
            justify-content: center;
            background: linear-gradient(135deg, #0a1628 0%, #1a3a6a 30%, #0ea5e9 60%, #38bdf8 100%);
            overflow-x: hidden;
            overflow-y: auto;
            padding: 40px 0;
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
            background: transparent;
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
            pointer-events: none;
        }

        .sport-icon {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: rgba(255,255,255,0.9);
            border: 1px solid rgba(255,255,255,0.18);
            background:
                radial-gradient(circle at 30% 25%, var(--tint, rgba(56,189,248,0.14)), transparent 65%),
                rgba(255,255,255,0.04);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.25), 0 10px 30px rgba(0,0,0,0.2);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            animation: sportBob var(--dur, 22s) ease-in-out infinite;
        }

        .sport-icon:nth-child(1) { left: 4%;  top: 12%; width: 78px;  height: 78px;  font-size: 30px; --dur: 20s; --tint: rgba(56,189,248,0.14); }
        .sport-icon:nth-child(2) { left: 13%; top: 32%; width: 118px; height: 118px; font-size: 46px; --dur: 26s; --tint: rgba(14,165,233,0.16); }
        .sport-icon:nth-child(3) { left: 24%; top: 62%; width: 88px;  height: 88px;  font-size: 34px; --dur: 18s; --tint: rgba(125,211,252,0.14); }
        .sport-icon:nth-child(4) { left: 38%; top: 14%; width: 112px; height: 112px; font-size: 44px; --dur: 28s; --tint: rgba(14,165,233,0.15); }
        .sport-icon:nth-child(5) { left: 49%; top: 44%; width: 78px;  height: 78px;  font-size: 30px; --dur: 21s; --tint: rgba(56,189,248,0.14); }
        .sport-icon:nth-child(6) { left: 59%; top: 70%; width: 100px; height: 100px; font-size: 40px; --dur: 25s; --tint: rgba(14,165,233,0.15); }
        .sport-icon:nth-child(7) { left: 73%; top: 18%; width: 120px; height: 120px; font-size: 48px; --dur: 24s; --tint: rgba(125,211,252,0.15); }
        .sport-icon:nth-child(8) { left: 84%; top: 54%; width: 88px;  height: 88px;  font-size: 34px; --dur: 19s; --tint: rgba(56,189,248,0.14); }
        .sport-icon:nth-child(9) { left: 92%; top: 78%; width: 78px;  height: 78px;  font-size: 30px; --dur: 23s; --tint: rgba(14,165,233,0.14); }
        .sport-icon:nth-child(10) { left: 7%;  top: 84%; width: 108px; height: 108px; font-size: 42px; --dur: 27s; --tint: rgba(125,211,252,0.15); }
        .sport-icon:nth-child(11) { left: 31%; top: 90%; width: 88px;  height: 88px;  font-size: 34px; --dur: 20s; --tint: rgba(56,189,248,0.14); }
        .sport-icon:nth-child(12) { left: 68%; top: 6%;  width: 100px; height: 100px; font-size: 40px; --dur: 22s; --tint: rgba(14,165,233,0.15); }

        .sport-icon::after {
            content: '';
            position: absolute;
            top: 9%;
            left: 18%;
            width: 26%;
            height: 18%;
            border-radius: 50%;
            background: rgba(255,255,255,0.35);
            filter: blur(1px);
            pointer-events: none;
        }

        @keyframes sportBob {
            0%, 100% { transform: translateY(0) rotate(0deg) scale(1); }
            30% { transform: translateY(-16px) rotate(4deg) scale(1.04); }
            60% { transform: translateY(8px) rotate(-3deg) scale(0.98); }
            80% { transform: translateY(-6px) rotate(2deg) scale(1.02); }
        }

        /* ===== AURORA SHEEN ===== */
        .aurora {
            position: absolute;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(ellipse at 25% 35%, rgba(56,189,248,0.28) 0%, transparent 55%),
                radial-gradient(ellipse at 75% 30%, rgba(14,165,233,0.25) 0%, transparent 55%),
                radial-gradient(ellipse at 50% 85%, rgba(125,211,252,0.2) 0%, transparent 55%);
            filter: blur(20px);
            animation: auroraDrift 14s ease-in-out infinite alternate;
        }

        @keyframes auroraDrift {
            0% { transform: translate(0, 0) scale(1) rotate(0deg); opacity: 0.7; }
            50% { transform: translate(-3%, -2%) scale(1.08) rotate(2deg); opacity: 1; }
            100% { transform: translate(2%, 3%) scale(1.04) rotate(-2deg); opacity: 0.8; }
        }

        /* ===== TWINKLING PARTICLES ===== */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            opacity: 0.6;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 0 6px 1px rgba(122, 200, 255, 0.6);
            animation: particleFloat var(--d, 18s) ease-in-out infinite;
        }

        @keyframes particleFloat {
            0% { transform: translateY(0) scale(1); opacity: 0; }
            15% { opacity: 1; }
            50% { transform: translateY(-60px) scale(0.6); opacity: 0.8; }
            85% { opacity: 1; }
            100% { transform: translateY(-120px) scale(0.3); opacity: 0; }
        }

        /* ===== ANIMATED WAVES ===== */
        .waves {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40vh;
            overflow: hidden;
            pointer-events: none;
        }

        .waves .wave {
            position: absolute;
            bottom: 0;
            height: 120%;
            width: 240%;
            background-size: 1000px 100%;
            background-repeat: repeat-x;
            opacity: 0.55;
            animation: waveShift var(--w, 18s) linear infinite;
        }

        .waves .wave-1 { background-image: radial-gradient(ellipse at 0 100%, rgba(14,165,233,0.35) 0%, transparent 60%); }
        .waves .wave-2 { background-image: radial-gradient(ellipse at 30% 100%, rgba(56,189,248,0.3) 0%, transparent 55%); animation-duration: 24s; }
        .waves .wave-3 { background-image: radial-gradient(ellipse at 60% 100%, rgba(7,89,133,0.4) 0%, transparent 60%); animation-duration: 30s; }

        @keyframes waveShift {
            0% { transform: translateX(0) translateY(0); }
            50% { transform: translateX(-12%) translateY(-12px); }
            100% { transform: translateX(-24%) translateY(0); }
        }

        /* ===== KINERJA & AKSESIBILITAS ===== */
        @media (prefers-reduced-motion: reduce) {
            .bg-gradient-animation,
            .aurora,
            .orb,
            .sport-icon,
            .particle,
            .waves .wave {
                animation: none !important;
            }
        }

        /* ===== AUTH CARD ===== */
        /* ===== AUTH WRAPPER BACK ARROW ===== */
        .auth-back {
            position: fixed;
            top: 18px;
            left: 18px;
            z-index: 5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.25);
            color: #ffffff;
            font-size: 17px;
            text-decoration: none;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 18px rgba(0,0,0,0.25);
            transition: all 0.3s ease;
        }
        .auth-back:hover {
            background: rgba(255,255,255,0.25);
            transform: translateX(-3px);
            color: #ffffff;
            box-shadow: 0 8px 26px rgba(0,0,0,0.3);
        }

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
            width: 140px;
            height: 80px;
            border-radius: 16px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 40px rgba(14,165,233,0.2);
            padding: 6px;
            position: relative;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid rgba(14,165,233,0.08);
        }

        .brand-logo-container::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 20px;
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
        @media (max-height: 640px) {
            body {
                align-items: flex-start;
                padding: 24px 0;
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 30px 22px;
                border-radius: 20px;
            }
            .brand-logo-container {
                width: 112px;
                height: 64px;
                padding: 5px;
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
                width: 52px !important;
                height: 52px !important;
                font-size: 20px !important;
            }
            .orb-1 { width: 250px; height: 250px; }
            .orb-2 { width: 200px; height: 200px; }
            .orb-3 { width: 150px; height: 150px; }
        }

        /* ===== MOBILE SCROLL INDICATOR ===== */
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #0ea5e9, #38bdf8, #7dd3fc);
            z-index: 2000;
            display: none;
        }

        .mobile-scroll-track {
            display: none;
            position: fixed;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 38vh;
            background: rgba(14, 165, 233, 0.15);
            border: 1px solid rgba(14, 165, 233, 0.25);
            border-radius: 10px;
            z-index: 2000;
            touch-action: none;
            cursor: pointer;
        }

        .mobile-scrollbar-thumb {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 18%;
            background: linear-gradient(180deg, #0ea5e9, #38bdf8);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(14, 165, 233, 0.4);
            transition: background 0.2s ease;
        }

        @media (max-width: 768px) {
            .scroll-progress {
                display: block;
            }
            .mobile-scroll-track {
                display: block;
                right: 4px;
            }
        }
    </style>
</head>
<body>

    <div id="loadingOverlayRoot"></div>

    <!-- ===== BACKGROUND ANIMATION ===== -->
    <div class="bg-animation">
        <div class="bg-gradient-animation"></div>
        <div class="aurora"></div>
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

        <div class="particles">
            <span class="particle" style="left:6%;top:70%;width:6px;height:6px;--d:16s;"></span>
            <span class="particle" style="left:14%;top:40%;width:4px;height:4px;--d:20s;"></span>
            <span class="particle" style="left:22%;top:80%;width:5px;height:5px;--d:14s;"></span>
            <span class="particle" style="left:31%;top:55%;width:3px;height:3px;--d:22s;"></span>
            <span class="particle" style="left:42%;top:75%;width:6px;height:6px;--d:18s;"></span>
            <span class="particle" style="left:55%;top:45%;width:4px;height:4px;--d:15s;"></span>
            <span class="particle" style="left:64%;top:70%;width:5px;height:5px;--d:23s;"></span>
            <span class="particle" style="left:74%;top:50%;width:3px;height:3px;--d:17s;"></span>
            <span class="particle" style="left:84%;top:72%;width:6px;height:6px;--d:21s;"></span>
            <span class="particle" style="left:93%;top:60%;width:4px;height:4px;--d:19s;"></span>
            <span class="particle" style="left:12%;top:20%;width:5px;height:5px;--d:25s;"></span>
            <span class="particle" style="left:48%;top:12%;width:4px;height:4px;--d:13s;"></span>
            <span class="particle" style="left:78%;top:22%;width:5px;height:5px;--d:26s;"></span>
            <span class="particle" style="left:33%;top:28%;width:3px;height:3px;--d:28s;"></span>
        </div>

        <div class="waves">
            <div class="wave wave-1"></div>
            <div class="wave wave-2"></div>
            <div class="wave wave-3"></div>
        </div>
    </div>

    <!-- ===== BACK ARROW (KEMBALI TO LOGIN) ===== -->
    <a href="{{ route('login') }}" class="auth-back" title="Kembali Login" aria-label="Kembali ke halaman login">
        <i class="fas fa-arrow-left"></i>
    </a>

    <!-- ===== MOBILE SCROLL: GARIS DRAGGABLE + TOP PROGRESS BAR ===== -->
    <div class="scroll-progress" id="scrollProgress"></div>
    <div class="mobile-scroll-track" id="mobileScrollTrack">
        <div class="mobile-scrollbar-thumb" id="mobileScrollThumb"></div>
    </div>

    <!-- ===== AUTH CARD ===== -->
    <div class="auth-wrapper">
        <div class="auth-card">
            <!-- Brand -->
            <div class="brand">
                <div class="brand-logo-wrapper">
                    <div class="brand-logo-container">
                        <img src="{{ asset('images/logo-simskul.png') }}"
                             alt="Logo SIMSKUL" 
                             loading="lazy"
                             style="width: 100%; height: 100%; object-fit: contain; border-radius: 12px;">
                    </div>
                </div>

                <h2>SIMSKUL</h2>
                <p>Sistem Manajemen Ekstrakurikuler</p>
                <div class="brand-line"></div>
                
                <div class="school-name">
                    <strong>SIMSKUL</strong>
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
        // ===== MOBILE SCROLL: TOP PROGRESS + DRAGGABLE GARIS =====
        var scrollTrackEl = document.getElementById('mobileScrollTrack');
        var scrollThumbEl = document.getElementById('mobileScrollThumb');
        var scrollProgressEl = document.getElementById('scrollProgress');
        var scrollDragging = false;
        var scrollDragOffset = 0;

        function updateScrollIndicator() {
            if (!scrollThumbEl || !scrollTrackEl) return;
            var total = document.body.scrollHeight - window.innerHeight;
            if (total <= 0) {
                scrollThumbEl.style.height = '18%';
                scrollThumbEl.style.top = '0px';
                if (scrollProgressEl) scrollProgressEl.style.width = '0%';
                return;
            }
            var frac = Math.min(1, Math.max(0, window.scrollY / total));
            var trackH = scrollTrackEl.getBoundingClientRect().height;
            var thumbH = Math.max(36, trackH * (window.innerHeight / document.body.scrollHeight));
            scrollThumbEl.style.height = thumbH + 'px';
            scrollThumbEl.style.top = (frac * (trackH - thumbH)) + 'px';
            if (scrollProgressEl) scrollProgressEl.style.width = (frac * 100) + '%';
        }

        if (scrollThumbEl && scrollTrackEl) {
            scrollThumbEl.addEventListener('pointerdown', function(event) {
                scrollDragging = true;
                scrollDragOffset = event.clientY - (scrollTrackEl.getBoundingClientRect().top + scrollThumbEl.getBoundingClientRect().top);
                event.preventDefault();
            });

            document.addEventListener('pointermove', function(event) {
                if (!scrollDragging || !scrollTrackEl || !scrollThumbEl) return;
                var total = document.body.scrollHeight - window.innerHeight;
                if (total <= 0) { scrollDragging = false; return; }
                var trackH = scrollTrackEl.getBoundingClientRect().height;
                var thumbH = scrollThumbEl.getBoundingClientRect().height;
                var frac = (event.clientY - (scrollTrackEl.getBoundingClientRect().top + scrollDragOffset)) / (trackH - thumbH);
                window.scrollTo(0, Math.min(1, Math.max(0, frac)) * total);
            });

            document.addEventListener('pointerup', function() {
                scrollDragging = false;
            });

            scrollTrackEl.addEventListener('click', function(event) {
                if (event.target === scrollThumbEl) return;
                var total = document.body.scrollHeight - window.innerHeight;
                if (total <= 0 || !scrollThumbEl) return;
                var trackH = scrollTrackEl.getBoundingClientRect().height;
                var thumbH = scrollThumbEl.getBoundingClientRect().height;
                var frac = (event.clientY - (scrollTrackEl.getBoundingClientRect().top + thumbH / 2)) / (trackH - thumbH);
                window.scrollTo(0, Math.min(1, Math.max(0, frac)) * total);
            });
        }

        document.addEventListener('scroll', updateScrollIndicator);
        window.addEventListener('resize', updateScrollIndicator);
        updateScrollIndicator();

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