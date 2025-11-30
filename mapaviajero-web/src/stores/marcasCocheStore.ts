import { createCrudStore } from './helpers/createCrudStore'
import type { MarcaCoche, CreateMarcaCoche, UpdateMarcaCoche } from '@/types'

export const useMarcasCocheStore = createCrudStore<MarcaCoche, CreateMarcaCoche, UpdateMarcaCoche>(
  'marcaCoches',
  'http://localhost:8000/api/marcaCoches',
)
