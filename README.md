Mini Sistema Registro
=======================

Framework utilizado: [Laravel 7](https://laravel.com/docs/7.x)

Enlace de modelo de base de datos: https://dbdiagram.io/d/5ebaa8bb39d18f5553ff14e8

Requisitos de sistema
---------------------
Se recomienda usar una maquina virtual para el sistema por la siguientes razones:

* Mayor escalabilidad
* Control de versiones
* Control de actualizaciones
* Mayor seguridad

Puede ser instalado en un hosting (GoDaddy, Bluehost, etc), pero la mayoria de los
pasos están enfocado en una maquina virtual, al instalar en un hosting se recomienda 
hacer estos pasos en local y luego subir la carpeta del proyecto por **FTP**.

Se requieren los siguientes componentes:

* PHP: 7.2.5 en adelante
* Servidor Apache o Nginx
* MySQL 5.7 (8.0 es soportado pero puede causar imcompatibilidad en la conexion)
* Composer

Tambien son requeridas las siguientes extensiones de PHP:

* BCMath
* Ctype
* Fileinfo
* JSON
* MBstring
* PDO
* XML

Instalacion
-----------

Para instalar el sistema, primero debemos clonar el repositorio, siguiendo este orden
de comandos:

1. Clonamos el repositorio: `git clone https://github.com/KiritoXD01/mini-sistema-registro.git`
2. Entramos a la carpeta del proyecto e instalamos las dependencias de Laravel con: `composer install`
3. Luego copiamos el archivo `.env.example` con: `cp .env.example .env`
4. abrimos el archivo `.env` y modificamos los siguientes atributos:
* **APP_NAME:** nombre de la aplicacion ("Mini Sistema Registro"), con las comillas
para que tome los espacios en blanco.
* **APP_ENV:** El entorno donde estara la aplicacion, **local** paar local y pruebas,
**production** para ambientes de produccion.
* **APP_DEBUG:** Habilita o deshaabilita los errores visuales.
* **APP_URL:** El dominio que apunta al servidor donde reside la aplicacion.
* **APP_LOCALE:** El idioma por defecto de la aplicacion: "es" para espanol, "en" para
ingles.
* **APP_TIMEZONE:** Hora horaria a usar: para republica dominicana por defecto seria:
`America/Santo_Domingo`

