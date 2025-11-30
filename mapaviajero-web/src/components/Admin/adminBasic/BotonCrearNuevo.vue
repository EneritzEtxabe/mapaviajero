<template>
  <Boton
    type="generalDark"
    @click="$emit('crearNuevo')"
    label="Añadir"
    :icon="'M12 4v16m8-8H4'"
    customClasses="mx-auto mb-3"
  />
</template>
<script lang="ts">
import Boton from '@/components/basic/BotonComponent.vue'
import { defineComponent } from 'vue'

export default defineComponent({
  components: { Boton },
})
</script>
