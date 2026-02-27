<style>
    .sidebar-cart {
        width: 350px;
        background: white;
        border-left: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        padding: 20px;
        box-shadow: -4px 0 6px -1px rgba(0,0,0,0.05);
    }
    .checkout-section {
        border-top: 2px solid #f1f5f9;
        padding-top: 15px;
        margin-top: auto;
    }
    .cart-title {
        font-size: 1.2rem;
        font-weight: 800;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

<div class="sidebar-cart">
    <h2 class="cart-title">PESANAN 🛒</h2>
    
    <div id="cart-items-container" style="flex: 1; overflow-y: auto;">
        <p style="color: #94a3b8; text-align: center; margin-top: 20px;">Keranjang kosong</p>
    </div>

    <form action="<?php echo e(route('transaksi.store')); ?>" method="POST" class="checkout-section">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="cart_data" id="cart_data_input">
        
        <div style="margin-bottom: 12px;">
            <label class="modal-label">Nama Pelanggan</label>
            <input type="text" name="nama_konsumen" placeholder="Masukkan nama..." required>
        </div>

        <div style="margin-bottom: 12px;">
            <label class="modal-label">Pilih Meja</label>
            <select name="id_meja" required>
                <option value="">-- Klik untuk Pilih --</option>
                <?php $__currentLoopData = $mejas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($meja->id); ?>">
                        Meja <?php echo e($meja->nomor_meja); ?> (<?php echo e($meja->kapasitas); ?> Kursi)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin: 15px 0; padding: 10px 0; border-top: 1px dashed #e2e8f0;">
            <span style="font-weight: 600; color: #64748b;">Total Bayar</span>
            <span id="total-price-display" style="font-size: 1.2rem; font-weight: 800; color: #16a34a;">Rp 0</span>
        </div>

        <button type="submit" class="btn-block bg-green" style="box-shadow: 0 4px 6px -1px rgba(22, 163, 74, 0.3);">
            PROSES TRANSAKSI
        </button>
    </form>
</div><?php /**PATH C:\xampp\htdocs\restoran\resources\views/kasir/keranjang.blade.php ENDPATH**/ ?>