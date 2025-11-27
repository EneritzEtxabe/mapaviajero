<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/25">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
      <h3 class="text-lg font-semibold mb-4">Crear nuevo usuario</h3>

      <form @submit.prevent class="space-y-4">
        <div>
          <label class="block mb-1 font-medium">Nombre*:</label>
          <input
            type="text"
            v-model="nuevoUsuario.nombre"
            class="w-full border px-3 py-2 rounded"
            :class="{ 'border-red-500': v.nombre.hayError }"
            @input=clearError
          />
          <p v-if="v.nombre.hayError" class="text-red-600 text-sm mt-1">
            {{ v.nombre.mensajesError[0] }}
          </p>
        </div>
        <div>
          <label class="block mb-1 font-medium">Email*:</label>
          <input
            type="email"
            v-model="nuevoUsuario.email"
            class="w-full border px-3 py-2 rounded"
            :class="{ 'border-red-500': v.email.hayError }"
            @input=clearError
          />
          <p v-if="v.email.hayError" class="text-red-600 text-sm mt-1">
            {{ v.email.mensajesError[0] }}
          </p>
        </div>
        <div>
          <label class="block mb-1 font-medium">Contraseña*:</label>
          <input
            type="password"
            v-model="nuevoUsuario.password"
            class="w-full border px-3 py-2 rounded"
            :class="{ 'border-red-500': v.password.hayError }"
            @input=clearError
          />
          <p v-if="v.password.hayError" class="text-red-600 text-sm mt-1">
            {{ v.password.mensajesError[0] }}
        </p>
        </div>

        <div class="flex justify-end space-x-2">
          <Boton
            @click="crearUsuario()"
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
import { mapState } from 'pinia'
import { useUsuariosStore } from '@/stores/usuariosStore'
import Boton from '../basic/BotonComponent.vue';

interface camposValidacion{
  hayError:boolean,
  mensajesError: string[]
};
type vType={
  nombre: camposValidacion,
  email: camposValidacion,
  password: camposValidacion
};
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
                v:{
                  nombre: { hayError: false, mensajesError: [] as string[] },
                  email: { hayError: false, mensajesError: [] as string[] },
                  password: { hayError: false, mensajesError: [] as string[] }
                } as vType
            }
        },
        computed:{
            // usuariosStore() {
            //     return useUsuariosStore()
            // },
            ...mapState(useUsuariosStore, {loading:'loading', error:'error'}),
            erroresValidacion():boolean{
              return Object.values(this.v).some((field:{hayError:boolean, mensajesError:string[]}) => field.hayError)
            },
        },
        watch: {
          nuevoUsuario: {
            handler() {
              this.validar()
            },
            deep: true,
          }
        },
        methods:{
          validar(){
            Object.values(this.v).forEach(campo => {
              campo.hayError = false
              campo.mensajesError = []
            })

            if (!this.nuevoUsuario.nombre){
              this.v.nombre.hayError = true
              this.v.nombre.mensajesError = ['Introduce tu nombre']
            }else if (this.nuevoUsuario.nombre.trim().length > 255) {
              this.v.nombre.hayError = true
              this.v.nombre.mensajesError.push('El nombre no puede ser más lago que 255 caracteres.')
            }
          
            if (!this.nuevoUsuario.email){
              this.v.email.hayError = true  
              this.v.email.mensajesError = ['Introduce tu email']
            }else{
              if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.nuevoUsuario.email.trim())) {
                this.v.email.hayError = true
                this.v.email.mensajesError=['Introduce un email válido (maria@ebis.com)']
              }
            }
        
            if (!this.nuevoUsuario.password){
              this.v.password.hayError = true
              this.v.password.mensajesError = ['Introduce la contraseña']
            }else if (this.nuevoUsuario.password.trim().length < 8) {
              this.v.password.hayError = true
              this.v.password.mensajesError.push('La contraseña tiene que tener como mínimo 8 caracteres')
            }
          },
            async crearUsuario() {
              this.validar()
              if(this.erroresValidacion){
                return
              }else{
                 // try {
                  await useUsuariosStore().createItem(this.nuevoUsuario)
                  alert('Usuario creado correctamente')
                  this.nuevoUsuario = {nombre:'', email: '', password: ''}
                  this.$emit('usuarioCreado')
                // } catch (e) {
                //     alert('Error al crear usuario')
                //     console.error(e)
                // }
              }
            },
            clearError() {
              useUsuariosStore().error = null;
            },
        }
    })
</script>
