import { createCrudStore } from './helpers/createCrudStore'
import type { TipoLugar, CreateTipoLugar, UpdateTipoLugar } from '@/types'

export const useTipoLugaresStore = createCrudStore<TipoLugar, CreateTipoLugar, UpdateTipoLugar>(
  'tipoLugares',
  'http://localhost:8000/api/tipoLugares'
)