# Login_PDS
Descripción General
Este sistema de login PHP y MySQL proporciona una interfaz de usuario intuitiva para autenticarse y gestionar cuentas. Los administradores cuentan con un panel para controlar a los usuarios registrados, incluyendo la creación, modificación y eliminación de cuentas.

Requisitos del Sistema
Servidor: Apache (configurado como se describe en la sección de instalación)
Base de datos: MySQL
Lenguajes: PHP 7.x o superior
Herramientas: Git para clonar el repositorio
Instalación
Clonar el repositorio:
Bash
git clone https://github.com/mgraneros/Login_PDS.git
Usa el código con precaución.

Configurar Apache

1.  En la seccion de apache ingresaremos con el servicio apagado, en el apartado de config haciendo click y seleccionaremos la opcion apache(httpd.conf)
En el archivo buscaremos el siguiente texto:
DocumentRoot "C:/xampp/htdocs/"
<Directory "C:/xampp/htdocs">
y lo cambiaremos por la ruta donde se encuentre guardado el proyecto (por ejemplo: "C:/xampp/htdocs/Login_PDS")
2. Luego encenderemos el apache y MySQL en la aplicacion de xampp
4. Ingresaremos mediante el navegador con la siguiente ruta: "localhost"
5. Ya en esta instancia, visualizaremos lo que seria nuestro main de pagina de registro

Crear la base de datos: Importar el esquema ejecutar el script tp (1).sql para crear las tablas y relaciones necesarias.

Configurar el archivo de conexión:
Editar db.php: Introducir los datos de conexión a tu base de datos (host, usuario, contraseña, base de datos).

Iniciar el servidor:
Iniciar Apache y MySQL: Asegurarse de que ambos servicios estén en ejecución.

Uso
Acceso de usuario:
Acceder a la URL base (por ejemplo, http://localhost/Login_PDS) para ver la página de inicio de sesión.
Introducir las credenciales válidas para iniciar sesión.

Acceso de administrador:
Iniciar sesión con las credenciales de administrador.
El panel de administración (en userController.php) permitirá gestionar usuarios.
Estructura del Proyecto
index.php: Página de inicio y formulario de login.
register.php: Formulario de registro de nuevos usuarios.
userController.php: Lógica para gestionar usuarios (crear, editar, eliminar).
db.php: Configuración de conexión a la base de datos.
tp.sql: Script SQL para crear las tablas de la base de datos.

Contribuciones
Las contribuciones son bienvenidas. Por favor, abre un issue en el repositorio para discutir cualquier mejora o problema.
