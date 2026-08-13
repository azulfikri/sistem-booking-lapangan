<?php $__env->startSection('title', 'Detail Booking #' . $booking->booking_code); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-gradient-hero pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="<?php echo e(route('booking.index')); ?>" class="inline-flex items-center gap-2 text-sm text-white/60 hover:text-white transition-colors mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
        <h1 class="text-3xl font-bold text-white animate-fade-in-up">Detail Booking</h1>
    </div>
</section>

<section class="py-12 bg-surface-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        
        <?php if(session('success')): ?>
            <div class="mb-8 p-6 rounded-2xl bg-linear-to-r from-accent-50 to-emerald-50 border border-accent-200 animate-scale-in">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-accent-100 rounded-xl flex items-center justify-center shrink-0">
                        <i data-lucide="check-circle" class="w-6 h-6 text-accent-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-accent-800 mb-1">Booking Berhasil Dibuat!</h3>
                        <p class="text-sm text-accent-700">Silakan selesaikan pembayaran sesuai metode yang dipilih. Simpan kode booking Anda.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            
            <div class="lg:col-span-2 space-y-6">

                
                <div class="card-admin rounded-2xl p-6 text-center animate-fade-in-up">
                    <p class="text-sm text-surface-500 mb-2">Kode Booking</p>
                    <p class="text-3xl font-black text-primary-600 tracking-widest mb-3"><?php echo e($booking->booking_code); ?></p>
                    <div class="flex items-center justify-center gap-4">
                        <span class="badge badge-<?php echo e($booking->booking_status); ?>">
                            <?php echo e(ucfirst($booking->booking_status)); ?>

                        </span>
                        <span class="badge badge-<?php echo e($booking->payment_status); ?>">
                            Bayar: <?php echo e(ucfirst($booking->payment_status)); ?>

                        </span>
                    </div>
                </div>

                
                <div class="card-admin rounded-2xl p-6 animate-fade-in-up delay-100">
                    <h3 class="font-bold text-surface-900 mb-5 flex items-center gap-2">
                        <i data-lucide="info" class="w-5 h-5 text-primary-500"></i>
                        Detail Booking
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-surface-100">
                            <span class="text-sm text-surface-500">Lapangan</span>
                            <span class="font-semibold text-surface-900"><?php echo e($booking->field->name); ?></span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-surface-100">
                            <span class="text-sm text-surface-500">Tanggal</span>
                            <span class="font-medium text-surface-700"><?php echo e($booking->formatted_date); ?></span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-surface-100">
                            <span class="text-sm text-surface-500">Waktu</span>
                            <span class="font-medium text-surface-700"><?php echo e($booking->time_range); ?> (<?php echo e($booking->duration); ?> jam)</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-surface-100">
                            <span class="text-sm text-surface-500">Metode Bayar</span>
                            <span class="font-medium text-surface-700 capitalize"><?php echo e($booking->payment_method); ?></span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm text-surface-500">Total</span>
                            <span class="text-xl font-bold text-primary-600"><?php echo e($booking->formatted_price); ?></span>
                        </div>
                    </div>
                </div>

                
                <div class="card-admin rounded-2xl p-6 animate-fade-in-up delay-200">
                    <h3 class="font-bold text-surface-900 mb-5 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-primary-500"></i>
                        Data Pemesan
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-surface-500">Nama</span>
                            <span class="font-medium text-surface-700"><?php echo e($booking->customer_name); ?></span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-surface-500">Telepon</span>
                            <span class="font-medium text-surface-700"><?php echo e($booking->customer_phone); ?></span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-surface-500">Email</span>
                            <span class="font-medium text-surface-700"><?php echo e($booking->customer_email); ?></span>
                        </div>
                        <?php if($booking->notes): ?>
                            <div class="pt-3 border-t border-surface-100">
                                <span class="text-sm text-surface-500">Catatan:</span>
                                <p class="text-sm text-surface-700 mt-1"><?php echo e($booking->notes); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-1">
                <div class="card-admin rounded-2xl p-6 sticky top-24 animate-fade-in-up delay-300">
                    <h3 class="font-bold text-surface-900 mb-5 flex items-center gap-2">
                        <i data-lucide="credit-card" class="w-5 h-5 text-primary-500"></i>
                        Pembayaran
                    </h3>

                    <?php if($booking->payment_method === 'midtrans' && in_array($booking->payment_status, ['unpaid', 'pending'])): ?>
                        <p class="text-sm text-surface-500 mb-4">Klik tombol di bawah untuk membayar secara online via Midtrans.</p>
                        <a href="<?php echo e(route('payment.process', $booking->booking_code)); ?>" class="btn-primary w-full py-3 gap-2">
                            <i data-lucide="credit-card" class="w-4 h-4"></i>
                            Bayar Sekarang
                        </a>
                    <?php elseif($booking->payment_method === 'transfer' && in_array($booking->payment_status, ['unpaid', 'pending'])): ?>
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                            <p class="text-sm font-semibold text-blue-800 mb-2">Transfer ke:</p>
                            <p class="text-sm text-blue-700">Bank BCA</p>
                            <p class="text-lg font-bold text-blue-900 mt-1">1234567890</p>
                            <p class="text-sm text-blue-700 mt-1">a.n. Sports Center</p>
                        </div>
                        <p class="text-xs text-surface-400 text-center">Konfirmasi pembayaran akan diverifikasi oleh admin.</p>
                    <?php elseif($booking->payment_method === 'cash' && in_array($booking->payment_status, ['unpaid', 'pending'])): ?>
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                            <p class="text-sm text-amber-800">Silakan bayar langsung di lokasi Sports Center saat datang bermain.</p>
                        </div>
                    <?php elseif($booking->payment_status === 'paid'): ?>
                        <div class="text-center py-4">
                            <div class="w-16 h-16 mx-auto bg-accent-100 rounded-full flex items-center justify-center mb-3">
                                <i data-lucide="check-circle" class="w-8 h-8 text-accent-600"></i>
                            </div>
                            <p class="font-semibold text-accent-700">Pembayaran Lunas</p>
                            <p class="text-sm text-surface-500 mt-1">Terima kasih! Selamat bermain.</p>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <div class="w-16 h-16 mx-auto bg-surface-100 rounded-full flex items-center justify-center mb-3">
                                <i data-lucide="clock" class="w-8 h-8 text-surface-400"></i>
                            </div>
                            <p class="text-sm text-surface-500">Status: <?php echo e(ucfirst($booking->payment_status)); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DEVELOPMENTS\MOA-GITS\sistem-booking-lapangan\resources\views/booking/show.blade.php ENDPATH**/ ?>