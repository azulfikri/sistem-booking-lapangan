<?php $__env->startSection('title', 'Beranda'); ?>
<?php $__env->startSection('meta_description', 'Sports Center — Booking lapangan olahraga online dengan mudah. Futsal, Badminton, Basket, Mini Soccer dan lainnya.'); ?>

<?php $__env->startSection('content'); ?>


<section class="relative min-h-screen flex items-center bg-gradient-hero overflow-hidden">
    
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-accent-500/15 rounded-full blur-3xl animate-float delay-500"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-150 h-150 bg-primary-600/10 rounded-full blur-3xl"></div>
    </div>

    
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle, rgba(255,255,255,0.3) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="text-center max-w-4xl mx-auto">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm text-white/90 mb-8 animate-fade-in-up">
                <span class="w-2 h-2 bg-accent-400 rounded-full animate-pulse"></span>
                Booking Online — Tersedia 24/7
            </div>

            
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-white leading-tight mb-6 animate-fade-in-up delay-100">
                Booking Lapangan
                <span class="block bg-linear-to-r from-primary-300 via-accent-300 to-primary-300 bg-clip-text text-transparent animate-gradient">
                    Jadi Lebih Mudah
                </span>
            </h1>

            
            <p class="text-lg sm:text-xl text-white/70 leading-relaxed max-w-2xl mx-auto mb-10 animate-fade-in-up delay-200">
                Pilih lapangan, tentukan jadwal, dan bayar online. Tanpa antri, tanpa ribet. Mulai main dalam hitungan menit.
            </p>

            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up delay-300">
                <a href="<?php echo e(route('booking.index')); ?>" class="btn-primary text-lg px-8 py-4 gap-2">
                    <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                    Booking Sekarang
                </a>
                <a href="#lapangan" class="btn-outline border-white/30 text-white hover:bg-white/15 hover:text-white px-8 py-4 gap-2">
                    <i data-lucide="eye" class="w-5 h-5"></i>
                    Lihat Lapangan
                </a>
            </div>

            
            <div class="grid grid-cols-3 gap-6 max-w-lg mx-auto mt-16 animate-fade-in-up delay-400">
                <div class="text-center">
                    <p class="text-3xl font-bold text-white"><?php echo e(\App\Models\Field::where('status', 'available')->count()); ?>+</p>
                    <p class="text-sm text-white/50 mt-1">Lapangan</p>
                </div>
                <div class="text-center border-x border-white/10">
                    <p class="text-3xl font-bold text-white"><?php echo e(\App\Models\Booking::where('booking_status', 'completed')->count()); ?>+</p>
                    <p class="text-sm text-white/50 mt-1">Booking</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-white">16</p>
                    <p class="text-sm text-white/50 mt-1">Jam/Hari</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <a href="#lapangan" class="text-white/40 hover:text-white/60 transition-colors">
            <i data-lucide="chevron-down" class="w-6 h-6"></i>
        </a>
    </div>
</section>


