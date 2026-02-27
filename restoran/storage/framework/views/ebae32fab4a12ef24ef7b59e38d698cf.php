

<?php $__env->startSection('content'); ?>
<div class="card menu-card">
    <div class="card-header">
        <h3>Tambah Meja Baru</h3>
    </div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route('meja.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-grid">
                
                <div class="form-group">
                    <label>Nomor Meja</label>
                    <input type="text" name="nomor_meja" placeholder="Contoh: A01" value="<?php echo e(old('nomor_meja')); ?>" required>
                    <?php $__errorArgs = ['nomor_meja'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="form-group">
                    <label>Kapasitas (Orang)</label>
                    <input type="number" name="kapasitas" placeholder="Contoh: 4" value="<?php echo e(old('kapasitas')); ?>" required>
                    <?php $__errorArgs = ['kapasitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            
            <div class="form-group">
                <label>Status Awal</label>
                <select name="status" required>
                    <option value="1" <?php echo e(old('status') == '1' ? 'selected' : ''); ?>>Tersedia (Aktif)</option>
                    <option value="0" <?php echo e(old('status') == '0' ? 'selected' : ''); ?>>Tidak Tersedia (Nonaktif)</option>
                </select>
            </div>

            <div class="form-action">
                <a href="<?php echo e(route('meja.index')); ?>" class="btn btn-red">Batal</a>
                <button type="submit" class="btn btn-green">Simpan Meja</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Style Identik dengan Menu */
.menu-card { max-width: 900px; margin: auto; border-radius: 12px; }
.card-header { padding: 16px 20px; border-bottom: 1px solid #e5e7eb; }
.card-header h3 { margin: 0; color: #166534; }
.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; margin-bottom: 18px; }
.form-group { display: flex; flex-direction: column; margin-bottom: 15px; }
label { font-size: 13px; font-weight: 600; color: #166534; margin-bottom: 6px; }
input, select { padding: 11px 12px; border-radius: 8px; border: 1px solid #bbf7d0; font-size: 14px; transition: .25s; }
input:focus, select:focus { border-color: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,.2); outline: none; }
.form-action { margin-top: 24px; display: flex; justify-content: flex-end; gap: 10px; }
.text-danger { color: #ef4444; font-size: 12px; margin-top: 4px; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\restoran\resources\views/meja/create.blade.php ENDPATH**/ ?>