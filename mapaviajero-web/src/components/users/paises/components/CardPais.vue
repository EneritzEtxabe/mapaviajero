<template>
  <div class="bg--white rounded-lg shadow-md p-4 hover:shadow-lg transition-all">
    <img :src="pais.bandera_url" alt="Bandera" class="w-20 h-auto mb-2 mx-auto" />
    <h2 class="text-md font-semibold mb-1 text-center">{{ pais.nombre }}</h2>
    <p class="text-gray-600 text-md"><strong>Continente:</strong> {{ pais.continente.nombre }}</p>
    <p class="text-gray-600text-md"><strong>Capital:</strong> {{ pais.capital }}</p>
    <p class="text-gray-600 text-md">
      <strong>Idiomas:</strong>
    </p>
    <ul class="list-disc list-inside mt-1 mb-5">
      <li v-for="(idioma, index) in pais.idiomas" :key="index">
        {{ idioma.nombre }}
      </li>
    </ul>
    <Boton
      :to="{ name: 'pais', params: { id: pais.id } }"
      type="generalDark"
      :label="'Saber más'"
      :icon="'M12 4v16m8-8H4'"
      :title="'Ir al detalle del país'"
    />
  </div>
</template>

<script lang="ts">
import Boton from '@/components/basic/BotonComponent.vue'

export default {
  props: ['pais'],
  components: {
    Boton,
  },
}
</script>
