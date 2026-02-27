import axios from 'axios'

const api = axios.create({
    baseURL: 'http://127.0.0.1:8000/api',
    withCredentials: true, // ⬅️ WAJIB untuk CORS + Sanctum
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
})

// OPTIONAL: interceptor token (kalau pakai JWT / bearer)
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token')
        if (token && config.headers) {
            config.headers.Authorization = `Bearer ${token}`
        }
        return config
    },
    (error) => Promise.reject(error)
)

export default api
