GesCliAdm
Integrantes del equipo:

Eric Pérez
Rubén del Olmo Calderón
Una vez hecho el clone de la aplicación debemos seguir los pasos que nos indica en este enlace

Una vez recuperado el .env y configurado para tu base de datos procedemos a cargar los datos a ésta. Para cargar las tablas de la base de datos deberemos posicionarnos con consola en la carpeta del proyecto y poner el siguiente comando: - php artisan migrate

A continuación cargamos los datos que se nos insertarán en las tablas con el siguiente comando: php artisan db:seed

Para poder subir archivos es importante poner el siguiente comando: - php artisan storage:link
