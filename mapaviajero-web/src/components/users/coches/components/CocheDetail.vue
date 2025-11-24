<template>
    <div class="bg--white rounded-lg shadow-md p-4 hover:shadow-lg transition-all">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTi579Fh8jxOoGIgx2ChaZZnbKy-gfoK7A6QQ&s" alt="Icono coche" class="w-20 h-auto mb-2 mx-auto" />
        <p class="text-gray-600 text-md"><strong>Marca:</strong> {{coche.marca.nombre }}</p>
        <p class="text-gray-600 text-md"><strong>Carrocería:</strong> {{coche.carroceria.nombre }}</p>
        <p class="text-gray-600 text-md"><strong>Plazas:</strong> {{coche.nPlazas }}</p>
        <p class="text-gray-600 text-md"><strong>Año:</strong> {{coche.ano }}</p>
        <p class="text-gray-600 text-md"><strong>Cambio:</strong> {{coche.cambio }}</p>
        <p class="text-gray-600 text-md pb-5"><strong>País:</strong> {{coche.pais.nombre }}</p>
        <Boton
            type="generalDark"
            :label="'Lo quiero'"
            :icon="'M12 4v16m8-8H4'"
            :title="'Alquilar coche'"
            @click="abrirModal"
        />
    </div>
    <!-- Modal -->
    <div
      v-if="mostrarModal"
      class="fixed inset-0 bg-black/25 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
        <h2 class="text-lg font-semibold mb-4">¡Tu petición se ha registrado con éxito!</h2>
        <p class="text-gray-700 mb-6">
          Nuestro equipo se pondrá en contácto contigo en unos días para gestionarlo todo.
        </p>
        <button
          @click="cerrarModal"
          class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700"
        >
          Cerrar
        </button>
      </div>
    </div>
</template>

<script lang="ts">
import Boton from '@/components/basic/BotonComponent.vue';

    export default{
        props:['coche'],
        components:{
            Boton
        },
        data(){
            return{
                mostrarModal:false,
            }
        },
        methods:{
            abrirModal(){
                this.mostrarModal=true
            },
            cerrarModal(){
                this.mostrarModal=false
            }
        }
    }
</script>