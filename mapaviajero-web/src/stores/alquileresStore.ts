import { createCrudStore } from './helpers/createCrudStore'
import type {Alquiler, CreateAlquiler, UpdateAlquiler} from '@/types'

export const useAlquileresStore = createCrudStore<Alquiler, CreateAlquiler, UpdateAlquiler>(
  'alquileres',
  'http://localhost:8000/api/alquileres'
)
