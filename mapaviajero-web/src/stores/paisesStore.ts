import { createCrudStore } from './helpers/createCrudStore'
import type { Pais, CreatePais, UpdatePais } from '@/types'

export const usePaisesStore = createCrudStore<Pais, CreatePais, UpdatePais>(
  'paises',
  'http://localhost:8000/api/paises',
)
