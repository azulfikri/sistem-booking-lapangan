<?php $__env->startSection('title', 'Daftar Lapangan'); ?>
<?php $__env->startSection('meta_description', 'Pilih dan booking lapangan olahraga di Sports Center. Futsal, badminton, basket, mini soccer dan lainnya.'); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-gradient-hero pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3 animate-fade-in-up">Daftar Lapangan</h1>
        <p class="text-white/60 max-w-lg mx-auto animate-fade-in-up delay-100">Pilih lapangan yang tersedia dan mulai booking sekarang.</p>
    </div>
</section>


<section class="py-12 bg-surface-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if($fields->count() > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card group" style="animation: fade-in-up 0.5s ease-out <?php echo e($index * 80); ?>ms both;">
                        
                        <div class="relative h-52 bg-linear-to-br from-primary-100 to-primary-50 overflow-hidden">
                            <?php if($field->photo): ?>
                                <img src="<?php echo e(asset('fields/' . $field->photo)); ?>" alt="<?php echo e($field->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <div class="flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <i data-lucide="map" class="w-12 h-12 text-primary-300 mx-auto mb-2"></i>
                                        <p class="text-sm text-primary-400">No Photo</p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            
                            <div class="absolute top-3 right-3">
                                <span class="badge badge-available">
                                    <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>Tersedia
                                </span>
                            </div>

                            <?php if($field->type): ?>
                                <div class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-xs font-semibold text-primary-700 capitalize">
                                    <?php echo e(str_replace('_', ' ', $field->type)); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-surface-900 mb-2"><?php echo e($field->name); ?></h3>
                            <p class="text-sm text-surface-500 mb-5 line-clamp-2"><?php echo e($field->description ?? 'Lapangan olahraga berkualitas tinggi.'); ?></p>

                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-2xl font-bold text-primary-600"><?php echo e($field->formatted_price); ?></p>
                                    <p class="text-xs text-surface-400 mt-0.5">per jam</p>
                                </div>
                                <a href="<?php echo e(route('booking.create', $field->id)); ?>" class="btn-primary py-2.5 px-5 text-sm gap-1.5">
                                    <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                                    Booking
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20 card max-w-md mx-auto">
                <i data-lucide="map-pin-off" class="w-16 h-16 text-surface-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-semibold text-surface-700 mb-2">Belum Ada Lapangan</h3>
                <p class="text-surface-500 text-sm">Saat ini belum ada lapangan yang tersedia. Silakan coba lagi nanti.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DEVELOPMENTS\MOA-GITS\sistem-booking-lapangan\resources\views/booking/index.blade.php ENDPATH**/ ?>