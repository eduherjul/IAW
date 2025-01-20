<?php

//Ver errores
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once 'redirec_tiempo.php';

session_start(); // Inicia la sesión para acceder a $_SESSION

// Verificamos si el usuario ha iniciado sesión
if (!isset($_SESSION["estoy"]) || $_SESSION["estoy"] !== true) {
  //Redirigimos al login si no está logeado
  redireccionConContador("No estas LOGIN, vamos a ello", 3, "/practica3.5.1/login.html");
} else {
  //Redirigimos a la página protegida de acceso
  redireccionConContador("Has iniciado sesión correctamente", 3, "/practica3.5.1/protegida.php");
}
