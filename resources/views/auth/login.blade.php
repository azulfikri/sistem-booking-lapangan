<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Booking Lapangan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden selection:bg-emerald-500 selection:text-white">

    <!-- Global Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[70%] h-[70%] bg-emerald-500/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute -bottom-[20%] -right-[10%] w-[70%] h-[70%] bg-blue-600/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Main Container Card -->
    <div class="w-full max-w-5xl bg-slate-900 rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row relative z-10 border border-slate-800/50">
        
        <!-- Left Side (Visuals) -->
        <div class="hidden lg:flex w-1/2 relative flex-col justify-center p-12 overflow-hidden bg-slate-900/50 group">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img src="{{ asset('img/login-bg.png') }}" alt="Background" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-slate-900/20 mix-blend-multiply"></div>
                <div class="absolute inset-0 bg-emerald-900/20 mix-blend-overlay"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 text-center">
                <h1 class="text-4xl font-bold text-white leading-tight shadow-sm drop-shadow-md">
                    Kelola Jadwal <br>
                    <span class="text-emerald-400">Lapangan Olahraga</span>
                </h1>
            </div>
        </div>

        <!-- Right Side (Login Form) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 bg-slate-950/50 backdrop-blur-md">
            <div class="w-full max-w-sm space-y-6">
                
                <!-- Mobile Logo (Visible only on small screens) -->
                <div class="lg:hidden text-center mb-6">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 shadow-lg shadow-emerald-500/30 mb-4">
                        <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-white">SportBook</h2>
                </div>

                <div class="text-center lg:text-left">
                    <h2 class="text-2xl font-bold text-white tracking-tight">Selamat Datang Kembali</h2>
                    <p class="mt-2 text-sm text-slate-400">Masuk ke akun anda untuk melanjutkan</p>
                </div>

                 <!-- Alerts -->
                @if ($errors->any())
                    <div class="p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs flex items-start gap-2 animate-fade-in-down">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs flex items-start gap-2 animate-fade-in-down">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label for="email" class="text-sm font-medium text-slate-300">Email Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-500 group-focus-within:text-emerald-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="block w-full pl-11 pr-4 py-3 bg-slate-900 border border-slate-700/50 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all duration-300 sm:text-sm @error('email')
                                    border-red-500 focus:ring-red-500/50 focus:border-red-500/50
                                @enderror" 
                                placeholder="nama@email.com"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                            >
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                             <label for="password" class="text-sm font-medium text-slate-300">Password</label>
                             <a href="#" class="text-xs font-medium text-emerald-400 hover:text-emerald-300 transition-colors">Lupa Password?</a>
                        </div>
                       
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-500 group-focus-within:text-emerald-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="block w-full pl-11 pr-12 py-3 bg-slate-900 border border-slate-700/50 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all duration-300 sm:text-sm @error('password')
                                    border-red-500 focus:ring-red-500/50 focus:border-red-500/50
                                @enderror" 
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-emerald-400 cursor-pointer focus:outline-none transition-colors">
                                <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off-icon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox" 
                            {{ old('remember') ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-500/20 focus:ring-offset-0 transition duration-200"
                        >
                        <label for="remember" class="ml-2 block text-sm text-slate-400 cursor-pointer hover:text-slate-300 transition-colors">Ingat saya</label>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-xl shadow-lg shadow-emerald-500/20 text-sm font-bold text-white bg-gradient-to-r cursor-pointer from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 focus:ring-offset-slate-900 transform hover:-translate-y-0.5 transition-all duration-200">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="text-center">
                    <p class="text-sm text-slate-500">
                        Belum punya akun? 
                        <a href="#" class="font-medium text-emerald-400 hover:text-emerald-300 transition-colors">Daftar disini</a>
                    </p>
                </div>
                
                 <div class="text-center lg:hidden pt-4">
                    <p class="text-xs text-slate-600">&copy; {{ date('Y') }} SportBook.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Copyright (Desktop) -->
    <div class="absolute bottom-4 left-0 w-full text-center hidden lg:block z-0 pointer-events-none">
        <p class="text-xs text-slate-600">&copy; {{ date('Y') }} Sistem Booking Lapangan. All rights reserved.</p>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
