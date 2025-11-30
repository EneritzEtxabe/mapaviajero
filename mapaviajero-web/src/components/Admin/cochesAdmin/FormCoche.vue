<template>
  <Loader :loading="loading" :error="error">
    <div>
      <div class="max-w-xl mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">{{ editMode ? 'Editar coche' : 'Crear coche' }}</h2>
        <form @submit.prevent>
          <!-- Marca -->
          <div class="mb-4">
            <label class="block mb-1">Marca*</label>
            <select
              v-model="form.marca_id"
              class="w-full border px-3 py-2 rounded"
              :class="{ 'border-red-500': v.marca_id.hayError }"
            >
              <option disabled value="">Selecciona una marca</option>
              <option v-for="m in marcasCoche" :key="m.id" :value="m.id">
                {{ m.nombre }}
              </option>
            </select>
            <p v-if="v.marca_id.hayError" class="text-red-600 text-sm mt-1">
              {{ v.marca_id.mensajesError[0] }}
            </p>
          </div>

          <!-- Carroceria -->
          <div class="mb-4">
            <label class="block mb-1">Carrocería*</label>
            <select
              v-model="form.carroceria_id"
              class="w-full border px-3 py-2 rounded"
              :class="{ 'border-red-500': v.carroceria_id.hayError }"
            >
              <option disabled value="">Selecciona una carrocería</option>
              <option v-for="c in carroceriasCoche" :key="c.id" :value="c.id">
                {{ c.nombre }}
              </option>
            </select>
            <p v-if="v.carroceria_id.hayError" class="text-red-600 text-sm mt-1">
              {{ v.carroceria_id.mensajesError[0] }}
            </p>
          </div>
          <!-- Año -->
          <div class="mb-4">
            <label class="block mb-1">Año de matriculación</label>
            <input
              v-model="form.ano"
              type="number"
              class="w-full border px-3 py-2 rounded"
              placeholder="Año de matriculacion del coche"
              :class="{ 'border-red-500': v.ano.hayError }"
            />
            <p v-if="v.ano.hayError" class="text-red-600 text-sm mt-1">
              {{ v.ano.mensajesError[0] }}
            </p>
          </div>
          <!-- Nº plazas -->
          <div class="mb-4">
            <label class="block mb-1">Nº plazas*</label>
            <select
              v-model="form.nPlazas"
              class="w-full border px-3 py-2 rounded"
              :class="{ 'border-red-500': v.nPlazas.hayError }"
            >
              <option disabled value="">Selecciona el Nº plazas del coche</option>
              <option v-for="nPlazas in [2, 4, 5, 7]" :key="nPlazas" :value="nPlazas">
                {{ nPlazas }}
              </option>
            </select>
            <p v-if="v.nPlazas.hayError" class="text-red-600 text-sm mt-1">
              {{ v.nPlazas.mensajesError[0] }}
            </p>
          </div>

          <!-- Cambio -->
          <div class="mb-4">
            <label class="block mb-1">Cambio</label>
            <select
              v-model="form.cambio"
              class="w-full border px-3 py-2 rounded"
              :class="{ 'border-red-500': v.cambio.hayError }"
            >
              <option disabled value="">Selecciona el tipo de cambio</option>
              <option v-for="cambio in ['automático', 'manual']" :key="cambio" :value="cambio">
                {{ cambio }}
              </option>
            </select>
            <p v-if="v.cambio.hayError" class="text-red-600 text-sm mt-1">
              {{ v.cambio.mensajesError[0] }}
            </p>
          </div>
          <!-- Estado -->
          <div class="mb-4">
            <label class="block mb-1">Estado</label>
            <select
              v-model="form.estado"
              class="w-full border px-3 py-2 rounded"
              :class="{ 'border-red-500': v.estado.hayError }"
            >
              <option disabled value="">Selecciona un estado</option>
              <option
                v-for="estado in ['disponible', 'mantenimiento']"
                :key="estado"
                :value="estado"
              >
                {{ estado }}
              </option>
            </select>
            <p v-if="v.estado.hayError" class="text-red-600 text-sm mt-1">
              {{ v.estado.mensajesError[0] }}
            </p>
          </div>
          <!-- Coste/Día-->
          <div class="mb-4">
            <label class="block mb-1">Coste/Día (euros)*</label>
            <input
              v-model="form.costeDia"
              type="number"
              class="w-full border px-3 py-2 rounded"
              placeholder="Coste por día"
              :class="{ 'border-red-500': v.costeDia.hayError }"
            />
            <p v-if="v.costeDia.hayError" class="text-red-600 text-sm mt-1">
              {{ v.costeDia.mensajesError[0] }}
            </p>
          </div>
          <!-- País -->
          <div class="mb-4">
            <label class="block mb-1">País*</label>
            <select
              v-model="form.pais_id"
              class="w-full border px-3 py-2 rounded"
              :class="{ 'border-red-500': v.pais_id.hayError }"
            >
              <option disabled value="">Seleccionas un país</option>
              <option v-for="p in paises" :key="p.id" :value="p.id">
                {{ p.nombre }}
              </option>
            </select>
            <p v-if="v.pais_id.hayError" class="text-red-600 text-sm mt-1">
              {{ v.pais_id.mensajesError[0] }}
            </p>
          </div>
          <!-- Botón -->
          <Boton
            @click="handleSubmit()"
            type="create"
            title="Crear"
            :label="editMode ? 'Actualizar' : 'Crear'"
            :customClasses="'px-4 py-2 rounded border'"
          />
          <Boton
            type="delete"
            label="Cancelar"
            title="Cancelar"
            @click="cancelar"
            :customClasses="'px-4 py-2 ml-2 border'"
          />
        </form>
      </div>
    </div>
  </Loader>
