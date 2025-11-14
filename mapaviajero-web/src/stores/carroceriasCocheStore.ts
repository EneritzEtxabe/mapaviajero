import { createCrudStore } from './helpers/createCrudStore'
import type { CarroceriaCoche } from '@/types'

export const useCarroceriasCocheStore = createCrudStore<CarroceriaCoche>(
  'carroceriaCoches',
  'http://localhost:8000/api/carroceriaCoches'
)