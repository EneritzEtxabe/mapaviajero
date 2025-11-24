<template>
<Loader :loading="loading" :error="error">
  <div>
    <div class="max-w-xl mx-auto p-4">
      <h2 class="text-xl font-bold mb-4">{{ editMode ? 'Editar coche' : 'Crear coche' }}</h2>
      <form @submit.prevent="handleSubmit">
        <!-- Marca -->
        <div class="mb-4">
          <label class="block mb-1">Marca*</label>
          <select v-model="form.marca_id" class="w-full border px-3 py-2 rounded" required>
            <option disabled value="">Selecciona una marca</option>
            <option v-for="m in marcasCoche" :key="m.id" :value="m.id">
              {{ m.nombre }}
            </option>
          </select>
        </div>

        <!-- Carroceria -->
        <div class="mb-4">
          <label class="block mb-1">Carrocería*</label>
          <select v-model="form.carroceria_id" class="w-full border px-3 py-2 rounded" required>
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
          <label class="block mb-1">Nº plazas*</label>
          <select v-model="form.nPlazas" class="w-full border px-3 py-2 rounded" required>
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
          <label class="block mb-1">Coste/Día (euros)*</label>
          <input
            v-model="form.costeDia"
            type="number"
            class="w-full border px-3 py-2 rounded"
            placeholder="Coste por día"
            required
          />
        </div>
        <!-- País -->
        <div class="mb-4">
          <label class="block mb-1">País*</label>
          <select v-model="form.pais_id" class="w-full border px-3 py-2 rounded" required>
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
import { mapState } from 'pinia';
import { defineComponent } from 'vue'
import { usePaisesStore } from '@/stores/paisesStore'
import { useCochesStore } from '@/stores/cochesStore'
import { useMarcasCocheStore } from '@/stores/marcasCocheStore'
import { useCarroceriasCocheStore } from '@/stores/carroceriasCocheStore'
import Loader from '@/components/LoaderComponent.vue'
import Boton from '@/components/basic/BotonComponent.vue'
import type { Estado, Cambio} from '@/types'

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
      form:{
        marca_id:0,
        carroceria_id: 0,
        ano: 0,
        nPlazas:0,
        cambio: null as Cambio | null,
        estado: null as Estado | null,
        costeDia: 0,
        pais_id:0
      },
    }
  },
  computed: {
    ...mapState(useCochesStore,{loadingCoche:'loading', errorCoche:'error', coche:'item'}),
    ...mapState(usePaisesStore,{loadingPaises:'loading', errorPaises:'error', paises:'items'}),
    ...mapState(useMarcasCocheStore,{loadingMarcasCoche:'loading', errorMarcasCoche:'error', marcasCoche:'items'}),
    ...mapState(useCarroceriasCocheStore,{loadingCarroceriasCoche:'loading', errorCarroceriasCoche:'error', carroceriasCoche:'items'}),
    loading(){
      return(
        this.loadingCoche || this.loadingPaises || this.loadingMarcasCoche || this.loadingCarroceriasCoche
      )
    },
    error(){
      return(
        this.errorCoche || this.errorPaises || this.errorMarcasCoche ||this.errorCarroceriasCoche
      )
    },
    editMode(){
      return !!this.id
    }
  },
  async created() {
    if(this.id){
      await useCochesStore().getItem(this.id as number);
      this.form={
        marca_id: this.coche?.marca['id'] ?? 0,
        carroceria_id: this.coche?.carroceria['id'] ?? 0,
        ano:this.coche?.ano ?? 0,
        nPlazas:this.coche?.nPlazas ?? 0,
        cambio: this.coche?.cambio ?? null,
        estado: this.coche?.estado ?? null,
        costeDia:this.coche?.costeDia ?? 0,
        pais_id:this.coche?.pais['id'] ?? 0,
      }
    }
    await usePaisesStore().fetchAll();
    await useMarcasCocheStore().fetchAll();
    await useCarroceriasCocheStore().fetchAll();
  },
  methods: {
    async handleSubmit() {
        if (this.editMode) {
          await useCochesStore().updateItem({ id:Number(this.id!), ...this.form },false)
          alert('Coche actualizado correctamente')
        } else {
          await useCochesStore().createItem(this.form)
          alert('Coche creado correctamente')
        }
        this.$router.push({ name: 'cochesAdmin' })
    },
    cancelar() {
      this.$router.push({ name: 'cochesAdmin' })
    }
  },
})
</script>