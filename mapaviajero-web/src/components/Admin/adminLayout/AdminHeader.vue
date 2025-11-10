<template>
  <!-- Barra superior móvil -->
  <header class="md:hidden fixed top-0 flex items-center justify-between bg--white h-15 p-4 w-full">
    <!-- Logo -->
    <h1 class="text-dark text-xl font-bold">World Map</h1>
    <!-- Botón hamburguesa -->
    <button @click="$emit('toggleIsVisible')">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"
        />
      </svg>
    </button>
  </header>
</template>
<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    
})
</script>
