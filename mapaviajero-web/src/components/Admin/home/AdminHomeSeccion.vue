<template>
  <section>
    <h2 class="text-lg font-semibold mb-4 text-gray-800">{{ icono }} {{ titulo }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
      <AdminHomeCard
        v-for="(card, index) in cards"
        :key="index"
        :titulo="card.titulo"
        :ruta="card.ruta"
      />
    </div>
  </section>
</template>
<script lang="ts">
import { defineComponent, type PropType } from 'vue'
import AdminHomeCard from '@/components/Admin/home/AdminHomeCard.vue'

export default defineComponent({
  components: { AdminHomeCard },
  props: {
    titulo: {
      type: String,
      required: true,
    },
    icono: {
      type: String,
      default: '',
    },
    cards: {
      type: Array as PropType<Array<{ titulo: string; ruta: string }>>,
      required: true,
    },
  },
})
</script>
