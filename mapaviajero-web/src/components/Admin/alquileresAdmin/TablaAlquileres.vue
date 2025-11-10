<template>
  <div class="mx-auto p-6">
    <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide">LISTA DE ALQUILERES DE COCHES</h2>     
    <!-- Separador -->
    <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
    <!-- <BaseTable
      :items="alquileres"
      :columns="columns"
    /> -->
    <Buscador 
      v-model:filtro="filtro"
    />
     <BaseTable
      :itemsFiltrados="alquileresFiltrados"
      :columns="columns"
      @edit="editar"
      @delete="eliminar"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useAlquileresStore } from '@/stores/alquileresStore'

import BaseTable from '@/components/Admin/adminBasic/BaseTable.vue'
import Buscador from '@/components/basic/Buscador.vue';

export default defineComponent({
  components: {BaseTable, Buscador},
  data() {
    return{
      alquileresStore: useAlquileresStore(),
      filtro:'',
      columns: [
        { key: 'coche', label: 'Coche id'},
        { key: 'cliente', label: 'Cliente'},
        { key: 'email', label: 'Email' },
        { key: 'fecha_inicio', label: 'Fecha inicio'},
        { key: 'fecha_fin', label: 'Fecha fin' },
        { key: 'coste', label: 'Coste' },
      ],
    }
  },
  computed: {
    alquileres(){
      return this.alquileresStore.items
    },
    alquileresFiltrados() {
      if (!this.filtro){
        return this.alquileres
      }else{
        return this.alquileres.filter(alquiler => {
          return alquiler.cliente.nombre.toLowerCase().startsWith(this.filtro.toLowerCase())
        })
      }
    }
  },
  created() {
    this.alquileresStore.fetchAll()
  },
  methods: {
    editar(alquiler: any) {
      this.$router.push({ name: 'editarAlquiler', params: { id: alquiler.id } })
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar este alquiler?')) {
        await this.alquileresStore.deleteItem(id)
      }
    }
    // async crear(datos: any) {
    //   try {
    //     await this.alquileresStore.createItem({ ...datos });
    //     alert('Aquiler creado correctamente');
    //   } catch (err) {
    //     this.error = err;
    //   }
    // },
    // async actualizar(datos) {
    //   try{
    //     await this.alquileresStore.updateItem({ ...datos},true)
    //     alert('Alquiler actualizado correctamente')
    //   }catch(err){
    //     this.error=err
    //   }
    // },
    // async eliminar(id: number) {
    //   if (confirm('¿Estás seguro de que deseas eliminar este alquiler?')) {
    //     try{
    //       await this.alquileresStore.deleteItem(id)
    //     }catch(err){
    //       this.error=err
    //     }
    //   }
    // }
  }
})
</script>
