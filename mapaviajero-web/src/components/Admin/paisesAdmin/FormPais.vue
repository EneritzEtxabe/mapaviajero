<template>
  <Loader :loading="loading" :error="error">
    <div>
      <div class="max-w-xl mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">{{ editMode ? 'Editar país' : 'Crear país' }}</h2>
        <form @submit.prevent>
          <!-- Nombre -->
          <div class="mb-4">
            <label class="block mb-1">Nombre*</label>
            <input
              v-model="form.nombre"
              type="text"
              class="w-full border px-3 py-2 rounded"
              placeholder="Nombre del país"
              :class="{ 'border-red-500': v.nombre.hayError }"
            />
            <p v-if="v.nombre.hayError" class="text-red-600 text-sm mt-1">
              {{ v.nombre.mensajesError[0] }}
            </p>
          </div>
          <!-- Capital -->
          <div class="mb-4">
            <label class="block mb-1">Capital*</label>
            <input
              v-model="form.capital"
              type="text"
              class="w-full border px-3 py-2 rounded"
              :class="{ 'border-red-500': v.capital.hayError }"
              placeholder="Capital del país"
            />
            <p v-if="v.capital.hayError" class="text-red-600 text-sm mt-1">
              {{ v.capital.mensajesError[0] }}
            </p>
          </div>

          <!-- Bandera -->
          <div class="mb-4">
            <label class="block mb-1">Url de la bandera del país</label>
            <input
              v-model="form.bandera_url"
              type="text"
              class="w-full border px-3 py-2 rounded"
              :class="{ 'border-red-500': v.bandera_url.hayError }"
              placeholder="Url de la bandera del país"
            />
            <p v-if="v.bandera_url.hayError" class="text-red-600 text-sm mt-1">
              {{ v.bandera_url.mensajesError[0] }}
            </p>
          </div>

          <!-- Continente -->
          <div class="mb-4">
            <label class="block mb-1">Continente*</label>
            <select
              v-model="form.continente_id"
              class="w-full border px-3 py-2 rounded"
              :class="{ 'border-red-500': v.continente_id.hayError }"
            >
              <option disabled value="">Selecciona un continente</option>
              <option v-for="c in continentes" :key="c.id" :value="c.id">
                {{ c.nombre }}
              </option>
            </select>
            <p v-if="v.continente_id.hayError" class="text-red-600 text-sm mt-1">
              {{ v.continente_id.mensajesError[0] }}
            </p>
          </div>

          <!-- Conducción -->
          <div class="mb-4">
            <label class="block mb-1">Tipo de conducción</label>
            <select
              v-model="form.conduccion"
              class="w-full border px-3 py-2 rounded"
              :class="{ 'border-red-500': v.conduccion.hayError }"
            >
              <option value="izquierda">Izquierda</option>
              <option value="derecha">Derecha</option>
            </select>
            <p v-if="v.conduccion.hayError" class="text-red-600 text-sm mt-1">
              {{ v.conduccion.mensajesError[0] }}
            </p>
          </div>

          <!-- Idiomas -->
          <div class="mb-4">
            <label class="block mb-2 font-medium">Idiomas</label>
            <div class="grid grid-cols-3 gap-2">
              <label
                v-for="idioma in idiomas"
                :key="idioma.id"
                class="flex items-center space-x-2"
                :class="{ 'border-red-500': v.idiomas.hayError }"
              >
                <input
                  type="checkbox"
                  :value="idioma.id"
                  v-model="form.idiomas"
                  class="accent-blue-600"
                />
                <span>{{ idioma.nombre }}</span>
              </label>
            </div>
            <p v-if="v.idiomas.hayError" class="text-red-600 text-sm mt-1">
              {{ v.idiomas.mensajesError[0] }}
            </p>
          </div>

          <!-- Lugares (solo si estamos editando y hay lugares) -->
          <div v-if="editMode && form.lugares?.length" class="mb-4">
            <label class="block mb-2 font-medium">Lugares</label>
            <ul class="space-y-2">
              <li
                v-for="lugar in form.lugares"
                :key="lugar.id"
                class="flex justify-between items-center bg-gray-100 p-2 rounded"
              >
                {{ lugar.nombre }}
                <Boton
                  type="delete"
                  label="Eliminar"
                  @click.prevent="eliminarLugar(lugar.id)"
                  :customClasses="'text-md'"
                />
              </li>
            </ul>
          </div>
          <!-- Botón -->
          <Boton
            @click="handleSubmit()"
            title="Crear"
            type="create"
            :icon="'M5 13l4 4L19 7'"
            :label="editMode ? 'Actualizar' : 'Crear'"
            :customClasses="'px-4 py-2 border'"
          />
          <Boton
            type="delete"
            label="Cancelar"
            title="Cancelar"
            :icon="'M6 18L18 6M6 6l12 12'"
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
import { useIdiomasStore } from '@/stores/idiomasStore'
import { useLugaresStore } from '@/stores/lugaresStore'
import Loader from '@/components/LoaderComponent.vue'
import Boton from '@/components/basic/BotonComponent.vue'
import type { FormPais, Conduccion, CreatePais, UpdatePais } from '@/types'

