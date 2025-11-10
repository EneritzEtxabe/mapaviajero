<template>
  <div class="p-6">
    <ErrorModal :error="error"/>
      <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide">LISTA DE CARROCERÍAS DE COCHES</h2>     
      <!-- Separador -->
      <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
      <div class="w-full overflow-x-auto flex flex-col">
        <TablaEditable
          :items="carroceriasCoche"
          :columns="columns"
          :mostrarBotonCrear="true"
          @create="crear"
          @update="actualizar"
          @delete="eliminar"
        />
      </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useCarroceriasCocheStore } from '@/stores/carroceriasCocheStore'
import ErrorModal from '@/components/error/ErrorModal.vue'

import TablaEditable from '@/components/Admin/adminBasic/TablaEditable.vue'

export default defineComponent({
  components:{TablaEditable, ErrorModal},
  data() {
    return{
      carroceriasCocheStore: useCarroceriasCocheStore(),
      columns: [
        { key: 'nombre', label: 'nombre' },
      ],
      error:null,
    }
  },
  computed: {
    carroceriasCoche(){
      return this.carroceriasCocheStore.items
    }
  },
  created() {
    this.carroceriasCocheStore.fetchAll()
  },
  methods: {
    async crear(datos: any) {
      try {
        await this.carroceriasCocheStore.createItem({ ...datos });
        alert('Carrocería de coche creada correctamente');
      } catch (err) {
        this.error = err;
      }
    },
    async actualizar(datos) {
      try{
        await this.carroceriasCocheStore.updateItem({ ...datos},true)
        alert('Carrocería actualizada correctamente')
      }catch(err){
        this.error=err
      }
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar esta carrocería de coches?')) {
        try{
          await this.carroceriasCocheStore.deleteItem(id)
        }catch(err){
          this.error=err
        }
      }
    },
  }
})
</script>

