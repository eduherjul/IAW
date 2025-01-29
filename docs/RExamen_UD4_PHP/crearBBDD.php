<?php
// Configuración de conexión
$servidor = "localhost:3306";
$usuario = "alumne";
$password = "alumne";
$nomBBDD = "acortador_url";
$nomtabla1 = "usuarios";
$nomtabla2 = "urls";

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $password);

// Verificar conexión
if ($conexion->connect_error) {
  die("Problemas con la conexión: " . $conexion->connect_error);
}

// Comprobar o crear base de datos
if ($conexion->query("SHOW DATABASES LIKE '$nomBBDD'")->num_rows == 0) {
  if ($conexion->query("CREATE DATABASE `$nomBBDD`") === TRUE) {
    echo "Creada BBDD $nomBBDD.<br><br>";
  } else {
    die("Error al crear la BBDD $nomBBDD: " . $conexion->error);
    echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/menu.html">';
    exit();
  }
} else {
  echo "La BBDD $nomBBDD ya existe. No se realizará ninguna acción.<br><br>";
  echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/menu.html">';
  exit();
}

// Seleccionar base de datos
$conexion->select_db($nomBBDD);

// Comprobar o crear tabla usuarios
if ($conexion->query("SHOW TABLES LIKE '$nomtabla1'")->num_rows == 0) {
  $creatabla = "CREATE TABLE `$nomtabla1` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
  if ($conexion->query($creatabla) === TRUE) {
    echo "Tabla '$nomtabla1' creada correctamente.<br>";
  } else {
    die("Error al crear la tabla $nomtabla1: " . $conexion->error);
    echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/menu.html">';
    exit();
  }
} else {
  echo "La tabla '$nomtabla1' ya existe. No se realizará ninguna acción.<br>";
  echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/menu.html">';
  exit();
}

// Comprobar o crear tabla urls
if ($conexion->query("SHOW TABLES LIKE '$nomtabla2'")->num_rows == 0) {
  $creatabla = "CREATE TABLE `$nomtabla2` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        url_original TEXT NOT NULL,
        url_corta VARCHAR(255) UNIQUE NOT NULL,
        usuario_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )";
  if ($conexion->query($creatabla) === TRUE) {
    echo "Tabla '$nomtabla2' creada correctamente.<br>";
    echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/menu.html">';
    exit();
  } else {
    die("Error al crear la tabla $nomtabla2: " . $conexion->error);
    echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/menu.html">';
    exit();
  }
} else {
  echo "La tabla '$nomtabla2' ya existe. No se realizará ninguna acción.<br>";
  echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/menu.html">';
  exit();
}

// Cerrar conexión
$conexion->close();
