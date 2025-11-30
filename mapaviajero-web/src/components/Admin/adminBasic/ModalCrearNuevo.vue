<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/25">
    <div class="bg--white w-full max-w-md mx-auto p-6 rounded-lg shadow-lg relative">
      <!-- Cierre -->
      <button
        @click="$emit('cancelar')"
        class="absolute top-2 right-2 text-gray-400 hover:text-gray-600"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>

      <h2 class="text-xl font-bold mb-4">Crear nuevo</h2>

      <!-- Formulario -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div v-for="col in columns" :key="col.key">
          <label :for="col.key" class="block text-sm font-medium text-gray-700">
            {{ col.label }}
          </label>
          <select
            v-if="col.key === 'rol'"
            v-model="datosEditables[col.key]"
            class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
          >
            <option disabled value="">Selecciona un rol</option>
            <option v-for="rol in rolesDisponibles" :key="rol" :value="rol">
              {{ rol }}
            </option>
          </select>
          <input
            v-else
            v-model="datosEditables[col.key]"
            :id="col.key"
            class="mt-1 block w-full border border-gray-300 rounded px-2 py-1 text-sm"
          />
        </div>
      </div>

      <!-- Botones -->
      <div class="flex justify-end mt-6">
        <Boton
          type="create"
          label="Crear"
          title="Crear nuevo"
          :icon="'M5 13l4 4L19 7'"
          @click="$emit('crear')"
          class="mr-2"
        />
        <Boton
          type="cancel"
          label="Cancelar"
          title="Cancelar"
          :icon="'M6 18L18 6M6 6l12 12'"
          @click="$emit('cancelar')"
        />
      </div>
    </div>
  </div>
</template>
<script lang="ts">
import Boton from '@/components/basic/BotonComponent.vue'
import { defineComponent, type PropType } from 'vue'

export default defineComponent({
  components: { Boton },
  props: {
    columns: {
      type: Array as PropType<Array<{ key: string; label: string }>>,
      required: true,
    },
    datosEditables: {
      type: Object as PropType<{ [key: string]: any }>,
      required: true,
    },
    rolesDisponibles: {
      type: Array as PropType<string[]>,
      required: true,
    },
  },
})
</script>
