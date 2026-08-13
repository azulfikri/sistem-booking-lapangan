@extends('layouts.admin')

@section('title', 'Detail Booking #' . $booking->booking_code)
@section('page_title', 'Detail Booking')
@section('page_subtitle', $booking->booking_code)

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.bookings') }}" class="inline-flex items-center gap-2 text-sm text-surface-500 hover:text-primary-600 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Booking
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Main Info --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Booking Info --}}
        <div class="card-admin rounded-2xl p-6 animate-fade-in-up">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-surface-900 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-primary-500"></i>
                    Informasi Booking
                </h3>
                <div class="flex gap-2">
                    <span class="badge badge-{{ $booking->booking_status }}">{{ ucfirst($booking->booking_status) }}</span>
                    <span class="badge badge-{{ $booking->payment_status }}">Bayar: {{ ucfirst($booking->payment_status) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 bg-surface-50 rounded-xl">
                    <p class="text-xs text-surface-400 mb-1">Kode Booking</p>
                    <p class="font-mono font-bold text-primary-600">{{ $booking->booking_code }}</p>
                </div>
                <div class="p-4 bg-surface-50 rounded-xl">
                    <p class="text-xs text-surface-400 mb-1">Lapangan</p>
                    <p class="font-semibold">{{ $booking->field->name ?? '-' }}</p>
                </div>
                <div class="p-4 bg-surface-50 rounded-xl">
                    <p class="text-xs text-surface-400 mb-1">Tanggal</p>
                    <p class="font-medium">{{ $booking->formatted_date }}</p>
                </div>
                <div class="p-4 bg-surface-50 rounded-xl">
                    <p class="text-xs text-surface-400 mb-1">Waktu</p>
                    <p class="font-medium">{{ $booking->time_range }} ({{ $booking->duration }} jam)</p>
                </div>
                <div class="p-4 bg-surface-50 rounded-xl">
                    <p class="text-xs text-surface-400 mb-1">Metode Bayar</p>
                    <p class="font-medium capitalize">{{ $booking->payment_method }}</p>
                </div>
                <div class="p-4 bg-surface-50 rounded-xl">
                    <p class="text-xs text-surface-400 mb-1">Total</p>
                    <p class="text-xl font-bold text-primary-600">{{ $booking->formatted_price }}</p>
                </div>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="card-admin rounded-2xl p-6 animate-fade-in-up delay-100">
            <h3 class="font-bold text-surface-900 mb-4 flex items-center gap-2">
                <i data-lucide="user" class="w-5 h-5 text-primary-500"></i>
                Data Customer
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-surface-400 mb-1">Nama</p>
                    <p class="font-medium">{{ $booking->customer_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-surface-400 mb-1">Telepon</p>
                    <p class="font-medium">{{ $booking->customer_phone }}</p>
                </div>
                <div>
                    <p class="text-xs text-surface-400 mb-1">Email</p>
                    <p class="font-medium">{{ $booking->customer_email }}</p>
                </div>
            </div>
            @if($booking->notes)
                <div class="mt-4 pt-4 border-t border-surface-100">
                    <p class="text-xs text-surface-400 mb-1">Catatan</p>
                    <p class="text-sm text-surface-700 whitespace-pre-line">{{ $booking->notes }}</p>
                </div>
            @endif

            @if($booking->midtrans_transaction_id)
                <div class="mt-4 pt-4 border-t border-surface-100">
                    <p class="text-xs text-surface-400 mb-1">Midtrans Transaction ID</p>
                    <p class="font-mono text-sm">{{ $booking->midtrans_transaction_id }}</p>
                    @if($booking->midtrans_payment_type)
                        <p class="text-xs text-surface-400 mt-1">Tipe: {{ $booking->midtrans_payment_type }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Actions Sidebar --}}
    <div class="lg:col-span-1 space-y-6">

        {{-- Update Payment Status --}}
        <div class="card-admin rounded-2xl p-6 animate-fade-in-up delay-200">
            <h3 class="font-bold text-surface-900 mb-4 flex items-center gap-2">
                <i data-lucide="credit-card" class="w-5 h-5 text-primary-500"></i>
                Status Pembayaran
            </h3>
            <form method="POST" action="{{ route('admin.bookings.update-payment', $booking->id) }}">
                @csrf
                @method('PUT')
                <select name="payment_status" class="form-input mb-3 text-sm">
                    @foreach(['unpaid', 'pending', 'paid', 'expired', 'failed'] as $status)
                        <option value="{{ $status }}" {{ $booking->payment_status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary w-full py-2.5 text-sm gap-1">
                    <i data-lucide="save" class="w-4 h-4"></i> Update Pembayaran
                </button>
            </form>
        </div>

        {{-- Update Booking Status --}}
        <div class="card-admin rounded-2xl p-6 animate-fade-in-up delay-300">
            <h3 class="font-bold text-surface-900 mb-4 flex items-center gap-2">
                <i data-lucide="settings" class="w-5 h-5 text-primary-500"></i>
                Status Booking
            </h3>
            <form method="POST" action="{{ route('admin.bookings.update-status', $booking->id) }}">
                @csrf
                @method('PUT')
                <select name="booking_status" id="admin-booking-status" class="form-input mb-3 text-sm">
                    @foreach(['pending', 'confirmed', 'cancelled', 'completed'] as $status)
                        <option value="{{ $status }}" {{ $booking->booking_status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <div id="cancel-reason-field" class="hidden mb-3">
                    <label class="form-label text-xs">Alasan Pembatalan</label>
                    <textarea name="cancel_reason" rows="2" class="form-input text-sm" placeholder="Masukkan alasan..."></textarea>
                </div>
                <button type="submit" class="btn-accent w-full py-2.5 text-sm gap-1">
                    <i data-lucide="save" class="w-4 h-4"></i> Update Status
                </button>
            </form>
        </div>

        {{-- Cancel/Delete --}}
        @if($booking->booking_status !== 'cancelled')
            <div class="card-admin rounded-2xl p-6 animate-fade-in-up delay-400">
                <h3 class="font-bold text-red-600 mb-4 flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    Batalkan Booking
                </h3>
                <form method="POST" action="{{ route('admin.bookings.destroy', $booking->id) }}" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                    @csrf
                    @method('DELETE')
                    <input type="text" name="reason" class="form-input mb-3 text-sm" placeholder="Alasan pembatalan" required>
                    <button type="submit" class="btn-danger w-full py-2.5 text-sm gap-1">
                        <i data-lucide="x-circle" class="w-4 h-4"></i> Batalkan Booking
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    const statusSelect = document.getElementById('admin-booking-status');
    const cancelField = document.getElementById('cancel-reason-field');
    statusSelect?.addEventListener('change', function() {
        cancelField.classList.toggle('hidden', this.value !== 'cancelled');
    });
</script>
@endpush
