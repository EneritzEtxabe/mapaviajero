import { createCrudStore } from './helpers/createCrudStore'
import type { TipoLugar } from '@/types'

export const useTipoLugaresStore = createCrudStore<TipoLugar>(
  'tipoLugares',
  'http://localhost:8000/api/tipoLugares'
)