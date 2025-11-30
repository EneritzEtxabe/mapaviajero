<template>
  <div class="mx-auto p-6">
    <Loader :loading="loading" :error="error">
      <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide">
        LISTA DE USUARIOS
      </h2>
      <!-- Separador -->
      <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
      <TablaEditable
        :items="usuarios"
        :columns="columns"
        :mostrarBotonCrear="false"
        :loading="loading"
        :error="error"
        @create="crear"
        @update="actualizar"
        @delete="eliminar"
      />
    </Loader>
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia'
import { defineComponent } from 'vue'
import type { CreateUsuario, UpdateUsuario } from '@/types'
import { useUsuariosStore } from '@/stores/usuariosStore'
import TablaEditable from '../adminBasic/TablaEditable.vue'
import Loader from '@/components/LoaderComponent.vue'

export default defineComponent({
  components: { TablaEditable, Loader },
  data() {
    return {
      columns: [
        { key: 'nombre', label: 'Nombre' },
        { key: 'email', label: 'Email' },
        { key: 'telefono', label: 'Teléfono' },
        { key: 'dni', label: 'DNI' },
        { key: 'rol', label: 'Rol' },
      ],
    }
  },
  computed: {
    ...mapState(useUsuariosStore, { loading: 'loading', error: 'error', usuarios: 'items' }),
  },
  created() {
    this.getUsuarios()
  },
  methods: {
    getUsuarios() {
      useUsuariosStore().fetchAll()
    },
    async crear(datos: CreateUsuario) {
      await useUsuariosStore().createItem({ ...datos })
      alert('Usuario creado correctamente')
    },
    async actualizar(datos: UpdateUsuario) {
      await useUsuariosStore().updateItem({ ...datos }, true)
      alert('Usuario actualizado correctamente')
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        await useUsuariosStore().deleteItem(id)
      }
    },
  },
})
</script>
