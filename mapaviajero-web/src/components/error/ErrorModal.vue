<template>
  <div
    v-if="visible && error"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/25"
  >
    <div class="bg-white w-full max-w-md mx-auto p-6 rounded-lg shadow-lg relative">
      <h3 class="text-lg font-semibold text-red-600 mb-4">Error</h3>
      <p class="text-gray-800">{{ error }}</p>
      <div class="mt-6 text-right">
        <button
          @click="cerrar"
          class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded"
        >
          Cerrar
        </button>
      </div>

      <button @click="cerrar" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
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
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import type { PropType } from 'vue'

export default defineComponent({
  name: 'ErrorModal',
  props: {
    error: {
      type: String as PropType<string | null>,
      default: null,
    },
  },
  data() {
    return {
      visible: true,
    }
  },
  watch: {
    error() {
      this.visible = true
    },
  },
  methods: {
    cerrar() {
      this.visible = false
      this.$router.push({ name: 'admin-panel' })
    },
  },
})
</script>
