import type { Estado, Cambio } from '@/types/enums'
export interface Alquiler {
   id:number
   coche:{
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
   }
   cliente:{
    id:number
    nombre:string
    email:string
   }
   fecha_inicio:string
   fecha_fin:string
}
export interface CreateAlquiler {
   coche: number
   cliente: number
//    email:string
   fecha_inicio:string
   fecha_fin:string
//    coste: number
}
export interface UpdateAlquiler {
    id:number
    coche?: number
    cliente?: number
    // email:string
    fecha_inicio?:string
    fecha_fin?:string
    // coste: number
}