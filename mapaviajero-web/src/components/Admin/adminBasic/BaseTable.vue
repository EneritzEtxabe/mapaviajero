<template>
    <div class="relative border border-gray-300 rounded-md">
      <div class="overflow-x-auto relative">
        <table class="min-w-full table-auto text-sm border-collapse">
          <thead class="bg--dark text-white uppercase tracking-wider">
            <tr>
              <th class="w-auto px-2 py-2 text-left border-b border-gray-300" v-for="col in columns" :key="col.key">{{ col.label }}</th>
              <th class="w-auto px-2 py-2 text-left border-b border-gray-300 sticky top-0 right-0 z-10 bg--dark"></th>
            </tr>
          </thead>
          <tbody class=" text-gray-800">
            <tr class="hover:bg--white transition duration-200" v-for="item in itemsFiltrados" :key="item.id">
              <td class="px-2 py-2 border-b border-gray-300 align-center max-w-xs" v-for="col in columns" :key="col.key">
                <div v-if="Array.isArray(item[col.key])">
                  <div v-for="(subItem, i) in item[col.key]" :key="i" class="line-clamp-2 text-ellipsis overflow-hidden">{{ subItem.nombre }}</div>
                </div>
                <!-- Caso 2: Objeto -->
                <div
                  v-else-if="typeof item[col.key] === 'object' && item[col.key] !== null"
                  class="line-clamp-2 text-ellipsis overflow-hidden"
                >
                  {{ item[col.key].nombre ?? item[col.key].id }}
                </div>
                <div v-else class="line-clamp-2 text-ellipsis overflow-hidden">
                  {{ item[col.key] }}
                </div>
              </td>
              <td class="flex flex-col px-2 py-2 border-b border-gray-300 sticky right-0 z-10 bg--white whitespace-nowrap">
                <Boton
                    type="edit"
                    label="Editar"
                    title="Editar"
                    :icon="'M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3zM4 20h16'"
                    @click="editar(item)"
                    class="mr-3"
                />
                <Boton
                  type="delete"
                  label="Eliminar"
                  title="Eliminar"
                  :icon="'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-3-4v4'"
                  @click="eliminar(item)"
                />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
</template>

<script lang="ts">
import Boton from '@/components/basic/Boton.vue';

export default {
  components:{Boton},
  props: {
    itemsFiltrados: Array,
    columns: Array
  },
  // data(){
  //   return {
  //     filtro:'',
  //   }
  // },
  // computed:{
  //   itemsFiltrados() {
  //     if (!this.filtro) return this.items;

  //     const busqueda = this.filtro.toLowerCase();
  //     return this.items.filter(item => {
  //       const valor = item.nombre;
  //       if (!valor) return false;
  //       return String(valor).toLowerCase().startsWith(busqueda);
  //     })
  //   }
  // },
  methods: {
    editar(item: any) {
      this.$emit('edit', item.id)
    },
    eliminar(item) {
      this.$emit('delete', item.id)
    }
   }
}
</script>
