<template>
<Loader :loading="loading" :error="error">
  <div>
    <div class="max-w-xl mx-auto p-4">
      <h2 class="text-xl font-bold mb-4">{{ editMode ? 'Editar lugar' : 'Crear lugar' }}</h2>
      <form @submit.prevent="handleSubmit">
        <!-- Nombre -->
        <div class="mb-4">
          <label class="block mb-1">Nombre*</label>
          <input
            v-model="form.nombre"
            type="text"
            class="w-full border px-3 py-2 rounded"
            placeholder="Nombre del lugar"
          />
        </div>

        <!-- Pais -->
        <div class="mb-4">
          <label class="block mb-1">País*</label>
          <select v-model="form.pais_id" class="w-full border px-3 py-2 rounded">
            <option disabled value="">Selecciona un país</option>
            <option v-for="p in paises" :key="p.id" :value="p.id">
              {{ p.nombre }}
            </option>
          </select>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
          <label class="block mb-1">Descripción</label>
          <textarea
            v-model="form.descripcion"
            class="w-full border px-3 py-2 rounded"
            placeholder="Descripción el lugar"
          ></textarea>
        </div>

        <!-- Tipo de lugar -->
        <div class="mb-4">
          <label class="block mb-2 font-medium">Tipo de lugar</label>
          <div class="grid grid-cols-3 gap-2">
            <label
              v-for="tipoLugar in tiposLugar"
              :key="tipoLugar.id"
              class="flex items-center space-x-2"
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
        </div>

        <!-- Imagen lugar -->
        <div class="mb-4">
          <label class="block mb-1">Url imagen del lugar</label>
          <input
            v-model="form.imagen_url"
            type="text"
            class="w-full border px-3 py-2 rounded"
            placeholder="Url de la imagen del lugar"
          />
        </div>

        <!-- Localizacion -->
        <div class="mb-4">
          <label class="block mb-1">Localizacion</label>
          <input
            v-model="form.localizacion_url"
            type="text"
            class="w-full border px-3 py-2 rounded"
            placeholder="Url de la localizacion"
          />
        </div>

        <!-- Dirección Web-->
        <div class="mb-4">
          <label class="block mb-1">Dirección Web</label>
          <input
            v-model="form.web_url"
            type="text"
            class="w-full border px-3 py-2 rounded"
            placeholder="Dirección Web"
          />
        </div>
        <!-- Botón -->
        <Boton
          htmlType="submit"
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
        nombre: '',
        pais_id: 0,
        descripcion: '',
        tipoLugares:[] as number[],
        imagen_url: '',
        localizacion_url: '',
        web_url: '',
      },
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
    }
  },
  async created() {
    if(this.id){
      await useLugaresStore().getItem(this.id as number);
      this.form={
        nombre:this.lugar?.nombre ?? "",
        pais_id:this.lugar?.pais['id'] ?? 0,
        descripcion: this.lugar?.descripcion ?? "",
        imagen_url: this.lugar?.imagen_url ?? "",
        web_url: this.lugar?.web_url ?? "",
        localizacion_url: this.lugar?.localizacion_url ?? "",
        tipoLugares: this.lugar?.tipo_lugar?.map(i=>i.id) ?? [],
      }
    }
    await useTipoLugaresStore().fetchAll();
    await usePaisesStore().fetchAll();
  },
  methods: {
    async handleSubmit() {
        if (this.editMode) {
          await useLugaresStore().updateItem({ id: Number(this.id), ...this.form },false)
          alert('Lugar actualizado correctamente')
        } else {
          await useLugaresStore().createItem(this.form)
          alert('Lugar creado correctamente')
        }
        this.$router.push({ name: 'lugaresAdmin' })
    },
    cancelar() {
      this.$router.push({ name: 'lugaresAdmin' })
    }
  },
})
</script>