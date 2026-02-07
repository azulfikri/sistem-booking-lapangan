<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - {{ $booking->booking_code }}</title>
    @vite('resources/css/app.css')
    <script type="text/javascript"
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ $clientKey }}">
    </script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Pembayaran</h1>
                <a href="{{ route('booking.show', $booking->booking_code) }}" class="text-gray-600 hover:text-gray-900">
                    Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Booking Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pesanan</h2>
            
            <div class="space-y-3 mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Kode Booking</span>
                    <span class="font-semibold text-gray-900">{{ $booking->booking_code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Lapangan</span>
                    <span class="font-semibold text-gray-900">{{ $booking->field->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tanggal</span>
                    <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Waktu</span>
                    <span class="font-semibold text-gray-900">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Durasi</span>
                    <span class="font-semibold text-gray-900">{{ $booking->duration }} Jam</span>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-medium text-gray-700">Total Pembayaran:</span>
                    <span class="text-2xl font-bold text-emerald-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Button -->
        <div class="bg-gradient-to-r from-emerald-500 to-cyan-600 rounded-xl p-8 text-white text-center">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <h3 class="text-2xl font-bold mb-2">Siap untuk Pembayaran?</h3>
            <p class="mb-6 opacity-90">Klik tombol di bawah untuk melanjutkan ke halaman pembayaran yang aman</p>
            <button 
                id="pay-button" 
                class="px-8 py-4 bg-white text-emerald-600 font-bold rounded-lg hover:bg-gray-100 transition-colors shadow-lg text-lg"
            >
                Bayar Sekarang
            </button>
            <p class="mt-4 text-sm opacity-75">Powered by Midtrans - Secure Payment Gateway</p>
        </div>

        <!-- Information -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Informasi Pembayaran:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Anda akan diarahkan ke halaman pembayaran Midtrans yang aman</li>
                        <li>Metode pembayaran: Transfer Bank, Kartu Kredit, E-Wallet, dll</li>
                        <li>Status pembayaran akan otomatis diperbarui setelah pembayaran berhasil</li>
                        <li>Jika ada kendala, hubungi customer service kami</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        const snapToken = '{{ $snapToken }}';

        payButton.addEventListener('click', function () {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    window.location.href = '{{ route('payment.callback') }}?order_id={{ $booking->booking_code }}';
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    window.location.href = '{{ route('payment.callback') }}?order_id={{ $booking->booking_code }}';
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function() {
                    console.log('Payment popup closed');
                }
            });
        });
    </script>
</body>
</html>
