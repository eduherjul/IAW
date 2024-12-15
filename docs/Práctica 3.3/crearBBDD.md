```php

<?php
// Configuración de conexión
$servidor = "localhost:3306";
$usuario = "alumne";
$password = "alumne";
$nomBBDD = "instituto";
$nomtabla = "estudiantes";

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $password) or
  die("Problemas con la conexión");

// Comprobar si la base de datos existe
$controlBBDD = "SHOW DATABASES LIKE '$nomBBDD'";
$resultadoBBDD = $conexion->query($controlBBDD);

if ($resultadoBBDD->num_rows > 0) {
  echo "La BBDD $nomBBDD ya existe. No se realizará ninguna acción.<br><br>";
} else {

  // Crear base de datos
  $creaBBDD = "CREATE DATABASE `$nomBBDD`";
  if ($conexion->query($creaBBDD) === TRUE) {
    echo "Creada BBDD $nomBBDD.<br><br>";
  } else {
    echo "Error al crear la BBDD $nomBBDD.<br><br>";
  }
}
// Seleccionar base de datos
$conexion->select_db($nomBBDD);

// Comprobar si la tabla existe
$controltabla = "SHOW TABLES LIKE '$nomtabla'";
$resultadoTabla = $conexion->query($controltabla);

if ($resultadoTabla->num_rows > 0) {
  echo "La tabla '$nomtabla' ya existe. No se realizará ninguna acción.<br>";
} else {

  // Crear tabla
  $creatabla = "CREATE TABLE `$nomtabla` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    edad INT NOT NULL
)";

  if ($conexion->query($creatabla) === TRUE) {
    echo "Tabla '$nomtabla' creada correctamente";
  } else {
    echo "Error al crear la tabla: $nomtabla";
  }
}

// Cerrar conexión
$conexion->close();
?>
```
