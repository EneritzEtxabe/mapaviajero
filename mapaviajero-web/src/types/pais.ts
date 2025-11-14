export enum Conduccion {
    DERECHA = 'derecha',
    IZQUIERDA = 'izquierda',
}
export interface Pais {
    id:number
    nombre: string
    bandera_url:string
    capital:string
    continente:{
        id:number
        nombre:string
    }
    conduccion: Conduccion
    idiomas:{
        id:number
        nombre:string
    }
    lugares:[
        {
            id:number
            nombre:string
        }
    ]
}