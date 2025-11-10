import { defineStore } from 'pinia';
import api from '../axios/axios';
import router from '@/router';

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
        await api.get('/sanctum/csrf-cookie');
        const response = await api.post('/api/login', 
          { 
            email, password 
          },
          {
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
            }
          }
        );
        this.token=response.data.token;
        api.defaults.headers.common['Authorization']=`Bearer ${this.token}`;
        await this.fetchUser();
      } catch (err: any) {
        this.error = err.response?.data?.message || 'Error al iniciar sesión';
      } finally {
        this.loading = false;
      }
    },
    async fetchUser() {
      try {
        const userInfo = await api.get('/api/user',
          {
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
            },
          }
        );
        const data = userInfo.data;
        this.user={
          id:data.id,
          nombre:data.nombre,
          rol:data.rol
        };
      } catch (error) {
        this.error = 'No se pudo obtener el usuario';
      }
    },
    async logout() {
      try {
        if (this.token) {
          await api.post('/api/logout', {},
            {
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
              },
            }
          )
        }
      } catch (error) {
        console.error('Error al cerrar sesión en el backend:', error);
      } finally {
        this.token = null;
        this.user = null;
        delete api.defaults.headers.common['Authorization'];
        router.push('/');
      }
    },
    initialize() {
      // Configura axios si ya hay token guardado
      if (this.token) {
        api.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
      }
    }
  },
  persist:true
});