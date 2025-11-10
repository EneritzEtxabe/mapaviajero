<template>
  <section class="w-full h-[50vh] relative">
    <img
      :src=imagen
      :alt=alt
      class="w-full h-full object-cover absolute inset-0 brightness-75"
    />

    <!-- Texto opcional sobre la imagen -->
    <div class="absolute inset-0 flex items-center justify-center">
      <h1 class="text-6xl md:text-7xl font-bold text-white text-center drop-shadow-lg">
        {{ texto }}
      </h1>
    </div>
  </section>
</template>
<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    props:{
        imagen:String,
        alt:String,
        texto:String
    }
})
</script>
