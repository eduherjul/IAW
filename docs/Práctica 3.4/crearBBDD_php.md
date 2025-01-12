```php
<?php
// Configuración de conexión
$servidor = "localhost:3306";
$usuario = "alumne";
$password = "alumne";
$nomBBDD = "todomovil";
$nomtabla = "usuarios";
$tabla = 0;

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $password) or
  die("Problemas con la conexión");

// Comprobar si la base de datos existe
$controlBBDD = "SHOW DATABASES LIKE '$nomBBDD'";
$resultadoBBDD = $conexion->query($controlBBDD);

if ($resultadoBBDD->num_rows > 0) {
  $mensaje = "La BBDD $nomBBDD ya existe. No se realizará ninguna acción.<br><br>";
} else {

  // Crear base de datos
  $creaBBDD = "CREATE DATABASE `$nomBBDD`";
  if ($conexion->query($creaBBDD) === TRUE) {
    $tabla = 1;
  } else {
    $mensaje = "Error al crear la BBDD $nomBBDD.<br><br>";
  }
}
// Seleccionar base de datos
$conexion->select_db($nomBBDD);

// Comprobar si la tabla existe
$controltabla = "SHOW TABLES LIKE '$nomtabla'";
$resultadoTabla = $conexion->query($controltabla);

if ($resultadoTabla->num_rows > 0) {
  $mensaje = "La tabla '$nomtabla' ya existe. No se realizará ninguna acción.<br>";
} else {

  // Crear tabla
  $creatabla = "CREATE TABLE `$nomtabla` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(25) NOT NULL UNIQUE,
    apellidos VARCHAR(75) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

  if ($conexion->query($creatabla) === TRUE) {
    $mensaje = "Tabla '$nomtabla' creada correctamente";
  } else {
    $mensaje = "Error al crear la tabla: $nomtabla";
  }
}

// Cerrar conexión
$conexion->close();

// Redirigir con mensajes acumulados
require_once 'redirec_tiempo.php';

if ($tabla === 1) {
  redireccionConContador("Creada BBDD $nomBBDD correctamente<br><br>$mensaje", 5, "/practica3.4/operacionesBBDD.html");
} else {
  redireccionConContador($mensaje, 5, "/practica3.4/operacionesBBDD.html");
}
```
