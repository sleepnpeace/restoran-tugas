<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Kulkaltim</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .register-card {
            background: white;
            width: 800px;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(22, 163, 74, 0.1);
        }

        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #14532d; font-size: 24px; font-weight: 800; }
        .header p { color: #64748b; font-size: 14px; margin-top: 5px; }

        /* GRID LAYOUT UTAMA */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .full-width { grid-column: 1 / -1; }

        .input-group { display: flex; flex-direction: column; gap: 8px; }
        .input-label { font-size: 13px; font-weight: 600; color: #374151; }

        input, select, textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: .2s;
            background: #fff;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
        }

        .section-title {
            grid-column: 1 / -1;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #16a34a;
            font-weight: 700;
            margin-top: 10px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        .btn-submit {
            grid-column: 1 / -1;
            padding: 14px;
            background: #16a34a;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: .3s;
            margin-top: 15px;
        }
        .btn-submit:hover { background: #15803d; transform: translateY(-2px); }

        .footer { margin-top: 20px; text-align: center; font-size: 14px; color: #64748b; }
        .footer a { color: #16a34a; font-weight: 600; text-decoration: none; }

        .error-msg { font-size: 12px; color: #dc2626; margin-top: 4px; }

        @media (max-width: 640px) {
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="header">
        <h1>Registrasi Karyawan 🌱</h1>
        <p>Lengkapi data diri dan akun untuk bergabung.</p>
    </div>

    <form method="POST" action="/register">
        <?php echo csrf_field(); ?>
        
        <div class="form-grid">
            <div class="section-title">Data Pribadi</div>

            <div class="input-group">
                <label class="input-label">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Cth: Budi Santoso" value="<?php echo e(old('nama')); ?>" required>
                <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-msg"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="input-group">
                <label class="input-label">Jenis Kelamin</label>
                <select name="jenkel" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" <?php echo e(old('jenkel') == 'L' ? 'selected' : ''); ?>>Laki-laki</option>
                    <option value="P" <?php echo e(old('jenkel') == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                </select>
                <?php $__errorArgs = ['jenkel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-msg"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="input-group">
                <label class="input-label">No. Telepon</label>
                <input type="text" name="notelp" placeholder="0812..." value="<?php echo e(old('notelp')); ?>" required>
                <?php $__errorArgs = ['notelp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-msg"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="input-group">
                <label class="input-label">Alamat</label>
                <input type="text" name="alamat" placeholder="Jl. Mulawarman No. 10" value="<?php echo e(old('alamat')); ?>" required>
            </div>

            <div class="section-title" style="margin-top: 20px;">Data Akun</div>

            <div class="input-group">
                <label class="input-label">Username</label>
                <input type="text" name="username" placeholder="Username unik" value="<?php echo e(old('username')); ?>" required>
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-msg"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="input-group">
                <label class="input-label">Role Akses</label>
                <select name="role" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="manager" <?php echo e(old('role') == 'manager' ? 'selected' : ''); ?>>Manager</option>
                    <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                    <option value="kasir" <?php echo e(old('role') == 'kasir' ? 'selected' : ''); ?>>Kasir</option>
                </select>
                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-msg"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="input-group full-width">
                <label class="input-label">Email</label>
                <input type="email" name="email" placeholder="email@contoh.com" value="<?php echo e(old('email')); ?>" required>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-msg"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="input-group">
                <label class="input-label">Password</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-msg"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="input-group">
                <label class="input-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn-submit">Daftar Sekarang</button>
        </div>
    </form>

    <div class="footer">
        Sudah memiliki akun? <a href="/login">Masuk disini</a>
    </div>
</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\restoran\resources\views/auth/register.blade.php ENDPATH**/ ?>