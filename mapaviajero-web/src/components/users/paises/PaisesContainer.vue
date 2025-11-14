<template>
  <Loader :loading="loading" :error="error">
    <ImagenCabecera
      imagen="https://www.tenvinilo-ecuador.com/webp/posters/original-png/90219.webp"
      alt="Mapa mundi con banderas"
      texto="Países de destino"
    />
    <div class="max-w-6xl mx-auto p-6">
      <div v-for="(paises, continente) in paisesPorContinente" :key="continente">
        <h2
          class="text-3xl sm:text-4xl font-bold mt-15 text-center f-color--dark tracking-wide uppercase"
        >
          {{ continente }}
        </h2>
        <!-- Separador -->
        <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>
        <p class="text-md text-gray-600 leading-relaxed">
          {{ obtenerDescripcionContinente(String(continente)) }}
        </p>
        <!-- Scroll horizontal -->
        <div class="flex space-x-4 overflow-x-auto py-2 scroll-hide">
          <CardPais
            v-for="pais in paises"
            :key="pais.id"
            :pais="pais"
            class="min-w-[240px] flex-shrink-0"
          />
        </div>
      </div>
    </div>
  </Loader>
</template>

<script lang="ts">
// import { mapActions, mapState } from 'pinia';
import { usePaisesStore } from '@/stores/paisesStore'
import CardPais from '@/components/users/paises/components/CardPais.vue'
import Loader from '@/components/Loader.vue'
import { defineComponent } from 'vue'
import ImagenCabecera from '../userBasic/ImagenCabecera.vue'
import type {Pais} from '@/types'

interface PaisesPorContinente {
  [continenteNombre: string]: Pais[]
}

export default defineComponent({
  components: {
    ImagenCabecera,
    CardPais,
    Loader,
  },
  data() {
    return {
      paisesStore: usePaisesStore(),
      continentes: [
        {
          id: 1,
          nombre: 'Asia',
          descripcion:
            'Descubre una mezcla de culturas milenarias, templos impresionantes y tecnología de vanguardia. Ideal para aventureros culturales y amantes de la gastronomía.',
        },
        {
          id: 2,
          nombre: 'África',
          descripcion:
            'Una experiencia salvaje y auténtica entre desiertos, selvas y safaris. Perfecto para exploradores en busca de naturaleza y culturas ancestrales.',
        },
        {
          id: 3,
          nombre: 'Europa',
          descripcion:
            'Arte, historia y arquitectura en cada rincón. Ideal para quienes buscan ciudades románticas, museos y paisajes encantadores.',
        },
        {
          id: 4,
          nombre: 'Oceanía',
          descripcion:
            'Playas paradisíacas, naturaleza exótica y culturas únicas. Un destino para los amantes del surf, la tranquilidad y los paisajes remotos.',
        },
        {
          id: 5,
          nombre: 'Sudamérica',
          descripcion:
            'Montañas imponentes, selvas vibrantes y cultura viva. Perfecto para viajes aventureros y descubrimientos culturales intensos.',
        },
        {
          id: 6,
          nombre: 'Norteamérica',
          descripcion:
            'Diversidad urbana, maravillas naturales y rutas icónicas. Desde metrópolis modernas hasta parques nacionales inolvidables.',
        },
        {
          id: 7,
          nombre: 'Antártida',
          descripcion:
            'El continente blanco ofrece una experiencia única y extrema. Solo para verdaderos exploradores de lo desconocido.',
        },
      ],
    }
  },
  computed: {
    // ...mapState(usePaisesStore,['loading', 'error','items'])
    paises() {
      return this.paisesStore.items
    },
    paisesPorContinente() {
      const resultado:PaisesPorContinente = {}
      this.continentes.forEach((continente) => {
        const paisesDelContinente = this.paises.filter(
          (pais) => pais.continente && pais.continente.id === continente.id,
        )
        if (paisesDelContinente.length > 0) {
          resultado[continente.nombre] = paisesDelContinente
        }
      })
      return resultado
    },
  },
  methods: {
    //     ...mapActions(usePaisesStore,['fetchAll'])
    obtenerDescripcionContinente(nombre:string) {
      const continente = this.continentes.find((c) => c.nombre === nombre)
      return continente ? continente.descripcion : ''
    },
  },
  created() {
    this.paisesStore.fetchAll()
  },
})
</script>
<style>
.scroll-hide {
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE 10+ */
}

.scroll-hide::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Edge */
}
</style>