</template>

<script lang="ts">
import { mapState } from 'pinia'
import { defineComponent } from 'vue'
import { usePaisesStore } from '@/stores/paisesStore'
import { useCochesStore } from '@/stores/cochesStore'
import { useMarcasCocheStore } from '@/stores/marcasCocheStore'
import { useCarroceriasCocheStore } from '@/stores/carroceriasCocheStore'
import Loader from '@/components/LoaderComponent.vue'
import Boton from '@/components/basic/BotonComponent.vue'
import type { Estado, Cambio, CreateCoche } from '@/types'

interface camposValidacion {
  hayError: boolean
  mensajesError: string[]
}
type vType = {
  marca_id: camposValidacion
  carroceria_id: camposValidacion
  ano: camposValidacion
  nPlazas: camposValidacion
  cambio: camposValidacion
  estado: camposValidacion
  costeDia: camposValidacion
  pais_id: camposValidacion
}
export default defineComponent({
  components: {
    Loader,
    Boton,
  },
  props: {
    id: {
      type: [String, Number],
      required: false,
    },
  },
  data() {
    return {
      form: {
        marca_id: null,
        carroceria_id: null,
        ano: null,
        nPlazas: null,
        cambio: null as Cambio | null,
        estado: null as Estado | null,
        costeDia: null,
        pais_id: null,
      } as CreateCoche,
      v: {
        marca_id: { hayError: false, mensajesError: [] as string[] },
        carroceria_id: { hayError: false, mensajesError: [] as string[] },
        ano: { hayError: false, mensajesError: [] as string[] },
        nPlazas: { hayError: false, mensajesError: [] as string[] },
        cambio: { hayError: false, mensajesError: [] as string[] },
        estado: { hayError: false, mensajesError: [] as string[] },
        costeDia: { hayError: false, mensajesError: [] as string[] },
        pais_id: { hayError: false, mensajesError: [] as string[] },
      } as vType,
    }
  },
  computed: {
    ...mapState(useCochesStore, { loadingCoche: 'loading', errorCoche: 'error', coche: 'item' }),
    ...mapState(usePaisesStore, {
      loadingPaises: 'loading',
      errorPaises: 'error',
      paises: 'items',
    }),
    ...mapState(useMarcasCocheStore, {
      loadingMarcasCoche: 'loading',
      errorMarcasCoche: 'error',
      marcasCoche: 'items',
    }),
    ...mapState(useCarroceriasCocheStore, {
      loadingCarroceriasCoche: 'loading',
      errorCarroceriasCoche: 'error',
      carroceriasCoche: 'items',
    }),
    loading() {
      return (
        this.loadingCoche ||
        this.loadingPaises ||
        this.loadingMarcasCoche ||
        this.loadingCarroceriasCoche
      )
    },
    error() {
      return (
        this.errorCoche || this.errorPaises || this.errorMarcasCoche || this.errorCarroceriasCoche
      )
    },
    editMode() {
      return !!this.id
    },
    erroresValidacion(): boolean {
      return Object.values(this.v).some(
        (field: { hayError: boolean; mensajesError: string[] }) => field.hayError,
      )
    },
  },
  async created() {
    if (this.id) {
      await useCochesStore().getItem(this.id as number)
      this.form = {
        marca_id: this.coche?.marca['id'] ?? null,
        carroceria_id: this.coche?.carroceria['id'] ?? null,
        ano: this.coche?.ano ?? null,
        nPlazas: this.coche?.nPlazas ?? 0,
        cambio: this.coche?.cambio ?? null,
        estado: this.coche?.estado ?? null,
        costeDia: this.coche?.costeDia ?? null,
        pais_id: this.coche?.pais['id'] ?? null,
      }
    }
    await usePaisesStore().fetchAll()
    await useMarcasCocheStore().fetchAll()
    await useCarroceriasCocheStore().fetchAll()
  },
  watch: {
    form: {
      handler() {
        this.validar()
      },
      deep: true,
    },
  },
  methods: {
    validar() {
      Object.values(this.v).forEach((campo) => {
        campo.hayError = false
        campo.mensajesError = []
      })

      if (!this.form.marca_id) {
        this.v.marca_id.hayError = true
        this.v.marca_id.mensajesError = ['Selecciona una marca de la lista']
      }

      if (!this.form.carroceria_id) {
        this.v.carroceria_id.hayError = true
        this.v.carroceria_id.mensajesError = ['Selecciona una carrocería de la lista']
      }

      if (this.form.ano) {
        if (this.form.ano < 1990) {
          this.v.ano.hayError = true
          this.v.ano.mensajesError = ['El año debe ser 1990 o posterior']
        } else if (this.form.ano > new Date().getFullYear()) {
          this.v.ano.hayError = true
          this.v.ano.mensajesError = [`El año no puede ser mayor que ${new Date().getFullYear()}`]
        }
      }

      if (!this.form.nPlazas) {
        this.v.nPlazas.hayError = true
        this.v.nPlazas.mensajesError = ['El número de plazas es obligatorio']
      }

      if (!this.form.costeDia) {
        this.v.costeDia.hayError = true
        this.v.costeDia.mensajesError = ['El coste por día es obligatorio']
      } else {
        if (this.form.costeDia <= 0) {
          this.v.costeDia.hayError = true
          this.v.costeDia.mensajesError = ['El coste es obligatorio y debe ser mayor que 0€']
        } else if (this.form.costeDia > 99.99) {
          this.v.costeDia.hayError = true
          this.v.costeDia.mensajesError = ['Máximo 99,99€']
        }
      }

      if (!this.form.pais_id) {
        this.v.pais_id.hayError = true
        this.v.pais_id.mensajesError = ['El país es obligatorio']
      }
    },
    async handleSubmit() {
      this.validar()
      if (this.erroresValidacion) {
        return
      } else {
        if (this.editMode) {
          await useCochesStore().updateItem({ id: Number(this.id!), ...this.form }, false)
          alert('Coche actualizado correctamente')
        } else {
          await useCochesStore().createItem(this.form)
          alert('Coche creado correctamente')
        }
        this.$router.push({ name: 'cochesAdmin' })
      }
    },
    cancelar() {
      this.$router.push({ name: 'cochesAdmin' })
    },
  },
})
</script>
