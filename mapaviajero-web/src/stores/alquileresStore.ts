import { createCrudStore } from './helpers/createCrudStore'
import type {Alquiler} from '@/types'

export const useAlquileresStore = createCrudStore<Alquiler>(
  'alquileres',
  'http://localhost:8000/api/alquileres'
)
