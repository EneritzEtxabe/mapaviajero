<template>
<Loader :loading="loading" :error="error">
  <div>
    <div class="max-w-xl mx-auto p-4">
      <h2 class="text-xl font-bold mb-4">{{ editMode ? 'Editar lugar' : 'Crear lugar' }}</h2>
      <form @submit.prevent>
        <!-- Nombre -->
        <div class="mb-4">
          <label class="block mb-1">Nombre*</label>
          <input
            v-model="form.nombre"
            type="text"
            class="w-full border px-3 py-2 rounded"
            :class="{ 'border-red-500': v.nombre.hayError }"
            placeholder="Nombre del lugar"
          />
          <p v-if="v.nombre.hayError" class="text-red-600 text-sm mt-1">
            {{ v.nombre.mensajesError[0] }}
          </p>
        </div>

        <!-- Pais -->
        <div class="mb-4">
          <label class="block mb-1">País*</label>
          <select v-model="form.pais_id" class="w-full border px-3 py-2 rounded" :class="{ 'border-red-500': v.pais_id.hayError }">
            <option disabled value="">Selecciona un país</option>
            <option v-for="p in paises" :key="p.id" :value="p.id">
              {{ p.nombre }}
            </option>
          </select>
          <p v-if="v.pais_id.hayError" class="text-red-600 text-sm mt-1">
            {{ v.pais_id.mensajesError[0] }}
          </p>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
          <label class="block mb-1">Descripción</label>
          <textarea
            v-model="form.descripcion"
            class="w-full border px-3 py-2 rounded"
            :class="{ 'border-red-500': v.descripcion.hayError }"
            placeholder="Descripción el lugar"
          ></textarea>
          <p v-if="v.descripcion.hayError" class="text-red-600 text-sm mt-1">
            {{ v.descripcion.mensajesError[0] }}
          </p>
        </div>

        <!-- Tipo de lugar -->
        <div class="mb-4">
          <label class="block mb-2 font-medium">Tipo de lugar</label>
          <div class="grid grid-cols-3 gap-2">
            <label
              v-for="tipoLugar in tiposLugar"
              :key="tipoLugar.id"
              class="flex items-center space-x-2"
              :class="{ 'border-red-500': v.tipoLugar.hayError }"
            >
              <input
                type="checkbox"
                :value="tipoLugar.id"
                v-model="form.tipoLugares"
                class="accent-blue-600"
              />
              <span>{{ tipoLugar.nombre }}</span>
            </label>
          </div>
          <p v-if="v.tipoLugar.hayError" class="text-red-600 text-sm mt-1">
            {{ v.tipoLugar.mensajesError[0] }}
          </p>
        </div>

        <!-- Imagen lugar -->
        <div class="mb-4">
          <label class="block mb-1">Url imagen del lugar</label>
          <input
            v-model="form.imagen_url"
            type="text"
            class="w-full border px-3 py-2 rounded"
            :class="{ 'border-red-500': v.imagen_url.hayError }"
            placeholder="Url de la imagen del lugar"
          />
          <p v-if="v.imagen_url.hayError" class="text-red-600 text-sm mt-1">
            {{ v.imagen_url.mensajesError[0] }}
          </p>
        </div>

        <!-- Localizacion -->
        <div class="mb-4">
          <label class="block mb-1">Localizacion</label>
          <input
            v-model="form.localizacion_url"
            type="text"
            class="w-full border px-3 py-2 rounded"
            :class="{ 'border-red-500': v.localizacion_url.hayError }"
            placeholder="Url de la localizacion"
          />
          <p v-if="v.localizacion_url.hayError" class="text-red-600 text-sm mt-1">
            {{ v.localizacion_url.mensajesError[0] }}
          </p>
        </div>

        <!-- Dirección Web-->
        <div class="mb-4">
          <label class="block mb-1">Dirección Web</label>
          <input
            v-model="form.web_url"
            type="text"
            class="w-full border px-3 py-2 rounded"
            :class="{ 'border-red-500': v.web_url.hayError }"
            placeholder="Dirección Web"
          />
          <p v-if="v.web_url.hayError" class="text-red-600 text-sm mt-1">
            {{ v.web_url.mensajesError[0] }}
          </p>
        </div>
        <!-- Botón -->
        <Boton
          @click="handleSubmit()"
          type="create"
          title="Crear"
          :icon="'M5 13l4 4L19 7'"
          :label="editMode ? 'Actualizar' : 'Crear'"
          :customClasses="'px-4 py-2 rounded border'"
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
import { mapState } from 'pinia';
import { defineComponent } from 'vue'
import { usePaisesStore } from '@/stores/paisesStore'
import { useLugaresStore } from '@/stores/lugaresStore'
import {useTipoLugaresStore} from '@/stores/tipoLugaresStore'
import Loader from '@/components/LoaderComponent.vue'
import Boton from '@/components/basic/BotonComponent.vue'
import type { CreateLugar } from '@/types';

