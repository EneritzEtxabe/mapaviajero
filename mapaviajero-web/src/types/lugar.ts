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
    tipoLugares:[
        {
            id:number
            nombre:string
        }
    ]
}