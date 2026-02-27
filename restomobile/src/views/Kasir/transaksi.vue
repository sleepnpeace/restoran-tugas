<template>
  <div class="main-content">
    <h1 class="page-title">Riwayat Transaksi</h1>

    <div v-if="loading" class="loading-container">
      <p>Memuat Riwayat...</p>
    </div>

    <div v-else class="table-card">
      <table class="modern-table">
        <thead>
          <tr>
            <th>Pelanggan</th>
            <th>Nomor Meja</th> 
            <th>Total Tagihan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="t in transaksis" :key="t.id">
            <td>
              <b class="text-dark">{{ t.nama_konsumen?.split('||')[0] }}</b><br>
              <small class="text-muted">{{ formatDate(t.tanggal) }}</small>
            </td>

            <td>
              <span class="badge-meja">
                {{ t.meja?.nomor_meja ? 'Meja ' + t.meja.nomor_meja : (t.nomor_meja ? 'Meja ' + t.nomor_meja : '-') }}
              </span>
            </td>

            <td class="text-price">{{ formatRupiah(t.total_bayar) }}</td>

            <td>
              <span :class="['status-badge', t.status.toLowerCase()]">
                {{ t.status.toUpperCase() }}
              </span>
            </td>

            <td>
              <div class="action-btns">
                <button 
                  v-if="t.status === 'pending'" 
                  @click="openPayment(t)" 
                  class="btn-pay"
                >
                  KONFIRMASI
                </button>
                <router-link 
                  :to="`/kasir/struk/${t.id}`" 
                  class="btn-print"
                >
                  📄 STRUK
                </router-link>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
      <div class="modal-content">
        <h2 class="modal-title">Selesaikan Pembayaran</h2>
        
        <div class="form-group">
          <label>Total Tagihan</label>
          <div class="total-display">{{ formatRupiah(selectedTrx?.total_bayar) }}</div>
        </div>

        <div class="form-group">
          <label>Jumlah Uang Diterima</label>
          <input 
            type="number" 
            v-model="payForm.jumlah_bayar" 
            class="input-modern" 
            placeholder="Masukkan nominal..." 
            autofocus
          >
          <div v-if="payForm.jumlah_bayar > 0" class="change-info">
            Kembalian: 
            <span :style="{ color: kembalian >= 0 ? '#16a34a' : '#ef4444' }">
              {{ formatRupiah(kembalian) }}
            </span>
          </div>
        </div>

        <button 
          @click="processPayment" 
          class="btn-confirm-full" 
          :disabled="kembalian < 0"
        >
          SIMPAN & SELESAI
        </button>
        <button @click="showModal = false" class="btn-close-modal">Batal</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const transaksis = ref([]);
const loading = ref(true);
const showModal = ref(false);
const selectedTrx = ref(null);
const payForm = ref({ jumlah_bayar: 0, metode_pembayaran: 'cash' });

// Formatters
const formatRupiah = (v) => "Rp " + parseInt(v || 0).toLocaleString('id-ID');
const formatDate = (d) => {
  if (!d) return '-';
  return new Date(d).toLocaleString('id-ID', { 
    dateStyle: 'medium', 
    timeStyle: 'short',
    timeZone: 'Asia/Makassar' // Mengatur ke Waktu Indonesia Tengah
  }) + ' WITA';
};

// Logic Kembalian
const kembalian = computed(() => payForm.value.jumlah_bayar - (selectedTrx.value?.total_bayar || 0));

const fetchData = async () => {
  loading.value = true;
  try {
    const res = await axios.get('/api/kasir/transaksi'); 
    transaksis.value = res.data;
  } catch (e) {
    console.error("Error Fetch:", e);
  } finally {
    loading.value = false;
  }
};

const openPayment = (t) => {
  selectedTrx.value = t;
  payForm.value.jumlah_bayar = t.total_bayar;
  showModal.value = true;
};

const processPayment = async () => {
  try {
    const id = selectedTrx.value.id;
    await axios.post(`/api/kasir/konfirmasi-bayar/${id}`, payForm.value);
    alert('Pembayaran Berhasil!');
    showModal.value = false;
    fetchData(); // Refresh list
  } catch (e) {
    alert('Gagal konfirmasi pembayaran.');
  }
};

onMounted(fetchData);
</script>

<style scoped>
.main-content { background: #f1f5f9; padding: 25px; min-height: 100vh; font-family: 'Inter', sans-serif; }
.page-title { margin-bottom: 30px; font-weight: 800; color: #0f172a; }

/* TABLE STYLES */
.table-card { background: white; border-radius: 16px; border: 1px solid #cbd5e1; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
.modern-table { width: 100%; border-collapse: collapse; text-align: left; }
.modern-table th { padding: 15px; background: #e2e8f0; color: #1e293b; font-size: 12px; text-transform: uppercase; font-weight: 800; }
.modern-table td { padding: 15px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }

/* BADGES & TEXT */
.text-dark { color: #000000 !important; font-weight: 800; font-size: 14px; }
.text-muted { color: #64748b; font-size: 12px; }
.badge-meja { background: #f8fafc; color: #000000 !important; font-weight: 800; padding: 5px 12px; border-radius: 8px; border: 1px solid #94a3b8; display: inline-block; }
.text-price { font-weight: 800; color: #16a34a; }
.status-badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; display: inline-block; }
.status-badge.paid, .status-badge.lunas, .status-badge.success { background: #22c55e; color: white; }
.status-badge.pending { background: #f59e0b; color: white; }

/* BUTTONS */
.action-btns { display: flex; gap: 8px; }
.btn-pay { background: #16a34a; color: white; border: none; padding: 8px 15px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.2s; }
.btn-pay:hover { background: #15803d; }
.btn-print { background: #ffffff; color: #1e293b; text-decoration: none; padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 12px; border: 1px solid #94a3b8; display: inline-block; transition: 0.2s; }
.btn-print:hover { background: #f8fafc; }

/* MODAL STYLES */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.45);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 3000;
}

.modal-content {
  background: #ffffff;
  width: 420px;
  border-radius: 20px;
  padding: 30px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.15);
  animation: fadeInScale 0.2s ease;
}

@keyframes fadeInScale {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

.modal-title { font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 25px; text-align: center; }
.form-group { margin-bottom: 20px; }
.form-group label { font-size: 12px; font-weight: 700; color: #64748b; display: block; margin-bottom: 8px; }

.total-display { background: #ecfdf5; border: 2px solid #bbf7d0; padding: 15px; border-radius: 14px; font-size: 1.8rem; font-weight: 800; color: #15803d; text-align: center; }
.input-modern { width: 100%; padding: 14px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 1.1rem; font-weight: 700; color: #0f172a; background: #f8fafc; box-sizing: border-box; }
.input-modern:focus { outline: none; border-color: #16a34a; background: white; }
.change-info { margin-top: 10px; font-size: 14px; font-weight: 700; }

.btn-confirm-full { width: 100%; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; padding: 14px; border-radius: 14px; font-weight: 800; margin-top: 20px; cursor: pointer; transition: 0.2s; }
.btn-confirm-full:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(22,163,74,0.3); }
.btn-confirm-full:disabled { background: #94a3b8; cursor: not-allowed; transform: none; box-shadow: none; }
.btn-close-modal { width: 100%; background: #f1f5f9; border: none; color: #475569; margin-top: 12px; padding: 12px; border-radius: 12px; cursor: pointer; font-weight: 600; }
</style>