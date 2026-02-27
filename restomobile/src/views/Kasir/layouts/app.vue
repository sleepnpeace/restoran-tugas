<template>
  <div class="layout-container">
    <header class="top-navbar">
      <div class="nav-left">
        <router-link to="/kasir/menu" class="nav-brand">KUKT</router-link>
        <nav class="nav-links">
          <router-link v-for="link in navLinks" :key="link.path" :to="link.path" class="nav-item" active-class="active">
            <span>{{ link.icon }}</span> {{ link.name }}
          </router-link>
        </nav>
      </div>
      <button @click="handleLogout" class="btn-logout-nav">🚪 KELUAR</button>
    </header>

    <main class="content-scrollable">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const navLinks = [
  { name: 'Menu', path: '/kasir/menu', icon: '🍽️' },
  { name: 'Meja', path: '/kasir/meja', icon: '🪑' },
  { name: 'Transaksi', path: '/kasir/transaksi', icon: '📜' }
];

const handleLogout = async () => {
  if (!confirm('Yakin ingin keluar?')) return;
  try {
    await axios.post('logout'); // baseURL otomatis menambah prefix api/
  } finally {
    localStorage.removeItem('token');
    delete axios.defaults.headers.common['Authorization'];
    router.push('/');
  }
};
</script>

<style scoped>
/* Gunakan style CSS yang Anda miliki sebelumnya */
.layout-container { min-height: 100vh; display: flex; flex-direction: column; background: #f8fafc; }
.top-navbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0 30px; display: flex; align-items: center; justify-content: space-between; height: 75px; position: sticky; top: 0; z-index: 1000; }
.nav-left { display: flex; align-items: center; gap: 30px; }
.nav-brand { color: #166534; font-weight: 800; font-size: 1.5rem; text-decoration: none; }
.nav-links { display: flex; gap: 10px; }
.nav-item { padding: 10px 20px; text-decoration: none; color: #64748b; font-weight: 700; border-radius: 12px; }
.nav-item.active { background: #f0fdf4; color: #16a34a; }
.btn-logout-nav { background: #fef2f2; color: #ef4444; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 800; cursor: pointer; }
.content-scrollable { flex: 1; padding: 25px; overflow-y: auto; }
</style>