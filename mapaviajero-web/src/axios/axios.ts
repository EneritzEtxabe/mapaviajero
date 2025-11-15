import axios from 'axios';
import router from '@/router';
import { useLoginStore } from '@/stores/loginStore';

const api = axios.create({
  baseURL: 'http://localhost:8000',
});

//REQUEST INTERCEPTOR
api.interceptors.request.use(
  config => {
    const loginStore = useLoginStore();
    // Si hay token, añadirlo automáticamente
    if (loginStore.token) {
      config.headers.Authorization = `Bearer ${loginStore.token}`;
    }
    return config;
  },
  error => Promise.reject(error)
);

//RESPONSE INTERCEPTOR
api.interceptors.response.use(
  response => response,

  error => {
    const loginStore = useLoginStore();
    if (error.response) {
      const status = error.response.status;
      const message = error.response.data?.message;

      //Usuario eliminado en la BBDD (desde el middleware)
      if (status === 401 && message === 'Usuario no encontrado. Sesión cerrada.') {
        loginStore.logout();
        router.push('/login');
      }
      //Token inválido o expirado
      else if (status === 401) {
        loginStore.logout();
        router.push('/login');
      }
    }

    return Promise.reject(error);
  }
);

export default api;