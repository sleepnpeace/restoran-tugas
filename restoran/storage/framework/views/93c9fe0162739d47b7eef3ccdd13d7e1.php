

<?php $__env->startSection('content'); ?>
<div class="card kategori-card">
    <div class="card-header">
        <h3>Tambah Kategori</h3>
    </div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route('kategori.store')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="form-group">
                <label>Nama Kategori</label>
                <input 
                    type="text" 
                    name="nama" 
                    placeholder="Contoh: Makanan Berat" 
                    value="<?php echo e(old('nama')); ?>"
                    required 
                    autofocus
                >
                
                <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small style="color: #ef4444; margin-top: 5px;"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-action">
                <a href="<?php echo e(route('kategori.index')); ?>" class="btn btn-red">Batal</a>
                <button type="submit" class="btn btn-green">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Card Style (Adaptasi dari Menu Card) */
.kategori-card {
    max-width: 600px; /* Lebih kecil karena isiannya sedikit */
    margin: auto;
    border-radius: 12px;
    background-color: #fff;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); /* Tambahan shadow halus */
}

.card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.card-header h3 {
    margin: 0;
    color: #166534;
    font-weight: 700;
}

.card-body {
    padding: 20px;
}

/* Form Layout */
.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 18px;
}

/* Label */
label {
    font-size: 13px;
    font-weight: 600;
    color: #166534;
    margin-bottom: 6px;
}

/* Input */
input {
    padding: 11px 12px;
    border-radius: 8px;
    border: 1px solid #bbf7d0;
    font-size: 14px;
    transition: .25s;
    width: 100%; /* Full width */
    box-sizing: border-box; /* Agar padding tidak merusak lebar */
}

input:focus {
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34,197,94,.2);
    outline: none;
}

/* Action Button */
.form-action {
    margin-top: 24px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* Button Classes (Jika belum ada di layout utama) */
.btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: 0.2s;
}

.btn-green {
    background-color: #16a34a;
    color: white;
}
.btn-green:hover { background-color: #15803d; }

.btn-red {
    background-color: white;
    color: #ef4444;
    border: 1px solid #ef4444;
}
.btn-red:hover { background-color: #fef2f2; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\restoran\resources\views/kategori/create.blade.php ENDPATH**/ ?>