<template>
  <div class="p-6">
    <Loader :loading="loading" :error="error">
    <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide">
      LISTA DE IDIOMAS
    </h2>
    <!-- Separador -->
    <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
    <TablaEditable
      :items="idiomas"
      :columns="columns"
      :mostrarBotonCrear="true"
      :loading="loading"
      :error="error"
      @create="crear"
      @update="actualizar"
      @delete="eliminar"
    />
    </Loader>
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent } from 'vue'
import { useIdiomasStore } from '@/stores/idiomasStore'
import type { Idioma } from '@/types';
import Loader from '@/components/LoaderComponent.vue'
import TablaEditable from '@/components/Admin/adminBasic/TablaEditable.vue'
import { useCarroceriasCocheStore } from '@/stores/carroceriasCocheStore';

export default defineComponent({
  components: { TablaEditable, Loader },
  data() {
    return {
      columns: [
        { key: 'nombre', label: 'Nombre' },
        { key: 'iso_639_1', label: 'iso_639_1' },
      ],
    }
  },
  computed: {
     ...mapState(useIdiomasStore,{loading:'loading', error:'error', idiomas:'items'}),
  },
  created() {
    this.getIdiomas()
  },
  methods: {
    getIdiomas(){
      useIdiomasStore().fetchAll()
    },
    async crear(datos: Idioma) {
      await useCarroceriasCocheStore().createItem({ ...datos })
      alert('Idioma creado correctamente')
    },
    async actualizar(datos:Idioma) {
      await useIdiomasStore().updateItem({ ...datos }, true)
      alert('Idioma actualizado correctamente')
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar este idioma?')) {
        await useIdiomasStore().deleteItem(id)
      }
    },
  },
})
</script>
