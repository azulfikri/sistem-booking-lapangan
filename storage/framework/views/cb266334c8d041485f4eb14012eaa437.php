<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> — Admin Sports Center</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-surface-100 text-surface-900 antialiased">

    <div class="flex min-h-screen">

        
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-sidebar transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-out lg:static lg:inset-auto">
            <div class="flex flex-col h-full">
                
                <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
                    <div class="w-10 h-10 bg-gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25">
                        <i data-lucide="trophy" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <span class="text-lg font-bold text-white tracking-tight">Sports<span class="text-primary-300">Center</span></span>
                        <p class="text-xs text-surface-400">Admin Panel</p>
                    </div>
                </div>

                
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <p class="px-4 mb-3 text-xs font-semibold uppercase tracking-wider text-surface-500">Menu Utama</p>

                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="<?php echo e(route('admin.lapangan')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.lapangan*') ? 'active' : ''); ?>">
                        <i data-lucide="map" class="w-5 h-5"></i>
                        <span>Lapangan</span>
                    </a>

                    <a href="<?php echo e(route('admin.bookings')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.bookings*') ? 'active' : ''); ?>">
                        <i data-lucide="calendar-check" class="w-5 h-5"></i>
                        <span>Booking</span>
                    </a>

                    <p class="px-4 mt-6 mb-3 text-xs font-semibold uppercase tracking-wider text-surface-500">Pengaturan</p>

                    <a href="<?php echo e(route('admin.users')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span>Admin Users</span>
                    </a>

                    <a href="<?php echo e(route('home')); ?>" class="sidebar-link" target="_blank">
                        <i data-lucide="external-link" class="w-5 h-5"></i>
                        <span>Lihat Website</span>
                    </a>
                </nav>

                
                <div class="px-4 py-4 border-t border-white/10">
                    <div class="flex items-center gap-3 px-4 py-3">
                        <div class="w-9 h-9 bg-primary-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            <?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?>

                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
                            <p class="text-xs text-surface-400 truncate"><?php echo e(auth()->user()->email ?? ''); ?></p>
                        </div>
                    </div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-2">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="sidebar-link w-full text-red-400 hover:text-red-300 hover:bg-red-500/10">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        
        <div id="sidebar-overlay" class="hidden fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden"></div>

        
        <div class="flex-1 flex flex-col min-w-0">
            
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-surface-200">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-4">
                        
                        <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 transition-colors">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <div>
                            <h1 class="text-lg font-bold text-surface-900"><?php echo $__env->yieldContent('page_title', 'Dashboard'); ?></h1>
                            <?php if (! empty(trim($__env->yieldContent('page_subtitle')))): ?>
                                <p class="text-sm text-surface-500"><?php echo $__env->yieldContent('page_subtitle'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="hidden sm:inline text-sm text-surface-500"><?php echo e(now()->isoFormat('dddd, D MMMM YYYY')); ?></span>
                    </div>
                </div>
            </header>

            
            <?php if(session('success') || session('error') || session('warning')): ?>
                <div class="px-4 sm:px-6 lg:px-8 pt-4 space-y-2">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success" data-auto-dismiss="5000">
                            <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                            <span><?php echo e(session('success')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-error" data-auto-dismiss="7000">
                            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                            <span><?php echo e(session('error')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if(session('warning')): ?>
                        <div class="alert alert-warning" data-auto-dismiss="6000">
                            <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0"></i>
                            <span><?php echo e(session('warning')); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            
            <div class="flex-1 p-4 sm:p-6 lg:p-8">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\DEVELOPMENTS\MOA-GITS\sistem-booking-lapangan\resources\views/layouts/admin.blade.php ENDPATH**/ ?>