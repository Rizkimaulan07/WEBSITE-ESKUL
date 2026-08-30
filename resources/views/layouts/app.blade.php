<!-- resources/views/layouts/app.blade.php -->
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
        /* ===== ROOT VARIABLES - BIRU CERAH ===== */
        :root {
            --primary: #0ea5e9;
            --primary-light: #38bdf8;
            --primary-dark: #0284c7;
            --primary-bg: #f0f9ff;
            --secondary: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-main: #f0f7ff;
            --card-shadow: 0 8px 40px rgba(14, 165, 233, 0.06);
            --card-hover: 0 12px 50px rgba(14, 165, 233, 0.12);
            --radius: 16px;
            --radius-sm: 10px;
            --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --sidebar-width: 280px;
            --topbar-height: 72px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: #0f172a;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .text-muted {
            color: #475569 !important;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, #0c4a6e 0%, #0284c7 50%, #0c4a6e 100%);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1050;
            padding: 0;
            overflow-y: auto;
            transition: var(--transition);
            border-right: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.3);
        }

        /* ===== SIDEBAR BRAND ===== */
        .sidebar-brand {
            padding: 24px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-brand::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .sidebar-brand .brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: 0 4px 20px rgba(14, 165, 233, 0.3);
            transition: var(--transition);
            flex-shrink: 0;
            overflow: hidden;
            padding: 6px;
        }

        .sidebar-brand .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
        }

        .sidebar-brand .brand-icon:hover {
            transform: rotate(-8deg) scale(1.05);
            box-shadow: 0 6px 30px rgba(14, 165, 233, 0.4);
        }

        .sidebar-brand .brand-text h5 {
            color: #ffffff;
            font-weight: 800;
            font-size: 18px;
            margin: 0;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .sidebar-brand .brand-text small {
            color: rgba(255,255,255,0.78);
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ===== SIDEBAR MENU ===== */
        .sidebar-menu {
            padding: 16px 12px;
        }

        .sidebar-menu .menu-label {
            color: rgba(255,255,255,0.72);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 12px 16px 6px;
            font-weight: 700;
        }

        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.92);
            padding: 11px 16px;
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 13.5px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            position: relative;
            cursor: pointer;
        }

        .sidebar-menu .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleX(0);
            width: 3px;
            height: 28px;
            background: #ffffff;
            border-radius: 0 4px 4px 0;
            transition: var(--transition);
        }

        .sidebar-menu .nav-link:hover::before,
        .sidebar-menu .nav-link.active::before {
            transform: translateY(-50%) scaleX(1);
        }

        .sidebar-menu .nav-link:hover {
            color: #ffffff;
            background: rgba(255,255,255,0.08);
            transform: translateX(4px);
        }

        .sidebar-menu .nav-link.active {
            color: #ffffff;
            background: rgba(255,255,255,0.1);
        }

        .sidebar-menu .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-menu .nav-link .badge {
            margin-left: auto;
            background: rgba(255,255,255,0.15);
            color: #ffffff;
            font-size: 9px;
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ===== SIDEBAR USER - DENGAN FOTO PROFIL ===== */
        .sidebar-user {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            margin-top: 8px;
            background: rgba(255,255,255,0.03);
        }

        .sidebar-user .avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .sidebar-user .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-user .name {
            color: #ffffff;
            font-weight: 600;
            font-size: 14px;
            margin: 0;
        }

        .sidebar-user .role {
            color: rgba(255,255,255,0.78);
            font-size: 11px;
            margin: 0;
        }

        .sidebar-user .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            display: inline-block;
            margin-right: 6px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 0;
        }

        /* ===== TOPBAR GLASS ===== */
        .topbar {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.04) 0%, rgba(56, 189, 248, 0.06) 50%, rgba(14, 165, 233, 0.04) 100%);
            backdrop-filter: blur(24px) saturate(1.8);
            -webkit-backdrop-filter: blur(24px) saturate(1.8);
            padding: 14px 36px;
            border-bottom: 1px solid rgba(14, 165, 233, 0.12);
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: var(--topbar-height);
        }

        .topbar .page-title h4 {
            font-weight: 800;
            font-size: 20px;
            color: #0c4a6e;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .topbar .page-title p {
            color: #475569;
            margin: 0;
            font-size: 13px;
            font-weight: 500;
            max-width: 70vw;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbar .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar .topbar-right .date-display {
            color: #0c4a6e;
            font-size: 13px;
            font-weight: 500;
            padding: 6px 14px;
            background: rgba(14, 165, 233, 0.06);
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar .topbar-right .avatar-top {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 16px rgba(14, 165, 233, 0.15);
        }

        .topbar .topbar-right .avatar-top:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 24px rgba(14, 165, 233, 0.3);
        }

        .topbar .topbar-right .btn-logout {
            padding: 8px 16px;
            border: none;
            border-radius: 10px;
            background: rgba(239, 68, 68, 0.06);
            color: #ef4444;
            font-weight: 500;
            font-size: 13px;
            transition: var(--transition);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar .topbar-right .btn-logout:hover {
            background: #ef4444;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.3);
        }

        /* ===== SIDEBAR TOGGLE ===== */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: #0c4a6e;
            font-size: 22px;
            padding: 0;
            transition: var(--transition);
        }

        .sidebar-toggle:hover {
            color: #0ea5e9;
            transform: scale(1.1);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10, 10, 26, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1040;
            transition: var(--transition);
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 28px 36px;
            animation: fadeUp 0.6s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 300px;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar-toggle {
                display: block;
            }
            .main-content {
                margin-left: 0;
                min-width: 0;
            }
            .topbar {
                padding: 12px 16px;
            }
            .page-content {
                padding: 16px;
            }
            .sidebar-overlay.show {
                display: block;
            }
            .topbar .topbar-right .date-display {
                display: none;
            }
            .topbar .page-title h4 {
                font-size: 18px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }

        @media (max-width: 768px) {
            .topbar .page-title p {
                max-width: 55vw;
            }
        }

        @media (max-width: 576px) {
            .topbar {
                gap: 8px;
            }
            .topbar .page-title {
                min-width: 0;
            }
            .topbar .page-title h4 {
                font-size: 16px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .topbar .page-title p {
                display: none;
            }
            .topbar .topbar-right .btn-logout span {
                display: none;
            }
            .topbar .topbar-right .btn-logout {
                padding: 8px 12px;
            }
            .page-content {
                padding: 12px;
            }
            .sidebar {
                width: min(300px, 86vw);
            }
            .sidebar-menu .nav-link {
                font-size: 14px;
                padding: 12px 16px;
            }
        }

        /* ===== SPACING & FULL RESPONSIVE POLISH ===== */
        img,
        video,
        canvas,
        svg {
            max-width: 100%;
            height: auto;
        }

        .page-content > * {
            margin-bottom: 26px;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .main-content {
            min-width: 0;
        }

        .page-title h4 {
            word-break: break-word;
        }

        @media (max-width: 1200px) {
            .page-content {
                padding: 24px 28px;
            }
        }

        @media (max-width: 992px) {
            .page-content > * {
                margin-bottom: 20px;
            }
            .row > [class*="col-"] {
                margin-bottom: 14px;
            }
            .d-flex {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            .page-content {
                padding: 14px 16px;
            }
            .card,
            .premium-card,
            .stat-card-modern {
                border-radius: 16px !important;
            }
            .row.g-4 > [class*="col-"],
            .row.g-3 > [class*="col-"] {
                padding-bottom: 4px;
            }
            input,
            select,
            textarea,
            .form-control {
                font-size: 16px !important;
            }
        }

        @media (max-width: 576px) {
            .page-content {
                padding: 12px 10px;
            }
            .page-content > * {
                margin-bottom: 16px;
            }
            .topbar {
                min-height: 60px;
            }
            .table {
                font-size: 12px;
            }
            body {
                padding-bottom: env(safe-area-inset-bottom);
            }
        }

        @media (min-width: 992px) {
            .table-responsive {
                max-height: none;
            }
        }

        /* ===== RESPONSIVE: TABEL MENUMPUK KE BAWAH (BUKAN SCROLL KESAMPING) ===== */
        @media (max-width: 991.98px) {
            .table-responsive {
                overflow-x: visible !important;
                -webkit-overflow-scrolling: auto;
            }

            .table-responsive table {
                display: block;
                width: 100% !important;
            }

            .table-responsive table thead {
                display: none;
            }

            .table-responsive table tbody {
                display: block;
                width: 100%;
            }

            .table-responsive table tr {
                display: flex;
                flex-direction: column;
                width: 100% !important;
                margin-bottom: 14px;
                border: 1px solid rgba(14, 165, 233, 0.10);
                border-radius: 14px;
                padding: 8px;
                background: #fff;
                box-shadow: 0 2px 10px rgba(14, 165, 233, 0.05);
            }

            .table-responsive table td {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 10px;
                flex-wrap: wrap;
                width: 100% !important;
                padding: 8px 10px !important;
                text-align: left !important;
                border: none;
                border-bottom: 1px dashed rgba(14, 165, 233, 0.10);
            }

            .table-responsive table td:last-child {
                border-bottom: none;
            }

            .table-responsive table td::before {
                content: attr(data-label);
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #64748b;
                background: rgba(248, 250, 252, 0.6);
                padding: 2px 8px;
                border-radius: 6px;
                flex: 0 0 auto;
            }

            .table-responsive table td[colspan] {
                display: block !important;
                text-align: center !important;
            }

            .table-responsive table td[colspan]::before {
                content: none;
            }

            .table-responsive table td form {
                flex: 1 1 100%;
                justify-content: center;
            }

            .table-responsive table td .nilai-form,
            .table-responsive table td .catatan-form {
                width: 100%;
            }
        }

        /* ===== UTILITY ===== */
        .glass {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .text-gradient {
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-modern {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(14, 165, 233, 0.06);
            border: 1px solid rgba(14, 165, 233, 0.04);
            transition: all 0.3s ease;
        }

        .card-modern:hover {
            box-shadow: 0 8px 30px rgba(14, 165, 233, 0.08);
        }

        .card-modern .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(14, 165, 233, 0.04);
            padding: 20px 24px;
            font-weight: 600;
        }

        .card-modern .card-body {
            padding: 24px;
        }

        /* ===== TOMBOL DOWNLOAD SIDEBAR ===== */
        .btn-download-sidebar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            color: #ffffff;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            transition: var(--transition);
            margin-top: 16px;
            border: none;
            width: 100%;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
        }

        .btn-download-sidebar:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(14, 165, 233, 0.4);
            color: #ffffff;
        }

        /* ===== TOAST NOTIFICATION ===== */
        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 3000;
            display: flex;
            flex-direction: column;
            gap: 12px;
            pointer-events: none;
            max-width: min(92vw, 380px);
        }

        .toast-notif {
            pointer-events: auto;
            display: flex;
            align-items: center;
            gap: 14px;
            background: #ffffff;
            border-radius: 16px;
            padding: 14px 18px;
            box-shadow: 0 16px 50px rgba(2, 6, 23, 0.18), 0 4px 16px rgba(2, 6, 23, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
            position: relative;
            transform: translateX(120%);
            opacity: 0;
            transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.4s ease;
        }

        .toast-notif.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast-notif.hide {
            transform: translateX(120%);
            opacity: 0;
        }

        .toast-notif::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--toast-color, #0ea5e9);
        }

        .toast-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
            flex-shrink: 0;
            animation: toastPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .toast-notif.success .toast-icon { background: linear-gradient(135deg, #10b981, #34d399); }
        .toast-notif.error .toast-icon { background: linear-gradient(135deg, #ef4444, #f87171); }
        .toast-notif.warning .toast-icon { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
        .toast-notif.info .toast-icon { background: linear-gradient(135deg, #0ea5e9, #38bdf8); }

        .toast-body { flex: 1; min-width: 0; }
        .toast-title { font-weight: 700; font-size: 14px; color: #0f172a; margin: 0; }
        .toast-message { font-size: 13px; color: #475569; margin: 2px 0 0; line-height: 1.35; word-break: break-word; }

        .toast-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            padding: 4px;
            line-height: 1;
            transition: color 0.2s ease;
        }
        .toast-close:hover { color: #334155; }

        .toast-progress {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            background: var(--toast-color, #0ea5e9);
            width: 100%;
            transform-origin: left;
        }

        @keyframes toastPop {
            0% { transform: scale(0.4) rotate(-90deg); opacity: 0; }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }

        @keyframes toastProgress {
            from { transform: scaleX(1); }
            to { transform: scaleX(0); }
        }

        /* ============================================================
           SHARED UI COMPONENTS (satu sumber gaya untuk seluruh halaman)
           ============================================================ */
        .hero-gradient {
            background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 30%, #38bdf8 60%, #7dd3fc 100%) !important;
            color: #ffffff;
        }
        .hero-gradient-green {
            background: linear-gradient(135deg, #064e3b 0%, #15803d 30%, #22c55e 60%, #86efac 100%) !important;
            color: #ffffff;
        }
        .page-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.7);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(14, 165, 233, 0.08);
        }
        .page-card .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(14, 165, 233, 0.08);
            padding: 20px 24px;
        }
        .page-card .card-body { padding: 24px; }

        .btn-primary-gradient {
            background: linear-gradient(135deg, #0ea5e9, #38bdf8) !important;
            color: #ffffff;
            border: none;
            font-weight: 600;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary-gradient:hover, .btn-primary-gradient:focus {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(14, 165, 233, 0.4);
        }
        .btn-secondary-custom {
            background: transparent;
            color: #475569;
            border: 2px solid #e2e8f0;
            font-weight: 500;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-secondary-custom:hover {
            border-color: #0ea5e9;
            color: #0ea5e9;
            background: rgba(14, 165, 233, 0.04);
            transform: translateY(-2px);
        }

        .stat-card-modern {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.6);
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(14, 165, 233, 0.06);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }
        .stat-card-modern:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 40px rgba(14, 165, 233, 0.14);
        }

        .table-modern {
            width: 100%;
            border-collapse: collapse;
        }
        .table-modern thead th {
            background: #f0f9ff;
            color: #0c4a6e;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border-bottom: 1px solid rgba(14, 165, 233, 0.1);
            white-space: nowrap;
        }
        .table-modern tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            font-size: 14px;
            color: #334155;
            vertical-align: middle;
        }
        .table-modern tbody tr { transition: background 0.2s ease; }
        .table-modern tbody tr:hover { background: #f8fbff; }

    </style>

    @stack('styles')
</head>
<body>
    <div id="loadingOverlayRoot"></div>
    <div id="toast-container" aria-live="polite"></div>
    @php
        $__toast = null;
        if (session('success')) { $__toast = ['type' => 'success', 'message' => session('success')]; }
        elseif (session('error')) { $__toast = ['type' => 'error', 'message' => session('error')]; }
        elseif (session('warning')) { $__toast = ['type' => 'warning', 'message' => session('warning')]; }
        elseif (session('info')) { $__toast = ['type' => 'info', 'message' => session('info')]; }
        elseif (isset($errors) && $errors instanceof \Illuminate\Support\ViewErrorBag && $errors->any()) {
            $__toast = ['type' => 'error', 'message' => 'Terjadi kesalahan. Periksa kembali data yang Anda isi.'];
        }
    @endphp
    @if(!empty($__toast))
        <script>window.__toastData = {!! json_encode($__toast) !!};</script>
    @endif
    <div class="app-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <!-- ===== BRAND / LOGO ===== -->
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <img src="{{ asset('images/logo-smk-bppi.png') }}" alt="Logo SMK BPPI">
                </div>
                <div class="brand-text">
                    <h5>SIMSKUL</h5>
                    <small>Sistem Manajemen Eskul</small>
                </div>
            </div>

            <div class="sidebar-menu">
                @if(auth()->check())
                    @php
                        $user = auth()->user();
                    @endphp

                    @if($user->role == 'admin')
                        <!-- ===== MENU ADMIN ===== -->
                        <div class="menu-label">Menu Utama</div>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.ekskul.index') }}" class="nav-link {{ request()->routeIs('admin.ekskul.*') ? 'active' : '' }}">
                            <i class="fas fa-trophy"></i> Ekstrakurikuler
                        </a>
                        <a href="{{ route('admin.anggota.index') }}" class="nav-link {{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Data Anggota
                            <span class="badge">{{ \App\Models\User::where('role', 'anggota')->count() }}</span>
                        </a>
                        <a href="{{ route('admin.pelatih.index') }}" class="nav-link {{ request()->routeIs('admin.pelatih.*') ? 'active' : '' }}">
                            <i class="fas fa-chalkboard-teacher"></i> Data Pelatih
                            <span class="badge">{{ \App\Models\User::where('role', 'pelatih')->count() }}</span>
                        </a>
                        <a href="{{ route('admin.kehadiran_pelatih') }}" class="nav-link {{ request()->routeIs('admin.kehadiran_pelatih') ? 'active' : '' }}">
                            <i class="fas fa-user-check"></i> Kehadiran Pelatih
                        </a>
                        <a href="{{ route('admin.kehadiran_anggota') }}" class="nav-link {{ request()->routeIs('admin.kehadiran_anggota') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list"></i> Kehadiran Anggota
                        </a>
                        <a href="{{ route('admin.nilai.index') }}" class="nav-link {{ request()->routeIs('admin.nilai.*') ? 'active' : '' }}">
                            <i class="fas fa-star"></i> Nilai Anggota
                            <span class="badge">{{ \App\Models\NilaiAnggota::count() }}</span>
                        </a>
                        <a href="{{ route('admin.template-surat.index') }}" class="nav-link {{ request()->routeIs('admin.template-surat.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i> Template Surat
                        </a>
                        <a href="{{ route('admin.dokumentasi.index') }}" class="nav-link {{ request()->routeIs('admin.dokumentasi.*') ? 'active' : '' }}">
                            <i class="fas fa-image"></i> Dokumentasi
                        </a>

                    @elseif($user->role == 'pelatih')
                        <!-- ===== MENU PELATIH ===== -->
                        <div class="menu-label">Menu Utama</div>
                        <a href="{{ route('pelatih.dashboard') }}" class="nav-link {{ request()->routeIs('pelatih.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> Dashboard
                        </a>
                        <a href="{{ route('pelatih.kehadiran_pelatih') }}" class="nav-link {{ request()->routeIs('pelatih.kehadiran_pelatih*') ? 'active' : '' }}">
                            <i class="fas fa-user-check"></i> Kehadiran Saya
                        </a>
                        <a href="{{ route('pelatih.kehadiran') }}" class="nav-link {{ request()->routeIs('pelatih.kehadiran') && !request()->routeIs('pelatih.kehadiran_pelatih*') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list"></i> Kehadiran Anggota
                        </a>
                        <a href="{{ route('pelatih.kehadiran.rekap') }}" class="nav-link {{ request()->routeIs('pelatih.kehadiran.rekap*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i> Rekap Kehadiran Anggota
                        </a>
                        <a href="{{ route('pelatih.nilai') }}" class="nav-link {{ request()->routeIs('pelatih.nilai*') ? 'active' : '' }}">
                            <i class="fas fa-star"></i> Nilai Anggota
                        </a>
                        <a href="{{ route('pelatih.dokumentasi') }}" class="nav-link {{ request()->routeIs('pelatih.dokumentasi*') ? 'active' : '' }}">
                            <i class="fas fa-camera"></i> Dokumentasi
                        </a>

                    @elseif($user->role == 'anggota')
                        <!-- ===== MENU ANGGOTA ===== -->
                        <div class="menu-label">Menu Utama</div>
                        <a href="{{ route('anggota.dashboard') }}" class="nav-link {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> Dashboard
                        </a>
                        <a href="{{ route('anggota.kehadiran') }}" class="nav-link {{ request()->routeIs('anggota.kehadiran') ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i> Kehadiran Saya
                        </a>
                        <a href="{{ route('anggota.nilai') }}" class="nav-link {{ request()->routeIs('anggota.nilai') ? 'active' : '' }}">
                            <i class="fas fa-star"></i> Nilai Saya
                        </a>
                    @endif
                @endif

                <!-- ===== PENGATURAN ===== -->
                <div class="menu-label">Pengaturan</div>
                <a href="{{ route('profile.show') }}" class="nav-link">
                    <i class="fas fa-user-cog"></i> Profil
                </a>
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

                <!-- ===== TOMBOL DOWNLOAD APLIKASI ===== -->
                @php
                    $apkPath = file_exists(public_path('downloads/SIMSKUL.apk')) ? public_path('downloads/SIMSKUL.apk') : public_path('apk/SIMSKUL.apk');
                    $apkExists = file_exists($apkPath);
                @endphp

                @if($apkExists)
                    <a href="{{ asset('downloads/SIMSKUL.apk') }}" class="btn-download-sidebar" download>
                        <i class="fas fa-download"></i> Unduh Aplikasi
                    </a>
                @else
                    <a href="{{ route('admin.downloads.index') }}" class="btn-download-sidebar">
                        <i class="fas fa-download"></i> Unduh Aplikasi
                    </a>
                @endif
            </div>

            @if(auth()->check())
            <div class="sidebar-user">
                <div class="d-flex align-items-center gap-3">
                    <!-- ===== FOTO PROFIL DI SIDEBAR ===== -->
                    <div class="avatar">
                        <img src="{{ Auth::user()->avatar_url }}" 
                             alt="{{ Auth::user()->name }}">
                    </div>
                    <div>
                        <p class="name">{{ Auth::user()->name }}</p>
                        <p class="role">
                            <span class="status-dot"></span>
                            {{ ucfirst(Auth::user()->role) }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <nav class="topbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="sidebar-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-title">
                        <h4>@yield('title', 'Dashboard')</h4>
                        <p>@yield('subtitle', '')</p>
                    </div>
                </div>
                <div class="topbar-right">
                    <span class="date-display">
                        <i class="far fa-calendar-alt"></i>
                        {{ now()->translatedFormat('d F Y') }}
                    </span>
                    <div class="avatar-top">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i> <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('show');
            }
        });

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 992) {
                if (sidebar.classList.contains('open') && 
                    !sidebar.contains(event.target) && 
                    !toggleBtn.contains(event.target)) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('show');
                }
            }
        });

        // ===== RESPONSIVE: INJEKSI LABEL KOLOM UNTUK TABEL STACK DI HP =====
        function initTableLabels() {
            document.querySelectorAll('.table-responsive table').forEach(function (table) {
                var thead = table.querySelector('thead');
                if (!thead) return;
                var headers = [];
                thead.querySelectorAll('th').forEach(function (th) {
                    headers.push(th.textContent.trim());
                });
                table.querySelectorAll('tbody tr').forEach(function (tr) {
                    var tds = tr.querySelectorAll('td');
                    for (var i = 0; i < tds.length; i++) {
                        var td = tds[i];
                        if (td.hasAttribute('colspan') || !headers[i]) continue;
                        td.setAttribute('data-label', headers[i]);
                    }
                });
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTableLabels);
        } else {
            initTableLabels();
        }

        // ===== TOAST NOTIFICATION SYSTEM =====
        function showToast(type, message, title) {
            var container = document.getElementById('toast-container');
            if (!container) return;

            var config = {
                success: { title: 'Berhasil!', icon: 'fas fa-check', color: '#10b981' },
                error:   { title: 'Gagal!',   icon: 'fas fa-times',  color: '#ef4444' },
                warning: { title: 'Perhatian', icon: 'fas fa-exclamation-triangle', color: '#f59e0b' },
                info:    { title: 'Info',     icon: 'fas fa-info-circle', color: '#0ea5e9' }
            };
            var c = config[type] || config.info;
            var finalTitle = title || c.title;

            var toast = document.createElement('div');
            toast.className = 'toast-notif ' + type;
            toast.style.setProperty('--toast-color', c.color);
            toast.innerHTML =
                '<div class="toast-icon"><i class="' + c.icon + '"></i></div>' +
                '<div class="toast-body">' +
                    '<p class="toast-title">' + finalTitle + '</p>' +
                    '<p class="toast-message">' + message + '</p>' +
                '</div>' +
                '<button class="toast-close" type="button"><i class="fas fa-xmark"></i></button>' +
                '<div class="toast-progress"></div>';

            container.appendChild(toast);

            requestAnimationFrame(function() {
                toast.classList.add('show');
            });

            var duration = 4500;
            var progress = toast.querySelector('.toast-progress');
            if (progress) {
                progress.style.animation = 'toastProgress ' + duration + 'ms linear forwards';
            }
            var closeTimer = setTimeout(function() { dismiss(toast); }, duration);

            toast.querySelector('.toast-close').addEventListener('click', function() {
                clearTimeout(closeTimer);
                dismiss(toast);
            });

            function dismiss(el) {
                el.classList.remove('show');
                el.classList.add('hide');
                setTimeout(function() { el.remove(); }, 450);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var data = window.__toastData || null;
            if (data) {
                showToast(data.type, data.message);
                window.__toastData = null;
            }
        });

        // ===== REGISTER SERVICE WORKER (Untuk PWA) =====
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