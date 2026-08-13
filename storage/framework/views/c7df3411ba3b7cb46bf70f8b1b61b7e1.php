<?php $__env->startSection('title', 'Kelola Lapangan'); ?>
<?php $__env->startSection('page_title', 'Kelola Lapangan'); ?>
<?php $__env->startSection('page_subtitle', 'Tambah, edit, dan hapus lapangan'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="<?php echo e(route('admin.lapangan.create')); ?>" class="btn-primary py-2.5 px-5 text-sm gap-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Lapangan
    </a>
</div>

<div class="card-admin rounded-2xl animate-fade-in-up">
    <div class="overflow-x-auto">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Harga/Jam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="w-16 h-12 rounded-lg overflow-hidden bg-surface-100">
                                <?php if($field->photo): ?>
                                    <img src="<?php echo e(asset('fields/' . $field->photo)); ?>" alt="<?php echo e($field->name); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="flex items-center justify-center h-full">
                                        <i data-lucide="image" class="w-5 h-5 text-surface-300"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <p class="font-semibold text-surface-900"><?php echo e($field->name); ?></p>
                            <p class="text-xs text-surface-400 line-clamp-1"><?php echo e($field->description ?? '-'); ?></p>
                        </td>
                        <td>
                            <?php if($field->type): ?>
                                <span class="text-sm font-medium text-primary-600 capitalize"><?php echo e(str_replace('_', ' ', $field->type)); ?></span>
                            <?php else: ?>
                                <span class="text-sm text-surface-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="font-semibold text-primary-600"><?php echo e($field->formatted_price); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($field->status); ?>"><?php echo e(ucfirst($field->status)); ?></span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.lapangan.edit', $field->id)); ?>" class="p-2 rounded-lg text-surface-500 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.lapangan.destroy', $field->id)); ?>" onsubmit="return confirm('Yakin ingin menghapus lapangan ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 rounded-lg text-surface-500 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-8 text-surface-400">Belum ada lapangan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($fields->hasPages()): ?>
        <div class="px-6 py-4 border-t border-surface-100">
            <?php echo e($fields->links()); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DEVELOPMENTS\MOA-GITS\sistem-booking-lapangan\resources\views/admin/lapangan/index.blade.php ENDPATH**/ ?>