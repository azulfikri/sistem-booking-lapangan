@props(['title' => 'Dashboard'])

<header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-30">
    <div class="px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Left: Mobile Menu Button + Page Title -->
            <div class="flex items-center space-x-4">
                <!-- Mobile menu button -->
                <button 
                    @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-lg p-2 transition-colors"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Page Title -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Kelola sistem booking lapangan Anda</p>
                </div>
            </div>

            <!-- Right: Admin Info & Notifications -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <!-- Notification badge -->
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Admin Profile -->
                <div class="hidden md:flex items-center space-x-3 pl-4 border-l border-gray-200">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-semibold shadow-md">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
