<template>
  <aside
    :class="[
      'bg--white f-color--dark flex flex-col p-4 transition-transform duration-300 ease-in-out',
      'fixed top-0 left-0 h-full z-40',
      isVisible ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
    ]"
  >
    <router-link :to="{ name: 'admin-panel' }" class="px-3 py-2 rounded">
      <h2 class="text-xl font-bold mb-4">World Map</h2>
    </router-link>
    <Boton
      type="generalDark"
      label="Vista usuario"
      :to="{ name: 'home' }"
      :customClasses="'mb-4 text-center'"
    />
    <nav class="flex flex-col space-y-4">
      <AdminNavbar
        v-for="grupo in direcciones"
        :key="grupo.bloque"
        :grupo="grupo"
        @toggleIsVisible="$emit('toggleIsVisible')"
      />
      <a href="#" @click.prevent="$emit('logout')" class="hover:underline px-3 py-2 rounded text-sm"
        >Logout</a
      >
    </nav>
  </aside>
</template>
<script lang="ts">
import Boton from '@/components/basic/BotonComponent.vue'
import { defineComponent, type PropType } from 'vue'
import AdminNavbar from './AdminNavbar.vue'

type itemsDirecciones = {
  label: string
  ruta: string
}

export default defineComponent({
  components: { Boton, AdminNavbar },
  props: {
    direcciones: {
      type: Array as PropType<Array<{ bloque: string; items: itemsDirecciones[] }>>,
      required: true,
    },
    isVisible: { type: Boolean, required: true },
  },
  emits: ['toggleIsVisible', 'logout'],
})
</script>
