

<?php $__env->startSection('content'); ?>
<div class="card">
    <h3>Manajemen Kategori</h3>

    
    <?php if(session('success')): ?>
        <div class="alert-success" style="margin-bottom:15px;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <a href="<?php echo e(route('kategori.create')); ?>" class="btn btn-green" style="margin-bottom:15px;">
        + Tambah Kategori
    </a>

    
    <table>
        <thead>
            <tr>
                <th width="60">No</th>
                <th>Nama Kategori</th>
                <th width="220">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($k->nama); ?></td>
                <td>
                    <a href="<?php echo e(route('kategori.show', $k->id)); ?>" class="btn btn-green">Lihat</a>
                    <a href="<?php echo e(route('kategori.edit', $k->id)); ?>" class="btn btn-green">Edit</a>

                    <form action="<?php echo e(route('kategori.destroy', $k->id)); ?>"
                          method="POST"
                          style="display:inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-red"
                                onclick="return confirm('Hapus kategori ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="3" style="text-align:center;color:#64748b;">
                    Belum ada kategori
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<style>
.alert-success {
    background: #dcfce7;
    color: #166534;
    padding: 10px 14px;
    border-radius: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th {
    background: #f8fafc;
    color: #0f172a;
    text-align: left;
    font-weight: 600;
}

table th,
table td {
    padding: 12px 14px;
    border-bottom: 1px solid #e5e7eb;
}

table tr:hover {
    background: #f1f5f9;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\restoran\resources\views/kategori/index.blade.php ENDPATH**/ ?>