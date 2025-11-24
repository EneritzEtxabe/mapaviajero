<template>
  <div class="p-6">
    <Loader :loading="loading" :error="error">
      <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide">LISTA DE CARROCERÍAS DE COCHES</h2>     
      <!-- Separador -->
      <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
      <div class="w-full overflow-x-auto flex flex-col">
        <TablaEditable
          :items="carroceriasCoche"
          :columns="columns"
          :mostrarBotonCrear="true"
          :loading="loading"
          :error="error"
          @create="crear"
          @update="actualizar"
          @delete="eliminar"
        />
      </div>
    </Loader>
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent } from 'vue'
import type {CreateCarroceriaCoche, UpdateCarroceriaCoche } from '@/types'
import { useCarroceriasCocheStore } from '@/stores/carroceriasCocheStore'
import Loader from '@/components/LoaderComponent.vue'

import TablaEditable from '@/components/Admin/adminBasic/TablaEditable.vue'

export default defineComponent({
  components:{TablaEditable, Loader},
  data() {
    return{
      columns: [
        { key: 'nombre', label: 'nombre' },
      ],
    }
  },
  computed: {
    ...mapState(useCarroceriasCocheStore,{loading:'loading', error:'error', carroceriasCoche:'items'}),
  },
  created() {
    this.getCarroceriasCoche()
  },
  methods: {
    getCarroceriasCoche(){
      useCarroceriasCocheStore().fetchAll()
    },
    async crear(datos:CreateCarroceriaCoche) {
      await useCarroceriasCocheStore().createItem({ ...datos });
      alert('Carrocería de coche creada correctamente');
    },
    async actualizar(datos:UpdateCarroceriaCoche) {
      await useCarroceriasCocheStore().updateItem({ ...datos},true)
      alert('Carrocería actualizada correctamente')
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar esta carrocería de coches?')) {
        await useCarroceriasCocheStore().deleteItem(id)
      }
    },
  }
})
</script>

