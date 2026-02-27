<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu Kulkaltim</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/menu-style.css')); ?>">
</head>

<body>

    <div class="container">
        <h1 class="page-title">Aneka Menu Lezat 🍽️</h1>

        <div class="menu-grid">
            <?php $__empty_1 = true; $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="menu-card">

                    <div class="card-image">
                        
                        <img src="<?php echo e($m->gambar ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80'); ?>"
                            alt="<?php echo e($m->nama); ?>">

                        <div class="badge-container">
                            <span class="badge badge-category">
                                <?php echo e($m->kategori->nama ?? 'Menu'); ?>

                            </span>

                            <?php if($m->status == 0): ?>
                                <span class="badge badge-status empty">Non-Aktif</span>
                            <?php elseif($m->stok == 0): ?>
                                <span class="badge badge-status empty">Habis</span>
                            <?php else: ?>
                                <span class="badge badge-status ready">Stok: <?php echo e($m->stok); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card-content">
                        <h3 class="menu-name"><?php echo e($m->nama); ?></h3>

                        <p class="menu-desc">
                            <?php echo e($m->deskripsi ?? 'Belum ada deskripsi untuk menu ini. Silakan hubungi admin untuk detail lebih lanjut.'); ?>

                        </p>

                        <div class="card-footer">
                            <span class="price-tag">Rp <?php echo e(number_format($m->harga, 0, ',', '.')); ?></span>

                            
                            <?php if($m->status == 1 && $m->stok > 0): ?>
                                <a href="#" class="btn-order">Pesan</a>
                            <?php else: ?>
                                <span class="btn-order disabled">Unavailable</span>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #64748b;">
                    <h3>Belum ada data menu.</h3>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>

</html><?php /**PATH C:\xampp\htdocs\restoran\resources\views/guest/dashboard.blade.php ENDPATH**/ ?>