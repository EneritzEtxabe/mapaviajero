export enum Rol {
    SUPERADMIN = 'superadmin',
    ADMIN = 'admin',
    CLIENTE = 'cliente',
}

export interface Usuario {
    id: number
    nombre: string
    email: string
    telefono: string
    dni: string
    rol: Rol
}