interface camposValidacion {
  hayError: boolean
  mensajesError: string[]
}
type vType = {
  nombre: camposValidacion
  capital: camposValidacion
  bandera_url: camposValidacion
  continente_id: camposValidacion
  conduccion: camposValidacion
  idiomas: camposValidacion
  lugares: camposValidacion
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
      lugaresEliminados: [] as number[],
      continentes: [
        { id: 1, nombre: 'Asia' },
        { id: 2, nombre: 'África' },
        { id: 3, nombre: 'Europa' },
        { id: 4, nombre: 'Oceanía' },
        { id: 5, nombre: 'Sudamérica' },
        { id: 6, nombre: 'Norteamérica' },
        { id: 7, nombre: 'Antártida' },
      ],
      form: {
        nombre: null,
        capital: null,
        continente_id: null,
        conduccion: null as Conduccion | null,
        bandera_url: null,
        idiomas: [],
      } as FormPais,
      v: {
        nombre: { hayError: false, mensajesError: [] as string[] },
        capital: { hayError: false, mensajesError: [] as string[] },
        continente_id: { hayError: false, mensajesError: [] as string[] },
        conduccion: { hayError: false, mensajesError: [] as string[] },
        bandera_url: { hayError: false, mensajesError: [] as string[] },
        idiomas: { hayError: false, mensajesError: [] as string[] },
        lugares: { hayError: false, mensajesError: [] as string[] },
      } as vType,
    }
  },
  computed: {
    ...mapState(usePaisesStore, { loadingPais: 'loading', errorPais: 'error', pais: 'item' }),
    ...mapState(useIdiomasStore, {
      loadingIdiomas: 'loading',
      errorIdiomas: 'error',
      idiomas: 'items',
    }),
    loading() {
      return this.loadingPais || this.loadingIdiomas
    },
    error() {
      return this.errorPais || this.errorIdiomas
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
      await usePaisesStore().getItem(this.id as number)
      this.form = {
        nombre: this.pais?.nombre ?? null,
        capital: this.pais?.capital ?? null,
        continente_id: this.pais?.continente['id'] ?? null,
        conduccion: this.pais?.conduccion || null,
        bandera_url: this.pais?.bandera_url ?? null,
        idiomas: this.pais?.idiomas?.map((i) => i.id) ?? [],
        lugares: this.pais?.lugares?.map((i) => ({ id: i.id, nombre: i.nombre })) ?? [],
      }
    }
    await useIdiomasStore().fetchAll()
  },
  methods: {
    validar() {
      Object.values(this.v).forEach((campo) => {
        campo.hayError = false
        campo.mensajesError = []
      })

      if (!this.form.nombre) {
        this.v.nombre.hayError = true
        this.v.nombre.mensajesError = ['Introduce el nombre del lugar']
      } else if (this.form.nombre.trim().length > 255) {
        this.v.nombre.hayError = true
        this.v.nombre.mensajesError.push('El nombre no puede superar los 255 caracteres')
      } else if (this.form.nombre.trim().length < 3) {
        this.v.nombre.hayError = true
        this.v.nombre.mensajesError.push('El nombre debe tener al menos 3 caracteres')
      }

      if (!this.form.capital) {
        this.v.capital.hayError = true
        this.v.capital.mensajesError = ['Introduce la capital de este país']
      } else if (this.form.capital.trim().length > 255) {
        this.v.capital.hayError = true
        this.v.capital.mensajesError.push('La capital no puede superar los 255 caracteres')
      }

      if (!this.form.continente_id) {
        this.v.continente_id.hayError = true
        this.v.continente_id.mensajesError = ['Selecciona un continente de la lista']
      }

      if (this.form.bandera_url) {
        const urlValida = /^https?:\/\/.+\.(jpg|jpeg|png|gif|webp|svg)(\?.*)?$/i.test(
          this.form.bandera_url.trim(),
        )
        if (!urlValida) {
          this.v.bandera_url.hayError = true
          this.v.bandera_url.mensajesError = [
            'Introduce una URL válida de imagen (jpg, png, gif, etc.)',
          ]
        }
      }
    },
    async handleSubmit() {
      this.validar()
      if (this.erroresValidacion) {
        return
      } else {
        if (this.editMode) {
          await usePaisesStore().updateItem(
            { id: Number(this.id), ...this.form } as UpdatePais,
            false,
          )
          if (this.lugaresEliminados?.length) {
            for (const id of this.lugaresEliminados) {
              if (
                confirm(
                  '¿Estás seguro de que deseas eliminar esos lugares permanentemente de tu Base de Datos?',
                )
              ) {
                await useLugaresStore().deleteItem(id)
              }
            }
            this.lugaresEliminados = []
          }
          alert('País actualizado correctamente')
        } else {
          await usePaisesStore().createItem({
            nombre: this.form.nombre,
            capital: this.form.capital,
            bandera_url: this.form.bandera_url,
            continente_id: this.form.continente_id,
            conduccion: this.form.conduccion ?? undefined,
            idiomas: this.form.idiomas,
          } as CreatePais)
          alert('País creado correctamente')
        }
        this.$router.push({ name: 'paisesAdmin' })
      }
    },
    cancelar() {
      this.$router.push({ name: 'paisesAdmin' })
    },
    eliminarLugar(id: number) {
      if (this.form.lugares) {
        this.form.lugares = this.form.lugares.filter((lugar) => lugar.id !== id)
        if (!this.lugaresEliminados) {
          this.lugaresEliminados = []
        }
        this.lugaresEliminados.push(id)
      }
    },
  },
})
</script>
