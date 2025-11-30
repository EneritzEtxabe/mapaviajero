import { createCrudStore } from './helpers/createCrudStore'
import type { Lugar, CreateLugar, UpdateLugar } from '@/types'

export const useLugaresStore = createCrudStore<Lugar, CreateLugar, UpdateLugar>(
  'lugares',
  'http://localhost:8000/api/lugares',
)
