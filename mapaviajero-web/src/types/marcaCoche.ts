export interface MarcaCoche {
    id: number
    nombre: string
}
export interface CreateMarcaCoche {
    nombre: string
}
export interface UpdateMarcaCoche {
    id: number
    nombre?: string
}