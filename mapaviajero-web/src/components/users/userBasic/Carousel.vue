<template>
  <section class="relative w-full h-[50vh] overflow-hidden">
    <!-- Imagen activa -->
    <transition name="fade">
      <img
        :src="imagenes[imagenActual]"
        :key="imagenActual"
        class="w-full h-full object-cover absolute inset-0 transition-all duration-700 brightness-75"
        :alt="alt"
      />
    </transition>

    <!-- Título superpuesto -->
    <div class="absolute inset-0 flex flex-col items-center justify-center z-10">
      <h1 class="text-6xl md:text-7xl font-bold text-white text-center drop-shadow-lg">
        {{ titulo }}
      </h1>
      <h2 class="text-4xl md:text-3xl mt-6 font-bold text-white text-center drop-shadow-lg">
        {{ subtitulo }}
      </h2>
    </div>

    <!-- Controles -->
    <button
      @click="anterior"
      class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white rounded-full p-2 z-20"
    >
      ‹
    </button>
    <button
      @click="siguiente"
      class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white rounded-full p-2 z-20"
    >
      ›
    </button>
  </section>
</template>
<script lang="ts">
import { defineComponent } from 'vue'
export default defineComponent({
  props:{
    imagenes:{
      type:Array,
      required:true
    },
    alt:String,
    titulo:String,
    subtitulo:String
    
  },
  data() {
    return {
      imagenActual: 0,
      intervalo: null,
    }
  },
  methods: {
    siguiente() {
      this.imagenActual = (this.imagenActual + 1) % this.imagenes.length
    },
    anterior() {
      this.imagenActual = (this.imagenActual - 1 + this.imagenes.length) % this.imagenes.length
    },
    iniciarCarrusel() {
      this.intervalo = setInterval(this.siguiente, 10000)
    },
    detenerCarrusel() {
      clearInterval(this.intervalo)
    },
  },
  mounted() {
    this.iniciarCarrusel()
  },
  beforeUnmount() {
    this.detenerCarrusel()
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
