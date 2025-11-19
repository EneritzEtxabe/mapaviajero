import { defineStore } from 'pinia';
import api from '../axios/axios';
import router from '@/router';
import type { AxiosError } from 'axios';

export const useLoginStore = defineStore('login', {
  state: () => ({
    error: null as string | null,
    loading: false,
    token: null as string | null,
    user: null as { id: number; nombre: string; rol: string; } | null,
  }),

  getters: {
    isAuthenticated:(state)=> {
      return !!state.token;
    }
  },

  actions: {
    async login(email: string, password: string) {
      this.loading = true;
      this.error = null;
      try {
        const response = await api.post('/api/login', {email, password});
        this.token=response.data.token;
        await this.fetchUser();
        // Redirigimos (todavía sin elegir una vista)
        router.push('/')
      } catch (err) {;
        const error = err as AxiosError<{message:string}>
        this.error = error.response?.data?.message || 'Error al iniciar sesión';
      } finally {
        this.loading = false;
      }
    },
    async fetchUser() {
      try {
        const userInfo = await api.get('/api/user');
        const data = userInfo.data;
        this.user={
          id:data.id,
          nombre:data.nombre,
          rol:data.rol
        };
      } catch (err) {
        const error = err as AxiosError<{message:string}>;
        this.error = error.response?.data?.message || 'No se pudo obtener el usuario';
      }
    },
    async logout(requestBackend: boolean=true) {
      try {
        if (requestBackend && this.token) {
          await api.post('/api/logout')
        }
      } catch (err) {
        const error = err as AxiosError<{message:string}>;
        this.error = error.response?.data?.message || 'Error al cerrar sesión en el backend';
      } finally {
        this.token = null;
        this.user = null;
        router.push('/login');
      }
    },
  },
  persist:true
});