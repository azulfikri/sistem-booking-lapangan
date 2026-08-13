<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Sports Center — Booking lapangan olahraga online dengan mudah dan cepat. Futsal, Badminton, Basket, dan lainnya.')">

    <title>@yield('title', 'Sports Center') — Booking Lapangan Online</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-surface-50 text-surface-900 antialiased">

    {{-- ============================================================
         NAVIGATION
         ============================================================ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25 group-hover:shadow-primary-500/40 transition-shadow duration-300">
                        <i data-lucide="trophy" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">Sports<span class="text-primary-300">Center</span></span>
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                        Beranda
                    </a>
                    <a href="{{ route('booking.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                        Lapangan
                    </a>
                    @auth
                        <a href="{{ route('booking.my-bookings') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                            Booking Saya
                        </a>
                    @endauth
                </div>

                {{-- Right side --}}
                <div class="flex items-center gap-3">
                    @auth
                        <div class="hidden md:flex items-center gap-3">
                            <span class="text-sm text-white/70">{{ auth()->user()->name }}</span>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium bg-white/10 text-white hover:bg-white/20 transition-all duration-200">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4 inline mr-1"></i>Admin
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 rounded-lg text-sm font-medium text-white/70 hover:text-white hover:bg-white/10 transition-all duration-200">
                                    <i data-lucide="log-out" class="w-4 h-4 inline mr-1"></i>Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:inline-flex px-5 py-2.5 rounded-xl text-sm font-semibold bg-white/15 text-white hover:bg-white/25 backdrop-blur-sm transition-all duration-200 border border-white/20">
                            <i data-lucide="log-in" class="w-4 h-4 inline mr-2"></i>Login
                        </a>
                    @endauth

                    {{-- Mobile menu toggle --}}
                    <button id="mobile-menu-toggle" class="md:hidden p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden bg-surface-900/95 backdrop-blur-xl border-t border-white/10">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Beranda</a>
                <a href="{{ route('booking.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Lapangan</a>
                @auth
                    <a href="{{ route('booking.my-bookings') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Booking Saya</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Admin Panel</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-red-400 hover:bg-white/10 transition-all">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-primary-300 hover:bg-white/10 transition-all">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ============================================================
         FLASH MESSAGES
         ============================================================ --}}
    @if(session('success') || session('error') || session('warning') || session('info'))
        <div class="fixed top-20 right-4 z-60 w-full max-w-sm space-y-2">
            @if(session('success'))
                <div class="alert alert-success" data-auto-dismiss="5000">
                    <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error" data-auto-dismiss="7000">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning" data-auto-dismiss="6000">
                    <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0"></i>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info" data-auto-dismiss="5000">
                    <i data-lucide="info" class="w-5 h-5 shrink-0"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif
        </div>
    @endif

    {{-- ============================================================
         MAIN CONTENT
         ============================================================ --}}
    <main>
        @yield('content')
    </main>

    {{-- ============================================================
         FOOTER
         ============================================================ --}}
    <footer class="bg-surface-900 text-white border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-primary rounded-xl flex items-center justify-center">
                            <i data-lucide="trophy" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-xl font-bold tracking-tight">Sports<span class="text-primary-300">Center</span></span>
                    </div>
                    <p class="text-surface-400 text-sm leading-relaxed">
                        Booking lapangan olahraga online dengan mudah dan cepat. Nikmati fasilitas terbaik untuk pengalaman bermain yang premium.
                    </p>
                </div>

                {{-- Links --}}
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-surface-400 mb-4">Navigasi</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-sm text-surface-300 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('booking.index') }}" class="text-sm text-surface-300 hover:text-white transition-colors">Daftar Lapangan</a></li>
                        <li><a href="{{ route('login') }}" class="text-sm text-surface-300 hover:text-white transition-colors">Login</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-surface-400 mb-4">Jam Operasional</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-sm text-surface-300">
                            <i data-lucide="clock" class="w-4 h-4 text-primary-400"></i>
                            <span>Senin — Minggu: 07:00 — 23:00</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-surface-300">
                            <i data-lucide="map-pin" class="w-4 h-4 text-primary-400"></i>
                            <span>Sports Center, Indonesia</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-surface-300">
                            <i data-lucide="phone" class="w-4 h-4 text-primary-400"></i>
                            <span>0812-XXXX-XXXX</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 mt-12 pt-8 text-center">
                <p class="text-sm text-surface-500">&copy; {{ date('Y') }} Sports Center. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- ============================================================
         SCRIPTS
         ============================================================ --}}
    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('bg-surface-900/95', 'backdrop-blur-xl', 'shadow-lg', 'shadow-black/10');
            } else {
                navbar.classList.remove('bg-surface-900/95', 'backdrop-blur-xl', 'shadow-lg', 'shadow-black/10');
            }
        });
        // Run on load
        if (window.scrollY > 20) {
            navbar.classList.add('bg-surface-900/95', 'backdrop-blur-xl', 'shadow-lg', 'shadow-black/10');
        }

        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
