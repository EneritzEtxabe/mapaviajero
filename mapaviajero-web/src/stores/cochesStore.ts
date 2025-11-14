import { createCrudStore } from './helpers/createCrudStore'
import type { Coche } from '@/types'

export const useCochesStore = createCrudStore<Coche>(
  'coches',
  'http://localhost:8000/api/coches'
)