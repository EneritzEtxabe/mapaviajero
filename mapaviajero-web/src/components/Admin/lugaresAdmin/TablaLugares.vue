<template>
  <h2 class="text-3xl sm:text-4xl pt-5 font-bold text-center f-color--dark tracking-wide">
    LISTA DE LUGARES
  </h2>
  <!-- Separador -->
  <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
  <div class="flex justify-between items-center m-4">
    <Buscador 
      v-model:filtro="filtro"
    />
    <Boton
      :to="{ name: 'nuevoLugar' }"
      type="generalDark"
      title="Añadir lugar"
      :icon="'M12 4v16m8-8H4'"
      label="Añadir Lugar"
    />
  </div>
  <BaseTable 
    :itemsFiltrados="lugaresFiltrados" 
    :columns="columns"
    @edit="editar" 
    @delete="eliminar" 
  >
  </BaseTable>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useLugaresStore } from '@/stores/lugaresStore'

import BaseTable from '@/components/Admin/adminBasic/BaseTable.vue'
import Boton from '@/components/basic/Boton.vue'
import Buscador from '@/components/basic/Buscador.vue'

export default defineComponent({
  components: { BaseTable, Boton, Buscador },
  data() {
    return {
      lugaresStore: useLugaresStore(),
      filtro:'',
      columns: [
        { key: 'nombre', label: 'Nombre' },
        { key: 'continente', label: 'Continente' },
        { key: 'pais', label: 'País' },
        { key: 'descripcion', label: 'Descripción' },
        { key: 'tipo_lugar', label: 'Tipo de lugar' },
        { key: 'imagen_url', label: 'Imagen' },
        { key: 'web_url', label: 'Dirección Web' },
        { key: 'localizacion_url', label: 'Localización' },
      ],
    }
  },
  computed: {
    lugares() {
      return this.lugaresStore.items
    },
    lugaresFiltrados() {
      if (!this.filtro){
        return this.lugares
      }else{
        return this.lugares.filter(lugar => {
          return lugar.nombre.toLowerCase().startsWith(this.filtro.toLowerCase())
        })
      }
    }
  },
  created() {
    this.lugaresStore.fetchAll()
  },
  methods: {
    editar(id) {
      this.$router.push({ name: 'editarLugar', params: { id: id } })
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar este lugar?')) {
        await this.lugaresStore.deleteItem(id)
      }
    },
  },
})
</script>
