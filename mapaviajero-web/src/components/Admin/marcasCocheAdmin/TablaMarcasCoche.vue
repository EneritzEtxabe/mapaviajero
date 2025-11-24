<template>
  <div class="p-6">
     <Loader :loading="loading" :error="error"></Loader>
      <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide">LISTA DE MARCAS DE COCHES</h2>     
      <!-- Separador -->
      <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
      <TablaEditable
        :items="marcasCoche"
        :columns="columns"
        :mostrarBotonCrear="true"
        :loading="loading"
        :error="error"
        @create="crear"
        @update="actualizar"
        @delete="eliminar"
      />
    </div>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent } from 'vue'
import { useMarcasCocheStore } from '@/stores/marcasCocheStore'
import Loader from '@/components/LoaderComponent.vue'

import TablaEditable from '../adminBasic/TablaEditable.vue'
import type { CreateMarcaCoche, UpdateMarcaCoche } from '@/types';

export default defineComponent({
  components:{TablaEditable, Loader},
  data() {
    return{
      columns: [
        { key: 'nombre', label: 'MARCA DE COCHE' },
      ],
    }
  },
  computed: {
    ...mapState(useMarcasCocheStore,{loading:'loading', error:'error', marcasCoche:'items'}),
  },
  created() {
    this.getMarcasCoche()
  },
  methods: {
    getMarcasCoche(){
      useMarcasCocheStore().fetchAll()
    },
    async crear(datos: CreateMarcaCoche) {
      await useMarcasCocheStore().createItem({ ...datos });
      alert('Marca de coche creada correctamente');
    },
    async actualizar(datos:UpdateMarcaCoche) {
      await useMarcasCocheStore().updateItem({ ...datos},true)
      alert('Marca de coche actualizada correctamente')
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar esta marca de coches?')) {
        await useMarcasCocheStore().deleteItem(id)
      }
    }
  }
})
</script>

