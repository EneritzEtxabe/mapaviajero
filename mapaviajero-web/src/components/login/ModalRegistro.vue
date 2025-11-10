<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/25">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
      <h3 class="text-lg font-semibold mb-4">Crear nuevo usuario</h3>

      <form @submit.prevent="crearUsuario" class="space-y-4">
        <div>
          <label class="block mb-1 font-medium">Nombre*:</label>
          <input
            type="text"
            v-model="nuevoUsuario.nombre"
            required
            class="w-full border px-3 py-2 rounded"
          />
        </div>
        <div>
          <label class="block mb-1 font-medium">Email*:</label>
          <input
            type="email"
            v-model="nuevoUsuario.email"
            required
            class="w-full border px-3 py-2 rounded"
          />
        </div>
        <div>
          <label class="block mb-1 font-medium">Contraseña*:</label>
          <input
            type="password"
            v-model="nuevoUsuario.password"
            class="w-full border px-3 py-2 rounded"
          />
        </div>

        <div class="flex justify-end space-x-2">
          <Boton
            htmlType="submit"
            title="Crear"
            type="create"
            label="Crear"
            :customClasses="'px-4 py-2 border'"
          />
          <Boton
            type="delete"
            label="Cancelar"
            title="Cancelar"
            @click="$emit('cerrar')"
            :customClasses="'px-4 py-2 ml-2 border'"
          />
        </div>
      </form>

      <!-- Botón X -->
      <button @click="$emit('cerrar')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
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
import { defineComponent } from 'vue';
import { useUsuariosStore } from '@/stores/usuariosStore'
import Boton from '../basic/Boton.vue';

    export default defineComponent({
        components:{
            Boton
        },
        data() {
            return{
                nuevoUsuario: {
                    nombre: '',
                    email: '',
                    password: '',
                },
            }
        },
        computed:{
            usuariosStore() {
                return useUsuariosStore()
            },
        },
        methods:{
            async crearUsuario() {
            try {
                await this.usuariosStore.createItem(this.nuevoUsuario)
                alert('Usuario creado correctamente')
                this.nuevoUsuario = {nombre:'', email: '', password: ''}
                this.$emit('usuarioCreado')
            } catch (e) {
                alert('Error al crear usuario')
                console.error(e)
            }
            },
        }
    })
</script>
