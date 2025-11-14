import { createCrudStore } from './helpers/createCrudStore'
import type { Idioma } from '@/types'

export const useIdiomasStore = createCrudStore<Idioma>(
  'idiomas',
  'http://localhost:8000/api/idiomas'
)