<?php

//Ver errores
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once 'connection.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start(); // Inicia la sesión para acceder a $_SESSION
}
//Verificar que el captcha está definido
if (!isset($_SESSION["valoraleatorio"])) {
  header("Location: /practica3.5.1/login.html?error=captcha_no_definido");
  exit();
}

$valorgenerado = $_SESSION["valoraleatorio"];
unset($_SESSION["valoraleatorio"]); // Elimina el valor una vez verificado


// Recuperar y validar los datos enviados desde el formulario
$usuario = trim($_REQUEST["usuario"] ?? '');
$contraseña = trim($_REQUEST["contraseña"] ?? '');
$captcha = trim($_REQUEST['captcha'] ?? '');

// Verificar el CAPTCHA
if ((int) $captcha !== (int) $valorgenerado) {
  require_once 'redirec_tiempo.php';
  redireccionConContador("CAPTCHA INCORRECTO", 3, "/practica3.5.1/login.html");
  exit();
}

//Controlar los campos vacíos
if (empty($usuario) || empty($contraseña)) {
  header("Location: /practica3.5.1/login.html?error=campos_vacios");
  exit();
}

//Conexión a la BBDD
$conexion = Connection();
if ($conexion->connect_error) {
  die("Error en la conexión.");
}

//Preparando la consulta
$consulta = $conexion->prepare("SELECT id, nombre_usuario, password FROM usuarios WHERE nombre_usuario = ?");
$consulta->bind_param("s", $usuario);
$consulta->execute();
$resultado = $consulta->get_result();

//Consulta la BBDD en forma fila de array-asociativo
if ($resultado->num_rows > 0) {
  $fila = $resultado->fetch_assoc();

  //Verificamos la contraseña
  if (password_verify($contraseña, $fila['password'])) {
    //Almacenar nombre de usurio
    $_SESSION["username"] = $usuario;
    $_SESSION["estoy"] = true;


    // Insertar el nuevo login en la BBDD
    $insertar = "INSERT INTO logins(username) VALUES (?)";
    $realiza = $conexion->prepare($insertar);
    $realiza->bind_param("s", $usuario);

    // Ejecutar la consulta
    if ($realiza->execute()) {
      $mensaje = "El login '$usuario' se ha registrado correctamente";
    } else {
      redireccionConContador("Error al registrar el login del usuario: $usuario. Por favor, inténtalo de nuevo.", 3, "/practica3.5.1/registro.html");
    }

    // Cerrar la sentencia de inserción
    $realiza->close();
    // Cerrar la sentencia de $resultado
    $resultado->close();

    require_once 'redirec_tiempo.php';
    redireccionConContador("LOGIN CORRECTO<br><br>$mensaje", 3, "/practica3.5.1/protegida.php");
  } else {
    require_once 'redirec_tiempo.php';
    redireccionConContador("CREDENCIALES INVALIDAS", 3, "/practica3.5.1/login.html");
  }
} else {
  require_once 'redirec_tiempo.php';
  redireccionConContador("CREDENCIALES INVALIDAS", 3, "/practica3.5.1/login.html");
}

$conexion->close();
