

<?php $__env->startSection('content'); ?>
<div class="card kategori-card">
    <div class="card-header">
        <h3>Edit Kategori</h3>
    </div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route('kategori.update', $kategori->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama" value="<?php echo e($kategori->nama); ?>" required>
            </div>

            <div class="form-action">
                <a href="<?php echo e(route('kategori.index')); ?>" class="btn btn-red">Batal</a>
                <button class="btn btn-green">Update</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\restoran\resources\views/kategori/edit.blade.php ENDPATH**/ ?>