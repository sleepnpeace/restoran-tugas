<template>
  <div class="scroll-wrapper">
    <div class="main-content">
      <div v-if="loading" style="text-align:center; padding: 100px;">
        <p style="color: #64748b; font-weight: 600;">Memuat Menu...</p>
      </div>

      <div v-else v-for="(items, kategoriName) in groupedMenu" :key="kategoriName" class="category-section">
        <h2 class="category-name">{{ kategoriName }}</h2>
        
        <div class="menu-grid">
          <div v-for="m in items" :key="m.id" class="menu-card">
            <div class="card-image" @click="openOrderModal(m)">
              <img :src="m.gambar || 'https://via.placeholder.com/300'" :alt="m.nama">
              <div class="stock-badge">Stok: {{ m.stok ?? '∞' }}</div>
            </div>
            
            <div class="card-content">
              <p class="menu-name">{{ m.nama }}</p>
              <p class="price-tag">{{ formatRupiah(m.harga) }}</p>
              
              <div class="action-group">
                <button class="btn-info-detail" @click="showDetail(m.id)">DETAIL</button>
                <button class="btn-order" @click="openOrderModal(m)">PESAN</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom-spacer"></div>
    </div>

    <button class="cart-toggle-btn" @click="isCartOpen = !isCartOpen">
      🛒 <div class="cart-badge">{{ cart.length }}</div>
    </button>

    <div :class="['sidebar-cart', { active: isCartOpen }]">
      <button @click="isCartOpen = false" style="background:none; border:none; color:#94a3b8; font-weight:800; cursor:pointer; margin-bottom:20px; text-align:left;">✕ TUTUP</button>
      <h2 style="color:#16a34a; margin-bottom:20px; font-weight: 800; font-size: 1.5rem;">Pesanan 🛒</h2>

      <div class="cart-items-container hide-scrollbar" style="flex:1; overflow-y:auto;">
        <div v-for="(item, index) in cart" :key="index" style="background:#ffffff; padding:15px; border-radius:15px; margin-bottom:12px; border: 1px solid #e2e8f0; position:relative;">
          <span style="position:absolute; top:12px; right:12px; font-size:10px; font-weight:800; padding:3px 8px; border-radius:5px; background:#f0fdf4; color:#16a34a; border: 1px solid #16a34a;">{{ item.metode.toUpperCase() }}</span>
          <b style="color:#1e293b; font-size:14px;">{{ item.nama }}</b><br>
          <small v-if="item.catatan" style="color:#64748b; font-style:italic;">"{{ item.catatan }}"</small><br v-if="item.catatan">
          <small style="color:#64748b;">{{ item.jumlah }}x @ {{ formatRupiah(item.harga) }}</small>
          <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; border-top: 1px dashed #e2e8f0; padding-top:10px;">
            <b style="color:#1e293b;">{{ formatRupiah(item.subtotal) }}</b>
            <button @click="removeItem(index)" style="color:#ef4444; border:none; background:none; cursor:pointer; font-weight:700; font-size:11px;">HAPUS</button>
          </div>
        </div>
      </div>

      <div class="cart-form" style="margin-top:20px">
        <label class="label-form">Nama Pelanggan</label>
        <input type="text" v-model="orderForm.nama" placeholder="Ketik nama tamu..." class="input-minimal">
        
        <label class="label-form">Pilih Nomor Meja</label>
        <select v-model="orderForm.mejaId" class="input-minimal">
          <option value="" disabled>Pilih Meja...</option>
          <option v-for="meja in mejas" :key="meja.id" :value="meja.id" :disabled="!meja.status">
            Meja {{ meja.nomor_meja }} {{ meja.status ? '' : '(Penuh)' }}
          </option>
        </select>

        <div style="display:flex; justify-content:space-between; margin:15px 0; font-weight:800; font-size:1.2rem;">
          <span style="color: #64748b;">Total</span>
          <span style="color:#16a34a;">{{ formatRupiah(totalPrice) }}</span>
        </div>
        <button class="btn-submit" @click="submitOrder">SIMPAN & CETAK</button>
      </div>
    </div>

    <div v-if="showOrderModal" class="modal-overlay" @click.self="showOrderModal = false">
      <div class="modal-content-small">
        <div style="text-align: center; margin-bottom: 20px;">
          <h3 style="font-weight:800; font-size:1.6rem; color:#1e293b; margin-bottom: 5px;">{{ currentItem.nama }}</h3>
          <p style="color:#16a34a; font-weight:800; font-size:1.2rem;">{{ formatRupiah(currentItem.harga) }}</p>
        </div>

        <div class="qty-container">
          <button @click="changeQty(-1)" class="btn-qty">-</button>
          <span style="font-size:2rem; font-weight:800; color: #1e293b;">{{ currentItem.qty }}</span>
          <button @click="changeQty(1)" class="btn-qty">+</button>
        </div>

        <label class="label-form">Metode Penyajian</label>
        <select v-model="currentItem.metode" class="input-minimal">
          <option value="Dine In">Makan Sini (Dine In)</option>
          <option value="Takeaway">Bungkus (Takeaway)</option>
        </select>

        <label class="label-form">Catatan Tambahan</label>
        <input type="text" v-model="currentItem.catatan" placeholder="Contoh: Tanpa pedas..." class="input-minimal">

        <button class="btn-submit" @click="addToCart">TAMBAH KE KERANJANG</button>
        <button @click="showOrderModal = false" style="width:100%; margin-top:15px; background:none; border:none; color:#94a3b8; font-weight:600; cursor:pointer;">Batal</button>
      </div>
    </div>

    <div v-if="showDetailModal" class="modal-overlay" @click.self="showDetailModal = false">
      <div class="modal-content-small">
        <div style="width:100%; height:200px; border-radius:15px; overflow:hidden; margin-bottom:20px;">
          <img :src="detailItem.gambar || 'https://via.placeholder.com/300'" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <h3 style="font-weight:800; font-size:1.5rem; color:#1e293b; margin-bottom:10px;">{{ detailItem.nama }}</h3>
        <p style="color:#64748b; font-size:0.9rem; line-height:1.5; margin-bottom:20px;">
          {{ detailItem.deskripsi || 'Tidak ada deskripsi untuk menu ini.' }}
        </p>
        <div style="background:#f1f5f9; padding:15px; border-radius:12px; margin-bottom:20px;">
          <span class="label-form" style="margin-bottom:5px;">Status Stok</span>
          <b style="color:#1e293b;">{{ detailItem.stok ?? '∞ (Tersedia)' }}</b>
        </div>
        <button @click="showDetailModal = false" class="btn-submit" style="background:#64748b;">TUTUP DETAIL</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

