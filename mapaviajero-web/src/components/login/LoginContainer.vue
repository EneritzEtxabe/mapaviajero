<template>
  <div class="flex items-center justify-center">
    <div
      class="bg--white mx-auto my-25 p-15 rounded-md shadow-md w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl"
    >
      <div class="flex justify-center mb-6">
        <img src="/imagenLogin.jpg" alt="Logo" class="w-24 h-24 sm:w-32 sm:h-32" />
      </div>

      <LoginForm @registrarse="mostrarModal = true" />
      
      <ModalRegistro
        v-if="mostrarModal"
        @cerrar="cerrarModal"
        @usuarioCreado="cerrarModal"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import LoginForm from '@/components/login/LoginForm.vue';
import ModalRegistro from './ModalRegistro.vue';

export default defineComponent({
  components:{
    LoginForm,ModalRegistro
  },
  data() {
    return{
      mostrarModal:false
    }
  },
  methods:{
    cerrarModal(){
      this.mostrarModal=false
    }
  }
});
</script>
