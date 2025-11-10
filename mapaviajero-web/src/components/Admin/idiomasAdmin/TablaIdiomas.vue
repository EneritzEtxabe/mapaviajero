<template>
  <div class="p-6">
    <ErrorModal :error="error" />
    <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide">
      LISTA DE IDIOMAS
    </h2>
    <!-- Separador -->
    <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
    <TablaEditable
      :items="idiomas"
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
import { useIdiomasStore } from '@/stores/idiomasStore'
import ErrorModal from '@/components/error/ErrorModal.vue'

import TablaEditable from '@/components/Admin/adminBasic/TablaEditable.vue'

export default defineComponent({
  components: { TablaEditable, ErrorModal },
  data() {
    return {
      idiomasStore: useIdiomasStore(),
      columns: [
        { key: 'nombre', label: 'Nombre' },
        { key: 'iso_639_1', label: 'iso_639_1' },
      ],
      error: null,
    }
  },
  computed: {
    idiomas() {
      return this.idiomasStore.items
    },
  },
  created() {
    this.idiomasStore.fetchAll()
  },
  methods: {
    async crear(datos: any) {
      try {
        await this.idiomasStore.createItem({ ...datos })
        alert('Idioma creado correctamente')
      } catch (err) {
        this.error = err
      }
    },
    async actualizar(datos) {
      try {
        await this.idiomasStore.updateItem({ ...datos }, true)
        alert('Idioma actualizado correctamente')
      } catch (err) {
        this.error = err
      }
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar este idioma?')) {
        try {
          await this.idiomasStore.deleteItem(id)
        } catch (err) {
          this.error = err
        }
      }
    },
  },
})
</script>