// Agar CSS eksternal terdeteksi oleh Vite
import '@/assets/css/kasir-style.css';

// States
const groupedMenu = ref({});
const mejas = ref([]);
const cart = ref([]);
const loading = ref(true);
const isCartOpen = ref(false);
const showOrderModal = ref(false);
const showDetailModal = ref(false);

const orderForm = ref({ nama: '', mejaId: '' });
const currentItem = ref({ id: '', nama: '', harga: 0, qty: 1, metode: 'Dine In', catatan: '' });
const detailItem = ref({});

// Methods
const formatRupiah = (val) => 'Rp ' + parseInt(val).toLocaleString('id-ID');

const openOrderModal = (menu) => {
  currentItem.value = { 
    id: menu.id, 
    nama: menu.nama, 
    harga: menu.harga, 
    qty: 1, 
    metode: 'Dine In', 
    catatan: '' 
  };
  showOrderModal.value = true;
};

const changeQty = (val) => {
  currentItem.value.qty = Math.max(1, currentItem.value.qty + val);
};

const addToCart = () => {
  cart.value.push({
    id_menu: currentItem.value.id,
    nama: currentItem.value.nama,
    harga: currentItem.value.harga,
    jumlah: currentItem.value.qty,
    metode: currentItem.value.metode,
    catatan: currentItem.value.catatan,
    subtotal: currentItem.value.harga * currentItem.value.qty
  });
  showOrderModal.value = false;
  isCartOpen.value = true;
};

const removeItem = (idx) => cart.value.splice(idx, 1);

const totalPrice = computed(() => cart.value.reduce((a, b) => a + b.subtotal, 0));

const showDetail = async (id) => {
  try {
    const res = await axios.get(`/api/kasir/menu/${id}`);
    detailItem.value = res.data;
    showDetailModal.value = true;
  } catch (err) {
    alert("Gagal memuat detail menu.");
  }
};

const submitOrder = async () => {
  if (!orderForm.value.nama || !orderForm.value.mejaId || cart.value.length === 0) {
    alert("Lengkapi data pelanggan, meja, dan keranjang!");
    return;
  }

  try {
    const payload = {
      nama_konsumen: orderForm.value.nama,
      id_meja: orderForm.value.mejaId,
      cart_data: cart.value
    };

    const res = await axios.post('/api/kasir/store', payload);

    alert("Pesanan berhasil disimpan!");
    cart.value = [];
    orderForm.value = { nama: '', mejaId: '' };
    isCartOpen.value = false;

  } catch (err) {
    console.error(err.response?.data);
    alert("Gagal mengirim pesanan.");
  }
};

const fetchData = async () => {
  try {
   const res = await axios.get('/api/kasir/initial-data');
    groupedMenu.value = res.data.menu;
    mejas.value = res.data.mejas;
  } catch (err) {
    console.error("Gagal fetch data");
  } finally {
    loading.value = false;
  }
};

onMounted(fetchData);
</script>