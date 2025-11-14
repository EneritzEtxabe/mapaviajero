import { createCrudStore } from './helpers/createCrudStore'
import type { Usuario } from '@/types'

export const useUsuariosStore = createCrudStore<Usuario>(
  'usuarios',
  'http://localhost:8000/api/users'
)