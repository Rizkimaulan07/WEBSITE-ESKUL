<!-- resources/views/layouts/navigation.blade.php -->
<nav x-data="{ open: false }" class="sticky top-0 z-50" style="background: #0c1a2e; border-bottom: 1px solid rgba(255,255,255,0.05); backdrop-filter: blur(12px);">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo-simskul.png') }}" alt="Logo SIMSKUL"
                             style="height:40px; width:auto; object-fit:contain; border-radius:10px;"
                             class="shadow-sm group-hover:shadow-md transition-shadow duration-300">
                        <div>
                            <span class="fw-bold" style="font-size:16px; letter-spacing:-0.3px; color: #ffffff;">SIMSKUL</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" style="color: rgba(255,255,255,0.7);">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl transition-all duration-200 gap-2" style="color: rgba(255,255,255,0.8); background: rgba(255,255,255,0.06); hover:background: rgba(255,255,255,0.12);">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div style="color: #ffffff;">{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" style="color: rgba(255,255,255,0.5);">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="py-1" style="background: #0c1a2e; border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.4);">
                            <x-dropdown-link :href="route('profile.show')" class="flex items-center gap-2" style="color: rgba(255,255,255,0.8); hover:background: rgba(255,255,255,0.06);">
                                <i class="fas fa-user text-sm" style="color: rgba(255,255,255,0.4);"></i>
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center gap-2" style="color: #ef4444; hover:background: rgba(239,68,68,0.08);">
                                    <i class="fas fa-sign-out-alt text-sm" style="color: rgba(239,68,68,0.6);"></i>
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl transition duration-150 ease-in-out" style="color: rgba(255,255,255,0.6); hover:background: rgba(255,255,255,0.06);">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background: #0c1a2e; border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" style="color: rgba(255,255,255,0.7); hover:background: rgba(255,255,255,0.06);">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t" style="border-color: rgba(255,255,255,0.05);">
            <div class="px-4">
                <div class="font-medium text-base" style="color: #ffffff;">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm" style="color: rgba(255,255,255,0.5);">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.show')" class="flex items-center gap-2" style="color: rgba(255,255,255,0.7); hover:background: rgba(255,255,255,0.06);">
                    <i class="fas fa-user text-sm" style="color: rgba(255,255,255,0.3);"></i>
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center gap-2" style="color: #ef4444; hover:background: rgba(239,68,68,0.08);">
                        <i class="fas fa-sign-out-alt text-sm" style="color: rgba(239,68,68,0.6);"></i>
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Hover effect untuk nav link */
    .nav-link:hover {
        color: #0ea5e9 !important;
    }
    
    /* Active state untuk nav link */
    .nav-link.active {
        color: #0ea5e9 !important;
        border-bottom-color: #0ea5e9 !important;
    }

    /* Dropdown hover effect */
    .dropdown-link:hover {
        background: rgba(255,255,255,0.06);
        color: #ffffff !important;
    }

    /* Hover effect untuk button di navbar */
    .nav-btn:hover {
        background: rgba(255,255,255,0.12) !important;
    }

    /* Responsive nav link hover */
    .responsive-nav-link:hover {
        background: rgba(255,255,255,0.06);
        color: #ffffff !important;
    }

    /* Scrollbar dropdown */
    .dropdown-content::-webkit-scrollbar {
        width: 4px;
    }
    .dropdown-content::-webkit-scrollbar-track {
        background: transparent;
    }
    .dropdown-content::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
    }

    /* Animasi dropdown */
    .dropdown-enter {
        animation: dropdownFade 0.2s ease;
    }
    
    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>