# mapaviajero - Backend (API)

> API desarrollada con Laravel 11.45.2 + MySQL  
> Sistema de gestión de lugares interesantes del mundo según país. Y alquiler de vehículo en él.

## Características principales

-   Laravel 11.45.2 con PHP 8.2+
-   Autenticación con Sanctum (Bearer Token)
-   Estructura de API REST limpia con recursos y form requests
-   Migraciones y seeders completos
-   Políticas y autorización con Gates
-   Validación de datos
-   Documentación de rutas (Swagger)

## Requisitos previos

| Herramienta | Versión mínima |
| ----------- | -------------- |
| PHP         | 8.2+           |
| Composer    | 2.8.10         |
| MySQL       | 8.2            |
| Git         | cualquier      |

## Instalación rápida (entorno local)

```bash
# 1. Clonar el repositorio
git clone https://github.com/EneritzEtxabe/mapaviajero.git
cd mapaviajero

# 2. Copiar variables de entorno
cp .env.example .env

# 3. Configurar base de datos en .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mapaviajero
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

# 4. Instalar dependencias
composer install

# 5. Generar clave de aplicación (Si el archivo ".env" no contiene una clave)
php artisan key:generate

# 6. Crea la base de datos
php artisan create-database

# 7. Ejecutar migraciones + seeders
php artisan migrate --seed

# 8. (Opcional: crear enlace simbólico para storage
php artisan storage:link

# 9. Iniciar servidor de desarrollo
php artisan serve
```

## Estructura de carpetas

app/
├── Http/
│ ├── Controllers/ # Controladores API
│ ├── Requests/ # Form Requests con validación
│ └── Resources/ # JSON Resources para respuestas
├── Models/ # Modelos
database/
├── factories/ # Factorias para tests
├── migrations/ # Migraciones
└── seeders/ # Seeders de datos iniciales
routes/
├── api.php # Todas las rutas de la API
test/
| ├── Feature/ # Test integracion
| | ├── crud-autorizacion/ # Test de permisos
| | ├── validacion/ # Test de validacion de datos

## Rutas

```bash
# 1. Utiliza este comando para ver la lista completa de rutas de la API actualizada
php artisan route:list --path=api
```

## Testing

```bash
# 1. Ejecutar todos los test
php artisan test
```
