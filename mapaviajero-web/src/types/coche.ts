import type { Estado, Cambio } from '@/types/enums'
export interface Coche {
    id:number
    marca:{
        id:number
        nombre:string
    }
    carroceria:{
        id:number
        nombre:string
    }
    ano:number
    nPlazas:number
    cambio: Cambio
    estado: Estado
    costeDia:number
    pais:{
        id:number
        nombre:string
    }
    alquileres:[
        {
            id:number
            fecha_inicio: string
            fecha_fin: string
        }
    ]
}
export interface CreateCoche {
  marca_id: number
  carroceria_id: number
  ano?: number
  nPlazas: number
  cambio?: Cambio | null
  estado?: Estado | null
  costeDia: number
  pais_id: number
}

export interface UpdateCoche {
    id:number
    marca_id?: number
    carroceria_id?: number
    ano?: number
    nPlazas?: number
    cambio?: Cambio | null
    estado?: Estado | null
    costeDia?: number
    pais_id?: number
}