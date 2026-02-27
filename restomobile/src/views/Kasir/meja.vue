<template>
  <div class="main-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
      <h1 style="margin: 0; font-weight: 800; color: #000000;">Status Meja</h1>
    </div>

    <div v-if="loading" style="text-align:center; padding: 50px;">
      <p style="color: #000000; font-weight: 600;">Memuat Data Meja...</p>
    </div>

    <div v-else class="menu-grid">
      <div v-for="m in mejas" :key="m.id" class="menu-card" style="padding: 20px; text-align: center;">
        
        <div style="font-size: 3rem;">{{ m.status ? '✅' : '🚫' }}</div>
        
        <h2 style="margin: 10px 0; color: #000000; font-weight: 800;">Meja {{ m.nomor_meja }}</h2>
        
        <p style="color: #000000; margin-bottom: 5px; font-weight: 700;">
          Kapasitas: {{ m.kapasitas }} Orang
        </p>

        <div style="min-height: 24px; margin-bottom: 15px;">
          <p v-if="!m.status && m.nama_pelanggan" style="color: #ef4444; font-weight: 700; margin: 0;">
            👤 {{ m.nama_pelanggan }}
          </p>
        </div>
        
        <button 
          @click="toggleStatus(m.id)"
          :disabled="updating === m.id"
          class="btn-submit"
          :style="{ background: m.status ? '#ef4444' : '#16a34a' }"
        >
          {{ updating === m.id ? 'Memproses...' : (m.status ? 'SET TIDAK TERSEDIA' : 'SET TERSEDIA') }}
        </button>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const mejas = ref([]);
const loading = ref(true);
const updating = ref(null);

const fetchMejas = async () => {
  loading.value = true;
  try {
    const res = await axios.get('/api/kasir/meja');
    mejas.value = res.data.data ? res.data.data : res.data;
  } catch (err) {
    console.error("Gagal memuat meja:", err);
  } finally {
    loading.value = false;
  }
};

const toggleStatus = async (id) => {
  updating.value = id;
  try {
    const res = await axios.post(`/api/kasir/meja/update/${id}`);
    const index = mejas.value.findIndex(m => m.id === id);
    if (index !== -1) {
      const newData = res.data.data ? res.data.data : res.data;
      mejas.value[index].status = newData.status;
      if (mejas.value[index].status) {
        mejas.value[index].nama_pelanggan = null;
      }
    }
  } catch (err) {
    alert("Gagal mengubah status meja");
    console.error(err);
  } finally {
    updating.value = null;
  }
};

onMounted(fetchMejas);
</script>

<style scoped>
.main-content { background: #f1f5f9; padding: 25px; min-height: 100vh; }
.menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; }
.menu-card { background: white; border-radius: 16px; border: 1px solid #cbd5e1; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.2s; }
.btn-submit { color: white; border: none; padding: 12px 16px; border-radius: 10px; font-weight: 800; font-size: 13px; cursor: pointer; width: 100%; }
.btn-refresh { background: white; border: 2px solid #000000; padding: 10px 18px; border-radius: 12px; font-weight: 800; cursor: pointer; color: #000000; }
</style>