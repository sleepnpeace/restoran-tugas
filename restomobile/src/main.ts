import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios' // Import axios secara eksplisit


axios.defaults.baseURL = 'http://127.0.0.1:8000'; 


axios.defaults.headers.common['Accept'] = 'application/json'; 
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; 


const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

// Ionic imports
import { IonicVue } from '@ionic/vue';
import '@ionic/vue/css/core.css';
import '@ionic/vue/css/normalize.css';
import '@ionic/vue/css/structure.css';
import '@ionic/vue/css/typography.css';



const app = createApp(App)
  .use(IonicVue)
  .use(router);

// Menyediakan axios ke seluruh komponen (opsional, tapi disarankan)
app.config.globalProperties.$axios = axios;

router.isReady().then(() => app.mount('#app'));