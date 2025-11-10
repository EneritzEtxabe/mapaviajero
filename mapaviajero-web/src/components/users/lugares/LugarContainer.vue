<template>
    <ImagenCabecera
        :imagen="lugar.imagen_url"
        alt="Imagen del lugar"
        :texto="lugar.nombre"
    />
    <div class="max-w-6xl mx-auto p-6">
        <h2 class="text-3xl sm:text-4xl font-bold mt-15 text-center f-color--dark tracking-wide">INFORMACIÓN GENERAL</h2>
        <!-- Separador -->
        <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
        <div class="flex flex-col md:flex-row items-center md:items-center gap-2">
            <div class="w-full md:w-1/3 flex flex-col items-center md:items-center">
                <div class="relative rounded-lg overflow-hidden shadow-lg group h-50">
                    <a :href="lugar.web_url" target="_blanck">
                        <img
                            src="https://cdn-icons-png.flaticon.com/512/5082/5082281.png"
                            alt="Enlace a la web del lugar"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                        />
                        <!-- Capa oscura -->
                        <div
                            class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition duration-300"
                        ></div>

                        <!-- Contenido sobre la imagen -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white z-10">
                            <h3 class="text-2xl font-bold mb-10 ml-5">Pulse aquí para más información</h3>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Información a la derecha -->
            <div class="w-full md:w-2/3 p-4 rounded">
                <p class="text-gray-700 mb-2" v-if="lugar && lugar.pais">
                    <strong>País:</strong> {{ lugar.pais.nombre }}
                </p>
                <p class="text-gray-700 mb-2">
                    <strong>Descripción:</strong> {{ lugar.descripcion}}
                </p>
                <p class="text-gray-700 mb-2">
                    <strong>Tipo de lugar:</strong>
                </p>
                <ul class="list-disc list-inside mt-1">
                    <li v-for="(tipo, i) in lugar.tipo_lugar" :key="i">
                        {{ tipo.nombre}}
                    </li>
                </ul>
            </div>
        </div>
        <h2 v-if="lugar.localizacion_url" class="text-3xl sm:text-4xl font-bold mt-15 text-center f-color--dark tracking-wide">LOCALÍZALO EN EL MAPA</h2>
        <!-- Separador -->
        <div v-if="lugar.localizacion_url" class="h-px bg--dark mx-auto w-1/4 my-6"></div>
        <div v-if="lugar.localizacion_url" class="mapa">
            <iframe
                :src="lugar.localizacion_url"
                width="100%"
                height="400"
                style="border:0;"
                allowfullscreen="true"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { useLugaresStore } from '@/stores/lugaresStore'
import ImagenCabecera from "../userBasic/ImagenCabecera.vue";
export default defineComponent({
    components:{
        ImagenCabecera
    },
    props:{
        id:Number,
    },
    data() {
        return{
            lugaresStore:useLugaresStore(),
        }
    },
    computed:{
        lugar(){
            return this.lugaresStore.item
        },
    },
    created(){
        this.lugaresStore.getItem(this.id)
    },
    beforeUnmount() {
        this.lugaresStore.item=""
    },
})
</script>