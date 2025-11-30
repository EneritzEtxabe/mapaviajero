import { createCrudStore } from './helpers/createCrudStore'
import type { Coche, CreateCoche, UpdateCoche } from '@/types'

export const useCochesStore = createCrudStore<Coche, CreateCoche, UpdateCoche>(
  'coches',
  'http://localhost:8000/api/coches',
)