<section id="lapangan" class="py-24 bg-surface-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 rounded-full bg-primary-100 text-primary-700 text-sm font-semibold mb-4">Fasilitas Kami</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-surface-900 mb-4">Lapangan Tersedia</h2>
            <p class="text-surface-500 max-w-xl mx-auto">Pilih lapangan yang sesuai kebutuhanmu. Semua fasilitas berkualitas dan terawat dengan baik.</p>
        </div>

        
        <?php if($fields->count() > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card group animate-fade-in-up delay-<?php echo e(($index + 1) * 100); ?>" style="animation-delay: <?php echo e(($index + 1) * 100); ?>ms;">
                        
                        <div class="relative h-48 bg-linear-to-br from-primary-100 to-primary-50 overflow-hidden">
                            <?php if($field->photo): ?>
                                <img src="<?php echo e(asset('fields/' . $field->photo)); ?>" alt="<?php echo e($field->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <div class="flex items-center justify-center h-full">
                                    <i data-lucide="image" class="w-12 h-12 text-primary-300"></i>
                                </div>
                            <?php endif; ?>
                            <?php if($field->type): ?>
                                <div class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-xs font-semibold text-primary-700 capitalize">
                                    <?php echo e(str_replace('_', ' ', $field->type)); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        
                        <div class="p-5">
                            <h3 class="font-bold text-surface-900 mb-1"><?php echo e($field->name); ?></h3>
                            <p class="text-sm text-surface-500 mb-4 line-clamp-2"><?php echo e($field->description ?? 'Lapangan olahraga berkualitas.'); ?></p>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-bold text-primary-600"><?php echo e($field->formatted_price); ?></p>
                                    <p class="text-xs text-surface-400">per jam</p>
                                </div>
                                <a href="<?php echo e(route('booking.create', $field->id)); ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary-50 text-primary-600 text-sm font-semibold hover:bg-primary-100 transition-colors">
                                    Booking
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="text-center mt-12">
                <a href="<?php echo e(route('booking.index')); ?>" class="btn-outline gap-2">
                    Lihat Semua Lapangan
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i data-lucide="map-pin-off" class="w-16 h-16 text-surface-300 mx-auto mb-4"></i>
                <p class="text-surface-500">Belum ada lapangan tersedia saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
</section>


<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 rounded-full bg-accent-100 text-accent-700 text-sm font-semibold mb-4">Cara Booking</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-surface-900 mb-4">Mudah & Cepat</h2>
            <p class="text-surface-500 max-w-xl mx-auto">Hanya 3 langkah sederhana untuk memesan lapangan favoritmu.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-linear-to-br from-primary-500 to-primary-600 flex items-center justify-center shadow-lg shadow-primary-500/25 group-hover:shadow-primary-500/40 transition-all duration-300 group-hover:-translate-y-1">
                    <i data-lucide="search" class="w-8 h-8 text-white"></i>
                </div>
                <div class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-primary-100 text-primary-700 text-sm font-bold mb-3">1</div>
                <h3 class="font-bold text-surface-900 mb-2">Pilih Lapangan</h3>
                <p class="text-sm text-surface-500">Lihat daftar lapangan yang tersedia dan pilih yang sesuai kebutuhanmu.</p>
            </div>

            
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-linear-to-br from-accent-500 to-accent-600 flex items-center justify-center shadow-lg shadow-accent-500/25 group-hover:shadow-accent-500/40 transition-all duration-300 group-hover:-translate-y-1">
                    <i data-lucide="calendar-check" class="w-8 h-8 text-white"></i>
                </div>
                <div class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-accent-100 text-accent-700 text-sm font-bold mb-3">2</div>
                <h3 class="font-bold text-surface-900 mb-2">Isi Jadwal</h3>
                <p class="text-sm text-surface-500">Tentukan tanggal, jam mulai, dan durasi bermain yang kamu inginkan.</p>
            </div>

            
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-linear-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:shadow-blue-500/40 transition-all duration-300 group-hover:-translate-y-1">
                    <i data-lucide="credit-card" class="w-8 h-8 text-white"></i>
                </div>
                <div class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-sm font-bold mb-3">3</div>
                <h3 class="font-bold text-surface-900 mb-2">Bayar & Main</h3>
                <p class="text-sm text-surface-500">Selesaikan pembayaran dan langsung datang bermain sesuai jadwal!</p>
            </div>
        </div>
    </div>
</section>


<section class="py-24 bg-gradient-hero relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-10 right-20 w-64 h-64 bg-primary-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-20 w-48 h-48 bg-accent-500/20 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">Siap Bermain?</h2>
        <p class="text-lg text-white/70 mb-10">Booking lapangan sekarang dan nikmati pengalaman bermain terbaik bersama teman-temanmu.</p>
        <a href="<?php echo e(route('booking.index')); ?>" class="btn-accent text-lg px-10 py-4 gap-2">
            <i data-lucide="zap" class="w-5 h-5"></i>
            Booking Sekarang
        </a>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DEVELOPMENTS\MOA-GITS\sistem-booking-lapangan\resources\views/welcome.blade.php ENDPATH**/ ?>