interface camposValidacion{
  hayError:boolean,
  mensajesError: string[]
};
type vType={
  nombre: camposValidacion,
  pais_id: camposValidacion,
  descripcion: camposValidacion,
  tipoLugar: camposValidacion,
  imagen_url:camposValidacion,
  localizacion_url: camposValidacion,
  web_url: camposValidacion
};
export default defineComponent({
  components:{
    Loader,
    Boton
  },
  props: {
    id: {
      type: [String, Number],
      required: false
    }
  },
  data() {
    return {
      form: {
        nombre: null,
        pais_id: null,
        descripcion: null,
        tipoLugares:[],
        imagen_url: null,
        localizacion_url: null,
        web_url: null,
      } as CreateLugar,
      v:{
        nombre: { hayError: false, mensajesError: [] as string[] },
        pais_id: { hayError: false, mensajesError: [] as string[] },
        descripcion: { hayError: false, mensajesError: [] as string[] },
        tipoLugar: { hayError: false, mensajesError: [] as string[] },
        imagen_url: { hayError: false, mensajesError: [] as string[] },
        localizacion_url: { hayError: false, mensajesError: [] as string[] },
        web_url: { hayError: false, mensajesError: [] as string[] },
      } as vType
    }
  },
  computed: {
    ...mapState(useLugaresStore,{loadingLugar:'loading', errorLugar:'error', lugar:'item'}),
    ...mapState(useTipoLugaresStore,{loadingTipoLugares:'loading', errorTipoLugares:'error', tiposLugar:'items'}),
    ...mapState(usePaisesStore,{loadingPaises:'loading', errorPaises:'error', paises:'items'}),
    loading(){
      return(
        this.loadingLugar || this.loadingTipoLugares || this.loadingPaises
      )
    },
    error(){
      return(
        this.errorLugar || this.errorTipoLugares || this.errorPaises
      )
    },
    editMode(){
      return !!this.id
    },
    erroresValidacion():boolean{
      return Object.values(this.v).some((field:{hayError:boolean, mensajesError:string[]}) => field.hayError)
    },
  },
  async created() {
    if(this.id){
      await useLugaresStore().getItem(this.id as number);
      this.form={
        nombre:this.lugar?.nombre ?? null,
        pais_id:this.lugar?.pais['id'] ?? null,
        descripcion: this.lugar?.descripcion ?? null,
        imagen_url: this.lugar?.imagen_url ?? null,
        web_url: this.lugar?.web_url ?? null,
        localizacion_url: this.lugar?.localizacion_url ?? null,
        tipoLugares: this.lugar?.tipo_lugar?.map(i=>i.id) ?? [],
      }
    }
    await useTipoLugaresStore().fetchAll();
    await usePaisesStore().fetchAll();
  },
  methods: {
    validar(){
      Object.values(this.v).forEach(campo => {
        campo.hayError = false
        campo.mensajesError = []
      })
     
      if (!this.form.nombre){
        this.v.nombre.hayError = true  
        this.v.nombre.mensajesError = ['Introduce el nombre del lugar']
      }else if (this.form.nombre.trim().length > 255) {
        this.v.nombre.hayError = true
        this.v.nombre.mensajesError.push('El nombre no puede tener más de 255 caracteres')
      }else if (this.form.nombre.trim().length < 3) {
        this.v.nombre.hayError = true
        this.v.nombre.mensajesError.push('El nombre debe tener al menos 3 caracteres')
      }
  
      if (!this.form.pais_id){
        this.v.pais_id.hayError = true
        this.v.pais_id.mensajesError = ['Selecciona un país de la lista']
      }

      if(this.form.imagen_url){
        const urlValida = /^https?:\/\/.+\.(jpg|jpeg|png|gif|webp|svg)(\?.*)?$/i.test(this.form.imagen_url.trim())
        if (!urlValida) {
          this.v.imagen_url.hayError = true
          this.v.imagen_url.mensajesError = ['Introduce una URL válida de imagen (jpg, png, gif, etc.)']
        }
      }

      if(this.form.localizacion_url){
        const urlValida = /^https:\/\/www\.google\.com\/maps\/embed\?pb=/.test(this.form.localizacion_url.trim())
        if (!urlValida) {
          this.v.localizacion_url.hayError = true
          this.v.localizacion_url.mensajesError = ['Introduce una URL válida para un mapa Embebido de Google Maps']
        }
      }

      if(this.form.web_url){
        const urlValida = /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/.test(this.form.web_url.trim())
        if (!urlValida) {
          this.v.web_url.hayError = true
          this.v.web_url.mensajesError = ['Introduce una URL válida']
        }
      }
    },
    async handleSubmit() {
      this.validar()
      if(this.erroresValidacion){
        return
      }else{
        if (this.editMode) {
          await useLugaresStore().updateItem({ id: Number(this.id), ...this.form },false)
          alert('Lugar actualizado correctamente')
        } else {
          await useLugaresStore().createItem(this.form)
          alert('Lugar creado correctamente')
        }
        this.$router.push({ name: 'lugaresAdmin' })
      }
    },
    cancelar() {
      this.$router.push({ name: 'lugaresAdmin' })
    }
  },
})
</script>