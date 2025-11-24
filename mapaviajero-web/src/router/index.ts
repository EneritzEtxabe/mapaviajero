import { createRouter, createWebHistory } from 'vue-router'
import UserLayout from '@/views/UserLayout.vue'
import AdminLayout from '@/views/AdminLayout.vue'

//--------------- Para vistas usuario---------------
import HomeView from '../views/HomeView.vue'
import PaisesContainer from '@/components/users/paises/PaisesContainer.vue'
import PaisContainer from '@/components/users/pais/paisContainer.vue'
import LugarContainer from '@/components/users/lugares/LugarContainer.vue'
import CochesContainer from '@/components/users/coches/CochesContainer.vue'

//-------------------- Para vistas administrador-----------------
import AdminHomeView from '@/views/AdminHomeView.vue'
import TablaPaises from '@/components/Admin/paisesAdmin/TablaPaises.vue'
import FormPais from '@/components/Admin/paisesAdmin/FormPais.vue'
import TablaLugares from '@/components/Admin/lugaresAdmin/TablaLugares.vue'
import FormLugar from '@/components/Admin/lugaresAdmin/FormLugar.vue'
import TablaIdiomas from '@/components/Admin/idiomasAdmin/TablaIdiomas.vue'
import TablaCoches from '@/components/Admin/cochesAdmin/TablaCoches.vue'
import FormCoche from '@/components/Admin/cochesAdmin/FormCoche.vue'
import TablaMarcasCoche from '@/components/Admin/marcasCocheAdmin/TablaMarcasCoche.vue'
import TablaCarroceriasCoche from '@/components/Admin/carroceriasCocheAdmin/TablaCarroceriasCoche.vue'
import TablaAlquileres from '@/components/Admin/alquileresAdmin/TablaAlquileres.vue'
import TablaUsuarios from '@/components/Admin/usuariosAdmin/TablaUsuarios.vue'

//------------------- Para login -------------------
import LoginContainer from '@/components/login/LoginContainer.vue'
import { useLoginStore } from '@/stores/loginStore'
import type { AxiosError } from 'axios'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: UserLayout,
      children: [
        { path: '', name: 'home', component: HomeView },
        { path: 'login', 
          name: 'login', 
          component: LoginContainer 
        },
        {
          path:"paises",
          name:'paises',
          component: PaisesContainer
        },
        {
          path:"paises/:id",
          name:'pais',
          component: PaisContainer,
          props:true
        },
        {
          path:"lugares/:id",
          name:'lugar',
          component: LugarContainer,
          props:true
        },
        {
          path:"coches",
          name:'alquilerCoches',
          component: CochesContainer,
          props:true,
          meta: { requiresAuth: true}
        },
      ]
    },
    {
      path: '/admin',
      component: AdminLayout,
      children: [
        {
          path: '',
          name: 'admin-panel',
          component: AdminHomeView,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'paises',
          name: 'paisesAdmin',
          component: TablaPaises,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'pais/nuevo',
          name: 'nuevoPais',
          component: FormPais,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: '/paises/:id/editar',
          name: 'editarPais',
          component: FormPais,
          props: true,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'lugares',
          name: 'lugaresAdmin',
          component: TablaLugares,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'lugar/nuevo',
          name: 'nuevoLugar',
          component: FormLugar,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: '/lugares/:id/editar',
          name: 'editarLugar',
          component: FormLugar,
          props: true,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'idiomas',
          name: 'idiomasAdmin',
          component: TablaIdiomas,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'coches',
          name: 'cochesAdmin',
          component: TablaCoches,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'lugar/coche',
          name: 'nuevoCoche',
          component: FormCoche,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: '/coches/:id/editar',
          name: 'editarCoche',
          component: FormCoche,
          props: true,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'marcasCoche',
          name: 'marcasCocheAdmin',
          component: TablaMarcasCoche,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'carroceriasCoche',
          name: 'carroceriasCocheAdmin',
          component: TablaCarroceriasCoche,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'alquileres',
          name: 'alquileresAdmin',
          component: TablaAlquileres,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
        {
          path: 'usuarios',
          name: 'usuariosAdmin',
          component: TablaUsuarios,
          meta: { requiresAuth: true, roles: ['admin', 'superadmin'] }
        },
      ]
    }
  ],
});

router.beforeEach(async (to, from, next) => {
  const loginStore = useLoginStore();

  if (to.meta.requiresAuth) {
    if (!loginStore.token) {
      return next({ name: 'login' });
    }
    if (!loginStore.user) {
      try{
        await loginStore.fetchUser();
      }catch(err){
        const error = err as AxiosError<{message:string}>;
        console.log(error)
        loginStore.token = null;
        loginStore.user=null;
        return next({name:'login'})
      }
    }
    if (to.meta.roles && Array.isArray(to.meta.roles)) {
      const userRole = loginStore.user?.rol;
      if (!to.meta.roles.includes(userRole)) {
        return next({ name: 'home' });
      }
    }
  }
  next();
});

export default router
