<template>
  <div class="receipt-wrapper">
    <div v-if="loading" class="status-msg">Memuat data struk...</div>

    <div v-else-if="transaksi" class="struk-container">
      <div class="header">
        <div class="store-name">NAMA RESTO ANDA</div>
        <div class="meta-info">
          Jl. Alamat Lengkap Restoran<br>
          Telp: 08xx-xxxx-xxxx
        </div>
      </div>

      <div class="meta-section">
        <div class="info-row"><span>No. Transaksi</span><span class="font-bold">#{{ transaksi.id }}</span></div>
        <div class="info-row"><span>Tanggal</span><span>{{ formatDateTime(transaksi.tanggal) }}</span></div>
        <div class="info-row"><span>Kasir</span><span>{{ transaksi.nama_kasir || 'System' }}</span></div>
        <div class="info-row"><span>Pelanggan</span><span>{{ transaksi.nama_bersih }}</span></div>
        <div class="info-row">
          <span>Tipe Pesanan</span>
          <span>{{ transaksi.nomor_meja ? `Dine In (Meja ${transaksi.nomor_meja})` : 'Takeaway' }}</span>
        </div>
      </div>

      <div class="divider"></div>

      <div class="items-list">
        <div v-for="item in details" :key="item.id" class="item-container">
          <span class="item-name">{{ item.nama_menu }}</span>
          <div class="item-details">
            <span>{{ item.jumlah }} x {{ formatPrice(item.harga_satuan) }}</span>
            <span class="font-bold">{{ formatPrice(item.subtotal) }}</span>
          </div>
          <div class="item-meta">[{{ (item.metode || 'dine in').toUpperCase() }}]</div>
          <div v-if="item.catatan" class="item-note">Catatan: {{ item.catatan }}</div>
        </div>
      </div>

      <div class="total-section">
        <div class="flex-between grand-total">
          <span>TOTAL TAGIHAN</span>
          <span>{{ formatPrice(transaksi.total_bayar) }}</span>
        </div>
        <div class="flex-between" style="margin-top:10px">
          <span>Status</span>
          <span class="status-badge">{{ transaksi.status.toUpperCase() }}</span>
        </div>
      </div>

      <div class="footer">
        <p>** TERIMA KASIH **<br><i>Selamat menikmati hidangan kami</i></p>
      </div>

      <div class="btn-group no-print">
        <button @click="printReceipt" class="btn-print-action">🖨️ CETAK STRUK</button>
        <router-link to="/kasir/transaksi" class="btn-back">Kembali ke Daftar</router-link>
      </div>
    </div>

    <div v-else class="status-msg error">Data transaksi tidak ditemukan.</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const transaksi = ref(null);
const details = ref([]);
const loading = ref(true);

const fetchData = async () => {
  try {
    const id = route.params.id;
    const res = await axios.get(`/api/kasir/transaksi/${id}`);
    const data = res.data.transaksi;
    
    // Logika Pembersihan Nama Pelanggan
    data.nama_bersih = data.nama_konsumen.split('||')[0];
    
    transaksi.value = data;
    details.value = res.data.details;
  } catch (e) {
    console.error(e);
  } finally {
    loading.value = false;
  }
};

const formatPrice = (v) => "Rp " + parseInt(v).toLocaleString('id-ID');
const formatDateTime = (dt) => new Date(dt).toLocaleString('id-ID');
const printReceipt = () => window.print();

const tambahPesanan = () => {
  // Simpan state ke localStorage agar dibaca oleh KasirMenu.vue
  localStorage.setItem('edit_transaksi_id', transaksi.value.id);
  localStorage.setItem('old_nama', transaksi.value.nama_bersih);
  localStorage.setItem('old_meja', transaksi.value.id_meja);
  router.push('/kasir/menu');
};

onMounted(fetchData);
</script>

<style scoped>
.receipt-wrapper { font-family: 'Courier New', Courier, monospace; background: #f1f5f9; min-height: 100vh; display: flex; justify-content: center; padding: 20px; color: #000; }
.struk-container { background: white; width: 320px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); height: fit-content; }
.header { text-align: center; border-bottom: 2px dashed #000; padding-bottom: 10px; margin-bottom: 15px; }
.store-name { font-size: 18px; font-weight: 800; }
.info-row { display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 3px; }
.divider { border-top: 1px dashed #000; margin: 10px 0; }
.item-container { margin-bottom: 10px; border-bottom: 1px dotted #ccc; padding-bottom: 5px; }
.item-name { font-weight: bold; font-size: 13px; }
.item-details { display: flex; justify-content: space-between; font-size: 12px; }
.item-meta { font-size: 10px; color: #666; }
.item-note { font-size: 10px; font-style: italic; background: #f0f0f0; padding: 2px 5px; margin-top: 3px; }
.grand-total { font-size: 16px; font-weight: 800; border-top: 1px solid #000; padding-top: 5px; }
.status-badge { border: 1px solid #000; padding: 2px 5px; font-size: 10px; font-weight: bold; }
.footer { text-align: center; font-size: 10px; margin-top: 20px; border-top: 1px dashed #000; padding-top: 10px; }
.btn-group { margin-top: 20px; }
.btn-tambah, .btn-print-action { width: 100%; padding: 12px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-bottom: 8px; font-family: sans-serif; }
.btn-tambah { background: #3b82f6; color: white; }
.btn-print-action { background: #16a34a; color: white; }
.btn-back { display: block; text-align: center; text-decoration: none; color: #64748b; font-size: 12px; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-family: sans-serif; }
@media print { .no-print { display: none; } .receipt-wrapper { background: white; padding: 0; } .struk-container { box-shadow: none; width: 100%; } }
</style>