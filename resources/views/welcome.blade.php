<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMSKUL') }} - Sistem Manajemen Ekstrakurikuler</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f7ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* ===== MAIN CONTAINER ===== */
        .landing-container {
            width: 100%;
            max-width: 1200px;
            background: #ffffff;
            border-radius: 32px;
            box-shadow: 0 20px 60px rgba(14, 165, 233, 0.06);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 90vh;
        }

        /* ===== HEADER ===== */
        .landing-header {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(14, 165, 233, 0.06);
            flex-wrap: wrap;
            gap: 16px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.25);
        }

        .logo-text {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .logo-text span {
            color: #0ea5e9;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-links .btn-login {
            padding: 10px 24px;
            border-radius: 12px;
            background: transparent;
            color: #64748b;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .nav-links .btn-login:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .nav-links .btn-register {
            padding: 10px 28px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.25);
        }

        .nav-links .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(14, 165, 233, 0.35);
        }

        /* ===== HERO SECTION ===== */
        .hero-section {
            padding: 60px 40px 40px;
            display: flex;
            align-items: center;
            gap: 60px;
            flex-wrap: wrap;
        }

        .hero-content {
            flex: 1;
            min-width: 300px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(14, 165, 233, 0.06);
            color: #0ea5e9;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .hero-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #0ea5e9;
            animation: pulse 2s infinite;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin-bottom: 16px;
        }

        .hero-title span {
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 18px;
            color: #64748b;
            line-height: 1.7;
            max-width: 480px;
            margin-bottom: 32px;
        }

        .hero-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hero-buttons .btn-primary {
            padding: 14px 36px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            color: #fff;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .hero-buttons .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(14, 165, 233, 0.35);
        }

        .hero-buttons .btn-secondary {
            padding: 14px 36px;
            border-radius: 14px;
            background: #f1f5f9;
            color: #0f172a;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #e2e8f0;
        }

        .hero-buttons .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-3px);
        }

        /* ===== HERO ILLUSTRATION ===== */
        .hero-illustration {
            flex: 1;
            min-width: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-illustration .illustration-box {
            width: 100%;
            max-width: 500px;
            aspect-ratio: 1;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .illustration-box .floating-icon {
            position: absolute;
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            color: #0ea5e9;
        }

        .floating-icon.icon-1 {
            top: 15%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-icon.icon-2 {
            top: 20%;
            right: 15%;
            animation: float 8s ease-in-out infinite reverse;
            color: #10b981;
        }

        .floating-icon.icon-3 {
            bottom: 25%;
            left: 20%;
            animation: float 7s ease-in-out infinite 1s;
            color: #f59e0b;
        }

        .floating-icon.icon-4 {
            bottom: 20%;
            right: 10%;
            animation: float 9s ease-in-out infinite 0.5s;
            color: #ec4899;
        }

        .illustration-box .center-icon {
            font-size: 80px;
            color: #0ea5e9;
            opacity: 0.15;
        }

        /* ===== FEATURES SECTION ===== */
        .features-section {
            padding: 40px 40px 60px;
            border-top: 1px solid rgba(14, 165, 233, 0.06);
        }

        .features-section .section-title {
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .features-section .section-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 16px;
            margin-bottom: 40px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .feature-card {
            padding: 28px 24px;
            background: #f8fafc;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.02);
            transition: all 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(14, 165, 233, 0.06);
            border-color: rgba(14, 165, 233, 0.06);
            background: #ffffff;
        }

        .feature-card .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(14, 165, 233, 0.06);
            color: #0ea5e9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 16px;
        }

        .feature-card h4 {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .feature-card p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 0;
        }

        /* ===== FOOTER ===== */
        .landing-footer {
            padding: 20px 40px;
            border-top: 1px solid rgba(14, 165, 233, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .landing-footer p {
            font-size: 13px;
            color: #64748b;
        }

        .landing-footer .footer-links {
            display: flex;
            gap: 20px;
        }

        .landing-footer .footer-links a {
            color: #64748b;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s ease;
        }

        .landing-footer .footer-links a:hover {
            color: #0ea5e9;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(0.7); }
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(15px, -15px) scale(1.05); }
            66% { transform: translate(-10px, 10px) scale(0.95); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .hero-section {
                flex-direction: column;
                text-align: center;
                padding: 40px 30px 30px;
            }

            .hero-title {
                font-size: 36px;
            }

            .hero-desc {
                max-width: 100%;
            }

            .hero-buttons {
                justify-content: center;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .illustration-box .floating-icon {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }

            .illustration-box .center-icon {
                font-size: 60px;
            }
        }

        @media (max-width: 768px) {
            .landing-container {
                border-radius: 20px;
                min-height: auto;
            }

            .landing-header {
                padding: 16px 20px;
            }

            .logo-text {
                font-size: 17px;
            }

            .hero-section {
                padding: 30px 20px 20px;
            }

            .hero-title {
                font-size: 28px;
            }

            .hero-desc {
                font-size: 15px;
            }

            .hero-buttons .btn-primary,
            .hero-buttons .btn-secondary {
                padding: 12px 24px;
                font-size: 13px;
                width: 100%;
                justify-content: center;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .features-section {
                padding: 30px 20px 40px;
            }

            .features-section .section-title {
                font-size: 22px;
            }

            .landing-footer {
                padding: 16px 20px;
                flex-direction: column;
                text-align: center;
            }

            .landing-footer .footer-links {
                justify-content: center;
            }

            .nav-links .btn-login {
                padding: 8px 16px;
                font-size: 13px;
            }

            .nav-links .btn-register {
                padding: 8px 20px;
                font-size: 13px;
            }

            .illustration-box {
                min-height: 280px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 24px;
            }

            .landing-header {
                flex-direction: column;
                align-items: stretch;
            }

            .nav-links {
                justify-content: center;
                flex-wrap: wrap;
            }

            .illustration-box .floating-icon {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .illustration-box .center-icon {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <!-- ===== HEADER ===== -->
        <header class="landing-header">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span class="logo-text">SIM<span>SKUL</span></span>
            </div>

            <nav class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-register">
                            <i class="fas fa-th-large me-2"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-register">
                                <i class="fas fa-user-plus me-2"></i> Daftar
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <!-- ===== HERO SECTION ===== -->
        <section class="hero-section">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Sistem Manajemen Ekstrakurikuler
                </div>

                <h1 class="hero-title">
                    Kelola Ekskul <br><span>Lebih Mudah & Efisien</span>
                </h1>

                <p class="hero-desc">
                    Platform manajemen ekstrakurikuler terintegrasi untuk sekolah.
                    Kelola anggota, kehadiran, nilai, dan dokumentasi dalam satu tempat.
                </p>

                <div class="hero-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">
                            <i class="fas fa-th-large"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary">
                            <i class="fas fa-rocket"></i> Mulai Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    @endauth
                </div>
            </div>

            <div class="hero-illustration">
                <div class="illustration-box">
                    <div class="floating-icon icon-1">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="floating-icon icon-2">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="floating-icon icon-3">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="floating-icon icon-4">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="center-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FEATURES SECTION ===== -->
        <section class="features-section">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Semua yang Anda butuhkan untuk mengelola ekstrakurikuler</p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Manajemen Anggota</h4>
                    <p>Kelola data anggota dengan mudah. Tambah, edit, dan lihat profil anggota secara lengkap.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4>Rekap Kehadiran</h4>
                    <p>Pantau kehadiran anggota dan pelatih dengan rekap bulanan dan tahunan yang informatif.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>Penilaian</h4>
                    <p>Input dan kelola nilai anggota dengan sistem penilaian yang terintegrasi dan mudah digunakan.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <h4>Dokumentasi Kegiatan</h4>
                    <p>Unggah dan kelola foto kegiatan ekstrakurikuler untuk dokumentasi yang rapi.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h4>Template Surat</h4>
                    <p>Kelola template surat untuk berbagai keperluan administrasi dengan mudah.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h4>Dashboard Analitik</h4>
                    <p>Lihat ringkasan data dan statistik secara real-time untuk pengambilan keputusan.</p>
                </div>
            </div>
        </section>

        <!-- ===== FOOTER ===== -->
        <footer class="landing-footer">
            <p>&copy; {{ date('Y') }} SIMSKUL. All rights reserved.</p>
            <div class="footer-links">
                <a href="#"><i class="fas fa-envelope me-1"></i> support@simskul.com</a>
                <a href="#"><i class="fas fa-github me-1"></i> GitHub</a>
            </div>
        </footer>
    </div>
</body>
</html>