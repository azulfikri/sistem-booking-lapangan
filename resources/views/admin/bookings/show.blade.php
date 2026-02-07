<x-layouts.admin title="Detail Booking">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.bookings') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Booking
        </a>
    </div>

    <!-- Success/Error Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Booking Code Header -->
    <div class="bg-gradient-to-r from-emerald-500 to-cyan-600 rounded-xl p-8 text-white mb-6 text-center">
        <p class="text-sm opacity-90 mb-2">Kode Booking</p>
        <h2 class="text-4xl font-bold tracking-wider">{{ $booking->booking_code }}</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Booking Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
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
                        <div>
                            <p class="text-sm text-gray-500">Metode Pembayaran</p>
                            <p class="text-base font-semibold text-gray-900">{{ ucfirst($booking->payment_method) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                            <p class="text-base text-gray-900">{{ $booking->created_at->isoFormat('D MMM YYYY, HH:mm') }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-700">Total Harga:</span>
                            <span class="text-2xl font-bold text-emerald-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($booking->notes)
                        <div class="border-t border-gray-200 pt-4">
                            <p class="text-sm text-gray-500 mb-2">Catatan:</p>
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $booking->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
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
                    @if($booking->user_id)
                        <div>
                            <p class="text-sm text-gray-500">Registered User</p>
                            <p class="text-base font-semibold text-gray-900">{{ $booking->user->name }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Proof (if exists) -->
            @if($booking->payment_proof)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">Bukti Pembayaran</h3>
                    </div>
                    <div class="p-6">
                        <img src="{{ asset('payment-proofs/' . $booking->payment_proof) }}" alt="Payment Proof" class="max-w-full h-auto rounded-lg">
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Actions -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status Cards -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Status</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Payment Status</p>
                        @php
                            $paymentBadgeColors = [
                                'unpaid' => 'bg-gray-100 text-gray-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'expired' => 'bg-red-100 text-red-800',
                                'failed' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium {{ $paymentBadgeColors[$booking->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($booking->payment_status) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-2">Booking Status</p>
                        @php
                            $bookingBadgeColors = [
                                'pending' => 'bg-blue-100 text-blue-800',
                                'confirmed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'completed' => 'bg-purple-100 text-purple-800',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium {{ $bookingBadgeColors[$booking->booking_status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($booking->booking_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Update Payment Status -->
            @if($booking->payment_status !== 'paid')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Update Payment Status</h3>
                    <form action="{{ route('admin.bookings.updatePayment', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-3 focus:ring-2 focus:ring-emerald-500">
                            <option value="unpaid" {{ $booking->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="expired" {{ $booking->payment_status == 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="failed" {{ $booking->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                            Update Payment
                        </button>
                    </form>
                </div>
            @endif

            <!-- Update Booking Status -->
            @if($booking->booking_status !== 'cancelled' && $booking->booking_status !== 'completed')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Update Booking Status</h3>
                    <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="booking_status" id="bookingStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-3 focus:ring-2 focus:ring-emerald-500">
                            <option value="pending" {{ $booking->booking_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->booking_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $booking->booking_status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        
                        <div id="cancelReasonDiv" class="hidden mb-3">
                            <textarea name="cancel_reason" id="cancel_reason" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500" placeholder="Alasan pembatalan..."></textarea>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors">
                            Update Status
                        </button>
                    </form>
                </div>
            @endif

            <!-- Cancel Booking -->
            @if($booking->booking_status !== 'cancelled')
                <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
                    <h3 class="text-lg font-bold text-red-900 mb-4">Batalkan Booking</h3>
                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                        @csrf
                        @method('DELETE')
                        <textarea name="reason" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-3 focus:ring-2 focus:ring-red-500" placeholder="Alasan pembatalan..." required></textarea>
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">
                            Batalkan Booking
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Show/hide cancel reason textarea
        const bookingStatus = document.getElementById('bookingStatus');
        const cancelReasonDiv = document.getElementById('cancelReasonDiv');
        const cancelReasonInput = document.getElementById('cancel_reason');

        if (bookingStatus) {
            bookingStatus.addEventListener('change', function() {
                if (this.value === 'cancelled') {
                    cancelReasonDiv.classList.remove('hidden');
                    cancelReasonInput.required = true;
                } else {
                    cancelReasonDiv.classList.add('hidden');
                    cancelReasonInput.required = false;
                }
            });
        }
    </script>
</x-layouts.admin>
