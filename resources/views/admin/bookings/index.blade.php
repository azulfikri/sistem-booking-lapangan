@extends('layouts.admin')

@section('title', 'Kelola Booking')
@section('page_title', 'Kelola Booking')
@section('page_subtitle', 'Lihat dan kelola semua booking')

@section('content')

{{-- Filters --}}
<div class="card-admin rounded-2xl p-5 mb-6 animate-fade-in-up">
    <form method="GET" action="{{ route('admin.bookings') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        <div>
            <input type="text" name="search" class="form-input text-sm" placeholder="Cari kode/nama/email..." value="{{ request('search') }}">
        </div>
        <div>
            <select name="booking_status" class="form-input text-sm">
                <option value="all">Semua Status</option>
                @foreach(['pending', 'confirmed', 'cancelled', 'completed'] as $status)
                    <option value="{{ $status }}" {{ request('booking_status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="payment_status" class="form-input text-sm">
                <option value="all">Semua Bayar</option>
                @foreach(['unpaid', 'pending', 'paid', 'expired', 'failed'] as $status)
                    <option value="{{ $status }}" {{ request('payment_status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="field_id" class="form-input text-sm">
                <option value="all">Semua Lapangan</option>
                @foreach($fields as $field)
                    <option value="{{ $field->id }}" {{ request('field_id') == $field->id ? 'selected' : '' }}>{{ $field->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <input type="date" name="date_from" class="form-input text-sm" placeholder="Dari" value="{{ request('date_from') }}">
        </div>
        <div class="flex gap-2">
            <input type="date" name="date_to" class="form-input text-sm flex-1" placeholder="Sampai" value="{{ request('date_to') }}">
            <button type="submit" class="btn-primary py-2 px-4 text-sm shrink-0">
                <i data-lucide="search" class="w-4 h-4"></i>
            </button>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="card-admin rounded-2xl animate-fade-in-up delay-100">
    <div class="overflow-x-auto">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Customer</th>
                    <th>Lapangan</th>
                    <th>Jadwal</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>
                            <span class="font-mono font-semibold text-sm text-primary-600">{{ $booking->booking_code }}</span>
                        </td>
                        <td>
                            <div>
                                <p class="font-medium text-surface-900 text-sm">{{ $booking->customer_name }}</p>
                                <p class="text-xs text-surface-400">{{ $booking->customer_phone }}</p>
                            </div>
                        </td>
                        <td class="text-sm">{{ $booking->field->name ?? '-' }}</td>
                        <td>
                            <div>
                                <p class="text-sm">{{ $booking->formatted_date }}</p>
                                <p class="text-xs text-surface-400">{{ $booking->time_range }}</p>
                            </div>
                        </td>
                        <td class="font-semibold text-sm">{{ $booking->formatted_price }}</td>
                        <td>
                            <span class="badge badge-{{ $booking->payment_status }}">{{ ucfirst($booking->payment_status) }}</span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $booking->booking_status }}">{{ ucfirst($booking->booking_status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="p-2 rounded-lg text-surface-500 hover:text-primary-600 hover:bg-primary-50 transition-colors inline-flex" title="Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-surface-400">Tidak ada booking ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-surface-100">
            {{ $bookings->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection
