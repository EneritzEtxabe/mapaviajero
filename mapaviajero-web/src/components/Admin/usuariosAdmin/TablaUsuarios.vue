<template>
  <div class="mx-auto p-6">
    <ErrorModal :error="error"/>
    <h2 class="text-3xl sm:text-4xl font-bold text-center f-color--dark tracking-wide">LISTA DE USUARIOS</h2>     
    <!-- Separador -->
    <div class="h-px bg--dark mx-auto w-1/4 my-6"></div>  
    <TablaEditable
      :items="usuarios"
      :columns="columns"
      :mostrarBotonCrear="true"
      @create="crear"
      @update="actualizar"
      @delete="eliminar"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useUsuariosStore } from '@/stores/usuariosStore'
import TablaEditable from '../adminBasic/TablaEditable.vue';
import ErrorModal from '@/components/error/ErrorModal.vue';

export default defineComponent({
  components:{TablaEditable, ErrorModal},
  data() {
    return{
      usuariosStore: useUsuariosStore(),
      columns: [
        { key: 'nombre', label: 'Nombre' },
        { key: 'email', label: 'Email' },
        { key: 'telefono', label: 'Teléfono' },
        { key: 'dni', label: 'DNI'},
        { key: 'rol', label: 'Rol' },
      ],
      error:null
    }
  },
  computed: {
    usuarios(){
      return this.usuariosStore.items
    }
  },
  created() {
    this.usuariosStore.fetchAll()
  },
  methods: {
    async crear(datos: any) {
      try {
        await this.usuariosStore.createItem({ ...datos });
        alert('Usuario creado correctamente');
      } catch (err) {
        this.error = err;
      }
    },
    async actualizar(datos) {
      try{
        await this.usuariosStore.updateItem({ ...datos},true)
        alert('Usuario actualizado correctamente')
      }catch(err){
        this.error=err
      }
    },
    async eliminar(id: number) {
      if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        try{
          await this.usuariosStore.deleteItem(id)
        }catch(err){
          this.error=err
        }
      }
    }
  }
})
</script>

