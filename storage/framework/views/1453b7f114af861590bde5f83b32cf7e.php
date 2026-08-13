<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>

<section class="min-h-screen flex items-center justify-center bg-gradient-hero relative overflow-hidden py-20">
    
    <div class="absolute top-20 left-10 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-20 right-10 w-64 h-64 bg-accent-500/15 rounded-full blur-3xl animate-float delay-500"></div>

    <div class="relative w-full max-w-md mx-auto px-4">
        <div class="glass-card rounded-3xl p-8 sm:p-10 animate-scale-in">
            
            <div class="text-center mb-8">
                <div class="w-14 h-14 mx-auto bg-gradient-primary rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/25 mb-4">
                    <i data-lucide="trophy" class="w-7 h-7 text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-surface-900">Selamat Datang</h1>
                <p class="text-sm text-surface-500 mt-1">Masuk ke akun Anda</p>
            </div>

            
            <form method="POST" action="<?php echo e(route('login.post')); ?>">
                <?php echo csrf_field(); ?>

                <div class="space-y-5">
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="w-4 h-4 text-surface-400"></i>
                            </div>
                            <input type="email" name="email" id="email" class="form-input pl-11" placeholder="admin@email.com" value="<?php echo e(old('email')); ?>" required autofocus>
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="password" class="form-label">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="w-4 h-4 text-surface-400"></i>
                            </div>
                            <input type="password" name="password" id="password" class="form-input pl-11" placeholder="••••••••" required>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-surface-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-surface-600">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary w-full py-3.5 gap-2">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        Masuk
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="<?php echo e(route('home')); ?>" class="text-sm text-surface-500 hover:text-primary-600 transition-colors inline-flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-3 h-3"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DEVELOPMENTS\MOA-GITS\sistem-booking-lapangan\resources\views/auth/login.blade.php ENDPATH**/ ?>