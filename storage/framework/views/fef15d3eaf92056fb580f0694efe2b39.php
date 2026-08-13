<?php $__env->startSection('title', 'Kelola Booking'); ?>
<?php $__env->startSection('page_title', 'Kelola Booking'); ?>
<?php $__env->startSection('page_subtitle', 'Lihat dan kelola semua booking'); ?>

<?php $__env->startSection('content'); ?>


<div class="card-admin rounded-2xl p-5 mb-6 animate-fade-in-up">
    <form method="GET" action="<?php echo e(route('admin.bookings')); ?>" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        <div>
            <input type="text" name="search" class="form-input text-sm" placeholder="Cari kode/nama/email..." value="<?php echo e(request('search')); ?>">
        </div>
        <div>
            <select name="booking_status" class="form-input text-sm">
                <option value="all">Semua Status</option>
                <?php $__currentLoopData = ['pending', 'confirmed', 'cancelled', 'completed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status); ?>" <?php echo e(request('booking_status') == $status ? 'selected' : ''); ?>><?php echo e(ucfirst($status)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <select name="payment_status" class="form-input text-sm">
                <option value="all">Semua Bayar</option>
                <?php $__currentLoopData = ['unpaid', 'pending', 'paid', 'expired', 'failed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status); ?>" <?php echo e(request('payment_status') == $status ? 'selected' : ''); ?>><?php echo e(ucfirst($status)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <select name="field_id" class="form-input text-sm">
                <option value="all">Semua Lapangan</option>
                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($field->id); ?>" <?php echo e(request('field_id') == $field->id ? 'selected' : ''); ?>><?php echo e($field->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <input type="date" name="date_from" class="form-input text-sm" placeholder="Dari" value="<?php echo e(request('date_from')); ?>">
        </div>
        <div class="flex gap-2">
            <input type="date" name="date_to" class="form-input text-sm flex-1" placeholder="Sampai" value="<?php echo e(request('date_to')); ?>">
            <button type="submit" class="btn-primary py-2 px-4 text-sm shrink-0">
                <i data-lucide="search" class="w-4 h-4"></i>
            </button>
        </div>
    </form>
</div>


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
                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <span class="font-mono font-semibold text-sm text-primary-600"><?php echo e($booking->booking_code); ?></span>
                        </td>
                        <td>
                            <div>
                                <p class="font-medium text-surface-900 text-sm"><?php echo e($booking->customer_name); ?></p>
                                <p class="text-xs text-surface-400"><?php echo e($booking->customer_phone); ?></p>
                            </div>
                        </td>
                        <td class="text-sm"><?php echo e($booking->field->name ?? '-'); ?></td>
                        <td>
                            <div>
                                <p class="text-sm"><?php echo e($booking->formatted_date); ?></p>
                                <p class="text-xs text-surface-400"><?php echo e($booking->time_range); ?></p>
                            </div>
                        </td>
                        <td class="font-semibold text-sm"><?php echo e($booking->formatted_price); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($booking->payment_status); ?>"><?php echo e(ucfirst($booking->payment_status)); ?></span>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($booking->booking_status); ?>"><?php echo e(ucfirst($booking->booking_status)); ?></span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.bookings.show', $booking->id)); ?>" class="p-2 rounded-lg text-surface-500 hover:text-primary-600 hover:bg-primary-50 transition-colors inline-flex" title="Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-8 text-surface-400">Tidak ada booking ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($bookings->hasPages()): ?>
        <div class="px-6 py-4 border-t border-surface-100">
            <?php echo e($bookings->appends(request()->query())->links()); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DEVELOPMENTS\MOA-GITS\sistem-booking-lapangan\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>