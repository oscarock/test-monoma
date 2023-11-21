## TEST MONOMA

Se desarrollo en laravel version 10

## Pasos para ejecutar el proyecto

- Clonar el repositorio
- Ubicar la rama master
- Ejecutar el comando ```composer install```
- En el archivo .env configurar la conexion de la base de datos
- Ejecutar el comando ```php artisan migrate --seed``` para crear las migraciones y los seed
- ejecutar el comando ```php artisan jwt:secret``` para generar el secreto del jwt
- ya deberia funcionar el proyecto
- revisar los seed creados para ejecutar los endpoints

## Enpoints

- **POST {host}/api/auth** = Genera el token con jwt
- **GET {host}/api/leads** = muestra todos los candidatos
- **GET {host}/api/leads/{id}** = muestra un canditado
- **POST {host}/api/leads** = Crea un candidato
