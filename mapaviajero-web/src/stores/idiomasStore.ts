import { createCrudStore } from './helpers/createCrudStore'
import type { Idioma, CreateIdioma, UpdateIdioma } from '@/types'

export const useIdiomasStore = createCrudStore<Idioma,CreateIdioma, UpdateIdioma>(
  'idiomas',
  'http://localhost:8000/api/idiomas'
)