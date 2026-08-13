<?php $__env->startSection('title', 'Booking Saya'); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-gradient-hero pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl font-bold text-white animate-fade-in-up">Booking Saya</h1>
        <p class="text-white/60 mt-2 animate-fade-in-up delay-100">Riwayat booking yang pernah Anda buat.</p>
    </div>
</section>

<section class="py-12 bg-surface-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if($bookings->count() > 0): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card-admin rounded-2xl p-5 sm:p-6 hover:shadow-md transition-shadow" style="animation: fade-in-up 0.4s ease-out <?php echo e($index * 60); ?>ms both;">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                                    <i data-lucide="calendar" class="w-6 h-6 text-primary-600"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-surface-900"><?php echo e($booking->field->name ?? 'Lapangan'); ?></h3>
                                        <span class="badge badge-<?php echo e($booking->booking_status); ?>"><?php echo e(ucfirst($booking->booking_status)); ?></span>
                                    </div>
                                    <p class="text-sm text-surface-500">
                                        <?php echo e($booking->formatted_date); ?> • <?php echo e($booking->time_range); ?> (<?php echo e($booking->duration); ?> jam)
                                    </p>
                                    <p class="text-xs text-surface-400 mt-1">Kode: <span class="font-mono font-semibold"><?php echo e($booking->booking_code); ?></span></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 sm:flex-col sm:items-end">
                                <p class="text-lg font-bold text-primary-600"><?php echo e($booking->formatted_price); ?></p>
                                <span class="badge badge-<?php echo e($booking->payment_status); ?>"><?php echo e(ucfirst($booking->payment_status)); ?></span>
                                <a href="<?php echo e(route('booking.show', $booking->booking_code)); ?>" class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1">
                                    Detail <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="mt-8">
                <?php echo e($bookings->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-20 card-admin rounded-2xl max-w-md mx-auto">
                <i data-lucide="calendar-x" class="w-16 h-16 text-surface-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-semibold text-surface-700 mb-2">Belum Ada Booking</h3>
                <p class="text-surface-500 text-sm mb-6">Anda belum pernah melakukan booking.</p>
                <a href="<?php echo e(route('booking.index')); ?>" class="btn-primary py-2.5 px-5 text-sm">Booking Sekarang</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DEVELOPMENTS\MOA-GITS\sistem-booking-lapangan\resources\views/booking/my-bookings.blade.php ENDPATH**/ ?>