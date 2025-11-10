<template>
<Loader :loading="loading">
  <div>
    <div class="max-w-xl mx-auto p-4">
      <h2 class="text-xl font-bold mb-4">{{ editMode ? 'Editar coche' : 'Crear coche' }}</h2>
      <form @submit.prevent="handleSubmit">
        <!-- Marca -->
        <div class="mb-4">
          <label class="block mb-1">Marca</label>
          <select v-model="form.marca_id" class="w-full border px-3 py-2 rounded">
            <option disabled value="">Selecciona una marca</option>
            <option v-for="m in marcasCoche" :key="m.id" :value="m.id">
              {{ m.nombre }}
            </option>
          </select>
        </div>

        <!-- Carroceria -->
        <div class="mb-4">
          <label class="block mb-1">Carrocería</label>
          <select v-model="form.carroceria_id" class="w-full border px-3 py-2 rounded">
            <option disabled value="">Selecciona una carrocería</option>
            <option v-for="c in carroceriasCoche" :key="c.id" :value="c.id">
              {{ c.nombre }}
            </option>
          </select>
        </div>
        <!-- Año -->
        <div class="mb-4">
          <label class="block mb-1">Año de matriculación</label>
          <input
            v-model="form.ano"
            type="number"
            class="w-full border px-3 py-2 rounded"
            placeholder="Año de matriculacion del coche"
          />
        </div>
        <!-- Nº plazas -->
        <div class="mb-4">
          <label class="block mb-1">Nº plazas</label>
          <select v-model="form.nPlazas" class="w-full border px-3 py-2 rounded">
            <option disabled value="">Selecciona el Nº plazas del coche</option>
            <option v-for="nPlazas in [2,4,5,7]" :key="nPlazas" :value="nPlazas">
              {{ nPlazas }}
            </option>
          </select>
        </div>

        <!-- Cambio -->
        <div class="mb-4">
          <label class="block mb-1">Cambio</label>
          <select v-model="form.cambio" class="w-full border px-3 py-2 rounded">
            <option disabled value="">Selecciona el tipo de cambio</option>
            <option v-for="cambio in ['automático', 'manual']" :key="cambio" :value="cambio">
              {{ cambio }}
            </option>
          </select>
        </div>
        <!-- Estado -->
        <div class="mb-4">
          <label class="block mb-1">Estado</label>
          <select v-model="form.estado" class="w-full border px-3 py-2 rounded">
            <option disabled value="">Selecciona un estado</option>
            <option v-for="estado in ['disponible', 'mantenimiento']" :key="estado" :value="estado">
              {{ estado }}
            </option>
          </select>
        </div>
        <!-- Coste/Día-->
         <div class="mb-4">
          <label class="block mb-1">Coste/Día (euros)</label>
          <input
            v-model="form.costeDia"
            type="number"
            class="w-full border px-3 py-2 rounded"
            placeholder="Coste por día"
          />
        </div>
        <!-- País -->
        <div class="mb-4">
          <label class="block mb-1">País</label>
          <select v-model="form.pais_id" class="w-full border px-3 py-2 rounded">
            <option disabled value="">Seleccionas un país</option>
            <option v-for="p in paises" :key="p.id" :value="p.id">
              {{ p.nombre}}
            </option>
          </select>
        </div>
        <!-- Botón -->
        <Boton
          htmlType="submit"
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
import { defineComponent } from 'vue'
import { usePaisesStore } from '@/stores/paisesStore'
import { useCochesStore } from '@/stores/cochesStore'
import { useMarcasCocheStore } from '@/stores/marcasCocheStore'
import { useCarroceriasCocheStore } from '@/stores/carroceriasCocheStore'
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
      cochesStore:useCochesStore(),
      marcasCocheStore:useMarcasCocheStore(),
      carroceriasCocheStore:useCarroceriasCocheStore(),
      loading:true,
      form: {
        marca_id: '',
        carroceria_id: '',
        ano: '',
        nPlazas:'',
        cambio: '',
        estado: '',
        costeDia: '',
        pais_id:''
      },
    }
  },
  computed: {
    coche(){
      return this.cochesStore.item
    },
    paises(){
      return this.paisesStore.items 
    },
    marcasCoche(){
      return this.marcasCocheStore.items 
    },
    carroceriasCoche(){
      return this.carroceriasCocheStore.items 
    },
    editMode(){
    return !!this.id
    }
  },
  async created() {
    this.loading=true;
    if(this.id){
      await this.cochesStore.getItem(this.id as number);
      this.form={
        marca_id: this.coche.marca['id'],
        carroceria_id: this.coche.carroceria['id'],
        ano:this.coche.ano,
        nPlazas:this.coche.nPlazas,
        cambio: this.coche.cambio,
        estado: this.coche.estado,
        costeDia:this.coche.costeDia,
        pais_id:this.coche.pais['id'],
      }
    }
    await this.paisesStore.fetchAll();
    await this.marcasCocheStore.fetchAll();
    await this.carroceriasCocheStore.fetchAll();
    this.loading=false;
  },
  methods: {
    async handleSubmit() {
      try {
        if (this.editMode) {
          await this.cochesStore.updateItem({ id: this.id, ...this.form },false)
          alert('Coche actualizado correctamente')
        } else {
          await this.cochesStore.createItem(this.form)
          alert('Coche creado correctamente')
        }
        // this.$emit('success') // Notificar al componente padre (si se usa)
      } catch (e) {
        console.error('Error al guardar el coche:', e)
        alert('Ha ocurrido un error al guardar')
      }finally{
        this.$router.push({ name: 'cochesAdmin' })
      }
    },
    cancelar() {
      this.$router.push({ name: 'cochesAdmin' })
    }
  },
})
</script>