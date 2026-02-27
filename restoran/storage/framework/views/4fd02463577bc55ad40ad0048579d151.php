

<?php $__env->startSection('content'); ?>
<div class="card">
    <h3>Detail Menu</h3>

    <p><b>Nama:</b> <?php echo e($menu->nama); ?></p>
    <p><b>Kategori:</b> <?php echo e($menu->kategori->nama); ?></p>
    <p><b>Harga:</b> Rp <?php echo e(number_format($menu->harga,0,',','.')); ?></p>
    <p><b>Stok:</b> <?php echo e($menu->stok); ?></p>
    <p><b>Status:</b> <?php echo e($menu->status ? 'Aktif' : 'Nonaktif'); ?></p>
    <p><b>Deskripsi:</b> <?php echo e($menu->deskripsi); ?></p>

    <a href="<?php echo e(route('menu.index')); ?>" class="btn btn-green">Kembali</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\restoran\resources\views/menu/show.blade.php ENDPATH**/ ?>