<template>
  <RouterView />
</template>

<script lang="ts">
import { useLoginStore } from '@/stores/loginStore'
  export default{
    name: 'App',
    data() {
      return {
        loginStore: useLoginStore()
      }
    },
    async created() {
      // Al iniciar la app, si hay token pero no hay user cargado, intenta obtenerlo
      if (this.loginStore.token && !this.loginStore.user) {
        await this.loginStore.fetchUser()
      }
    }
  }
</script>
<style scoped>

</style>