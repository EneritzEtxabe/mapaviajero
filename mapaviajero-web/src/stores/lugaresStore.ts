import { createCrudStore } from './helpers/createCrudStore'
import type { Lugar } from '@/types'

export const useLugaresStore = createCrudStore<Lugar>(
  'lugares',
  'http://localhost:8000/api/lugares'
)
  