<template>
  <input
    v-model="busqueda"
    type="text"
    class="w-full md:w-1/6 border px-3 py-2 rounded text-sm"
    placeholder="Buscar..."
    @input="$emit('update:filtro', busqueda)"
  />
</template>
<script lang="ts">
export default {
  data() {
    return {
      busqueda: this.filtro || '',
    }
  },
}
</script>
