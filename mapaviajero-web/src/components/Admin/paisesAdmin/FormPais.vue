<template>
<Loader :loading="loading">
  <div>
    <div class="max-w-xl mx-auto p-4">
      <h2 class="text-xl font-bold mb-4">{{ editMode ? 'Editar país' : 'Crear país' }}</h2>
      <form @submit.prevent="handleSubmit">
        <!-- Nombre -->
        <div class="mb-4">
          <label class="block mb-1">Nombre</label>
          <input
            v-model="form.nombre"
            type="text"
            class="w-full border px-3 py-2 rounded"
            placeholder="Nombre del país"
          />
        </div>
        <!-- Capital -->
        <div class="mb-4">
          <label class="block mb-1">Capital</label>
          <input
            v-model="form.capital"
            type="text"
            class="w-full border px-3 py-2 rounded"
            placeholder="Capital del país"
          />
        </div>

        <!-- Bandera -->
        <div class="mb-4">
          <label class="block mb-1">Url de la bandera del país</label>
          <input
            v-model="form.bandera_url"
            type="text"
            class="w-full border px-3 py-2 rounded"
            placeholder="Url de la bandera del país"
          />
        </div>

        <!-- Continente -->
        <div class="mb-4">
          <label class="block mb-1">Continente</label>
          <select v-model="form.continente_id" class="w-full border px-3 py-2 rounded">
            <option disabled value="">Selecciona un continente</option>
            <option v-for="c in continentes" :key="c.id" :value="c.id">
              {{ c.nombre }}
            </option>
          </select>
        </div>

        <!-- Conducción -->
        <div class="mb-4">
          <label class="block mb-1">Tipo de conducción</label>
          <select v-model="form.conduccion" class="w-full border px-3 py-2 rounded">
            <option value="izquierda">Izquierda</option>
            <option value="derecha">Derecha</option>
          </select>
        </div>

        <!-- Idiomas -->
          <div class="mb-4">
            <label class="block mb-2 font-medium">Idiomas</label>
            <div class="grid grid-cols-3 gap-2">
              <label
                v-for="idioma in idiomas"
                :key="idioma.id"
                class="flex items-center space-x-2"
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
              <!-- <button
                @click.prevent="eliminarLugar(lugar.id)"
                class="text-red-500 hover:underline text-sm"
              >
                Eliminar
              </button> -->
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
          htmlType="submit"
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
import { defineComponent } from 'vue'
import { usePaisesStore } from '@/stores/paisesStore'
import { useIdiomasStore } from '@/stores/idiomasStore'
import { useLugaresStore } from '@/stores/lugaresStore'
import Loader from '@/components/Loader.vue'
import Boton from '@/components/basic/Boton.vue'
// import LugarContainer from '@/components/users/lugares/LugarContainer.vue'

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
      idiomasStore:useIdiomasStore(),
      lugaresStore:useLugaresStore(),
      loading:true,
      continentes: [
        { id: 1, nombre: 'Asia' },
        { id: 2, nombre: 'África' },
        { id: 3, nombre: 'Europa' },
        { id: 4, nombre: 'Oceanía' },
        { id: 5, nombre: 'Sudamérica' },
        { id: 6, nombre: 'Norteamérica' },
        { id: 7, nombre: 'Antártida' }
      ],
      form: {
        nombre: '',
        capital: '',
        continente_id: '',
        conduccion: '',
        bandera_url: '',
        idiomas: [],
        lugares:[],
      },
    }
  },
  computed: {
    pais(){
      return this.paisesStore.item
    },
    idiomas(){
      return this.idiomasStore.items
    },
    editMode(){
    return !!this.id
    }
  },
  async created() {
    this.loading=true;
    if(this.id){
      await this.paisesStore.getItem(this.id as number);
      this.form={
        nombre:this.pais.nombre,
        capital:this.pais.capital,
        continente_id: this.pais.continente['id'],
        conduccion: this.pais.conduccion,
        bandera_url: this.pais.bandera_url,
        idiomas:this.pais.idiomas.map(i=>i.id),
        lugares:this.pais.lugares,
      }
    }
    await this.idiomasStore.fetchAll();
    this.loading=false;
  },
  methods: {
    async handleSubmit() {
      try {
        if (this.editMode) {
          await this.paisesStore.updateItem({ id: this.id, ...this.form },false)
          if (this.lugaresEliminados?.length) {
            for (const id of this.lugaresEliminados) {
              if (confirm('¿Estás seguro de que deseas eliminar esos lugares permanentemente de tu Base de Datos?')) {
                try{
                   await this.lugaresStore.deleteItem(id);
                }catch(err){
                  this.error=err
                }
              }
            }
            this.lugaresEliminados = [];
          }
          alert('País actualizado correctamente')
        } else {
          await this.paisesStore.createItem(this.form)
          alert('País creado correctamente')
        }
        // this.$emit('success') // Notificar al componente padre (si se usa)
      } catch (e) {
        console.error('Error al guardar el país:', e)
        alert('Ha ocurrido un error al guardar')
      }finally{
        this.$router.push({ name: 'paisesAdmin' })
      }
    },
    cancelar() {
      this.$router.push({ name: 'paisesAdmin' })
    },
    eliminarLugar(id:number){
      this.form.lugares = this.form.lugares.filter(lugar =>lugar.id!== id)
      if (!this.lugaresEliminados) {
        this.lugaresEliminados = [];
      }
      this.lugaresEliminados.push(id);
    }
  },
})
</script>