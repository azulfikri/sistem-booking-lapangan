<?php $__env->startSection('title', 'Kelola Admin'); ?>
<?php $__env->startSection('page_title', 'Kelola Admin'); ?>
<?php $__env->startSection('page_subtitle', 'Tambah dan kelola akun admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn-primary py-2.5 px-5 text-sm gap-2">
        <i data-lucide="user-plus" class="w-4 h-4"></i>
        Tambah Admin
    </a>
</div>

<div class="card-admin rounded-2xl animate-fade-in-up">
    <div class="overflow-x-auto">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-primary-100 rounded-full flex items-center justify-center text-primary-700 text-sm font-bold shrink-0">
                                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                </div>
                                <span class="font-medium text-surface-900"><?php echo e($user->name); ?></span>
                            </div>
                        </td>
                        <td class="text-sm"><?php echo e($user->email); ?></td>
                        <td class="text-sm"><?php echo e($user->phone ?? '-'); ?></td>
                        <td><span class="badge badge-confirmed"><?php echo e(ucfirst($user->role)); ?></span></td>
                        <td class="text-sm text-surface-400"><?php echo e($user->created_at->format('d M Y')); ?></td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="p-2 rounded-lg text-surface-500 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <?php if($user->id !== auth()->id()): ?>
                                    <form method="POST" action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="p-2 rounded-lg text-surface-500 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-8 text-surface-400">Belum ada admin.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($users->hasPages()): ?>
        <div class="px-6 py-4 border-t border-surface-100">
            <?php echo e($users->links()); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DEVELOPMENTS\MOA-GITS\sistem-booking-lapangan\resources\views/admin/users/index.blade.php ENDPATH**/ ?>