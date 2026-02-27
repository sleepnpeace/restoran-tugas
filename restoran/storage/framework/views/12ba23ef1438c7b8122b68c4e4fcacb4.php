

<?php $__env->startSection('content'); ?>
<div class="main-content" style="padding: 20px;">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
        <a href="<?php echo e(route('users.index')); ?>" style="color: #64748b; text-decoration: none; font-size: 20px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 style="margin: 0; font-weight: 800;">Tambah User Baru</h1>
    </div>

    <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); max-width: 800px;">
        <form action="<?php echo e(route('users.store')); ?>" method="POST" style="padding: 30px;">
            <?php echo csrf_field(); ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155;">Username</label>
                    <input type="text" name="username" required placeholder="Contoh: budi_admin"
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; transition: 0.3s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155;">Email Address</label>
                    <input type="email" name="email" required placeholder="email@perusahaan.com"
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; transition: 0.3s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155;">Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; transition: 0.3s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155;">Hubungkan Karyawan</label>
                    <select name="id_karyawan" required 
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; background: white; outline: none;">
                        <option value="">-- Pilih Karyawan --</option>
                        <?php $__currentLoopData = $karyawans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>"><?php echo e($k->nama); ?> (<?php echo e($k->jabatan); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155;">Hak Akses (Role)</label>
                    <select name="role" required 
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; background: white; outline: none;">
                        <option value="kasir">Kasir</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155;">Status Akun</label>
                    <div style="display: flex; gap: 15px; padding: 10px 0;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="status" value="1" checked style="accent-color: #16a34a; width: 18px; height: 18px;"> 
                            <span style="font-weight: 600; color: #16a34a;">Aktif</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="status" value="0" style="accent-color: #ef4444; width: 18px; height: 18px;"> 
                            <span style="font-weight: 600; color: #ef4444;">Non-Aktif</span>
                        </label>
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid #f1f5f9; padding-top: 25px; display: flex; justify-content: flex-end; gap: 12px;">
                <a href="<?php echo e(route('users.index')); ?>" 
                   style="background: #f1f5f9; color: #64748b; text-decoration: none; padding: 12px 25px; border-radius: 10px; font-weight: 700; transition: 0.3s;">
                    BATAL
                </a>
                <button type="submit" 
                        style="background: #16a34a; color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 800; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);">
                    SIMPAN USER
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('manager.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\restoran\resources\views/users/create.blade.php ENDPATH**/ ?>