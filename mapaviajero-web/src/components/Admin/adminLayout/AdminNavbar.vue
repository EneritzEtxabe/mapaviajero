<template>
  <h3 class="text-sm font-semibold uppercase tracking-wide p-2 f-color--dark mb-2 bg--beige">
    {{ grupo.bloque }}
  </h3>
  <div v-for="direccion in grupo.items" :key="direccion.label">
    <router-link
      :to="{ name: direccion.ruta }"
      class="text-sm hover:underline px-3 py-2 rounded"
      @click="$emit('toggleIsVisible')"
    >
      {{ direccion.label }}
    </router-link>
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    props:{
        grupo:{type:Object, required:true}
    },
    emits:['toggleIsVisible']
})
</script>
