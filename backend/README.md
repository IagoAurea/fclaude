## FisicalCoach API Backend

API del proyecto FisicalCoach en Laravel framework.

- [FisicalCoach API producción](https://dev.fisicalcoach.com)
- [FisicalCoach API local](http://127.0.0.1:8083/)
- [FisicaCoach CDN](https://cdn.fisicalcoach.com/resources)
- [Documentación API y ejemplos](https://doc.fisicalcoach.com/)

## Instalación

- Clonar el proyecto desde el repositorio `https://bitbucket.org/APPYWEB/fisicalcoach-laravel/`
  1. HTTP: `git clone https://bitbucket.org/APPYWEB/fisicalcoach-laravel.git`
  2. SSH: `git clone git@bitbucket.org:APPYWEB/fisicalcoach-laravel.git`

## Puesta en marcha

- Creamos un archivo con el nombre ".env" en el directorio raíz del proyecto con la siguiente configuración

### Ambiente de Desarrollo

```bash
#Docker-compose parameters
DOCKER_OCTANE_PORT=8080
DOCKER_PHP_PORTS=8083:8080
DOCKER_POSTGRES_PORTS=5434:5432
DOCKER_POSTGRES_USER=postgres
DOCKER_POSTGRES_PASSWORD=root
DOCKER_POSTGRES_DB=fisco_api_db
DOCKER_MAILCATCHER_WEB_PORTS=1080:1080
DOCKER_MAILCATCHER_SMTP_PORTS=1025:1025
DOCKER_REDIS_PORTS=6388:6379
DOCKER_REDIS_PORT_EXPOSE=6388
DOCKER_WEBSOCKET_PORTS=6001:6001
DOCKER_MINIO_PORTS=9093:9000
DOCKER_MINIO_PORTS_CONSOLE=9001:9001
DOCKER_MINIO_PORT=9001
DOCKER_MINIO_USER=minio
DOCKER_MINIO_PASSWORD=minio123

```

- Levantamos los contenedores

```bash
docker-compose up -d
```

- Configuramos el .env

```bash
docker-compose exec api-fisco-php cp .env.docker .env
```

- Instalamos los componentes de composer

```bash
docker-compose exec api-fisco-php composer install
```
- Generamos la key de la aplicacion

```bash
docker-compose exec api-fisco-php php artisan key:generate
```

Ver **CDN de Recursos** y realizar la configuración alli especificada, antes de seguir con el siguiente paso.

- Inicializar base de datos y los datos iniciales de prueba

```bash
docker-compose exec api-fisco-php php artisan fisical:init
```

### Ambiente de Produccion

```bash
#Docker-compose parameters
DOCKER_USER=user
DOCKER_UID=1000
DOCKER_OCTANE_PORT=8080
DOCKER_PHP_PORTS=8083:8080
DOCKER_POSTGRES_PORTS=5434:5432
DOCKER_POSTGRES_USER=postgres
DOCKER_POSTGRES_PASSWORD=root
DOCKER_POSTGRES_DB=fisco_api_db
DOCKER_MAILCATCHER_WEB_PORTS=1080:1080
DOCKER_MAILCATCHER_SMTP_PORTS=1025:1025
DOCKER_REDIS_PORTS=6388:6379
DOCKER_REDIS_PORT_EXPOSE=6388
DOCKER_WEBSOCKET_PORTS=6001:6001
DOCKER_MINIO_PORTS=9093:9000
DOCKER_MINIO_PORTS_CONSOLE=9001:9001
DOCKER_MINIO_PORT=9001
DOCKER_MINIO_USER=minio
DOCKER_MINIO_PASSWORD=minio123

```

- Levantamos los contenedores

```bash
docker-compose up -d
```

- Configuramos el .env

```bash
docker-compose exec api-fisco-php cp .env.docker .env
```

- Instalamos los componentes de composer

```bash
docker-compose exec api-fisco-php composer install
```
- Generamos la key de la aplicacion

```bash
docker-compose exec api-fisco-php php artisan key:generate
```

Ver **CDN de Recursos** y realizar la configuración alli especificada, antes de seguir con el siguiente paso.

- Crear productos con sus planes (tarifas mensual y tarifas anual) y niveles con cantidad y precio en la plataforma de stripe,
agregar en el seeder de `PackagesPriceTableSeeder` el id de cada plan segun el caso en cada uno de los precio de los paquetes el campo `stripe_month_id` parar el plan mensual y `stripe_year_id` para el plan anual.

- Crear tipos de impuestos en la plataforma de stripe de forma personalizada (custom) agregando la tasa y en descripcion nombre y tasa, ejemplo `VAT 21%` agregar el id del impuesto en el seeder `TaxTableSeeder` el campo `stripe_tax_id`.

- Inicializar base de datos y los datos iniciales de prueba

```bash
docker-compose exec api-fisco-php php artisan fisical:init-prod
```


## CDN de Recursos

El CDN es usado para almacenar todos los recursos (imagenes, videos, etc) que servirán en la aplicacion.

- Entramos en el [backend de Minio](http://127.0.0.1:9093/minio/) (user:minio password:minio123) y creamos el bucket "resources"

- (Aplicar solo en ambiente de testing, staging y produccion) Crear un usuario con el username `user3d` y asignar contraseña (Enviar datos de la url asignada al minio y de las credenciales al equipo de integracion 3D)

- Copiar el contenido de la carpeta `public > images > images` y crear dentro del bucket `resources` un directorio con el nombre `images` y pegar el contenido copiado en el CDN.

## Envio de emails

Para el envio de emails en desarrollo, puede accederse a un webmail virtual desde [este enlace](http://127.0.0.1:1080/).

## Uso de colas

- Si se necesita el uso de alguna cola de procesos, para incializar el listener ejecutamos:

```bash
docker-compose exec api-fisco-php php artisan queue:listen
```

## Tareas Programadas
- La aplicacion ejecuta tareas programadas es necesario agregar un cron job para que se ejecuten automaticamente
```bash
* * * * * docker exec -t api_fisco_php php /usr/src/app/artisan schedule:run >> /dev/null 2>&1
``` 
Nota cambiar ruta_aplicacion por la ruta completa donde se encuentra la aplicación, si se requiere almacenar el log de cada ejecucion de la tarea sustituir `/dev/null` por una ruta con nombre del log con la extension .log donde se desea almacenar dicho archivo.

## Documentación

la nueva documentación con Swagger (Open Api) se accede en ambiente de desarrollo a traves de [este enlace](http://127.0.0.1:8083/api/documentation) y en el ambiente de testing [este enlace](https://dev.fisicalcoach.com/api/documentation)

La documentación anterior de los endpoints que conforman la api se lleva sobre Insomnia `https://insomnia.rest/`.
Dentro del directorio raíz del proyecto se encuentra una carpeta con el nombre de documentation que contiene un json (insomnia.json) con detalle de cada endpoint, el cual puede ser importado a Postman/Insomnia para realizar pruebas y test.

## Code quality

Para analizar errores de código (nivel sensibilidad máxima):

```bash
docker-compose exec api-fisco-php php vendor/bin/phpstan analyse --memory-limit=512M
```

## Herramienta de desarrollo

Para depurar la aplicación y tener información de las peticiones, consultas a la base de datos, eventos ejecutados, entre otra funciones se encuentra el paquete clockwork, para interactuar con los datos se accede a la interfaz web desde [este enlace](http://127.0.0.1:8083/clockwork/app).

## Rendimiento y Seguridad

Para mejorar el rendimiento y la seguridad, se usa el paquete Enlinghtn

```bash
docker-compose exec api-fisco-php php artisan enlightn
```

## Ramas

- master: codigo para el ambiente de produccion.
- develop: codigo para el ambiente de desarrollo y test.

## Creacion de Paquetes en Stripe

Para crear los paquetes de stripe (ambiente produccion) que se definieron en la aplicacion

```bash
docker-compose exec api-fisco-php php artisan module:seed --class=CreatePlansStripeTableSeeder Package
```

## Licencia

Este proyecto está bajo la Licencia Privada


## FisicalCoach API Backend

API del proyecto FisicalCoach en Laravel framework.

- [FisicalCoach API producciÃ³n](https://dev.fisicalcoach.com)
- [FisicalCoach API local](http://127.0.0.1:8083/)
- [FisicaCoach CDN](https://cdn.fisicalcoach.com/resources)
- [DocumentaciÃ³n API y ejemplos](https://doc.fisicalcoach.com/)

## InstalaciÃ³n

- Clonar el proyecto desde el repositorio `https://bitbucket.org/APPYWEB/fisicalcoach-laravel/`
  1. HTTP: `git clone https://bitbucket.org/APPYWEB/fisicalcoach-laravel.git`
  2. SSH: `git clone git@bitbucket.org:APPYWEB/fisicalcoach-laravel.git`

## Puesta en marcha

- Creamos un archivo con el nombre ".env" en el directorio raÃ­z del proyecto con la siguiente configuraciÃ³n

### Ambiente de Desarrollo

```bash
#Docker-compose parameters
DOCKER_OCTANE_PORT=8080
DOCKER_PHP_PORTS=8083:8080
DOCKER_POSTGRES_PORTS=5434:5432
DOCKER_POSTGRES_USER=postgres
DOCKER_POSTGRES_PASSWORD=root
DOCKER_POSTGRES_DB=fisco_api_db
DOCKER_MAILCATCHER_WEB_PORTS=1080:1080
DOCKER_MAILCATCHER_SMTP_PORTS=1025:1025
DOCKER_REDIS_PORTS=6388:6379
DOCKER_REDIS_PORT_EXPOSE=6388
DOCKER_WEBSOCKET_PORTS=6001:6001
DOCKER_MINIO_PORTS=9093:9000
DOCKER_MINIO_PORTS_CONSOLE=9001:9001
DOCKER_MINIO_PORT=9001
DOCKER_MINIO_USER=minio
DOCKER_MINIO_PASSWORD=minio123

```

- Levantamos los contenedores

```bash
docker-compose up -d
```

- Configuramos el .env

```bash
docker-compose exec api-fisco-php cp .env.docker .env
```

- Instalamos los componentes de composer

```bash
docker-compose exec api-fisco-php composer install
```
- Generamos la key de la aplicacion

```bash
docker-compose exec api-fisco-php php artisan key:generate
```

Ver **CDN de Recursos** y realizar la configuraciÃ³n alli especificada, antes de seguir con el siguiente paso.

- Inicializar base de datos y los datos iniciales de prueba

```bash
docker-compose exec api-fisco-php php artisan fisical:init
```

### Ambiente de Produccion

```bash
#Docker-compose parameters
DOCKER_USER=user
DOCKER_UID=1000
DOCKER_OCTANE_PORT=8080
DOCKER_PHP_PORTS=8083:8080
DOCKER_POSTGRES_PORTS=5434:5432
DOCKER_POSTGRES_USER=postgres
DOCKER_POSTGRES_PASSWORD=root
DOCKER_POSTGRES_DB=fisco_api_db
DOCKER_MAILCATCHER_WEB_PORTS=1080:1080
DOCKER_MAILCATCHER_SMTP_PORTS=1025:1025
DOCKER_REDIS_PORTS=6388:6379
DOCKER_REDIS_PORT_EXPOSE=6388
DOCKER_WEBSOCKET_PORTS=6001:6001
DOCKER_MINIO_PORTS=9093:9000
DOCKER_MINIO_PORTS_CONSOLE=9001:9001
DOCKER_MINIO_PORT=9001
DOCKER_MINIO_USER=minio
DOCKER_MINIO_PASSWORD=minio123

```

- Levantamos los contenedores

```bash
docker-compose up -d
```

- Configuramos el .env

```bash
docker-compose exec api-fisco-php cp .env.docker .env
```

- Instalamos los componentes de composer

```bash
docker-compose exec api-fisco-php composer install
```
- Generamos la key de la aplicacion

```bash
docker-compose exec api-fisco-php php artisan key:generate
```

Ver **CDN de Recursos** y realizar la configuraciÃ³n alli especificada, antes de seguir con el siguiente paso.

- Crear productos con sus planes (tarifas mensual y tarifas anual) y niveles con cantidad y precio en la plataforma de stripe,
agregar en el seeder de `PackagesPriceTableSeeder` el id de cada plan segun el caso en cada uno de los precio de los paquetes el campo `stripe_month_id` parar el plan mensual y `stripe_year_id` para el plan anual.

- Crear tipos de impuestos en la plataforma de stripe de forma personalizada (custom) agregando la tasa y en descripcion nombre y tasa, ejemplo `VAT 21%` agregar el id del impuesto en el seeder `TaxTableSeeder` el campo `stripe_tax_id`.

- Inicializar base de datos y los datos iniciales de prueba

```bash
docker-compose exec api-fisco-php php artisan fisical:init-prod
```


## CDN de Recursos

El CDN es usado para almacenar todos los recursos (imagenes, videos, etc) que servirÃ¡n en la aplicacion.

- Entramos en el [backend de Minio](http://127.0.0.1:9093/minio/) (user:minio password:minio123) y creamos el bucket "resources"

- (Aplicar solo en ambiente de testing, staging y produccion) Crear un usuario con el username `user3d` y asignar contraseÃ±a (Enviar datos de la url asignada al minio y de las credenciales al equipo de integracion 3D)

- Copiar el contenido de la carpeta `public > images > images` y crear dentro del bucket `resources` un directorio con el nombre `images` y pegar el contenido copiado en el CDN.

## Envio de emails

Para el envio de emails en desarrollo, puede accederse a un webmail virtual desde [este enlace](http://127.0.0.1:1080/).

## Uso de colas

- Si se necesita el uso de alguna cola de procesos, para incializar el listener ejecutamos:

```bash
docker-compose exec api-fisco-php php artisan queue:listen
```

## Tareas Programadas
- La aplicacion ejecuta tareas programadas es necesario agregar un cron job para que se ejecuten automaticamente
```bash
* * * * * docker exec -t api_fisco_php php /usr/src/app/artisan schedule:run >> /dev/null 2>&1
``` 
Nota cambiar ruta_aplicacion por la ruta completa donde se encuentra la aplicaciÃ³n, si se requiere almacenar el log de cada ejecucion de la tarea sustituir `/dev/null` por una ruta con nombre del log con la extension .log donde se desea almacenar dicho archivo.

## DocumentaciÃ³n

la nueva documentaciÃ³n con Swagger (Open Api) se accede en ambiente de desarrollo a traves de [este enlace](http://127.0.0.1:8083/api/documentation) y en el ambiente de testing [este enlace](https://dev.fisicalcoach.com/api/documentation)

La documentaciÃ³n anterior de los endpoints que conforman la api se lleva sobre Insomnia `https://insomnia.rest/`.
Dentro del directorio raÃ­z del proyecto se encuentra una carpeta con el nombre de documentation que contiene un json (insomnia.json) con detalle de cada endpoint, el cual puede ser importado a Postman/Insomnia para realizar pruebas y test.

## Code quality

Para analizar errores de cÃ³digo (nivel sensibilidad mÃ¡xima):

```bash
docker-compose exec api-fisco-php php vendor/bin/phpstan analyse --memory-limit=512M
```

## Herramienta de desarrollo

Para depurar la aplicaciÃ³n y tener informaciÃ³n de las peticiones, consultas a la base de datos, eventos ejecutados, entre otra funciones se encuentra el paquete clockwork, para interactuar con los datos se accede a la interfaz web desde [este enlace](http://127.0.0.1:8083/clockwork/app).

## Rendimiento y Seguridad

Para mejorar el rendimiento y la seguridad, se usa el paquete Enlinghtn

```bash
docker-compose exec api-fisco-php php artisan enlightn
```

## Ramas

- master: codigo para el ambiente de produccion.
- develop: codigo para el ambiente de desarrollo y test.

## Creacion de Paquetes en Stripe

Para crear los paquetes de stripe (ambiente produccion) que se definieron en la aplicacion

```bash
docker-compose exec api-fisco-php php artisan module:seed --class=CreatePlansStripeTableSeeder Package
```

## Licencia

Este proyecto estÃ¡ bajo la Licencia Privada
