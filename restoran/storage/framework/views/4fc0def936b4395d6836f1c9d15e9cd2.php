

<?php $__env->startSection('content'); ?>
<div class="main-content">
    <h1 style="margin-bottom: 30px; font-weight: 800;">Status Meja</h1>
    
    <div class="menu-grid">
        <?php $__currentLoopData = $mejas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="menu-card" style="padding: 20px; text-align: center;">
            <div style="font-size: 3rem;"><?php echo e($m->status ? '✅' : '🚫'); ?></div>
            <h2 style="margin: 10px 0;">Meja <?php echo e($m->nomor_meja); ?></h2>
            <p style="color: #64748b; margin-bottom: 15px;">Kapasitas: <?php echo e($m->kapasitas); ?> Orang</p>
            
            <form action="<?php echo e(route('kasir.meja.update', $m->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-submit" style="background: <?php echo e($m->status ? '#16a34a' : '#ef4444'); ?>">
                    <?php echo e($m->status ? 'SET TIDAK TERSEDIA' : 'SET TERSEDIA'); ?>

                </button>
            </form>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('kasir.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\restoran\resources\views/kasir/meja.blade.php ENDPATH**/ ?>