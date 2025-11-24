import type { Conduccion } from '@/types/enums'
export interface Pais {
    id:number
    nombre: string
    bandera_url:string
    capital:string
    continente:{
        id:number
        nombre:string
    }
    conduccion: Conduccion | null,
    idiomas:{id:number,nombre:string}[]
    lugares:{id:number,nombre:string}[]
}

export interface CreatePais {
  nombre: string;
  capital: string;
  bandera_url?: string;
  continente_id: number | "";
  conduccion?: Conduccion;
  idiomas: number[];
}

export interface UpdatePais {
    id:number;
    nombre?: string;
    capital?: string;
    bandera_url?: string;
    continente_id?: number | "";
    conduccion?: Conduccion;
    idiomas?: number[];
    lugares?:{
        id:number;
        nombre:string
    }[];
}
export interface FormPais{
    nombre?: string;
    capital?: string;
    bandera_url?: string;
    continente_id?: number | "";
    conduccion?: Conduccion | null;
    idiomas?: number[];
    lugares?:{
        id:number;
        nombre:string
    }[];
}