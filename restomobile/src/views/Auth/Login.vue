<template>
  <div class="page-wrapper">
    <div class="login-container">
      <div class="login-image">
        <div class="overlay">
          <h2>KUKT</h2>
          <p>Kelola restoran dengan rasa otentik khas Kalimantan Timur.</p>
        </div>
      </div>

      <div class="login-form">
        <div class="header">
          <h1>Selamat Datang 👋</h1>
          <p>Silakan masukkan detail akun Anda</p>
        </div>

        <Transition name="fade">
          <div v-if="error" class="alert alert-error">
            {{ error }}
          </div>
        </Transition>

        <form @submit.prevent="login">
          <div class="input-group">
            <div class="field-container">
              <input 
                type="email" 
                v-model="email" 
                id="email"
                placeholder=" " 
                required 
                autofocus
              >
              <label for="email" class="floating-label">Email</label>
            </div>
          </div>

          <div class="input-group">
            <div class="field-container">
              <input 
                type="password" 
                v-model="password" 
                id="password"
                placeholder=" " 
                required
              >
              <label for="password" class="floating-label">Password</label>
            </div>
          </div>

          <button type="submit" class="btn-submit" :disabled="loading">
            <span v-if="!loading">Masuk Sekarang</span>
            <span v-else class="loader"></span>
          </button>
        </form>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)

async function login() {
  loading.value = true
  error.value = ''
  
  try {
    const response = await axios.post(
      'http://127.0.0.1:8000/api/login',
      {
        email: email.value,
        password: password.value
      },
      {
        withCredentials: true
      }
    )

    // Bypass Vue Router jika ada instruksi redirect dari API
    if (response.data.redirect) {
      window.location.replace('/' + response.data.redirect)
    }

  } catch (err) {
    error.value = err.response?.data?.message || 'Login gagal. Periksa kembali akun Anda.'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

/* Reset & Base */
.page-wrapper {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background-color: #f0fdf4;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0;
  padding: 20px;
}

.login-container {
  display: flex;
  background: white;
  width: 100%;
  max-width: 900px;
  height: 550px;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
}

/* Bagian Kiri (Image) */
.login-image {
  flex: 1.2;
  background: url('https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80') center/cover no-repeat;
  position: relative;
}

.overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(22, 163, 74, 0.85), transparent);
  padding: 40px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  color: white;
}

.overlay h2 { font-size: 32px; font-weight: 800; margin-bottom: 8px; text-align: left; }
.overlay p { font-size: 16px; opacity: 0.95; line-height: 1.5; text-align: left; }

/* Bagian Kanan (Form) */
.login-form {
  flex: 1;
  padding: 50px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: #fff;
}

.header { margin-bottom: 35px; }
.header h1 { font-size: 26px; color: #14532d; font-weight: 800; margin-bottom: 8px; }
.header p { color: #64748b; font-size: 14px; }

/* Floating Label Logic */
.input-group {
  margin-bottom: 22px;
}

.field-container {
  position: relative;
  width: 100%;
}

input {
  width: 100%;
  padding: 22px 16px 10px 16px; /* Padding ditinggikan untuk ruang label */
  border: 2px solid #e2e8f0;
  border-radius: 14px;
  font-size: 15px;
  font-weight: 500;
  transition: all 0.3s ease;
  outline: none;
  background: #f8fafc;
  color: #1e293b;
}

.floating-label {
  position: absolute;
  left: 16px;
  top: 18px;
  color: #94a3b8;
  font-size: 14px;
  font-weight: 500;
  pointer-events: none;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Animasi saat input fokus atau memiliki teks */
input:focus ~ .floating-label,
input:not(:placeholder-shown) ~ .floating-label {
  top: 8px;
  left: 14px;
  font-size: 11px;
  color: #16a34a;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

input:focus {
  border-color: #16a34a;
  background: #fff;
  box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
}

/* Button & UI */
.btn-submit {
  width: 100%;
  padding: 16px;
  background: #16a34a;
  color: white;
  border: none;
  border-radius: 14px;
  font-weight: 700;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.btn-submit:hover:not(:disabled) {
  background: #15803d;
  transform: translateY(-2px);
  box-shadow: 0 10px 15px -3px rgba(22, 163, 74, 0.2);
}

.btn-submit:disabled {
  background: #94a3b8;
  cursor: not-allowed;
}

.footer { margin-top: 30px; text-align: center; font-size: 14px; color: #64748b; }
.footer a { color: #16a34a; font-weight: 700; text-decoration: none; transition: 0.2s; }
.footer a:hover { color: #15803d; text-decoration: underline; }

/* Alert */
.alert {
  padding: 14px;
  border-radius: 12px;
  font-size: 13px;
  margin-bottom: 25px;
  border-left: 5px solid #dc2626;
  background: #fee2e2;
  color: #991b1b;
}

/* Loader Simple */
.loader {
  width: 20px;
  height: 20px;
  border: 3px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: #fff;
  animation: spin 0.8s ease-in-out infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Fade Transition */
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

/* Responsive */
@media (max-width: 850px) {
  .login-container { height: auto; flex-direction: column; max-width: 450px; }
  .login-image { display: none; }
  .login-form { padding: 40px 30px; }
}
</style>