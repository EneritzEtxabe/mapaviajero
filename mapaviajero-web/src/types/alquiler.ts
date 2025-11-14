export enum Estado {
    DISPONIBLE = 'disponible',
    MANTENIMIENTO = 'mantenimiento',
}
export enum Cambio {
    MANUAL = 'manual',
    AUTOMATICO = 'automático',
}

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