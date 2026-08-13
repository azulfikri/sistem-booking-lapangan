<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page_title', 'Dashboard'); ?>
<?php $__env->startSection('page_subtitle', 'Ringkasan statistik Sports Center'); ?>

<?php $__env->startSection('content'); ?>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    
    <div class="stat-card bg-linear-to-br from-primary-500 to-primary-700 text-white animate-fade-in-up" style="animation-delay: 0ms;">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
            <span class="text-xs font-medium bg-white/20 px-2.5 py-1 rounded-full">Total</span>
        </div>
        <p class="text-2xl font-bold">Rp <?php echo e(number_format($revenue, 0, ',', '.')); ?></p>
        <p class="text-sm text-white/70 mt-1">Pendapatan</p>
    </div>

    
    <div class="stat-card bg-linear-to-br from-accent-500 to-accent-700 text-white animate-fade-in-up" style="animation-delay: 80ms;">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center">
                <i data-lucide="calendar-check" class="w-5 h-5"></i>
            </div>
            <span class="text-xs font-medium bg-white/20 px-2.5 py-1 rounded-full">Hari Ini</span>
        </div>
        <p class="text-2xl font-bold"><?php echo e($todayBookings); ?></p>
        <p class="text-sm text-white/70 mt-1">Booking</p>
    </div>

    
    <div class="stat-card bg-linear-to-br from-blue-500 to-blue-700 text-white animate-fade-in-up" style="animation-delay: 160ms;">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center">
                <i data-lucide="map" class="w-5 h-5"></i>
            </div>
            <span class="text-xs font-medium bg-white/20 px-2.5 py-1 rounded-full">Aktif</span>
        </div>
        <p class="text-2xl font-bold"><?php echo e($availableFields); ?></p>
        <p class="text-sm text-white/70 mt-1">Lapangan</p>
    </div>

    
    <div class="stat-card bg-linear-to-br from-purple-500 to-purple-700 text-white animate-fade-in-up" style="animation-delay: 240ms;">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <span class="text-xs font-medium bg-white/20 px-2.5 py-1 rounded-full">Total</span>
        </div>
        <p class="text-2xl font-bold"><?php echo e($uniqueCustomers); ?></p>
        <p class="text-sm text-white/70 mt-1">Customer</p>
    </div>
</div>


<?php if($pendingBookings > 0): ?>
    <div class="alert alert-warning mb-6">
        <i data-lucide="clock" class="w-5 h-5 shrink-0"></i>
        <span>Ada <strong><?php echo e($pendingBookings); ?></strong> booking menunggu konfirmasi.</span>
        <a href="<?php echo e(route('admin.bookings', ['booking_status' => 'pending'])); ?>" class="ml-auto text-sm font-semibold hover:underline">Lihat →</a>
    </div>
<?php endif; ?>


<div class="card-admin rounded-2xl animate-fade-in-up" style="animation-delay: 300ms;">
    <div class="px-6 py-5 border-b border-surface-100 flex items-center justify-between">
        <h2 class="font-bold text-surface-900 flex items-center gap-2">
            <i data-lucide="list" class="w-5 h-5 text-primary-500"></i>
            Booking Terbaru
        </h2>
        <a href="<?php echo e(route('admin.bookings')); ?>" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat Semua →</a>
    </div>

    <div class="overflow-x-auto">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Customer</th>
                    <th>Lapangan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <span class="font-mono font-semibold text-sm text-primary-600"><?php echo e($booking->booking_code); ?></span>
                        </td>
                        <td>
                            <div>
                                <p class="font-medium text-surface-900"><?php echo e($booking->customer_name); ?></p>
                                <p class="text-xs text-surface-400"><?php echo e($booking->customer_email); ?></p>
                            </div>
                        </td>
                        <td><?php echo e($booking->field->name ?? '-'); ?></td>
                        <td>
                            <div>
                                <p class="text-sm"><?php echo e($booking->formatted_date); ?></p>
                                <p class="text-xs text-surface-400"><?php echo e($booking->time_range); ?></p>
                            </div>
                        </td>
                        <td class="font-semibold"><?php echo e($booking->formatted_price); ?></td>
                        <td>
                            <div class="flex flex-col gap-1">
                                <span class="badge badge-<?php echo e($booking->booking_status); ?>"><?php echo e(ucfirst($booking->booking_status)); ?></span>
                                <span class="badge badge-<?php echo e($booking->payment_status); ?>"><?php echo e(ucfirst($booking->payment_status)); ?></span>
                            </div>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.bookings.show', $booking->id)); ?>" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-8 text-surface-400">Belum ada booking.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DEVELOPMENTS\MOA-GITS\sistem-booking-lapangan\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>