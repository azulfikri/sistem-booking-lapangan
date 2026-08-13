@extends('layouts.app')

@section('title', 'Pembayaran — ' . $booking->booking_code)

@section('content')

{{-- Page Header --}}
<section class="bg-gradient-hero pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl font-bold text-white animate-fade-in-up">Pembayaran Online</h1>
        <p class="text-white/60 mt-2 animate-fade-in-up delay-100">Selesaikan pembayaran untuk booking Anda.</p>
    </div>
</section>

<section class="py-12 bg-surface-50">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card-admin rounded-2xl p-6 sm:p-8 text-center animate-scale-in">
            {{-- Booking Summary --}}
            <div class="mb-8">
                <p class="text-sm text-surface-500 mb-1">Kode Booking</p>
                <p class="text-2xl font-black text-primary-600 tracking-widest mb-4">{{ $booking->booking_code }}</p>

                <div class="bg-surface-50 rounded-xl p-4 text-left space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-surface-500">Lapangan</span>
                        <span class="font-medium">{{ $booking->field->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-surface-500">Jadwal</span>
                        <span class="font-medium">{{ $booking->formatted_date }}, {{ $booking->time_range }}</span>
                    </div>
                    <div class="flex justify-between text-sm border-t border-surface-200 pt-2 mt-2">
                        <span class="font-semibold text-surface-700">Total Bayar</span>
                        <span class="font-bold text-primary-600">{{ $booking->formatted_price }}</span>
                    </div>
                </div>
            </div>

            {{-- Pay Button --}}
            <button id="pay-button" class="btn-primary w-full py-4 text-base gap-2">
                <i data-lucide="credit-card" class="w-5 h-5"></i>
                Bayar Sekarang
            </button>

            <p class="text-xs text-surface-400 mt-4">Pembayaran diproses melalui Midtrans (aman & terenkripsi).</p>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = '{{ route("payment.callback") }}?order_id={{ $booking->booking_code }}';
            },
            onPending: function(result) {
                window.location.href = '{{ route("payment.callback") }}?order_id={{ $booking->booking_code }}';
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
                window.location.href = '{{ route("booking.show", $booking->booking_code) }}';
            },
            onClose: function() {
                // User closed popup without completing payment
            }
        });
    });
</script>
@endpush
