<template>
    <form class="space-y-6" @submit.prevent>
      <div>
        <label class="block mb-1 text-gray-700 font-medium">Email*:</label>
        <input
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500"
          :class="{ 'border-red-500': v.email.hayError }"
          type="email"
          v-model="email"
          @input=clearError
        />
        <p v-if="v.email.hayError" class="text-red-600 text-sm mt-1">
            {{ v.email.mensajesError[0] }}
          </p>
      </div>

      <div>
        <label class="block mb-1 text-gray-700 font-medium">Contraseña*:</label>
        <input
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500"
          :class="{ 'border-red-500': v.password.hayError }"
          type="password"
          v-model="password"
          @input=clearError
        />
        <p v-if="v.password.hayError" class="text-red-600 text-sm mt-1">
            {{ v.password.mensajesError[0] }}
        </p>
      </div>

      <Boton
        @click="login()"
        type="generalDark"
        label="Iniciar sesión"
        :customClasses="'px-4 py-2 rounded w-full'"
      />
      <p v-if="error" class="error">{{ error }}</p>
      
      <div class="mt-4 text-center">
        <Boton
          @click="$emit('registrarse')"
          type="generalDark"
          label="Registrarse"
          :customClasses="'px-4 py-2 rounded w-full'"
        />
      </div>
    </form>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { mapState } from 'pinia'
import { useLoginStore } from '@/stores/loginStore'
import Boton from '../basic/BotonComponent.vue'

interface camposValidacion{
  hayError:boolean,
  mensajesError: string[]
};
type vType={
  email: camposValidacion,
  password: camposValidacion
};

export default defineComponent({
  components: { Boton },
  data() {
    return {
      email: '',
      password: '',
      v:{
        email: { hayError: false, mensajesError: [] as string[] },
        password: { hayError: false, mensajesError: [] as string[] }
      } as vType
    }
  },
  computed: {
    ...mapState(useLoginStore, {loading:'loading', error:'error', user:'user'}),
    erroresValidacion():boolean{
      return Object.values(this.v).some((field:{hayError:boolean, mensajesError:string[]}) => field.hayError)
    },
  },

  methods: {
    validar(){
      Object.values(this.v).forEach(campo => {
        campo.hayError = false
        campo.mensajesError = []
      })
     
      if (!this.email){
        this.v.email.hayError = true  
        this.v.email.mensajesError = ['Introduce tu email']
      }else{
        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.email.trim())) {
          this.v.email.hayError = true
          this.v.email.mensajesError=['Introduce un email válido (maria@ebis.com)']
        }
      }
  
      if (!this.password){
        this.v.password.hayError = true
        this.v.password.mensajesError = ['Introduce la contraseña']
      }else if (this.password.trim().length < 8) {
        this.v.password.hayError = true
        this.v.password.mensajesError.push('La contraseña tiene que tener como mínimo 8 caracteres')
      }
    },
    async login() {
      this.validar()
      if(this.erroresValidacion){
        return
      }else{
        await useLoginStore().login(this.email, this.password)
        if(this.error == null){
          if (this.user?.rol === 'admin' || this.user?.rol === 'superadmin') {
            this.$router.push({ name: 'admin-panel' })
          } else {
            this.$router.push({ name: 'home' })
          }
        }
      }
    },
    clearError() {
      useLoginStore().error = null;
    },
  },
})
</script>

<style scoped>
.error {
  color: red;
}
</style>
