<template>
    <h2 class="text-3xl sm:text-4xl pt-5 font-bold text-center f-color--dark tracking-wide">LISTA DE COCHES</h2>     
    <!-- Separador -->
    <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
    <div class="flex justify-between items-center m-4">
    <Buscador 
      v-model:filtro="filtro"
    />
    <Boton
      :to="{ name: 'nuevoCoche' }"
      type="generalDark"
      title="Añadir Coche"
      :icon="'M12 4v16m8-8H4'"
      label="Añadir Coche"
    />
  </div>
  <BaseTable
    :itemsFiltrados="datosParaMostrar"
    :columns="columns"
    :loading="loading"
    :error="error"
    @edit="editar"
    @delete="eliminar"
  />
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent } from 'vue'
import { useCochesStore } from '@/stores/cochesStore'

import BaseTable from '@/components/Admin/adminBasic/BaseTable.vue'
import Boton from '@/components/basic/BotonComponent.vue'
import Buscador from '@/components/basic/BuscadorComponent.vue'

export default defineComponent({
  components:{BaseTable, Boton, Buscador},
  data() {
    return{
      filtro:'',
      columns: [
        { key:'id', label:'id'},
        { key: 'marca', label: 'Marca' },
        { key: 'carroceria', label: 'Carroceria' },
        { key: 'ano', label: 'Año' },
        { key: 'nPlazas', label: 'Número de plazas' },
        { key: 'cambio', label: 'Cambio' },
        { key: 'estado', label: 'Estado' },
        { key: 'costeDia', label: 'Coste por día' },
        { key: 'pais', label: 'País' },
      ],
    }
  },
  computed: {
    ...mapState(useCochesStore,{loading:'loading', error:'error', coches:'items'}),
    cochesFiltrados() {
      if (!this.filtro){
        return this.coches
      }else{
        return this.coches.filter(coche => {
          return coche.marca.nombre.toLowerCase().startsWith(this.filtro.toLowerCase())
        })
      }
    },
    datosParaMostrar(){
      return this.cochesFiltrados.map(c => ({
        id:c.id,
        marca: c.marca.nombre,
        carroceria:c.carroceria.nombre,
        ano:c.ano,
        nPlazas:c.nPlazas,
        cambio:c.cambio,
        estado:c.estado,
        costeDia:c.costeDia,
        pais:c.pais.nombre
      }))
    },
  },
  created() {
    this.getCoches()
  },
  methods: {
    getCoches(){
      useCochesStore().fetchAll()
    },
    editar(id:number) {
      this.$router.push({ name: 'editarCoche', params: { id: id } })
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar este coche?')) {
        await useCochesStore().deleteItem(id)
      }
    }
  }
})
</script>

