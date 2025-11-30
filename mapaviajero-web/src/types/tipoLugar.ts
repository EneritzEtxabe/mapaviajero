export interface TipoLugar {
  id: number
  nombre: string
}

export interface CreateTipoLugar {
  nombre: string
}

export interface UpdateTipoLugar {
  id: number
  nombre?: string
}
