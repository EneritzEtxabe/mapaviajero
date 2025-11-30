<template>
  <div class="mx-auto p-6">
    <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide">
      LISTA DE ALQUILERES DE COCHES
    </h2>
    <!-- Separador -->
    <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
    <Buscador v-model:filtro="filtro" />
    <BaseTable
      :itemsFiltrados="datosParaMostrar"
      :columns="columns"
      :loading="loading"
      :error="error"
      @edit="editar"
      @delete="eliminar"
    />
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia'
import { defineComponent } from 'vue'
import { useAlquileresStore } from '@/stores/alquileresStore'

import BaseTable from '@/components/Admin/adminBasic/BaseTable.vue'
import Buscador from '@/components/basic/BuscadorComponent.vue'
import type { UpdateAlquiler } from '@/types'

export default defineComponent({
  components: { BaseTable, Buscador },
  data() {
    return {
      filtro: '',
      columns: [
        { key: 'coche', label: 'Coche id' },
        { key: 'pais', label: 'Pais' },
        { key: 'cliente', label: 'Cliente' },
        { key: 'email', label: 'Email' },
        { key: 'fecha_inicio', label: 'Fecha inicio' },
        { key: 'fecha_fin', label: 'Fecha fin' },
        { key: 'coste', label: 'Coste' },
      ],
    }
  },
  computed: {
    ...mapState(useAlquileresStore, { loading: 'loading', error: 'error', alquileres: 'items' }),
    alquileresFiltrados() {
      if (!this.filtro) {
        return this.alquileres
      } else {
        return this.alquileres.filter((alquiler) => {
          return alquiler.cliente.nombre.toLowerCase().startsWith(this.filtro.toLowerCase())
        })
      }
    },
    datosParaMostrar() {
      return this.alquileresFiltrados.map((a) => ({
        id: a.id,
        coche: a.coche.id,
        pais: a.coche.pais.nombre,
        cliente: a.cliente.nombre,
        email: a.cliente.email,
        fecha_inicio: a.fecha_inicio,
        fecha_fin: a.fecha_fin,
        coste: a.coche.costeDia,
      }))
    },
  },
  created() {
    this.getAlquileres()
  },
  methods: {
    getAlquileres() {
      useAlquileresStore().fetchAll()
    },
    deleteAlquiler(id: number) {
      useAlquileresStore().deleteItem(id)
    },
    editar(alquiler: UpdateAlquiler) {
      this.$router.push({ name: 'editarAlquiler', params: { id: alquiler.id } })
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar este alquiler?')) {
        await this.deleteAlquiler(id)
      }
    },
  },
})
</script>
