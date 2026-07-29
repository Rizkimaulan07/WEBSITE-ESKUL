<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - EkskulPro</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* ===== ROOT VARIABLES - Warna Cantik ===== */
        :root {
            --primary: #6C63FF;
            --primary-dark: #5A52D5;
            --primary-light: #A29BFE;
            --primary-bg: rgba(108, 99, 255, 0.1);
            --primary-glow: rgba(108, 99, 255, 0.3);
            
            --secondary: #FF6B6B;
            --secondary-light: #FF8E8E;
            
            --accent: #00D2D3;
            --accent-light: #55EFC4;
            
            --gradient-1: linear-gradient(135deg, #6C63FF, #A29BFE);
            --gradient-2: linear-gradient(135deg, #FF6B6B, #FF8E8E);
            --gradient-3: linear-gradient(135deg, #00D2D3, #55EFC4);
            --gradient-4: linear-gradient(135deg, #FDCB6E, #F39C12);
            --gradient-5: linear-gradient(135deg, #6C63FF, #00D2D3);
            
            --success: #00B894;
            --warning: #FDCB6E;
            --danger: #FF6B6B;
            --info: #74B9FF;
            
            --radius: 20px;
            --radius-sm: 12px;
            --radius-xs: 8px;
            
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
            --shadow-md: 0 8px 30px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 60px rgba(0,0,0,0.12);
            --shadow-xl: 0 30px 80px rgba(0,0,0,0.16);
            --shadow-glow: 0 8px 40px rgba(108, 99, 255, 0.25);
            
            --transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            --transition-smooth: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* ===== DARK MODE ===== */
        .dark {
            --bg-body: #0a0a1a;
            --bg-card: #14142e;
            --bg-card-hover: #1e1e42;
            --bg-input: #1a1a38;
            --bg-nav: rgba(10, 10, 26, 0.9);
            --text-primary: #f0f0f5;
            --text-secondary: #8888bb;
            --text-muted: #555577;
            --border-color: #2a2a4a;
            --shadow-md: 0 8px 30px rgba(0,0,0,0.5);
            --shadow-lg: 0 20px 60px rgba(0,0,0,0.6);
            --shadow-xl: 0 30px 80px rgba(0,0,0,0.7);
            --shadow-glow: 0 8px 40px rgba(108, 99, 255, 0.15);
        }

        .light {
            --bg-body: #f0f2f8;
            --bg-card: #ffffff;
            --bg-card-hover: #f8f9fe;
            --bg-input: #f1f4f9;
            --bg-nav: rgba(255, 255, 255, 0.9);
            --text-primary: #0f0f1a;
            --text-secondary: #6b6b8a;
            --text-muted: #a0a0b8;
            --border-color: #e2e8f0;
            --shadow-md: 0 8px 30px rgba(0,0,0,0.06);
            --shadow-lg: 0 20px 60px rgba(0,0,0,0.08);
            --shadow-xl: 0 30px 80px rgba(0,0,0,0.1);
            --shadow-glow: 0 8px 40px rgba(108, 99, 255, 0.2);
        }

        /* ===== BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            transition: background 0.6s ease, color 0.6s ease;
            min-height: 100vh;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            position: relative;
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-body); }
        ::-webkit-scrollbar-thumb { 
            background: var(--gradient-1);
            border-radius: 10px; 
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: var(--bg-nav);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 4px 0;
            transition: var(--transition-smooth);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-custom .navbar-brand {
            font-weight: 900;
            font-size: 1.3rem;
            color: var(--text-primary) !important;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            position: relative;
        }

        .navbar-custom .navbar-brand .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            transition: var(--transition);
            box-shadow: var(--shadow-glow);
        }

        .navbar-custom .navbar-brand:hover .brand-icon {
            transform: rotate(-10deg) scale(1.05) translateY(-2px);
        }

        .navbar-custom .navbar-brand .brand-text {
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .navbar-custom .navbar-brand .brand-dot {
            width: 6px;
            height: 6px;
            background: var(--secondary);
            border-radius: 50%;
            display: inline-block;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.5; }
        }

        /* ===== SIDEBAR ===== */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 9998;
            display: none;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            animation: fadeIn 0.4s ease;
        }
        .sidebar-overlay.active { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateX(-100%) scale(0.95); opacity: 0; }
            to { transform: translateX(0) scale(1); opacity: 1; }
        }

        .sidebar-mobile {
            position: fixed;
            top: 0;
            left: -100%;
            width: 320px;
            height: 100vh;
            background: var(--bg-card);
            z-index: 9999;
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            padding: 28px 24px;
            overflow-y: auto;
            border-right: 1px solid var(--border-color);
            box-shadow: var(--shadow-xl);
        }
        .sidebar-mobile.active { 
            left: 0;
            animation: slideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .sidebar-mobile .close-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 24px;
            transition: var(--transition);
            padding: 4px;
        }
        .sidebar-mobile .close-btn:hover { 
            color: var(--text-primary); 
            transform: rotate(90deg) scale(1.1);
        }

        .sidebar-mobile .user-card {
            padding: 20px;
            background: var(--gradient-1);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .sidebar-mobile .user-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            animation: floatBanner 20s infinite;
        }

        .sidebar-mobile .user-card .avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 20px;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .sidebar-mobile .user-card .info h6 {
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
            color: white;
        }
        .sidebar-mobile .user-card .info small {
            color: rgba(255,255,255,0.7);
            font-size: 0.8rem;
        }

        .sidebar-mobile .nav-link {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .sidebar-mobile .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 4px;
            height: 28px;
            background: var(--gradient-1);
            border-radius: 0 4px 4px 0;
            transition: var(--transition);
        }

        .sidebar-mobile .nav-link:hover::before,
        .sidebar-mobile .nav-link.active::before {
            transform: translateY(-50%) scaleY(1);
        }

        .sidebar-mobile .nav-link:hover {
            background: var(--bg-body);
            color: var(--text-primary);
            transform: translateX(6px);
        }

        .sidebar-mobile .nav-link.active {
            background: var(--primary-bg);
            color: var(--primary);
        }

        .sidebar-mobile .nav-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            transition: var(--transition);
        }

        .sidebar-mobile .nav-link:hover i {
            transform: scale(1.2) rotate(-5deg);
        }

        .sidebar-mobile .divider {
            border-top: 1px solid var(--border-color);
            margin: 16px 0;
        }

        .sidebar-mobile .btn-logout {
            background: none;
            border: none;
            color: var(--text-secondary);
            width: 100%;
            text-align: left;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sidebar-mobile .btn-logout:hover {
            background: rgba(255, 107, 107, 0.1);
            color: var(--secondary);
            transform: translateX(6px);
        }

        .sidebar-mobile .btn-logout i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        /* ===== CARDS - Premium ===== */
        .card-modern {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            transition: var(--transition-smooth);
            overflow: hidden;
            position: relative;
        }

        .card-modern::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: var(--radius);
            padding: 1px;
            background: var(--gradient-1);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: var(--transition-smooth);
        }

        .card-modern:hover::before {
            opacity: 1;
        }

        .card-modern:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: var(--shadow-glow);
            border-color: transparent;
        }

        .card-modern .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 20px 24px;
            font-weight: 700;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-modern .card-header .badge-gradient {
            background: var(--gradient-1);
            color: white;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .card-modern .card-body { padding: 24px; }

        /* ===== STATS - Premium ===== */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 24px;
            transition: var(--transition-smooth);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-1);
            opacity: 0;
            transition: var(--transition-smooth);
        }

        .stat-card:hover::after {
            opacity: 1;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-glow);
            border-color: var(--primary-light);
        }

        .stat-card .icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
            transition: var(--transition);
        }

        .stat-card:hover .icon-wrap {
            transform: scale(1.1) rotate(-8deg);
        }

        .stat-card .icon-wrap.gradient-1 { background: var(--gradient-1); color: white; }
        .stat-card .icon-wrap.gradient-2 { background: var(--gradient-2); color: white; }
        .stat-card .icon-wrap.gradient-3 { background: var(--gradient-3); color: white; }
        .stat-card .icon-wrap.gradient-4 { background: var(--gradient-4); color: white; }

        .stat-card .number {
            font-size: 2.4rem;
            font-weight: 900;
            line-height: 1.2;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: countUp 1s ease;
        }

        @keyframes countUp {
            from { opacity: 0; transform: translateY(20px) scale(0.9); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .stat-card .label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-top: 2px;
        }

        .stat-card .trend {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .stat-card .trend.up { background: rgba(0, 184, 148, 0.12); color: var(--success); }
        .stat-card .trend.down { background: rgba(255, 107, 107, 0.12); color: var(--danger); }

        /* ===== WELCOME BANNER ===== */
        .welcome-banner {
            background: var(--gradient-5);
            border-radius: var(--radius);
            padding: 36px 44px;
            color: white;
            position: relative;
            overflow: hidden;
            border: none;
            box-shadow: var(--shadow-glow);
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
            animation: floatBanner 20s ease-in-out infinite;
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -40%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
            animation: floatBanner 25s ease-in-out infinite reverse;
        }

        @keyframes floatBanner {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(50px, -50px) scale(1.15); }
            66% { transform: translate(-40px, 40px) scale(0.85); }
        }

        .welcome-banner .bg-icon {
            position: absolute;
            right: 30px;
            bottom: 10px;
            font-size: 120px;
            opacity: 0.06;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .welcome-banner h2 {
            font-weight: 900;
            font-size: 2rem;
            margin: 0;
            position: relative;
            z-index: 1;
            animation: slideRight 0.8s ease;
        }

        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .welcome-banner p {
            opacity: 0.85;
            margin: 6px 0 0 0;
            font-size: 1.05rem;
            position: relative;
            z-index: 1;
            font-weight: 400;
        }

        .welcome-banner .badge-light {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255,255,255,0.1);
            transition: var(--transition);
        }

        .welcome-banner .badge-light:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
        }

        /* ===== BUTTONS - Premium ===== */
        .btn-primary-custom {
            background: var(--gradient-1);
            border: none;
            color: white;
            padding: 10px 28px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.85rem;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px var(--primary-glow);
        }

        .btn-primary-custom::after {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gradient-1);
            opacity: 0;
            transition: var(--transition);
            background-size: 200% 200%;
            animation: gradientMove 3s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .btn-primary-custom:hover::after {
            opacity: 1;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 40px var(--primary-glow);
            color: white;
        }

        .btn-primary-custom span { position: relative; z-index: 1; }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid var(--border-color);
            color: var(--text-secondary);
            padding: 10px 28px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline-custom:hover {
            background: var(--bg-body);
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        /* ===== TABLE ===== */
        .table-responsive-custom { overflow-x: auto; }

        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table-custom thead th {
            padding: 12px 18px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-secondary);
            font-weight: 700;
            background: transparent;
            border: none;
        }

        .table-custom tbody tr {
            background: var(--bg-card);
            border-radius: var(--radius-sm);
            transition: var(--transition-smooth);
            cursor: pointer;
            border: 1px solid transparent;
            box-shadow: var(--shadow-sm);
        }

        .table-custom tbody tr:hover {
            border-color: var(--primary-light);
            box-shadow: var(--shadow-glow);
            transform: translateY(-3px) scale(1.01);
        }

        .table-custom tbody td {
            padding: 14px 18px;
            border: none;
            font-size: 0.9rem;
            color: var(--text-primary);
            vertical-align: middle;
        }

        .table-custom tbody tr:first-child td:first-child { border-radius: var(--radius-sm) 0 0 var(--radius-sm); }
        .table-custom tbody tr:first-child td:last-child { border-radius: 0 var(--radius-sm) var(--radius-sm) 0; }

        /* ===== FORM ===== */
        .form-group { margin-bottom: 20px; position: relative; }

        .form-group label {
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-bottom: 6px;
            display: block;
            letter-spacing: 0.3px;
        }

        .form-group .form-control {
            width: 100%;
            padding: 12px 18px 12px 48px;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-sm);
            background: var(--bg-input);
            color: var(--text-primary);
            font-size: 0.9rem;
            transition: var(--transition);
            height: 48px;
        }

        .form-group .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 4px var(--primary-bg);
            background: var(--bg-card);
            transform: scale(1.01);
        }

        .form-group .input-icon {
            position: absolute;
            left: 16px;
            bottom: 14px;
            color: var(--text-secondary);
            font-size: 20px;
            transition: var(--transition);
        }

        .form-group .form-control:focus + .input-icon {
            color: var(--primary);
            transform: scale(1.1) translateX(2px);
        }

        /* ===== BADGE ===== */
        .badge-status {
            padding: 5px 16px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
            letter-spacing: 0.3px;
        }

        .badge-status:hover {
            transform: scale(1.05);
        }

        .badge-hadir { background: rgba(0, 184, 148, 0.12); color: var(--success); }
        .badge-izin { background: rgba(253, 203, 110, 0.12); color: var(--warning); }
        .badge-sakit { background: rgba(255, 107, 107, 0.12); color: var(--danger); }
        .badge-alpa { background: rgba(255, 107, 107, 0.12); color: var(--danger); }

        /* ===== PROGRESS ===== */
        .progress-custom {
            height: 6px;
            border-radius: 10px;
            background: var(--border-color);
            overflow: hidden;
            margin-top: 12px;
            position: relative;
        }

        .progress-custom .progress-bar {
            height: 100%;
            border-radius: 10px;
            background: var(--gradient-1);
            transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* ===== GALLERY ===== */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            border-radius: var(--radius-sm);
            overflow: hidden;
            aspect-ratio: 1;
            cursor: pointer;
            position: relative;
            transition: var(--transition-smooth);
            box-shadow: var(--shadow-sm);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-smooth);
        }

        .gallery-item:hover {
            transform: scale(1.03);
            box-shadow: var(--shadow-glow);
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-item .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 24px;
            background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);
            color: white;
            transform: translateY(100%);
            transition: var(--transition-smooth);
        }

        .gallery-item:hover .overlay {
            transform: translateY(0);
        }

        /* ===== FAB ===== */
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient-1);
            color: white;
            border: none;
            box-shadow: 0 8px 40px var(--primary-glow);
            font-size: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            z-index: 100;
            cursor: pointer;
            animation: pulse 2s infinite;
        }

        .fab:hover {
            transform: scale(1.15) rotate(90deg);
            box-shadow: 0 12px 60px var(--primary-glow);
            color: white;
        }

        /* ===== THEME TOGGLE ===== */
        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            background: transparent;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            cursor: pointer;
            font-size: 18px;
            position: relative;
        }

        .theme-toggle:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: rotate(180deg) scale(1.1);
            box-shadow: 0 0 30px var(--primary-glow);
        }

        /* ===== DROPDOWN ===== */
        .dropdown-menu {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-xl);
            padding: 8px;
            min-width: 200px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            animation: slideDown 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .dropdown-menu .dropdown-item {
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 0.85rem;
            color: var(--text-primary);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .dropdown-menu .dropdown-item:hover {
            background: var(--bg-body);
            color: var(--text-primary);
            transform: translateX(4px);
        }

        .dropdown-menu .dropdown-item i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .dropdown-menu .dropdown-item.text-danger:hover {
            background: rgba(255, 107, 107, 0.08);
            color: var(--danger);
        }

        /* ===== ALERT ===== */
        .alert-custom {
            padding: 16px 22px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 0.9rem;
            border: 1px solid transparent;
            animation: slideDown 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-weight: 500;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .alert-custom.success {
            background: rgba(0, 184, 148, 0.08);
            border-color: rgba(0, 184, 148, 0.15);
            color: var(--success);
        }

        .alert-custom.error {
            background: rgba(255, 107, 107, 0.08);
            border-color: rgba(255, 107, 107, 0.15);
            color: var(--danger);
        }

        .alert-custom i {
            font-size: 22px;
        }

        /* ===== TOAST ===== */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            max-width: 400px;
            width: 100%;
        }

        /* ===== SPINNER ===== */
        .spinner-custom {
            width: 40px;
            height: 40px;
            border: 3px solid var(--border-color);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s cubic-bezier(0.34, 1.56, 0.64, 1) infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== AVATAR ===== */
        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--gradient-1);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
            transition: var(--transition);
            box-shadow: 0 4px 15px var(--primary-glow);
        }

        .avatar:hover {
            transform: scale(1.1);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .welcome-banner { padding: 24px 20px; }
            .welcome-banner h2 { font-size: 1.4rem; }
            .welcome-banner .bg-icon { font-size: 60px; }
            .stat-card .number { font-size: 1.6rem; }
            .gallery-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 14px; }
            .card-modern .card-body { padding: 18px; }
            .sidebar-mobile { width: 290px; }
            .fab { width: 50px; height: 50px; font-size: 20px; bottom: 16px; right: 16px; }
            .table-custom thead th { font-size: 0.6rem; padding: 8px 12px; }
            .table-custom tbody td { font-size: 0.82rem; padding: 10px 12px; }
        }

        @media (max-width: 480px) {
            .stat-card { padding: 16px; }
            .stat-card .icon-wrap { width: 44px; height: 44px; font-size: 18px; }
            .stat-card .number { font-size: 1.2rem; }
            .gallery-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; }
            .welcome-banner { padding: 16px; }
            .welcome-banner h2 { font-size: 1.1rem; }
            .welcome-banner p { font-size: 0.9rem; }
            .card-modern .card-header { padding: 14px 16px; font-size: 0.85rem; }
            .card-modern .card-body { padding: 14px; }
            .sidebar-mobile { width: 270px; padding: 16px; }
            .navbar-custom .navbar-brand { font-size: 1rem; }
            .navbar-custom .navbar-brand .brand-icon { width: 32px; height: 32px; font-size: 14px; }
            .form-group .form-control { height: 42px; font-size: 0.85rem; padding: 10px 14px 10px 42px; }
            .form-group .input-icon { bottom: 11px; font-size: 16px; left: 14px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Global Loader -->
    <div id="globalLoader" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:99999; backdrop-filter:blur(12px);">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center;">
            <div class="spinner-custom mx-auto"></div>
            <p class="text-white mt-4" style="font-size:0.95rem; font-weight:300; letter-spacing:1px;">Loading...</p>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Mobile Sidebar -->
    <div class="sidebar-mobile" id="mobileSidebar">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 style="font-weight:900; font-size:1.1rem; margin:0; background:var(--gradient-1); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
                <i class="bi bi-grid"></i> Menu
            </h5>
            <button class="close-btn" id="closeSidebar"><i class="bi bi-x-lg"></i></button>
        </div>

        <div class="user-card">
            <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <div class="info">
                <h6>{{ Auth::user()->name }}</h6>
                <small>{{ ucfirst(Auth::user()->role) }}</small>
            </div>
        </div>

        <nav>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            @if(Auth::user()->role == 'admin')
            <a href="{{ route('ekskul.index') }}" class="nav-link {{ request()->routeIs('ekskul*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Data Ekskul
            </a>
            <a href="{{ route('anggota.index') }}" class="nav-link {{ request()->routeIs('anggota*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Anggota
            </a>
            <a href="{{ route('template-surat.index') }}" class="nav-link {{ request()->routeIs('template-surat*') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i> Template Surat
            </a>
            @endif

            @if(Auth::user()->role == 'pelatih')
            <a href="{{ route('kehadiran.index') }}" class="nav-link {{ request()->routeIs('kehadiran*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i> Kehadiran
            </a>
            <a href="{{ route('dokumentasi.index') }}" class="nav-link {{ request()->routeIs('dokumentasi*') ? 'active' : '' }}">
                <i class="bi bi-images"></i> Dokumentasi
            </a>
            <a href="{{ route('surat.create') }}" class="nav-link {{ request()->routeIs('surat*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i> Buat Surat
            </a>
            @endif

            @if(Auth::user()->role == 'anggota')
            <a href="{{ route('anggota.dashboard') }}" class="nav-link">
                <i class="bi bi-calendar-check"></i> Kehadiran Saya
            </a>
            <a href="{{ route('dokumentasi.publik') }}" class="nav-link">
                <i class="bi bi-images"></i> Galeri
            </a>
            @endif

            <div class="divider"></div>

            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
                <i class="bi bi-person"></i> Profile
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-custom sticky-top">
        <div class="container-fluid">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-link p-0" id="menuToggle" style="color:var(--text-secondary);">
                    <i class="bi bi-list fs-2"></i>
                </button>
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <span class="brand-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                    <span class="brand-text">EkskulPro</span>
                    <span class="brand-dot"></span>
                </a>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button class="theme-toggle" id="themeToggle">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>

                <div class="dropdown d-none d-md-block">
                    <button class="btn btn-link p-0 dropdown-toggle" data-bs-toggle="dropdown" style="color:var(--text-primary);">
                        <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-eye"></i> Lihat Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-3 py-md-4">
        @if(session('success'))
            <div class="alert-custom success">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom error">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- FAB -->
    @yield('fab')

    <!-- Toast -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ===== AOS =====
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
            easing: 'cubic-bezier(0.34, 1.56, 0.64, 1)'
        });

        // ===== THEME =====
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;
        const saved = localStorage.getItem('theme') || 'light';
        html.className = saved;
        updateIcon(saved);

        themeToggle.addEventListener('click', () => {
            const next = html.className === 'light' ? 'dark' : 'light';
            html.className = next;
            localStorage.setItem('theme', next);
            updateIcon(next);
            showToast('✨ Mode ' + next + ' diaktifkan', 'info');
        });

        function updateIcon(theme) {
            themeIcon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        }

        // ===== SIDEBAR =====
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('mobileSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        menuToggle.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });

        // ===== TOAST =====
        function showToast(msg, type = 'success') {
            const container = document.getElementById('toastContainer');
            const colors = {
                success: '#00B894',
                error: '#FF6B6B',
                warning: '#FDCB6E',
                info: '#6C63FF'
            };
            const icons = {
                success: 'check-circle-fill',
                error: 'x-circle-fill',
                warning: 'exclamation-triangle-fill',
                info: 'info-circle-fill'
            };
            
            const toast = document.createElement('div');
            toast.className = 'toast show';
            toast.style.cssText = `
                background: var(--bg-card);
                border-left: 4px solid ${colors[type]};
                border-radius: 14px;
                box-shadow: var(--shadow-xl);
                margin-bottom: 10px;
                animation: slideDown 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
                border: 1px solid var(--border-color);
            `;
            toast.innerHTML = `
                <div class="toast-body d-flex align-items-center gap-3 p-3">
                    <i class="bi bi-${icons[type]}" style="color:${colors[type]};font-size:22px;"></i>
                    <span style="flex:1; font-weight:500;">${msg}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
            `;
            container.appendChild(toast);
            setTimeout(() => { 
                toast.style.opacity = '0'; 
                toast.style.transition = 'opacity 0.4s ease'; 
                setTimeout(() => toast.remove(), 400); 
            }, 4000);
        }

        // ===== DELETE CONFIRMATION =====
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-confirm')) {
                e.preventDefault();
                const form = e.target.closest('form');
                Swal.fire({
                    title: 'Hapus data ini?',
                    text: 'Data akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#FF6B6B',
                    cancelButtonColor: '#6b6b8a',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    background: 'var(--bg-card)',
                    color: 'var(--text-primary)',
                    backdrop: 'rgba(0,0,0,0.5)',
                    borderRadius: '16px',
                    iconColor: '#FF6B6B'
                }).then(r => { if (r.isConfirmed) form.submit(); });
            }
        });

        // ===== AUTO DISMISS ALERTS =====
        setTimeout(() => {
            document.querySelectorAll('.alert-custom').forEach(el => {
                el.style.opacity = '0';
                el.style.transition = 'opacity 0.5s ease';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);

        console.log('🚀 EkskulPro v5.0 - Premium UI');
        console.log('✨ Made with ❤️ for your PKK project!');
        console.log('🎨 Colors: Gradient Purple + Coral + Teal');
    </script>

    @stack('scripts')
</body>
</html>