<template>
    <!-- Destinos destacados -->
    <section class="max-w-6xl mx-auto py-16 px-6">
      <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide mb-5">DESTINOS DESTACADOS</h2>
      <!-- Separador -->
      <div class="h-px bg--dark mx-auto w-1/4 mb-10"></div>
      <div
        v-for="(destino, index) in lugares"
        :key="destino.id"
        class="flex flex-col md:flex-row items-center md:items-stretch mt-8"
        :class="index % 2 === 1 ? 'md:flex-row-reverse' : ''"
      >
        <!-- Imagen -->
        <div class="w-1/1 md:w-1/2 h-64">
          <img
            :src="destino.imagen_url"
            :alt="destino.nombre"
            class="w-full h-full object-cover rounded-lg shadow-lg"
          />
        </div>

        <!-- Texto -->
        <div class="w-1/1 md:w-1/2 md:pl-10 md:pr-10 mt-6 md:mt-0 flex-col justify-between">
          <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-3">
              {{ destino.nombre }}
            </h2>
            <p class="text-gray-600 text-md line-clamp-6">
              {{ destino.descripcion }}
            </p>
            <p class="text-gray-600 text-md mb-3">
              <strong>País: </strong> {{ destino.pais.nombre }}
            </p>
          </div>
          <Boton
            :to="{ name: 'lugar', params: { id: destino.id } }"
            type="generalDark"
            :label="'Saber más'"
            :icon="'M12 4v16m8-8H4'"
            :title="'Ir al detalle del lugar'"
          />
        </div>
      </div>
    </section>
</template>
<script lang="ts">
import Boton from "@/components/basic/Boton.vue";
import { defineComponent } from "vue";
import { useLugaresStore } from "@/stores/lugaresStore";

export default defineComponent({
    components:{Boton},
    data(){
      return {
        lugaresStore: useLugaresStore(),
      }
    },
    computed: {
      lugares(){
        const lugaresCompleto = this.lugaresStore.items;
        return lugaresCompleto.slice(-5).reverse();
      },
    },
    created() {
      this.lugaresStore.fetchAll()
    },
})
</script>