import { createCrudStore } from './helpers/createCrudStore'
import type { MarcaCoche } from '@/types'

export const useMarcasCocheStore = createCrudStore<MarcaCoche>(
  'marcaCoches',
  'http://localhost:8000/api/marcaCoches'
)