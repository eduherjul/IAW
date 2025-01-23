<?php
$correo_destinatario = "udexeraco@hotmail.com";
$asunto = "Prueba desde PHP simplificado";
$codigo = rand(100000, 999999); // Código de 6 dígitos
$mensaje = "Tu código de verificación es: $codigo\n\nSi no solicitaste este código, ignora este mensaje.";
$cabeceras = "From: udexeraco@gmail.com\r\n";

// Enviar el correo
if (mail($correo_destinatario, $asunto, $mensaje, $cabeceras)) {
  // Guardar el código en una sesión para verificarlo en verificar.html
  session_start();
  $_SESSION['codigo_verificacion'] = $codigo;

  // Redirigir a verificar.html
  header("Location: http://localhost/practica3.5.2/verificar.html");
  exit();
} else {
  echo "Error al enviar el correo.";
}
