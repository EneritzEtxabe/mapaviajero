import type { Rol } from '@/types/enums'
export interface Usuario {
  id: number
  nombre: string
  email: string
  telefono: string
  dni: string
  rol: Rol
}
export interface CreateUsuario {
  nombre: string
  email: string
  password: string
}

export interface UpdateUsuario {
  id: number
  nombre?: string
  email?: string
  telefono?: string
  dni?: string
  rol?: Rol
}
