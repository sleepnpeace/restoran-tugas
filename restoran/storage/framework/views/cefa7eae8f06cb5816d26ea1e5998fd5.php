<!DOCTYPE html>
<html>
<head>
    <title>Karyawan Dashboard</title>
</head>
<body>
    <h2>Welcome Karyawan <?php echo e(session('nama')); ?></h2>
    <form action="<?php echo e(route('logout')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit">Logout</button>
    </form>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\restoran\resources\views/karyawan/index.blade.php ENDPATH**/ ?>