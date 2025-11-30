export interface Lugar {
  id: number
  nombre: string
  pais: {
    id: number
    nombre: string
  }
  continente: {
    id: number
    nombre: string
  }
  descripcion: string
  imagen_url: string
  web_url: string
  localizacion_url: string
  tipo_lugar: [
    {
      id: number
      nombre: string
    },
  ]
}

export interface CreateLugar {
  nombre: string | null
  pais_id: number | null
  descripcion?: string | null
  tipoLugares: number[]
  imagen_url?: string | null
  localizacion_url?: string | null
  web_url?: string | null
}
export interface UpdateLugar {
  id: number
  nombre?: string | null
  pais_id?: number | null
  descripcion?: string | null
  tipoLugares?: number[]
  imagen_url?: string | null
  localizacion_url?: string | null
  web_url?: string | null
}
