

## Consideraciones


# Rebits Test

## Requerimientos

- PHP 8.1+
- Node.js 18.x+
- NPM 10.X+
- Composer 2.x+

## Instalacion

### 1. clonar el repositorio

```sh
git clone https://github.com/vitoxint/rebits-test.git
cd rebits-test
```
### Instalar dependencias de php

```sh
composer install
```

### Instalar dependencias de node

```sh
npm install
```

## Variables de entorno

- Copiar .env.example file a .env y editar las variables de entorno necesarias:

```sh
cp .env.example .env
```

## Generar application key:

```sh

php artisan key:generate

```

##  Configurar la base de datos

- Asegurate de que los parametros de conexión a la bbdd esten configurados en el archivo .env file.

## Ejecutar las migraciones:

```sh

php artisan migrate
```

## Cargar registros por defecto de la base de datos (seeder)

```sh

php artisan db:seed

```

## Ejecutar la aplicación

- Mediante el servidor local de artisan:

```sh

php artisan serve

```

## Usuario por defecto (Admin)

- Usuario por defecto o primario es :

    Email: admin@admin.com
    Password: secret



## Ejecutar servidor node en desarrollo:

```sh

npm run dev

```

## Compilar para producción:

```sh

npm run build

```

