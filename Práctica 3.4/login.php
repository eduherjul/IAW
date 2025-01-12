<?php

use FTP\Connection;

require_once 'connection.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Recuperar y validar los datos enviados desde el formulario
$usuario = $_REQUEST["usuario"];
$contraseña = $_REQUEST["contraseña"];

if (empty($usuario) || empty($contraseña)) {
  header("Location: /practica3.4/login.html?error=campos_vacios");
  exit();
}

// Conexión a la base de datos
$conexion = Connection();
if ($conexion->connect_error) {
  die("Error en la conexión: " . $conexion->connect_error);
}

// Consulta segura con prepared statements
$consulta = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE nombre = ?");
$consulta->bind_param("s", $usuario);
$consulta->execute();
$resultado = $consulta->get_result();

if ($resultado->num_rows > 0) {
  $fila = $resultado->fetch_assoc();
  $password = $fila['password'];
  $user_id = $fila['id'];

  // Verificar la contraseña
  if ($contraseña === $password) {
    $_SESSION["username"] = $usuario;

    // Redirigir al usuario
    require_once 'redirec_tiempo.php';
    redireccionConContador("Inicio de sesión correcto", 3, "/practica3.4/protegida.php");
    exit();
  } else {
    require_once 'redirec_tiempo.php';
    redireccionConContador("Credenciales inválidas.", 3, "/practica3.4/login.html");
  }
} else {
  require_once 'redirec_tiempo.php';
  redireccionConContador("Credenciales inválidas.", 3, "/practica3.4/login.html");
}

// Cerrar la conexión
$conexion->close();
