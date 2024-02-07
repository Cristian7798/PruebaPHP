#### Tema: encuestas

#### Requerimientos
- Desarrollar un formulario dinámico, el cual, dependiendo del tipo seleccionado por medio de un combo, carge de forma asyncrona las preguntas correspondientes.
- Asignación de opciones de respuestas por JavaScript
- Guardado asyncrono del formulario generado.
- Resumen/estadisticas de los registros ingresados por cada formulario, y un promedio de los mismos.
- Desarrollar en PHP puro sin frameworks ni librerías.
- Desarrollado con javaScript vanilla

#### Caracteristicas
- PHP 8.1.10
- javascript
- Asyncronía con fetch
- Bootstrap
- BD mySql

#### Implementación
Se requiere tener las variables de entorno de la BD en el archivo `config\Constants.php`, crear una BD `(ej: pruebaphp)`  y un servidor de entorno de desarrollo.

    <?php
        define("SERVIDORBD", "localhost");
		define("PUERTO", "3306");
		define("NOMBREBD", "pruebaphp");
		define("USUARIO", "root");
		define("PASSWORD", "");
    ?>
URL de acceso al inicio EN ENTORNO DE DESARROLLO: `http://localhost/{nombre_carpeta}/index.php`

URL de acceso a estadísticas EN ENTORNO DE DESARROLLO: 
Normal: `http://localhost/{nombre_carpeta}/estadisticas.php`
Ajax: `http://localhost/{nombre_carpeta}/estadisticasAjax.php`