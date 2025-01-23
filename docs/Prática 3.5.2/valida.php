<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = $_POST['usuario'];
  $contraseña = $_POST['contraseña'];
  $captcha = $_POST['captcha'];

  // Verificar el CAPTCHA
  if ($captcha === $_SESSION['captcha']) {
    echo "CAPTCHA correcto. Bienvenido, $usuario!";
    // Aquí puedes agregar la lógica de autenticación
  } else {
    echo "CAPTCHA incorrecto. Inténtalo de nuevo.";
  }
}
