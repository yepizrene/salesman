<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<h2 align="center" style="margin-bottom:100px;margin-top:-30px; border:none">
  SalesMan
</h2>

## Descripción

### Aplicación de prueba hecha en Laravel v 11.21.0, Inertia.js y Vue3

Funciones: 
- Login
- Registro de nuevos usuarios
- Catálogos
  - Usuarios (CRUD)
  - Clientes (CRUD)
  - Ordenes (CRUD)
  - Productos (CRUD)


Por seguridad e integridad referencial se implementó borrado lógico (Soft Delete) en cada uno de los catálogos


## Instalación

Clonar repositorio:

```sh
git clone https://github.com/yepizrene/salesman.git salesman

cd salesman
```

Instalar dependencias de PHP:

```sh
composer install
```

Instalar dependencias de NPM:

```sh
npm install
```

Construir assets:

```sh
npm run dev
```

Crear archivo de configuración Laravel:

```sh
cp .env.example .env
```

Generar clave de la aplicación:

```sh
php artisan key:generate
```

Crear base de datos SQLite, puedes utilizar cualquier otra base de datos (MySQL, Postgres), solamente cambiando la configuración en el archivo .env

```sh
touch database/database.sqlite
```

Ejecutar las migraciones de la base de datos:

```sh
php artisan migrate
```

Ejecutar el seeder para data de ejemplo:

```sh
php artisan db:seed
```

Arrancar servidor de desarrollo:

```sh
php artisan serve
```

Cuando todo este listo puedes ir a la dirección obtenida en el paso anterior:

- **Username:** johndoe@example.com
- **Password:** password

Puedes utilizar esas credenciales o puedes registrar un nuevo usuario, para probar la aplicación 

## Licencia
Al igual que laravel este proyecto se rige por la licencia [MIT license](https://opensource.org/licenses/MIT).
