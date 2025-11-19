import axios from 'axios';
import { useLoginStore } from '@/stores/loginStore';

const api = axios.create({
  baseURL: 'http://localhost:8000',
});

api.interceptors.request.use(
  config => {
    const loginStore = useLoginStore();
    if (loginStore.token) {
      config.headers.Authorization = `Bearer ${loginStore.token}`;
    }
    return config;
  },
  error => Promise.reject(error)
);

api.interceptors.response.use(
  response => response,
  error => {
    const loginStore = useLoginStore();
    if (error.response) {
      const status = error.response.status;
      if (status === 401 && loginStore.token) {
        loginStore.error="Tu sesión ha expirado o tu usuario ya no existe.";
        loginStore.logout(false);
      }
    }
    return Promise.reject(error);
  }
);

export default api;