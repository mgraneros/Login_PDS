# Login_PDS
Descripción General
Este sistema de login permite a los usuarios autenticarse en una aplicación web utilizando PHP y MySQL como tecnologías principales. Además, cuenta con una interfaz de administración que otorga al administrador los permisos para gestionar los usuarios registrados, incluyendo la posibilidad de dar de baja cuentas o modificar sus datos.

Antes que nada usaremos xampp para levantar el servidor y configurar el ingreso a la aplicacion.
1. En la seccion de apache ingresaremos con el servicio apagado, en el apartado de config haciendo click y seleccionaremos la opcion apache(httpd.conf)
2. En el archivo buscaremos el siguiente texto:
DocumentRoot "C:/xampp/htdocs/"
<Directory "C:/xampp/htdocs">
y lo cambiaremos por el siguiente
DocumentRoot "C:/xampp/htdocs/Login_PDS"
<Directory "C:/xampp/htdocs/Login_PDS">
3. Luego encenderemos el apache y MySQL en la aplicacion de xampp
4. Ingresaremos mediante el navegador con la siguiente ruta: "localhost"
5. Ya en esta instancia, visualizaremos lo que seria nuestro main de pagina de registro

Requisitos
Servidor web: Apache, Nginx o similar.
PHP: Versión 7.x o superior.
Base de datos: MySQL.
Navegador web: Cualquier navegador (Chrome, Firefox, Edge, etc.).
Instalación
Clonar el repositorio:
Bash
git clone https://github.com/mgraneros/Login_PDS.git
Usa el código con precaución.

Crear la base de datos: Crear una base de datos en MySQL con el nombre especificado en el archivo de configuración (por ejemplo, login). Ejecutar el script (tp.sql) de instalación SQL para crear las tablas necesarias.
Configurar el archivo de configuración: Editar el archivo config.php con los datos de conexión a la base de datos.
Iniciar el servidor web: Iniciar el servidor web y asegurarse de que el directorio raíz apunte al directorio del proyecto.
Uso
Acceso de usuario: Los usuarios registrados pueden acceder al sistema a través de la página de login.
Acceso de administrador: El administrador accede con sus credenciales y podrá:
Ver una lista de todos los usuarios registrados.
Editar los datos de un usuario.
Dar de baja un usuario.
Estructura de Archivos
index.php: Página principal del sistema.
login.php: Formulario de login.
register.php: Formulario de registro.
userController.php: Panel de administración.
db.php: Archivo de configuración con los datos de conexión a la base de datos.
tp.sql: Script SQL para crear las tablas de la base de datos.