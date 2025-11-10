<template>
  <div class="p-6">
    <ErrorModal :error="error"/>
      <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide">LISTA DE MARCAS DE COCHES</h2>     
      <!-- Separador -->
      <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
      <TablaEditable
        :items="marcasCoche"
        :columns="columns"
        :mostrarBotonCrear="true"
        @create="crear"
        @update="actualizar"
        @delete="eliminar"
      />
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useMarcasCocheStore } from '@/stores/marcasCocheStore'
import ErrorModal from '@/components/error/ErrorModal.vue'

import TablaEditable from '../adminBasic/TablaEditable.vue'

export default defineComponent({
  components:{TablaEditable, ErrorModal},
  data() {
    return{
      marcasCocheStore: useMarcasCocheStore(),
      columns: [
        { key: 'nombre', label: 'MARCA DE COCHE' },
      ],
      error:null,
    }
  },
  computed: {
    marcasCoche(){
      return this.marcasCocheStore.items
    }
  },
  created() {
    this.marcasCocheStore.fetchAll()
  },
  methods: {
    async crear(datos: any) {
      try {
        await this.marcasCocheStore.createItem({ ...datos });
        alert('Marca de coche creada correctamente');
      } catch (err) {
        this.error = err;
      }
    },
    async actualizar(datos) {
      try{
        await this.marcasCocheStore.updateItem({ ...datos},true)
        alert('Marca de coche actualizada correctamente')
      }catch(err){
        this.error=err
      }
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar esta marca de coches?')) {
        try{
          await this.marcasCocheStore.deleteItem(id)
        }catch(err){
          this.error=err
        }
      }
    }
  }
})
</script>

