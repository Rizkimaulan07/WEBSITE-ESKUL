<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SISMEKUL') }} - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --primary-dark: #0f172a;
            --secondary: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-main: #f0f2f5;
            --card-shadow: 0 8px 40px rgba(0,0,0,0.06);
            --card-hover: 0 12px 50px rgba(79, 70, 229, 0.15);
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
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: var(--primary-dark);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1050;
            padding: 0;
            overflow-y: auto;
            transition: var(--transition);
            border-right: 1px solid rgba(255,255,255,0.04);
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.3); border-radius: 10px; }

        /* Brand */
        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .sidebar-brand .brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #4f46e5, #818cf8, #06b6d4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.3);
            transition: var(--transition);
        }

        .sidebar-brand .brand-icon:hover {
            transform: rotate(-8deg) scale(1.05);
            box-shadow: 0 6px 30px rgba(79, 70, 229, 0.4);
        }

        .sidebar-brand h5 {
            color: #fff;
            font-weight: 800;
            font-size: 18px;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .sidebar-brand small {
            color: rgba(255,255,255,0.3);
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Menu */
        .sidebar-menu { padding: 16px 12px; }

        .sidebar-menu .menu-label {
            color: rgba(255,255,255,0.1);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 12px 16px 6px;
            font-weight: 700;
        }

        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.5);
            padding: 11px 16px;
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 13px;
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
            background: linear-gradient(180deg, #4f46e5, #818cf8);
            border-radius: 0 4px 4px 0;
            transition: var(--transition);
        }

        .sidebar-menu .nav-link:hover::before,
        .sidebar-menu .nav-link.active::before {
            transform: translateY(-50%) scaleX(1);
        }

        .sidebar-menu .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.04);
            transform: translateX(4px);
        }

        .sidebar-menu .nav-link.active {
            color: #818cf8;
            background: rgba(99,102,241,0.08);
        }

        .sidebar-menu .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-menu .nav-link .badge {
            margin-left: auto;
            background: rgba(99,102,241,0.2);
            color: #818cf8;
            font-size: 9px;
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* User Info */
        .sidebar-user {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.04);
            margin-top: 8px;
        }

        .sidebar-user .avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
        }

        .sidebar-user .name {
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            margin: 0;
        }

        .sidebar-user .role {
            color: rgba(255,255,255,0.3);
            font-size: 11px;
            margin: 0;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            padding: 0;
        }

        /* ===== TOPBAR GLASS ===== */
        .topbar {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(24px) saturate(1.8);
            -webkit-backdrop-filter: blur(24px) saturate(1.8);
            padding: 14px 36px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar .page-title h4 {
            font-weight: 800;
            font-size: 20px;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .topbar .page-title p {
            color: #94a3b8;
            margin: 0;
            font-size: 13px;
            font-weight: 400;
        }

        .topbar .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar .topbar-right .date-display {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
            padding: 6px 14px;
            background: rgba(0,0,0,0.03);
            border-radius: 10px;
        }

        .topbar .topbar-right .avatar-top {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 16px rgba(79, 70, 229, 0.15);
        }

        .topbar .topbar-right .avatar-top:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 24px rgba(79, 70, 229, 0.3);
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

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 28px 36px;
            animation: fadeUp 0.6s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
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

        .sidebar-toggle:hover { color: #4f46e5; transform: scale(1.1); }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10, 10, 26, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1040;
            transition: var(--transition);
        }

        .sidebar-overlay.show { display: block; }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 300px;
            }
            .sidebar.open { transform: translateX(0); }
            .sidebar-toggle { display: block; }
            .main-content { margin-left: 0; }
            .topbar { padding: 12px 16px; }
            .page-content { padding: 16px; }
            .sidebar-overlay.show { display: block; }
            .topbar .topbar-right .date-display { display: none; }
        }

        @media (max-width: 576px) {
            .topbar .page-title h4 { font-size: 17px; }
            .topbar .page-title p { display: none; }
            .topbar .topbar-right .btn-logout span { display: none; }
            .page-content { padding: 12px; }
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(79, 70, 229, 0.15); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(79, 70, 229, 0.3); }

        /* ===== UTILITY ===== */
        .glass {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .text-gradient {
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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
                    <i class="fas fa-trophy"></i>
                </div>
                <div>
                    <h5>SISMEKUL</h5>
                    <small>Management System</small>
                </div>
            </div>

            <div class="sidebar-menu">
                @auth
                    @php $user = Auth::user(); @endphp

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
                        <a href="{{ route('admin.kehadiran_pelatih') }}" class="nav-link {{ request()->routeIs('admin.kehadiran_pelatih') ? 'active' : '' }}">
                            <i class="fas fa-user-check"></i> Kehadiran Pelatih
                        </a>
                        <a href="{{ route('admin.kehadiran_anggota') }}" class="nav-link {{ request()->routeIs('admin.kehadiran_anggota') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list"></i> Kehadiran Anggota
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
                        <a href="{{ route('pelatih.kehadiran_pelatih') }}" class="nav-link {{ request()->routeIs('pelatih.kehadiran_pelatih*') ? 'active' : '' }}">
                            <i class="fas fa-user-check"></i> Kehadiran Saya
                        </a>
                        <a href="{{ route('pelatih.kehadiran') }}" class="nav-link {{ request()->routeIs('pelatih.kehadiran*') && !request()->routeIs('pelatih.kehadiran_pelatih*') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list"></i> Kehadiran Anggota
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

            @auth
            <div class="sidebar-user">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div>
                        <p class="name">{{ Auth::user()->name }}</p>
                        <p class="role">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                </div>
            </div>
            @endauth
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
                        <i class="far fa-calendar-alt me-1"></i>
                        {{ now()->translatedFormat('d F Y') }}
                    </span>
                    <div class="avatar-top">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
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
    </script>
    @stack('scripts')
</body>
</html>