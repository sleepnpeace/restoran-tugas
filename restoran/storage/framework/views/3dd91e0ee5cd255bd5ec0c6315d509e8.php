

<?php $__env->startSection('content'); ?>
<div class="card">
    <h3>Dashboard Admin</h3>
    <p>Selamat datang, <?php echo e(auth()->user()->username); ?></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\restoran\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>