<template>
  <main class="min-h-screen bg--beige">
    <Carousel 
      :imagenes="imagenes"
      alt="Destinos del momento"
      titulo="World Map"
      subtitulo="Encuentra los lugares más bonitos del mundo y planifica tu viaje con nosotros."
    />
    <HomeIntro />
    <HomeDestinos />
  </main>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Carousel from '@/components/users/userBasic/CarouselCabecera.vue'
import HomeIntro from '@/components/users/home/HomeIntro.vue'
import HomeDestinos from '@/components/users/home/HomeDestinos.vue'
import { useLugaresStore } from '@/stores/lugaresStore'

export default defineComponent({
  components: { Carousel, HomeIntro, HomeDestinos },
  data() {
    return {
      lugaresStore: useLugaresStore(),
    }
  },
  computed: {
    imagenes() {
      const imagenesCompleto = this.lugaresStore.items
        .map((lugar) => lugar.imagen_url)
        .filter(Boolean)
      return imagenesCompleto.slice(-5).reverse()
    },
  },
  created() {
    this.lugaresStore.fetchAll()
  },
})
</script>
