<template>
    <form class="space-y-6" @submit.prevent="login">
      <div>
        <label class="block mb-1 text-gray-700 font-medium">Email*:</label>
        <input
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500"
          type="email"
          v-model="email"
          @input=clearError
          required
        />
      </div>

      <div>
        <label class="block mb-1 text-gray-700 font-medium">Contraseña*:</label>
        <input
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500"
          type="password"
          v-model="password"
          @input=clearError
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
import { mapState } from 'pinia'
import { useLoginStore } from '@/stores/loginStore'
import Boton from '../basic/BotonComponent.vue'

export default defineComponent({
  components: { Boton },
  data() {
    return {
      email: '',
      password: '',
    }
  },
  computed: {
    ...mapState(useLoginStore, {loading:'loading', error:'error', user:'user'}),
  },

  methods: {
    async login() {
      await useLoginStore().login(this.email, this.password)
      if(this.error == null){
        if (this.user?.rol === 'admin' || this.user?.rol === 'superadmin') {
          this.$router.push({ name: 'admin-panel' })
        } else {
          this.$router.push({ name: 'home' })
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
