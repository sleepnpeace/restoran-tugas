

<?php $__env->startSection('content'); ?>
<div class="card">
    <h3>Manajemen Menu</h3>

    <a href="<?php echo e(route('menu.create')); ?>" class="btn btn-green" style="margin-bottom:15px;">
        + Tambah Menu
    </a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($m->nama); ?></td>
                <td><?php echo e($m->kategori->nama); ?></td>
                <td>Rp <?php echo e(number_format($m->harga,0,',','.')); ?></td>
                <td><?php echo e($m->stok); ?></td>
                <td>
                    <?php if($m->status): ?>
                        <span style="color:#16a34a;font-weight:bold">Aktif</span>
                    <?php else: ?>
                        <span style="color:#dc2626;font-weight:bold">Nonaktif</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo e(route('menu.show',$m->id)); ?>" class="btn btn-green">Lihat</a>
                    <a href="<?php echo e(route('menu.edit',$m->id)); ?>" class="btn btn-green">Edit</a>

                    <form action="<?php echo e(route('menu.destroy',$m->id)); ?>"
                          method="POST"
                          style="display:inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-red"
                                onclick="return confirm('Hapus menu ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align:center;">
                    <span style="color:#64748b;">
                        Belum ada data menu
                    </span>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\restoran\resources\views/menu/index.blade.php ENDPATH**/ ?>