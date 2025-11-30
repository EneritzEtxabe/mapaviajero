# mapaviajero - Frontend

> Aplicación frontend en Vue 3 + TypeScript + Pinia + Tailwind CSS  
> Panel administrativo / Vista usuario / Aplicación SPA consumiendo API Laravel.

## Tecnologías usadas

- Vue 3 (Options API)
- TypeScript
- Pinia (gestión de estado)
- Vue Router
- Axios (peticiones HTTP)
- Tailwind CSS v4+
- Vite
- ESLint + Prettier

## Requisitos previos

- Node.js 22.12.0
- NPM 11.6.2
- Un backend Laravel corriendo (normalmente en `http://localhost:5173`)

## Instalación rápida

```bash
# 1. Clonar el repositorio (es el mismo repositorio tanto para front como para back)
git clone https://github.com/EneritzEtxabe/mapaviajero.git
cd mapaviajero

# 2. Instalar dependencias
npm install

# 3. Configurar variables de entorno
Este proyecto frontend no requiere configuración de variables de entorno adicionales.

# 4. Iniciar
npm run dev
```

## Estructura principal del carpetas

<pre>```
src/
├── assets/                       # Fuentes css
├── axios/                        # Axios
├── components/                   # Componentes
|   ├── admin/                    # Componentes vistas admin/superadmin
|   ├── basic/                    # Componentes reutilizables
|   ├── error/                    # Componentes modal error
|   ├── login/                    # Componentes login
|   ├── users/                    # Componentes vistas cliente
|   ├── loaderComponent.vue       # Loader general
├── router/                       # Configuración de Vue Router
├── stores/                       # Stores de Pinia
├── types/                        # Interfaces, enums y tipos de TypeScript
├── views/                        # Vistas principales
├── App.vue
└── main.ts
```</pre>

## Rutas principales

| Ruta                    | Componente      | Auth |
| ----------------------- | --------------- | ---- |
| /                       | HomeView        | NO   |
| /login                  | Login           | NO   |
| /paises                 | PaisesContainer | NO   |
| /pais/id                | PaisContainer   | NO   |
| /lugar/id               | LugarContainer  | NO   |
| /admin                  | AdminHomeView   | SÍ   |
| /admin/paises           | TablaPaises     | SÍ   |
| /admin/pais/nuevo       | FromPais        | SÍ   |
| /admin/paiess/id/editar | FromPais        | SÍ   |
| / admin/idiomas         | TabalIdiomas    | SÍ   |

...

## Usuarios en BBDD (para hacer pruebas en front)

| Email               | Contraseña | Rol        |
| ------------------- | ---------- | ---------- |
| admin@ebis.com      | 12345678   | admin      |
| auperadmin@ebis.com | 12345678   | superadmin |
| cliente1@ebis.com   | 12345678   | cliente    |
