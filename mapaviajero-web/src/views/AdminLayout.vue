<template>
    <div class="min-h-screen flex flex-row overflow-x-hidden">
      <AdminHeader 
        @toggleIsVisible="toggleIsVisible()"
      />
      <AdminSidebar 
        :direcciones="direcciones"
        :isVisible="isVisible"
        @logout="logout()"
        @toggleIsVisible="toggleIsVisible()"
      />
      <div class="flex flex-col flex-1 w-full">
        <main :class="['flex-1 bg--beige p-6 ml-0 md:ml-50','mt-15','md:mt-0']">
            <RouterView />
        </main>
        <footer class="bg--white f-color--dark text-center text-sm p-4">
          <AdminFooter />
        </footer>
      </div>
    </div>
</template>

<script lang="ts">
import { RouterView } from 'vue-router';
import { useLoginStore } from '@/stores/loginStore';
import AdminFooter from '@/components/Admin/adminLayout/AdminFooter.vue';
import AdminSidebar from '@/components/Admin/adminLayout/AdminSidebar.vue';
import AdminHeader from '@/components/Admin/adminLayout/AdminHeader.vue';
  export default{
    components:{
      RouterView, AdminHeader, AdminSidebar, AdminFooter
    },
    data(){
      return{
        direcciones:[
          {
            bloque:"Destinos",
            items:[
              {
                label:'Paises',
                ruta:'paisesAdmin'
              },
              {
                label:'Lugares',
                ruta:'lugaresAdmin'
              },
              {
                label:'Idiomas',
                ruta:'idiomasAdmin'
              },
            ],
          },
          {
            bloque:"Coches",
            items:[
              {
                label:'Coches',
                ruta:'cochesAdmin'
              },
              {
                label:'Marcas de coche',
                ruta:'marcasCocheAdmin'
              },
              {
                label:'Carrocerías de coches',
                ruta:'carroceriasCocheAdmin'
              },
            ],
          },
          {
            bloque:"Gestiones",
            items:[
              {
              label:'Usuarios',
              ruta:'usuariosAdmin'
              },
              {
                label:'Alquileres',
                ruta:'alquileresAdmin'
              }
            ],
          }
        ],
        isVisible:false,
      }
    },
    computed:{
      loginStore() {
        return useLoginStore();
      },
    },
    methods:{
       logout() {
          this.loginStore.logout();
        },
        toggleIsVisible(){
            this.isVisible=!this.isVisible
        },
    },
  }
</script>


