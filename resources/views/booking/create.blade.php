<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Booking - {{ $field->name }}</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Form Booking</h1>
                <a href="{{ route('booking.index') }}" class="text-gray-600 hover:text-gray-900">
                    ← Kembali ke Daftar Lapangan
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Field Info Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 sticky top-6">
                    <div class="h-48 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-t-xl relative">
                        @if($field->photo)
                            <img src="{{ asset('fields/' . $field->photo) }}" alt="{{ $field->name }}" class="w-full h-full object-cover rounded-t-xl">
                        @endif
                    </div>
                    <div class="p-5">
                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $field->name }}</h2>
                        @if($field->description)
                            <p class="text-sm text-gray-600 mb-4">{{ $field->description }}</p>
                        @endif
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Harga per jam:</span>
                                <span class="text-lg font-bold text-emerald-600">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</span>
                            </div>
                            <div id="total-price-display" class="flex justify-between items-center text-sm text-gray-600 hidden">
                                <span class="font-medium">Total Harga:</span>
                                <span id="total-price" class="text-xl font-bold text-gray-900"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Isi Data Booking</h3>

                    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="field_id" value="{{ $field->id }}">

                        <!-- Tanggal Booking -->
                        <div class="mb-6">
                            <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Booking <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                name="booking_date" 
                                id="booking_date" 
                                value="{{ old('booking_date') }}"
                                min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('booking_date') border-red-500 @enderror"
                                required
                            >
                            @error('booking_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jam Mulai -->
                        <div class="mb-6">
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Jam Mulai <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="start_time" 
                                id="start_time" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('start_time') border-red-500 @enderror"
                                required
                            >
                                <option value="">Pilih jam...</option>
                                @for($h = 6; $h < 22; $h++)
                                    <option value="{{ sprintf('%02d:00', $h) }}" {{ old('start_time') == sprintf('%02d:00', $h) ? 'selected' : '' }}>
                                        {{ sprintf('%02d:00', $h) }}
                                    </option>
                                @endfor
                            </select>
                            @error('start_time')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">Jam operasional: 06:00 - 22:00</p>
                            @enderror
                        </div>

                        <!-- Durasi -->
                        <div class="mb-6">
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Durasi (Jam) <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="duration" 
                                id="duration" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('duration') border-red-500 @enderror"
                                required
                            >
                                <option value="">Pilih durasi...</option>
                                @for($d = 1; $d <= 8; $d++)
                                    <option value="{{ $d }}" {{ old('duration') == $d ? 'selected' : '' }}>
                                        {{ $d }} Jam
                                    </option>
                                @endfor
                            </select>
                            @error('duration')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <!-- Availability Check Result -->
                            <div id="availability-result" class="mt-2 hidden"></div>
                        </div>

                        <div class="border-t border-gray-200 pt-6 mb-6"></div>

                        <!-- Nama -->
                        <div class="mb-6">
                            <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="guest_name" 
                                id="guest_name" 
                                value="{{ old('guest_name') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('guest_name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap"
                                required
                            >
                            @error('guest_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="guest_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="guest_email" 
                                id="guest_email" 
                                value="{{ old('guest_email') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('guest_email') border-red-500 @enderror"
                                placeholder="contoh@email.com"
                                required
                            >
                            @error('guest_email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="mb-6">
                            <label for="guest_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="guest_phone" 
                                id="guest_phone" 
                                value="{{ old('guest_phone') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('guest_phone') border-red-500 @enderror"
                                placeholder="08xxxxxxxxxx"
                                required
                            >
                            @error('guest_phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mb-6">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="payment_method" 
                                id="payment_method" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('payment_method') border-red-500 @enderror"
                                required
                            >
                                <option value="">Pilih metode pembayaran...</option>
                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash (Bayar di Tempat)</option>
                                <option value="midtrans" {{ old('payment_method') == 'midtrans' ? 'selected' : '' }}>Pembayaran Online (Midtrans)</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea 
                                name="notes" 
                                id="notes" 
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('notes') border-red-500 @enderror"
                                placeholder="Tambahkan catatan jika ada..."
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('booking.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit" id="submitBtn" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors shadow-sm disabled:bg-gray-400 disabled:cursor-not-allowed">
                                Booking Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        const pricePerHour = {{ $field->price_per_hour }};
        const fieldId = {{ $field->id }};
        
        // Calculate and display total price
        function updateTotalPrice() {
            const duration = document.getElementById('duration').value;
            if (duration) {
                const total = pricePerHour * parseInt(duration);
                document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('total-price-display').classList.remove('hidden');
            } else {
                document.getElementById('total-price-display').classList.add('hidden');
            }
        }

        // Check availability via AJAX
        function checkAvailability() {
            const date = document.getElementById('booking_date').value;
            const startTime = document.getElementById('start_time').value;
            const duration = document.getElementById('duration').value;
            const resultDiv = document.getElementById('availability-result');
            const submitBtn = document.getElementById('submitBtn');

            if (!date || !startTime || !duration) {
                resultDiv.classList.add('hidden');
                submitBtn.disabled = false;
                return;
            }

            resultDiv.innerHTML = '<p class="text-sm text-gray-500">Mengecek ketersediaan...</p>';
            resultDiv.classList.remove('hidden');

            fetch('{{ route('booking.check') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    field_id: fieldId,
                    booking_date: date,
                    start_time: startTime,
                    duration: parseInt(duration)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                    resultDiv.innerHTML = '<p class="text-sm text-green-600 font-medium">✓ ' + data.message + '</p>';
                    submitBtn.disabled = false;
                } else {
                    resultDiv.innerHTML = '<p class="text-sm text-red-600 font-medium">✗ ' + data.message + '</p>';
                    submitBtn.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultDiv.innerHTML = '<p class="text-sm text-red-600">Gagal mengecek ketersediaan.</p>';
            });
        }

        // Event listeners
        document.getElementById('duration').addEventListener('change', function() {
            updateTotalPrice();
            checkAvailability();
        });

        document.getElementById('booking_date').addEventListener('change', checkAvailability);
        document.getElementById('start_time').addEventListener('change', checkAvailability);
    </script>
</body>
</html>
