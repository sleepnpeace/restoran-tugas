

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Detail Kategori</h3>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <p><strong>ID Kategori:</strong> <?php echo e($kategori->id); ?></p>
                <p><strong>Nama Kategori:</strong> <?php echo e($kategori->nama); ?></p>
                <p><strong>Total Menu Terkait:</strong> <?php echo e($kategori->menu->count()); ?> Item</p>
                <p><strong>Tanggal Dibuat:</strong> <?php echo e($kategori->created_at->format('d/m/Y H:i')); ?></p>
            </div>

            <hr>

            <div class="form-action">
                <a href="<?php echo e(route('kategori.index')); ?>" class="btn btn-green">Kembali</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\restoran\resources\views/kategori/show.blade.php ENDPATH**/ ?>