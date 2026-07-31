<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Estrakulikuler') }} - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --sidebar-bg: #0a0a1a;
            --sidebar-border: rgba(255,255,255,0.04);
            --sidebar-text: #6b7280;
            --sidebar-text-hover: #f3f4f6;
            --sidebar-active-bg: rgba(99, 102, 241, 0.12);
            --sidebar-active-text: #818cf8;
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --primary-bg: rgba(99, 102, 241, 0.06);
            --secondary: #06b6d4;
            --secondary-light: #67e8f9;
            --accent: #f472b6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.02);
            --card-hover: 0 12px 40px rgba(15, 23, 42, 0.08);
            --radius: 16px;
            --radius-sm: 10px;
            --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: #0f172a;
            min-height: 100vh;
            transition: var(--transition);
        }

        /* ===== APP WRAPPER ===== */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 270px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 1050;
            flex-shrink: 0;
            transition: var(--transition);
            border-right: 1px solid var(--sidebar-border);
            box-shadow: 4px 0 40px rgba(0,0,0,0.15);
        }

        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.2); border-radius: 10px; }

        /* ===== SIDEBAR BRAND ===== */
        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .sidebar-brand .brand-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: var(--transition);
            overflow: hidden;
            background: transparent;
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.15);
        }

        .sidebar-brand .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .sidebar-brand .brand-icon:hover {
            transform: rotate(-8deg) scale(1.05);
            box-shadow: 0 6px 30px rgba(37, 99, 235, 0.25);
        }

        .sidebar-brand .brand-text h5 {
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            margin: 0;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .sidebar-brand .brand-text small {
            color: rgba(255,255,255,0.3);
            font-size: 9px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* ===== SIDEBAR MENU ===== */
        .sidebar-menu {
            padding: 20px 16px;
        }

        .sidebar-menu .menu-label {
            color: rgba(255,255,255,0.15);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 16px 12px 8px;
            font-weight: 600;
        }

        .sidebar-menu .nav-link {
            color: var(--sidebar-text);
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
        }

        .sidebar-menu .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleX(0);
            width: 3px;
            height: 28px;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
            border-radius: 0 4px 4px 0;
            transition: var(--transition);
        }

        .sidebar-menu .nav-link:hover::before,
        .sidebar-menu .nav-link.active::before {
            transform: translateY(-50%) scaleX(1);
        }

        .sidebar-menu .nav-link:hover {
            color: var(--sidebar-text-hover);
            background: rgba(255,255,255,0.03);
            transform: translateX(6px);
        }

        .sidebar-menu .nav-link.active {
            color: var(--sidebar-active-text);
            background: var(--sidebar-active-bg);
            box-shadow: inset 0 0 30px rgba(99,102,241,0.03);
        }

        .sidebar-menu .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
            color: rgba(255,255,255,0.2);
            transition: var(--transition);
        }

        .sidebar-menu .nav-link.active i {
            color: var(--primary-light);
        }

        .sidebar-menu .nav-link:hover i {
            color: #fff;
        }

        .sidebar-menu .nav-link .badge {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            font-weight: 600;
            font-size: 10px;
            padding: 2px 10px;
            border-radius: 12px;
            margin-left: auto;
            box-shadow: 0 2px 12px rgba(99, 102, 241, 0.35);
            transition: var(--transition);
        }

        .sidebar-menu .nav-link:hover .badge {
            transform: scale(1.05);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 270px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: calc(100% - 270px);
        }

        /* ===== TOP NAVBAR ===== */
        .top-navbar {
            background: rgba(255,255,255,0.82);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            padding: 16px 36px;
            border-bottom: 1px solid rgba(0,0,0,0.02);
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
            transition: var(--transition);
        }

        .top-navbar .page-title {
            font-weight: 700;
            font-size: 20px;
            color: #0f172a;
            letter-spacing: -0.3px;
        }

        .top-navbar .page-title span {
            font-weight: 400;
            font-size: 13px;
            color: #94a3b8;
            margin-left: 10px;
        }

        .top-navbar .user-info {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .top-navbar .user-info .avatar {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            transition: var(--transition);
            cursor: pointer;
            box-shadow: 0 2px 16px rgba(99, 102, 241, 0.2);
        }

        .top-navbar .user-info .avatar:hover {
            transform: scale(1.05) rotate(-3deg);
            box-shadow: 0 4px 24px rgba(99, 102, 241, 0.35);
        }

        .top-navbar .user-info .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #0f172a;
            line-height: 1.2;
        }

        .top-navbar .user-info .user-role {
            font-size: 11px;
            color: #94a3b8;
            text-transform: capitalize;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 32px 36px;
            flex: 1;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== RESPONSIVE ===== */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: #0f172a;
            font-size: 22px;
            padding: 0;
            transition: var(--transition);
        }

        .sidebar-toggle:hover {
            color: var(--primary);
            transform: scale(1.1);
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 1060;
                width: 290px;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(10, 10, 26, 0.6);
                backdrop-filter: blur(6px);
                z-index: 1055;
                transition: var(--transition);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .sidebar-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .top-navbar {
                padding: 14px 18px;
            }
            .page-content {
                padding: 18px;
            }
        }

        @media (max-width: 576px) {
            .top-navbar .page-title {
                font-size: 16px;
            }
            .top-navbar .page-title span {
                display: none;
            }
            .top-navbar .user-info .user-name {
                font-size: 12px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="app-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo Sekolah">
                </div>
                <div class="brand-text">
                    <h5>Estrakulikuler</h5>
                    <small>Management System</small>
                </div>
            </div>
            <div class="sidebar-menu">
                @auth
                    @php
                        $user = Auth::user();
                    @endphp

                    @if($user->role == 'admin')
                        <!-- ===== MENU ADMIN ===== -->
                        <div class="menu-label">Main Menu</div>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.ekskul.index') }}" class="nav-link {{ request()->routeIs('admin.ekskul.*') ? 'active' : '' }}">
                            <i class="fas fa-trophy"></i> Ekstrakurikuler
                        </a>
                        <a href="{{ route('admin.anggota.index') }}" class="nav-link {{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Anggota
                            <span class="badge">{{ \App\Models\User::where('role', 'anggota')->count() }}</span>
                        </a>
                        <a href="{{ route('admin.template-surat.index') }}" class="nav-link {{ request()->routeIs('admin.template-surat.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i> Template Surat
                        </a>

                    @elseif($user->role == 'pelatih')
                        <!-- ===== MENU PELATIH ===== -->
                        <div class="menu-label">Main Menu</div>
                        <a href="{{ route('pelatih.dashboard') }}" class="nav-link {{ request()->routeIs('pelatih.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> Dashboard
                        </a>
                        <a href="{{ route('pelatih.nilai') }}" class="nav-link {{ request()->routeIs('pelatih.nilai*') ? 'active' : '' }}">
                            <i class="fas fa-star"></i> Nilai Anggota
                        </a>
                        <a href="{{ route('pelatih.dokumentasi') }}" class="nav-link {{ request()->routeIs('pelatih.dokumentasi*') ? 'active' : '' }}">
                            <i class="fas fa-camera"></i> Dokumentasi
                        </a>

                    @elseif($user->role == 'anggota')
                        <!-- ===== MENU ANGGOTA ===== -->
                        <div class="menu-label">Main Menu</div>
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
                @endauth

                <!-- ===== SETTINGS ===== -->
                <div class="menu-label">Settings</div>
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <i class="fas fa-user-cog"></i> Profile
                </a>
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>

        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <button class="sidebar-toggle" onclick="toggleSidebar()">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div>
                            <h5 class="page-title mb-0">
                                @yield('title', 'Dashboard')
                                <span>@yield('subtitle', '')</span>
                            </h5>
                        </div>
                    </div>
                    <div class="user-info">
                        <div class="text-end d-none d-sm-block">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                        <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    </div>
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

        // Auto close sidebar on resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('show');
            }
        });

        // Close sidebar when clicking outside on mobile
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
    </script>

    @stack('scripts')
</body>
</html>