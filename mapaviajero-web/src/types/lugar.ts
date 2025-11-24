export interface Lugar {
    id:number
    nombre: string
    pais:{
        id:number
        nombre:string
    }
    continente:{
        id:number
        nombre:string
    }
    descripcion:string
    imagen_url:string
    web_url:string
    localizacion_url:string
    tipo_lugar:[
        {
            id:number
            nombre:string
        }
    ]
}

export interface CreateLugar {
  nombre: string
  pais_id: number
  descripcion?: string
//   tipoLugares: number[]
  imagen_url?: string
  localizacion_url?: string
  web_url?: string
}
export interface UpdateLugar{
  id: number
  nombre?: string
  pais_id?: number
  descripcion?: string
//   tipoLugares?: number[]
  imagen_url?: string
  localizacion_url?: string
  web_url?: string
}