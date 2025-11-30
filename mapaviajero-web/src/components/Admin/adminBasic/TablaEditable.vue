<template>
  <div class="w-full overflow-x-auto flex flex-col">
    <BotonCrearNuevo v-if="mostrarBotonCrear" @crearNuevo="crearNuevo()" />
    <table class="mx-auto table-auto text-sm border-collapse border border-gray-300">
      <thead class="bg--dark text-white uppercase text-sm tracking-wider">
        <tr>
          <th
            class="px-4 py-2 text-left border-b border-gray-300"
            v-for="col in columns"
            :key="col.key"
          >
            {{ col.label }}
          </th>
          <th class="px-4 py-2 text-left border-b border-gray-300"></th>
        </tr>
      </thead>
      <tbody class="text-gray-800">
        <tr class="hover:bg--white transition duration-200" v-for="item in items" :key="item.id">
          <td
            v-for="col in columns"
            :key="col.key"
            class="px-4 py-2 border-b border-gray-300 align-top max-w-xs text-sm"
          >
            <!-- 📝 Modo edición -->
            <div v-if="idEditando === item.id">
              <div v-if="col.key === 'rol' || col.key == 'coste'" class="py-1 px-2 text-gray-500">
                {{ datosEditables[col.key] }}
              </div>
              <div v-else>
                <input
                  v-model="datosEditables[col.key]"
                  :id="col.key"
                  class="mt-1 block w-full border border-gray-300 rounded px-2 py-1 text-sm"
                />
              </div>
            </div>

            <!-- 📄 Modo lectura -->
            <div v-else class="line-clamp-2 text-ellipsis overflow-hidden text-sm">
              {{ item[col.key] }}
            </div>
          </td>

          <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap">
            <!-- Botones de acción -->
            <div v-if="idEditando === item.id" class="flex">
              <Boton
                type="update"
                label="Actualizar"
                title="Guardar"
                :icon="'M5 13l4 4L19 7'"
                @click="actualizar()"
                class="mr-2"
              />
              <Boton
                type="cancel"
                label="Cancelar"
                title="Cancelar edición"
                :icon="'M6 18L18 6M6 6l12 12'"
                @click="cancelar"
              />
            </div>
            <div v-else class="flex">
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
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <ModalCrearNuevo
      v-if="idEditando === 0"
      :columns="columns"
      :datosEditables="datosEditables"
      :rolesDisponibles="rolesDisponibles"
      @crear="crear()"
      @cancelar="cancelar()"
    />
  </div>
</template>

<script lang="ts">
import BotonCrearNuevo from '@/components/Admin/adminBasic/BotonCrearNuevo.vue'
import ModalCrearNuevo from './ModalCrearNuevo.vue'
import Boton from '@/components/basic/BotonComponent.vue'
import { defineComponent, type PropType } from 'vue'

export default defineComponent({
  components: {
    BotonCrearNuevo,
    ModalCrearNuevo,
    Boton,
  },
  props: {
    items: {
      type: Array as PropType<Array<any>>,
      required: true,
    },
    columns: {
      type: Array as PropType<Array<{ key: string; label: string }>>,
      required: true,
    },
    mostrarBotonCrear: Boolean,
  },
  data() {
    return {
      idEditando: null as number | null,
      datosEditables: {} as Record<string, any>,
      rolesDisponibles: ['admin', 'superadmin', 'cliente'],
    }
  },
  methods: {
    editar(item: { id: number }) {
      this.idEditando = item.id
      this.datosEditables = { ...item }
    },
    crearNuevo() {
      this.idEditando = 0
      this.datosEditables = this.columns.reduce<Record<string, string>>((obj, col) => {
        obj[col.key] = ''
        return obj
      }, {})
    },
    cancelar() {
      this.idEditando = null
      this.datosEditables = {}
    },
    actualizar() {
      this.$emit('update', this.datosEditables)
      this.cancelar()
    },
    crear() {
      this.$emit('create', this.datosEditables)
      this.cancelar()
    },
    eliminar(item: { id: number | string }) {
      this.$emit('delete', item.id)
    },
  },
})
</script>
