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
    :itemsFiltrados="datosParaMostrar" 
    :columns="columns"
    :loading="loading"
    :error="error"
    @edit="editar" 
    @delete="eliminar" 
  >
  </BaseTable>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent } from 'vue'
import { useLugaresStore } from '@/stores/lugaresStore'

import BaseTable from '@/components/Admin/adminBasic/BaseTable.vue'
import Boton from '@/components/basic/BotonComponent.vue'
import Buscador from '@/components/basic/BuscadorComponent.vue'

export default defineComponent({
  components: { BaseTable, Boton, Buscador },
  data() {
    return {
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
    ...mapState(useLugaresStore,{loading:'loading', error:'error', lugares:'items'}),
    lugaresFiltrados() {
      if (!this.filtro){
        return this.lugares
      }else{
        return this.lugares.filter(lugar => {
          return lugar.nombre.toLowerCase().startsWith(this.filtro.toLowerCase())
        })
      }
    },
    datosParaMostrar(){
      return this.lugaresFiltrados.map(l => ({
        id:l.id,
        nombre: l.nombre,
        continente:l.continente.nombre,
        pais: l.pais.nombre,
        descripcion:l.descripcion,
        tipo_lugar:l.tipo_lugar,
        imagen_url:l.imagen_url,
        web_url:l.web_url,
        localizacion_url:l.localizacion_url,
      }))
    },
  },
  created() {
    this.getLugares()
  },
  methods: {
    getLugares(){
      useLugaresStore().fetchAll()
    },
    editar(id:number) {
      this.$router.push({ name: 'editarLugar', params: { id: id } })
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar este lugar?')) {
        await useLugaresStore().deleteItem(id)
      }
    },
  },
})
</script>
