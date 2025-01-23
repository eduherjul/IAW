<?php
// Configuración de conexión
$servidor = "localhost:3306";
$usuario = "alumne";
$password = "alumne";
$nomBBDD = "sistema_login";
$nomtabla1 = "usuarios";
$nomtabla2 = "logins";
$tabla = 0;

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $password);
if ($conexion->connect_error) {
  die("Problemas con la conexión: " . $conexion->connect_error);
}

// Inicializar mensajes
$mensaje = "";
$mensaje1 = "";
$mensaje2 = "";

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

// Comprobar y crear primera tabla (usuarios)
$controltabla1 = "SHOW TABLES LIKE '$nomtabla1'";
$resultadoTabla1 = $conexion->query($controltabla1);

if ($resultadoTabla1->num_rows > 0) {
  $mensaje1 = "La tabla '$nomtabla1' ya existe. No se realizará ninguna acción.<br>";
} else {
  // Crear tabla usuarios
  $creatabla1 = "CREATE TABLE `$nomtabla1` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre_usuario VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

  if ($conexion->query($creatabla1) === TRUE) {
    $mensaje1 = "Tabla '$nomtabla1' creada correctamente.<br>";
  } else {
    $mensaje1 = "Error al crear la tabla '$nomtabla1'.<br>";
  }
}

// Comprobar y crear segunda tabla (logins)
$controltabla2 = "SHOW TABLES LIKE '$nomtabla2'";
$resultadoTabla2 = $conexion->query($controltabla2);

if ($resultadoTabla2->num_rows > 0) {
  $mensaje2 = "La tabla '$nomtabla2' ya existe. No se realizará ninguna acción.<br>";
} else {
  // Crear tabla logins
  $creatabla2 = "CREATE TABLE `$nomtabla2` (
        login_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(25) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

  if ($conexion->query($creatabla2) === TRUE) {
    $mensaje2 = "Tabla '$nomtabla2' creada correctamente.<br>";
  } else {
    $mensaje2 = "Error al crear la tabla '$nomtabla2'.<br>";
  }
}

// Cerrar conexión
$conexion->close();

// Redirigir con mensajes acumulados
require_once 'redirec_tiempo.php';

if ($tabla === 1) {
  redireccionConContador("Creada BBDD $nomBBDD correctamente<br><br>" . $mensaje1 . "<br>" . $mensaje2, 5, "/practica3.5.1/operacionesBBDD.html");
} else {
  redireccionConContador($mensaje1 . "<br><br>" . $mensaje2, 5, "/practica3.5.1/operacionesBBDD.html");
}
