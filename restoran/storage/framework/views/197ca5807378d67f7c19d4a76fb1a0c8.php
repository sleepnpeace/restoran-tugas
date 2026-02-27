<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Kulkaltim - POS</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/kasir-style.css')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

    <div class="main-content">
        <h1 style="margin-bottom: 30px; color: #166534; font-weight: 800; letter-spacing: -1px;">KULKALTIM POS 🍽️</h1>

        <?php $__currentLoopData = $menu->groupBy('kategori.nama'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $namaKategori => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="category-section">
                <h2 class="category-name"><?php echo e($namaKategori); ?></h2>
                <div class="menu-grid">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="menu-card">
                            <div class="card-image" onclick="showDetail('<?php echo e($m->id); ?>')">
                                <img src="<?php echo e($m->gambar ?? 'https://via.placeholder.com/300'); ?>" alt="<?php echo e($m->nama); ?>">
                                <div class="stock-badge">Stok: <?php echo e($m->stok ?? '∞'); ?></div>
                            </div>
                            <div class="card-content">
                                <p class="menu-name"><?php echo e($m->nama); ?></p>
                                <p class="price-tag">Rp <?php echo e(number_format($m->harga, 0, ',', '.')); ?></p>

                                <div class="action-group">
                                    <button class="btn-info-detail"
                                        style="flex:1; padding:10px; border-radius:10px; border:none; background:#f1f5f9; font-weight:700; cursor:pointer; font-size:12px;"
                                        onclick="showDetail('<?php echo e($m->id); ?>')">DETAIL</button>
                                    <button class="btn-order"
                                        style="flex:2; padding:10px; border-radius:10px; border:none; background:#16a34a; color:white; font-weight:700; cursor:pointer; font-size:12px;"
                                        onclick="openModal('<?php echo e($m->id); ?>', '<?php echo e($m->nama); ?>', '<?php echo e($m->harga); ?>')">PESAN</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <button class="cart-toggle-btn" onclick="toggleCart()">
        🛒 <div id="cart-count"
            style="position:absolute; top:0; right:0; background:#ef4444; color:white; width:24px; height:24px; border-radius:50%; font-size:12px; font-weight:800; display:flex; align-items:center; justify-content:center; border:2px solid white;">
            0</div>
    </button>

    <div class="sidebar-cart" id="sidebar-cart">
        <div style="display: flex; justify-content: flex-start; margin-bottom: 20px;">
            <button onclick="toggleCart()"
                style="background: none; border: none; color: #94a3b8; font-weight: 800; cursor: pointer; font-size: 13px; padding: 0; letter-spacing: 0.5px;">✕
                TUTUP</button>
        </div>

        <h2 style="color:#16a34a; margin-bottom:20px; font-weight: 800; font-size: 1.5rem;">Pesanan Baru 🛒</h2>

        <div id="cart-items-container" style="flex:1; overflow-y:auto;"></div>

        <form action="<?php echo e(route('transaksi.store')); ?>" method="POST" style="margin-top: 20px;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="cart_data" id="cart_data_input">

            <label class="label-form">Nama Pelanggan</label>
            <input type="text" name="nama_konsumen" placeholder="Ketik nama tamu..." required class="input-minimal">

            <label class="label-form">Pilih Nomor Meja</label>
            <select name="id_meja" required class="input-minimal">
                <option value="" disabled selected>Pilih Meja...</option>
                <?php $__currentLoopData = $mejas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($meja->id); ?>">Meja <?php echo e($meja->nomor_meja); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <div style="display:flex; justify-content:space-between; margin:15px 0; font-weight:800; font-size:1.2rem;">
                <span style="color: #64748b;">Total</span>
                <span id="total-price-display" style="color:#16a34a;">Rp 0</span>
            </div>
            <button type="submit" class="btn-submit">SIMPAN & CETAK</button>
        </form>
    </div>

    <div id="orderModal" class="modal">
        <div class="modal-content-small">
            <h3 id="modal-title" style="font-weight:800; font-size:1.6rem; color:#1e293b; margin-bottom: 5px;"></h3>
            <p id="modal-price" style="color:#16a34a; font-weight:800; font-size: 1.2rem; margin-bottom: 25px;"></p>

            <div
                style="display:flex; align-items:center; justify-content:center; gap:30px; margin-bottom:25px; background: #f8fafc; padding: 15px; border-radius: 20px;">
                <button onclick="changeQty(-1)" class="btn-qty">-</button>
                <span id="modal-qty" style="font-size:2rem; font-weight:800; color: #1e293b; min-width: 40px;">1</span>
                <button onclick="changeQty(1)" class="btn-qty">+</button>
            </div>

            <div style="text-align: left;">
                <label class="label-form">Metode Penyajian</label>
                <select id="modal-metode" class="input-minimal">
                    <option value="Dine In">Dine In (Makan Sini)</option>
                    <option value="Takeaway">Takeaway (Bungkus)</option>
                </select>

                <label class="label-form">Catatan Tambahan</label>
                <input type="text" id="modal-catatan" placeholder="Contoh: Tanpa pedas..." class="input-minimal">
            </div>

            <button class="btn-submit" onclick="addToCart()">TAMBAH KE KERANJANG</button>
            <button onclick="closeModal()"
                style="width:100%; margin-top:15px; background:none; border:none; color:#94a3b8; font-weight:600; cursor:pointer;">Batal</button>
        </div>
    </div>

    <script>
        let cart = [];
        let currentItem = null;

        function toggleCart() { document.getElementById('sidebar-cart').classList.toggle('active'); }
        function closeModal() { document.getElementById('orderModal').style.display = 'none'; }

        function openModal(id, nama, harga) {
            currentItem = { id, nama, harga, qty: 1 };
            document.getElementById('modal-title').innerText = nama;
            document.getElementById('modal-price').innerText = 'Rp ' + parseInt(harga).toLocaleString('id-ID');
            document.getElementById('modal-qty').innerText = 1;
            document.getElementById('modal-catatan').value = '';
            document.getElementById('orderModal').style.display = 'flex';
        }

        function changeQty(v) {
            currentItem.qty = Math.max(1, currentItem.qty + v);
            document.getElementById('modal-qty').innerText = currentItem.qty;
        }

        function addToCart() {
            cart.push({
                id_menu: currentItem.id,
                nama: currentItem.nama,
                harga: currentItem.harga,
                jumlah: currentItem.qty,
                metode: document.getElementById('modal-metode').value,
                catatan: document.getElementById('modal-catatan').value,
                subtotal: currentItem.harga * currentItem.qty
            });
            renderCart();
            closeModal();
            document.getElementById('sidebar-cart').classList.add('active');
        }

        function renderCart() {
            const container = document.getElementById('cart-items-container');
            container.innerHTML = '';
            let total = 0;
            cart.forEach((item, index) => {
                total += item.subtotal;
                container.innerHTML += `
                    <div style="background:#ffffff; padding:15px; border-radius:15px; margin-bottom:12px; border: 1px solid #e2e8f0; position:relative;">
                       <span style="position:absolute; top:12px; right:12px; font-size:10px; font-weight:800; padding:3px 8px; border-radius:5px; 
                            background:${item.metode === 'Takeaway' ? '#fff7ed' : '#f0fdf4'}; 
                            color:${item.metode === 'Takeaway' ? '#ea580c' : '#16a34a'}; 
                            border: 1px solid currentColor;">
                            ${item.metode.toUpperCase()}
                        </span>
                        <div>
                            <b style="color:#1e293b; font-size:14px;">${item.nama}</b><br>
                            <small style="color:#64748b;">${item.jumlah}x @ Rp ${parseInt(item.harga).toLocaleString('id-ID')}</small>
                            ${item.catatan ? `<br><small style="color:#16a34a; font-style:italic;">"${item.catatan}"</small>` : ''}
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; padding-top:10px; border-top: 1px dashed #e2e8f0;">
                            <b style="color:#1e293b; font-size:14px;">Rp ${item.subtotal.toLocaleString('id-ID')}</b>
                            <button onclick="removeItem(${index})" style="color:#ef4444; border:none; background:none; cursor:pointer; font-size:11px; font-weight:700;">HAPUS</button>
                        </div>
                    </div>`;
            });
            document.getElementById('total-price-display').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('cart-count').innerText = cart.length;
            document.getElementById('cart_data_input').value = JSON.stringify(cart);
        }

        function removeItem(index) { cart.splice(index, 1); renderCart(); }
    </script>
</body>

</html><?php /**PATH C:\xampp\htdocs\restoran\resources\views/kasir/dashboard.blade.php ENDPATH**/ ?>