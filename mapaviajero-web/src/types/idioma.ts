export interface Idioma {
  id: number
  iso_639_1: string
  nombre: string
}
export interface CreateIdioma {
  iso_639_1?: string
  nombre: string
}
export interface UpdateIdioma {
  id: number
  iso_639_1?: string
  nombre?: string
}
