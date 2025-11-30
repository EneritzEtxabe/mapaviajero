<template>
  <Loader :loading="loading" :error="error">
    <ImagenCabecera
      imagen="https://www.race.es/revista-autoclub/wp-content/uploads/sites/4/2021/07/alquila-coche-con-la-garantia-del-race-759x500.jpg"
      alt="Coche en un mirador"
      texto="Alquila tu coche"
    />

    <div class="max-w-6xl mx-auto p-6">
      <P class="text-md"
        >Si estás interesado en alquilar un coche para tu viaje, este es el momento!!! Mira la
        selección de coches de la que disponemos en cada país y selecciona la que mejor se adapte a
        tus necesidades. Una vez selecciones du coche ideal, nuestro equipo se pondrá en contácto
        contigo para gestionar todo lo necesario.</P
      >
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-5">
        <CocheDetail
          v-for="coche in coches"
          :coche="coche"
          :key="coche.id"
          class="min-w-[240px] mx-auto"
        />
      </div>
    </div>
  </Loader>
</template>

<script lang="ts">
import { mapState } from 'pinia'
import { useCochesStore } from '@/stores/cochesStore'
import CocheDetail from '@/components/users/coches/components/CocheDetail.vue'
import ImagenCabecera from '../userBasic/ImagenCabecera.vue'
import Loader from '@/components/LoaderComponent.vue'

export default {
  components: {
    ImagenCabecera,
    CocheDetail,
    Loader,
  },
  computed: {
    ...mapState(useCochesStore, { loading: 'loading', error: 'error', coches: 'items' }),
  },
  methods: {
    getCoches() {
      useCochesStore().fetchAll()
    },
    resetCoches() {
      useCochesStore().resetItems()
    },
  },
  mounted() {
    this.getCoches()
  },
  beforeUnmount() {
    this.resetCoches()
  },
}
</script>
