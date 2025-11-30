<template>
  <h2 class="text-3xl sm:text-4xl pt-5 font-bold text-center f-color--dark tracking-wide">
    LISTA DE PAÍSES
  </h2>
  <!-- Separador -->
  <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
  <div class="flex justify-between items-center m-4">
    <Buscador v-model:filtro="filtro" />
    <Boton
      :to="{ name: 'nuevoPais' }"
      type="generalDark"
      title="Añadir pais"
      :icon="'M12 4v16m8-8H4'"
      label="Añadir País"
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
import { mapState } from 'pinia'
import { defineComponent } from 'vue'
import { usePaisesStore } from '@/stores/paisesStore'

import BaseTable from '@/components/Admin/adminBasic/BaseTable.vue'
import Boton from '@/components/basic/BotonComponent.vue'
import Buscador from '@/components/basic/BuscadorComponent.vue'

export default defineComponent({
  components: { BaseTable, Boton, Buscador },
  data() {
    return {
      filtro: '',
      columns: [
        { key: 'nombre', label: 'Nombre' },
        { key: 'capital', label: 'Capital' },
        { key: 'continente', label: 'Continente' },
        { key: 'conduccion', label: 'Conducción' },
        { key: 'bandera_url', label: 'Bandera' },
        { key: 'idiomas', label: 'Idiomas' },
        { key: 'lugares', label: 'Lugares' },
      ],
    }
  },
  computed: {
    ...mapState(usePaisesStore, { loading: 'loading', error: 'error', paises: 'items' }),
    paisesFiltrados() {
      if (!this.filtro) {
        return this.paises
      } else {
        return this.paises.filter((pais) => {
          return pais.nombre.toLowerCase().startsWith(this.filtro.toLowerCase())
        })
      }
    },
    datosParaMostrar() {
      return this.paisesFiltrados.map((p) => ({
        id: p.id,
        nombre: p.nombre,
        capital: p.capital,
        continente: p.continente.nombre,
        conduccion: p.conduccion,
        bandera_url: p.bandera_url,
        idiomas: p.idiomas,
        lugares: p.lugares,
      }))
    },
  },
  created() {
    this.getPaises()
  },
  methods: {
    getPaises() {
      usePaisesStore().fetchAll()
    },
    editar(id: number) {
      this.$router.push({ name: 'editarPais', params: { id: id } })
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar este país?')) {
        await usePaisesStore().deleteItem(id)
      }
    },
  },
})
</script>
