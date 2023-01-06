# Json PHP #

## Contenido ##

1. Introducción.
2. Dependencias.
3. Comenzando.

## Introducción ##

Este proyecto surge como una alternativa a la creación de servicios web.

## Dependencias ##

* Node.js (https://nodejs.org).
  - Ejecute "node -v" en la consola de su sistema operativo para ver si ya está instalado.
* Npm CLI (https://docs.npmjs.com/cli).
  - En Windows viene con el instalador de Node.js.
  - En los sistemas operativos basados en Linux deberá instalarlo.
  - Ejecute "npm -v" en la consola de su sistema operativo para ver si ya está instalado.
* Python (https://www.python.org).
  - En Windows debe instalarlo y agregarlo a la ruta del sistema operativo.
  - En los sistemas operativos basados en Linux debe ejecutar el comando "sudo apt-get install python-is-python3".
  - Ejecute "python --version" en la consola de su sistema operativo para ver si ya está instalado.
* Entorno basado en Apache, MySQL y PHP.
  - AMPPS, XAMPP, WAMP, LAMP o MAMP.
* JsonPHP CLI.
  - Ejecute "npm i jsonphp-cli -g".
  - En los sistemas operativos basados en Linux incluya "--unsafe-perm". El comando se vería así "npm i jsonphp-cli -g --unsafe-perm".
  - Ejecute "jsonphp-cli --version" en la consola de su sistema operativo para ver si ya está instalado.

## Comenzando ##

Usando la consola de nuestro sistema operativo accederemos al directorio que queramos para nuestro proyecto, luego ejecutaremos el siguiente comando que cargará todos los archivos del proyecto "jsonphp".

~~~
jsonphp-cli install
~~~