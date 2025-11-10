<template>
  <nav class="fixed top-0 left-0 right-0 z-50 bg--white f-color--dark px-20 h-16 flex items-center justify-between">
      <div class="text-xl font-bold">World Map</div>

      <!-- Menú para escritorio -->
       <ul class="hidden md:flex space-x-6 items-center">
        <li><router-link to="/" class=" text-md inline-flex items-center justify-center h-9 px-3 hover:underline">Inicio</router-link></li>
        <li><router-link :to="{name:'paises'}" class="inline-flex items-center justify-center h-9 px-3 hover:underline">Países</router-link></li>
        <li v-if="isAuthenticated">
          <router-link :to="{name:'alquilerCoches'}" class=" text-md inline-flex items-center justify-center h-9 px-3 hover:underline">Alquiler de coches</router-link>
        </li>
        <li v-if="isAuthenticated && user && user.rol=='admin'">
          <Boton
            type="generalDark"
            label="Vista admin"
            :to="{ name: 'admin-panel' }"
            :customClasses="'text-center'"
          />
        </li>
        <li v-if="!isAuthenticated">
          <router-link :to="{name:'login'}" class="text-md inline-flex items-center justify-center h-9 px-3 pl-20 hover:underline">Login</router-link>
        </li>
        <li v-if="isAuthenticated">
          <a href="#" @click.prevent="logout" class="text-md inline-flex items-center justify-center h-9 px-3 pl-20 hover:underline">Logout</a>
        </li>
      </ul>

      <!-- Menú en móvil -->
      <button @click="toggleIsVisible" class="md:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

    <!-- Menú vertical en móvil -->
    <div v-show="isVisible" class="absolute left-0 right-0 top-full z-50 bg--white lg:hidden px-4 pb-4">
      <div class="flex justify-end mb-3">
          <Boton
            v-if="isAuthenticated && user && user.rol=='admin'"
            type="generalDark"
            label="Vista admin"
            :to="{ name: 'admin-panel' }"
            :customClasses="'text-center'"
          />
      </div>
      <ul class="space-y-2">
        <li>
          <router-link to="/" class="block py-2 border-b" @click="isVisible=false">
            Inicio
          </router-link>
        </li>
        <li>
          <router-link :to="{name:'paises'}" class="block py-2 border-b" @click="isVisible=false">
            Países
          </router-link>
        </li>
        <li v-if="isAuthenticated">
          <router-link :to="{name:'alquilerCoches'}" class="block py-2 border-b" @click="isVisible=false">
            Alquiler de coches
          </router-link>
        </li>
        <li v-if="(user && user.rol!=='admin') || !isAuthenticated">
          <router-link to="" class="block py-2 border-b" @click="isVisible=false">
            Contácto
          </router-link>
        </li>
        <li v-if="!isAuthenticated">
          <router-link :to="{name:'login' }"  class="hover:underline" @click="isVisible=false">
            Login
          </router-link>
        </li>
        <li v-if="isAuthenticated">
          <a href="#" @click.prevent="logout" class="inline-flex items-center justify-center h-9 px-3 hover:underline">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script lang="ts">
import { useLoginStore } from '@/stores/loginStore';
import Boton from '@/components/basic/Boton.vue';
export default{
    data(){
        return {
            isVisible:false,

        };
    },
    computed:{
      // Obtener el store
      loginStore() {
        return useLoginStore();
      },
      // Usar el getter isAuthenticated del store
      isAuthenticated() {
        return this.loginStore.isAuthenticated;
      },
      // Por ejemplo, si quieres el usuario
      user() {
        return this.loginStore.user;
      },
    },
    methods:{
        toggleIsVisible(){
            this.isVisible=!this.isVisible
        },
        logout() {
          this.loginStore.logout();
        },
    },
    components:{
      Boton
    }
}
</script>

<style>
    
</style>
