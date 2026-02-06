<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Lapangan - Sistem Booking Lapangan</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Booking Lapangan Futsal</h1>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">
                    Kembali ke Home
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Pilih Lapangan</h2>
            <p class="text-gray-600 mt-1">Pilih lapangan yang ingin Anda booking</p>
        </div>

        @if($fields->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($fields as $field)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <!-- Field Photo -->
                        <div class="h-48 bg-gradient-to-br from-emerald-500 to-cyan-600 relative">
                            @if($field->photo)
                                <img src="{{ asset('fields/' . $field->photo) }}" alt="{{ $field->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Field Info -->
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $field->name }}</h3>
                            
                            @if($field->description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $field->description }}</p>
                            @endif

                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Harga</p>
                                    <p class="text-xl font-bold text-emerald-600">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">per jam</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                                        Tersedia
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('booking.create', $field->id) }}" class="block w-full text-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors">
                                Booking Sekarang
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <p class="text-gray-500 text-lg">Mohon maaf, saat ini belum ada lapangan yang tersedia.</p>
            </div>
        @endif
    </main>
</body>
</html>
