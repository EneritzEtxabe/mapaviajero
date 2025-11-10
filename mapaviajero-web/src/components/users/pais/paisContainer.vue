<template>
  <!-- <Loader :loading="loading" :error="error"> -->
  <Carousel :imagenes="imagenes" alt="Destinos" :titulo="pais.nombre" />
  <div class="max-w-6xl mx-auto p-6">
    <h2 class="text-3xl sm:text-4xl font-bold mt-15 text-center f-color--dark tracking-wide">
      INFORMACIÓN GENERAL
    </h2>
    <!-- Separador -->
    <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
      <!-- Bandera a la izquierda -->
      <div class="w-full md:w-1/3 flex justify-center md:justify-start">
        <img :src="pais.bandera_url" alt="Bandera" class="w-40 h-auto rounded shadow-md" />
      </div>

      <!-- Información a la derecha -->
      <div class="w-full md:w-2/3">
        <p class="text-gray-700 mb-2"><strong>Capital:</strong> {{ pais.capital }}</p>
        <p class="text-gray-700 mb-2" v-if="pais && pais.continente">
          <strong>Continente:</strong> {{ pais.continente.nombre }}
        </p>
        <p class="text-gray-700 mb-2" v-if="pais.conduccion">
          <strong>Lado de conducción:</strong> {{ pais.conduccion }}
        </p>
        <p class="text-gray-700 mb-2">
          <strong>Idiomas:</strong>
        </p>
        <ul class="list-disc list-inside mt-1">
          <li v-for="(idioma, i) in pais.idiomas" :key="i">
            {{ idioma.nombre }}
          </li>
        </ul>
      </div>
    </div>
    <h2
      class="text-3xl sm:text-4xl font-bold mt-15 text-center f-color--dark tracking-wide uppercase"
    >
      SITIOS DE INTERÉS
    </h2>
    <!-- Separador -->
    <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <div
        v-for="lugar in lugaresPais"
        :key="lugar.id"
        class="relative rounded-lg overflow-hidden shadow-lg group h-64"
      >
        <router-link :to="{ name: 'lugar', params: { id: lugar.id } }">
          <!-- Imagen de fondo -->
          <img
            :src="lugar.imagen_url"
            alt="Imagen del lugar"
            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
          />

          <!-- Capa oscura -->
          <div
            class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition duration-300"
          ></div>

          <!-- Contenido sobre la imagen -->
          <div class="absolute bottom-0 left-0 right-0 p-4 text-white z-10">
            <h3 class="text-2xl font-bold mb-1">{{ lugar.nombre }}</h3>
          </div>
        </router-link>
      </div>
    </div>
  </div>
  <!-- </Loader> -->
</template>

<script lang="ts">
// import { mapActions, mapState } from 'pinia';
import { usePaisesStore } from '@/stores/paisesStore'
import { useLugaresStore } from '@/stores/lugaresStore'
import { defineComponent } from 'vue'
import Carousel from '../userBasic/Carousel.vue'
// import Loader from '@/components/Loader.vue';

export default defineComponent({
  components: {
    Carousel,
  },
  props: ['id'],
  data() {
    return {
      paisesStore: usePaisesStore(),
      lugaresStore: useLugaresStore(),
    }
  },
  computed: {
    // ...mapState(usePaisesStore,['loading', 'error','item'])
    pais() {
      return this.paisesStore.item
    },
    lugaresPais() {
      const res = this.lugaresStore.items
      return res.filter((lugar) => lugar.pais.id === Number(this.id))
    },
    imagenes() {
      return this.lugaresPais.map((lugar) => lugar.imagen_url)
    },
  },
  created() {
    this.lugaresStore.fetchAll()
    this.paisesStore.getItem(this.id)
  },
  beforeUnmount() {
    this.paisesStore.item = ''
  },
})
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
