import { createCrudStore } from './helpers/createCrudStore'
import type { Pais } from '@/types'

export const usePaisesStore = createCrudStore<Pais>(
  'paises',
  'http://localhost:8000/api/paises'
)