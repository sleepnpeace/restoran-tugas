<template>
<div>
    <h2>Register</h2>
    <input v-model="nama" placeholder="Nama">
    <input v-model="email" placeholder="Email">
    <input v-model="password" placeholder="Password" type="password">
    <select v-model="jenkel">
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>
    <select v-model="id_role">
        <option value="1">Admin</option>
        <option value="2">Karyawan</option>
    </select>
    <button @click="register">Register</button>
    <p>{{ msg }}</p>
    <router-link to="/">Login</router-link>
</div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import api from '@/services/api';

const nama = ref('');
const email = ref('');
const password = ref('');
const jenkel = ref('L');
const id_role = ref(2);
const msg = ref('');

const register = async () => {
    try{
        const res = await api.post('/register',{nama,email,password,jenkel,id_role});
        msg.value = res.data.message;
    } catch(err:any){
        msg.value = err.response?.data?.message || 'Register gagal';
    }
}
</script>
