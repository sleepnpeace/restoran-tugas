import { createRouter, createWebHistory } from 'vue-router';

// Layouts
import AppLayout from '@/views/Kasir/layouts/app.vue'; 

// Views
import Login from '@/views/Auth/Login.vue';
import Register from '@/views/Auth/Register.vue';
import KasirMenu from '@/views/Kasir/menu.vue';
import KasirMeja from '@/views/Kasir/meja.vue';      // Pastikan file ini ada
import KasirTransaksi from '@/views/Kasir/transaksi.vue'; // Pastikan file ini ada
import KasirDetailTransaksi from '@/views/Kasir/detailtransaksi.vue'; // Pastikan file ini ada

const routes = [
  // --- PUBLIC ROUTES (Tanpa Navbar) ---
  { 
    path: '/', 
    name: 'login', 
    component: Login 
  },
  { 
    path: '/register', 
    name: 'register', 
    component: Register 
  },

  // --- KASIR ROUTES (Dengan Navbar AppLayout) ---
  {
    path: '/kasir',
    component: AppLayout, 
    redirect: { name: 'kasir.menu' }, // Otomatis ke menu jika akses /kasir
    children: [
      { 
        path: 'menu', 
        name: 'kasir.menu', 
        component: KasirMenu 
      },
      { 
        path: 'meja', 
        name: 'kasir.meja', 
        component: KasirMeja 
      },
      { 
        path: 'transaksi', 
        name: 'kasir.transaksi', 
        component: KasirTransaksi 
      },
      {
      path: '/kasir/struk/:id',
      name: 'kasir.detailtransaksi',
      component: KasirDetailTransaksi
    },
    ]
  },

  // --- CATCH ALL (404 Redirect) ---
  { 
    path: '/:pathMatch(.*)*', 
    redirect: '/' 
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

export default router;