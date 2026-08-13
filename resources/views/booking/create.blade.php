@extends('layouts.app')

@section('title', 'Booking ' . $field->name)

@section('content')

{{-- Page Header --}}
<section class="bg-gradient-hero pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('booking.index') }}" class="inline-flex items-center gap-2 text-sm text-white/60 hover:text-white transition-colors mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Lapangan
        </a>
        <h1 class="text-3xl font-bold text-white animate-fade-in-up">Booking {{ $field->name }}</h1>
    </div>
</section>

<section class="py-12 bg-surface-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Booking Form --}}
            <div class="lg:col-span-2">
                <div class="card-admin rounded-2xl p-6 sm:p-8 animate-fade-in-up">
                    <h2 class="text-xl font-bold text-surface-900 mb-6 flex items-center gap-2">
                        <i data-lucide="calendar-plus" class="w-5 h-5 text-primary-500"></i>
                        Form Booking
                    </h2>

                    <form method="POST" action="{{ route('booking.store') }}" id="booking-form">
                        @csrf
                        <input type="hidden" name="field_id" value="{{ $field->id }}">

                        {{-- Jadwal --}}
                        <div class="space-y-5 mb-8">
                            <p class="text-sm font-semibold text-surface-500 uppercase tracking-wider">Jadwal</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="booking_date" class="form-label">Tanggal Booking</label>
                                    <input type="date" name="booking_date" id="booking_date" class="form-input" min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}" required>
                                    @error('booking_date') <p class="form-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="start_time" class="form-label">Jam Mulai</label>
                                    <select name="start_time" id="start_time" class="form-input" required>
                                        <option value="">Pilih Jam</option>
                                        @for($h = 7; $h <= 22; $h++)
                                            <option value="{{ sprintf('%02d:00', $h) }}" {{ old('start_time') == sprintf('%02d:00', $h) ? 'selected' : '' }}>
                                                {{ sprintf('%02d:00', $h) }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('start_time') <p class="form-error">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="duration" class="form-label">Durasi (Jam)</label>
                                <select name="duration" id="duration" class="form-input" required>
                                    <option value="">Pilih Durasi</option>
                                    @for($d = 1; $d <= 8; $d++)
                                        <option value="{{ $d }}" {{ old('duration') == $d ? 'selected' : '' }}>{{ $d }} Jam</option>
                                    @endfor
                                </select>
                                @error('duration') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            {{-- Availability indicator --}}
                            <div id="availability-status" class="hidden px-4 py-3 rounded-xl text-sm font-medium items-center gap-2"></div>
                        </div>

                        {{-- Data Customer --}}
                        <div class="space-y-5 mb-8">
                            <p class="text-sm font-semibold text-surface-500 uppercase tracking-wider">Data Pemesan</p>

                            <div>
                                <label for="guest_name" class="form-label">Nama Lengkap</label>
                                <input type="text" name="guest_name" id="guest_name" class="form-input" placeholder="Masukkan nama lengkap" value="{{ old('guest_name', auth()->user()->name ?? '') }}" required>
                                @error('guest_name') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="guest_phone" class="form-label">Nomor Telepon</label>
                                    <input type="tel" name="guest_phone" id="guest_phone" class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('guest_phone', auth()->user()->phone ?? '') }}" required>
                                    @error('guest_phone') <p class="form-error">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="guest_email" class="form-label">Email</label>
                                    <input type="email" name="guest_email" id="guest_email" class="form-input" placeholder="email@contoh.com" value="{{ old('guest_email', auth()->user()->email ?? '') }}" required>
                                    @error('guest_email') <p class="form-error">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Pembayaran --}}
                        <div class="space-y-5 mb-8">
                            <p class="text-sm font-semibold text-surface-500 uppercase tracking-wider">Pembayaran</p>

                            <div>
                                <label class="form-label">Metode Pembayaran</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    @foreach(['transfer' => ['Transfer Bank', 'building-2'], 'cash' => ['Cash / Tunai', 'banknote'], 'midtrans' => ['Midtrans (Online)', 'credit-card']] as $value => [$label, $icon])
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="payment_method" value="{{ $value }}" class="peer hidden" {{ old('payment_method') == $value ? 'checked' : '' }}>
                                            <div class="flex items-center gap-3 p-4 rounded-xl border-2 border-surface-200 peer-checked:border-primary-500 peer-checked:bg-primary-50 transition-all duration-200 hover:border-surface-300">
                                                <i data-lucide="{{ $icon }}" class="w-5 h-5 text-surface-400 peer-checked:text-primary-600"></i>
                                                <span class="text-sm font-medium text-surface-700">{{ $label }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('payment_method') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-8">
                            <label for="notes" class="form-label">Catatan (opsional)</label>
                            <textarea name="notes" id="notes" rows="3" class="form-input" placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                            @error('notes') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" id="submit-btn" class="btn-primary w-full py-4 text-base gap-2">
                            <i data-lucide="check" class="w-5 h-5"></i>
                            Buat Booking
                        </button>
                    </form>
                </div>
            </div>

            {{-- Field Info Sidebar --}}
            <div class="lg:col-span-1">
                <div class="card-admin rounded-2xl overflow-hidden sticky top-24 animate-fade-in-up delay-200">
                    {{-- Image --}}
                    <div class="h-48 bg-linear-to-br from-primary-100 to-primary-50 overflow-hidden">
                        @if($field->photo)
                            <img src="{{ asset('fields/' . $field->photo) }}" alt="{{ $field->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <i data-lucide="map" class="w-12 h-12 text-primary-300"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <h3 class="font-bold text-surface-900 mb-1">{{ $field->name }}</h3>
                        @if($field->type)
                            <span class="text-xs font-medium text-primary-600 capitalize">{{ str_replace('_', ' ', $field->type) }}</span>
                        @endif
                        <p class="text-sm text-surface-500 mt-3">{{ $field->description ?? '-' }}</p>

                        <div class="mt-5 pt-5 border-t border-surface-100">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm text-surface-500">Harga per jam</span>
                                <span class="font-bold text-primary-600">{{ $field->formatted_price }}</span>
                            </div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm text-surface-500">Status</span>
                                <span class="badge badge-available">Tersedia</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-surface-500">Jam Operasional</span>
                                <span class="text-sm font-medium text-surface-700">07:00 - 23:00</span>
                            </div>
                        </div>

                        {{-- Price summary --}}
                        <div id="price-summary" class="hidden mt-5 pt-5 border-t border-surface-100">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm text-surface-500">Durasi</span>
                                <span class="text-sm font-medium text-surface-700" id="summary-duration">-</span>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <span class="font-semibold text-surface-700">Total</span>
                                <span class="text-xl font-bold text-primary-600" id="summary-total">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    const pricePerHour = {{ $field->price_per_hour }};
    const fieldId = {{ $field->id }};

    // Update price summary
    function updateSummary() {
        const duration = document.getElementById('duration').value;
        const summary = document.getElementById('price-summary');

        if (duration) {
            summary.classList.remove('hidden');
            document.getElementById('summary-duration').textContent = duration + ' Jam';
            document.getElementById('summary-total').textContent = formatRupiah(pricePerHour * duration);
        } else {
            summary.classList.add('hidden');
        }
    }

    // Check availability
    async function checkAvailability() {
        const date = document.getElementById('booking_date').value;
        const time = document.getElementById('start_time').value;
        const duration = document.getElementById('duration').value;
        const statusEl = document.getElementById('availability-status');

        if (!date || !time || !duration) {
            statusEl.classList.add('hidden');
            return;
        }

        statusEl.classList.remove('hidden');
        statusEl.className = 'px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 bg-surface-100 text-surface-500';
        statusEl.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Mengecek ketersediaan...';
        lucide.createIcons();

        try {
            const response = await axios.post('{{ route("booking.check-availability") }}', {
                field_id: fieldId,
                booking_date: date,
                start_time: time,
                duration: duration,
            });

            if (response.data.available) {
                statusEl.className = 'px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 bg-green-50 text-green-700 border border-green-200';
                statusEl.innerHTML = '<i data-lucide="check-circle" class="w-4 h-4"></i> ' + response.data.message;
            } else {
                statusEl.className = 'px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 bg-red-50 text-red-700 border border-red-200';
                statusEl.innerHTML = '<i data-lucide="alert-circle" class="w-4 h-4"></i> ' + response.data.message;
            }
            lucide.createIcons();
        } catch (error) {
            statusEl.className = 'px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 bg-red-50 text-red-700 border border-red-200';
            statusEl.innerHTML = '<i data-lucide="alert-circle" class="w-4 h-4"></i> Gagal mengecek ketersediaan.';
            lucide.createIcons();
        }
    }

    document.getElementById('duration').addEventListener('change', () => { updateSummary(); checkAvailability(); });
    document.getElementById('booking_date').addEventListener('change', checkAvailability);
    document.getElementById('start_time').addEventListener('change', checkAvailability);
</script>
@endpush
