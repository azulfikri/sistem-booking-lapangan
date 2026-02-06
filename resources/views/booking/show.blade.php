<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Booking - {{ $booking->booking_code }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Konfirmasi Booking</h1>
                <a href="{{ route('booking.index') }}" class="text-gray-600 hover:text-gray-900">
                    Booking Lagi
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-start">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Booking Code -->
        <div class="bg-gradient-to-r from-emerald-500 to-cyan-600 rounded-xl p-8 text-white mb-6 text-center">
            <p class="text-sm opacity-90 mb-2">Kode Booking Anda</p>
            <h2 class="text-4xl font-bold tracking-wider mb-2">{{ $booking->booking_code }}</h2>
            <p class="text-sm opacity-90">Simpan kode ini untuk referensi Anda</p>
        </div>

        <!-- Booking Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Detail Booking</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Lapangan</p>
                        <p class="text-base font-semibold text-gray-900">{{ $booking->field->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal</p>
                        <p class="text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->isoFormat('dddd, D MMMM YYYY') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jam Main</p>
                        <p class="text-base font-semibold text-gray-900">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Durasi</p>
                        <p class="text-base font-semibold text-gray-900">{{ $booking->duration }} Jam</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-700">Total Harga:</span>
                        <span class="text-2xl font-bold text-emerald-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Data Pemesan</h3>
            </div>
            <div class="p-6 space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="text-base font-semibold text-gray-900">{{ $booking->guest_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-base font-semibold text-gray-900">{{ $booking->guest_email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nomor Telepon</p>
                    <p class="text-base font-semibold text-gray-900">{{ $booking->guest_phone }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Instructions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Instruksi Pembayaran</h3>
            </div>
            <div class="p-6">
                @if($booking->payment_method === 'transfer')
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <p class="font-semibold text-blue-900 mb-2">Transfer Bank</p>
                        <p class="text-sm text-blue-800 mb-4">Silakan transfer ke rekening berikut:</p>
                        <div class="bg-white rounded p-3 space-y-2">
                            <div>
                                <p class="text-xs text-gray-500">Bank</p>
                                <p class="font-semibold">BCA</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">No. Rekening</p>
                                <p class="font-semibold">1234567890</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Atas Nama</p>
                                <p class="font-semibold">Lapangan Futsal XYZ</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Jumlah Transfer</p>
                                <p class="text-lg font-bold text-emerald-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-blue-800 mt-4">Setelah transfer, mohon kirim bukti transfer ke email atau WhatsApp kami untuk konfirmasi.</p>
                    </div>
                @elseif($booking->payment_method === 'cash')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="font-semibold text-yellow-900 mb-2">Bayar di Tempat (Cash)</p>
                        <p class="text-sm text-yellow-800">Anda dapat membayar langsung di tempat saat datang. Harap datang 15 menit sebelum waktu booking Anda.</p>
                    </div>
                @elseif($booking->payment_method === 'midtrans')
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-4">
                        <p class="font-semibold text-purple-900 mb-2">Pembayaran Online (Midtrans)</p>
                        <p class="text-sm text-purple-800 mb-4">Klik tombol di bawah untuk melanjutkan ke halaman pembayaran.</p>
                        <button class="w-full px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-colors">
                            Bayar Sekarang
                        </button>
                        <p class="text-xs text-purple-700 mt-2">Anda akan diarahkan ke halaman pembayaran Midtrans yang aman.</p>
                    </div>
                @endif

                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-700 mb-2">
                        <span class="font-semibold">Status Pembayaran:</span> 
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                            {{ ucfirst($booking->payment_status) }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-700">
                        <span class="font-semibold">Status Booking:</span> 
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 ml-2">
                            {{ ucfirst($booking->booking_status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-center space-x-4">
            <a href="{{ route('booking.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Booking Lagi
            </a>
            <a href="{{ route('home') }}" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors">
                Kembali ke Home
            </a>
        </div>
    </main>
</body>
</html>
