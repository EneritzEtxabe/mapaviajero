<template>
    <form class="space-y-6" @submit.prevent="login">
      <div>
        <label class="block mb-1 text-gray-700 font-medium">Email:</label>
        <input
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500"
          type="email"
          v-model="email"
          @input="loginStore.error=null"
          required
        />
      </div>

      <div>
        <label class="block mb-1 text-gray-700 font-medium">Contraseña:</label>
        <input
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500"
          type="password"
          v-model="password"
          @input="loginStore.error=null"
          required
        />
      </div>

      <Boton
        htmlType="submit"
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
import { useLoginStore } from '@/stores/loginStore'
import Boton from '../basic/Boton.vue'

export default defineComponent({
  components: { Boton },
  data() {
    return {
      email: '',
      password: '',
    }
  },

  computed: {
    loginStore() {
      return useLoginStore()
    },
    error() {
      return this.loginStore.error
    },
  },

  methods: {
    async login() {
      await this.loginStore.login(this.email, this.password)
      const user = this.loginStore.user
      if(this.error == null){
        if (user?.rol === 'admin' || user?.rol === 'superadmin') {
          this.$router.push({ name: 'admin-panel' })
        } else {
          this.$router.push({ name: 'home' })
        }
      }
    },
  },
})
</script>

<style scoped>
.error {
  color: red;
}
</style>
