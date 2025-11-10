<template>
  <div class="p-6 space-y-10">
    <AdminHomeSeccion
      titulo="DESTINOS"
      icono="🌍"
      :cards="cardsDestinos"
    />
    <AdminHomeSeccion
      titulo="COCHES"
      icono="🚗"
      :cards="cardsCoches"
    />
    <AdminHomeSeccion
      titulo="GESTIONES"
      icono="🧾"
      :cards="cardsGestiones"
    />
  </div>
</template>
<script lang="ts">
import AdminHomeSeccion from '@/components/Admin/home/AdminHomeSeccion.vue';

  export default{
    components:{AdminHomeSeccion},
    data(){
      return {
        cardsDestinos:[
          {
            titulo: 'PAÍSES',
            ruta:'paisesAdmin'
          },
          {
            titulo: 'LUGARES',
            ruta:'lugaresAdmin'
          },
          {
            titulo: 'IDIOMAS',
            ruta:'idiomasAdmin'
          },
        ],
        cardsCoches:[
          {
            titulo: 'COCHES',
            ruta:'cochesAdmin'
          },
          {
            titulo: 'MARCAS DE COCHES',
            ruta:'marcasCocheAdmin'
          },
          {
            titulo: 'CARROCERÍAS DE COCHES',
            ruta:'carroceriasCocheAdmin'
          },
        ],
        cardsGestiones:[
           {
            titulo: 'USUARIOS',
            ruta:'usuariosAdmin'
          },
          {
            titulo: 'ALQUILERES',
            ruta:'alquileresAdmin'
          },
        ]
      };
    }
  }
</script>
<style>

</style>
