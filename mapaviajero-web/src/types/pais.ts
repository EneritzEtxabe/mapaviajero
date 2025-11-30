import type { Conduccion } from '@/types/enums'
export interface Pais {
  id: number
  nombre: string
  bandera_url: string
  capital: string
  continente: {
    id: number
    nombre: string
  }
  conduccion: Conduccion | null
  idiomas: { id: number; nombre: string }[]
  lugares: { id: number; nombre: string }[]
}

export interface CreatePais {
  nombre: string | null
  capital: string | null
  bandera_url?: string | null
  continente_id: number | null
  conduccion?: Conduccion | null
  idiomas: number[]
}

export interface UpdatePais {
  id: number
  nombre?: string | null
  capital?: string | null
  bandera_url?: string | null
  continente_id?: number | null
  conduccion?: Conduccion | null
  idiomas?: number[]
}
export interface FormPais {
  nombre?: string | null
  capital?: string | null
  bandera_url?: string | null
  continente_id?: number | null
  conduccion?: Conduccion | null
  idiomas?: number[]
  lugares?: {
    id: number
    nombre: string
  }[]
}
