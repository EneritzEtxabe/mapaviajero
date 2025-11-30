import { createCrudStore } from './helpers/createCrudStore'
import type { Usuario, CreateUsuario, UpdateUsuario } from '@/types'

export const useUsuariosStore = createCrudStore<Usuario, CreateUsuario, UpdateUsuario>(
  'usuarios',
  'http://localhost:8000/api/users',
)
