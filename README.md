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
* PDO (MySQL)
* XML
* Curl (para composer)

Instalacion
-----------

Para instalar el sistema, primero debemos clonar el repositorio, siguiendo este orden
de comandos:

* Clonamos el repositorio: `git clone https://github.com/KiritoXD01/mini-sistema-registro.git`
* Luego copiamos el archivo `.env.example` con: `cp .env.example .env`
* abrimos el archivo `.env` y modificamos los siguientes atributos:

**APP_NAME:** nombre de la aplicacion ("Mini Sistema Registro"), con las comillas
para que tome los espacios en blanco.

**APP_ENV:** El entorno donde estara la aplicacion, **local** para local y pruebas,
**production** para ambientes de produccion.

**APP_DEBUG:** Habilita o deshabilita los errores visuales.

**APP_URL:** El dominio que apunta al servidor donde reside la aplicacion.

**APP_LOCALE:** El idioma por defecto de la aplicación: "es" para español, "en" para
ingles.

**APP_TIMEZONE:** Hora horaria a usar: para republica dominicana por defecto seria:
`America/Santo_Domingo`

* Luego modificamos la sección de base de datos con los datos del servidor de base
de datos a utilizar, el ejemplo puede ser encontrado en el archivo `.env.example`.

* Luego para instalar todas las dependencias del proyecto, usamos el comando `composer install`,
este nos avisara si falta alguna extension de PHP para ser instalado.

* Al terminar, debemos generar la llave de seguridad de la aplicación, para esto usamos
el comando `php artisan key:generate`.

* Ahora se configura el servidor web para mostrar la aplicacion, se recomienda 
[nginx](https://www.digitalocean.com/community/tutorials/how-to-install-laravel-with-an-nginx-web-server-on-ubuntu-14-04),
[Aqui esta como debe quedar el archivo de virtualhost](https://laravel.com/docs/7.x/deployment#nginx).
Recordando que debe apuntar a la carpeta `public` del proyecto. puede ser instalado tambien con Apache,
pero no maneja la misma cantidad de usuarios conectados al mismo tiempo.

* Para crear las tablas de la base de datos y agregar los datos iniciales, (habiendo 
ya configurado la base de datos), se ejecuta el comando: `php artisan migrate --seed`

Datos de usuario ADMIN
----------------------

* **Usuario:** admin@admin.com
* **Clave:** password

Sistema de Permisos del sistema
-------------------------------

El sistema contiene permisos para poder crear usuarios con diferentes niveles de acceso.
Aqui el listado de todos los permisos disponibles:

Permiso              | Descripcion
:------------------- | :----------------------------------------------
user-list            | Lista todos los usuarios creados en el sistema
user-create          | Crear usuarios (tambien importacion de usuarios)
user-show            | Mostrar informacion de usuario en especifico
user-edit            | Editar informacion de usuario en especifico
user-delete          | Deshabilitar un usuario
role-list            | Lista todos los roles creados en el sistema
role-create          | Crear roles de usuario
role-show            | Mostrar informacion de Rol en especifico
role-edit            | Editar informacion de Rol en especifico
role-delete          | Eliminar Rol 
teacher-list         | Lista todos los profesores creados en el sistema
teacher-create       | Crear profesores (tambien importacion de profesores)
teacher-show         | Mostrar informacion de usuario en especifico
teacher-edit         | Editar informacion de usuario en especifico
teacher-delete       | Deshabilitar un usuario
student-list         | Lista todos los estudiantes creados en el sistema
student-create       | Crear estudiantes (tambien importacion de estudiantes)
student-show         | Mostrar informacion de estudiante en especifico
student-edit         | Editar informacion de estudiante en especifico
student-delete       | Deshabilitar un estudiante
course-list          | Lista todos los cursos creados en el sistema
course-create        | Crear cursos
course-show          | Mostrar informacion de curso en especifico
course-edit          | Editar informacion de curso en especifico
course-delete        | Deshabilitar un curso
course-students      | Administrar estudiantes d en un curso (remover o agregar)
course-points        | Cambiar puntos de un estudiante en un curso
course-certification | Obtener certificado de un estudiante
study-subject-list   | Lista todos las materias creadas en el sistema
study-subject-create | Crear materias (tambien importacion de materias)
study-subject-show   | Mostrar informacion de una materia en especifico
study-subject-edit   | Editar informacion de una materia en especifico
study-subject-delete | Deshabilitar una materia
institution-show     | Mostrar informacion de la institucion
institution-edit     | Editar informacion de la institucion

Plantillas de importacion
-------------------------

Las pantallas de Usuarios, Profesores, Estudiantes y materias pueden importar datos
a traves de un archivo CSV o Excel, para hacer esto crear el archivo (sin encabezados)
con el siguiente formato:

Pantalla             | Formato
:---------- | :----------------------------------------------
Usuarios    | nombre, email, clave
Estudiantes | nombre, apellido, email, clave
Profesores  | nombre, apellido, email, clave
Materias    | nombre, codigo
