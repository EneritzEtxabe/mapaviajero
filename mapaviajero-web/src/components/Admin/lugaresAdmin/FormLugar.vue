<template>
<Loader :loading="loading">
  <div>
    <div class="max-w-xl mx-auto p-4">
      <h2 class="text-xl font-bold mb-4">{{ editMode ? 'Editar lugar' : 'Crear lugar' }}</h2>
      <form @submit.prevent="handleSubmit">
        <!-- Nombre -->
        <div class="mb-4">
          <label class="block mb-1">Nombre</label>
          <input
            v-model="form.nombre"
            type="text"
            class="w-full border px-3 py-2 rounded"
            placeholder="Nombre del lugar"
          />
        </div>

        <!-- Pais -->
        <div class="mb-4">
          <label class="block mb-1">País</label>
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
import { defineComponent } from 'vue'
import { usePaisesStore } from '@/stores/paisesStore'
import { useLugaresStore } from '@/stores/lugaresStore'
import {useTipoLugaresStore} from '@/stores/tipoLugaresStore'
import Loader from '@/components/Loader.vue'
import Boton from '@/components/basic/Boton.vue'

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
      paisesStore:usePaisesStore(),
      lugaresStore:useLugaresStore(),
      tipoLugaresStore:useTipoLugaresStore(),
      loading:true,
      form: {
        nombre: '',
        pais_id: '',
        descripcion: '',
        tipoLugares:[],
        imagen_url: '',
        localizacion_url: '',
        web_url: '',
      },
    }
  },
  computed: {
    lugar(){
      return this.lugaresStore.item
    },
    tiposLugar(){
      return this.tipoLugaresStore.items
    },
    paises(){
      return this.paisesStore.items 
    },
    editMode(){
    return !!this.id
    }
  },
  async created() {
    this.loading=true;
    if(this.id){
      await this.lugaresStore.getItem(this.id as number);
      this.form={
        nombre:this.lugar.nombre,
        pais_id:this.lugar.pais['id'],
        descripcion: this.lugar.descripcion,
        imagen_url: this.lugar.imagen_url,
        web_url: this.lugar.web_url,
        localizacion_url: this.lugar.localizacion_url,
        tipoLugares: this.lugar.tipo_lugar.map(i=>i.id),
      }
    }
    await this.tipoLugaresStore.fetchAll();
    await this.paisesStore.fetchAll();
    this.loading=false;
  },
  methods: {
    async handleSubmit() {
      try {
        if (this.editMode) {
          await this.lugaresStore.updateItem({ id: this.id, ...this.form },false)
          alert('Lugar actualizado correctamente')
        } else {
          await this.lugaresStore.createItem(this.form)
          alert('Lugar creado correctamente')
        }
      } catch (e) {
        console.error('Error al guardar el lugar:', e)
        alert('Ha ocurrido un error al guardar')
      }finally{
        this.$router.push({ name: 'lugaresAdmin' })
      }
    },
    cancelar() {
      this.$router.push({ name: 'lugaresAdmin' })
    }
  },
})
</script>