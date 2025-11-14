export enum Estado {
    DISPONIBLE = 'disponible',
    MANTENIMIENTO = 'mantenimiento',
}
export enum Cambio {
    MANUAL = 'manual',
    AUTOMATICO = 'automático',
}
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