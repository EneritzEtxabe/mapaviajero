import { createCrudStore } from './helpers/createCrudStore'
import type { CarroceriaCoche, CreateCarroceriaCoche, UpdateCarroceriaCoche } from '@/types'

export const useCarroceriasCocheStore = createCrudStore<
  CarroceriaCoche,
  CreateCarroceriaCoche,
  UpdateCarroceriaCoche
>('carroceriaCoches', 'http://localhost:8000/api/carroceriaCoches')
