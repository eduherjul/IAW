<?php
// Dimensiones de la imagen
$ancho = 150;
$alto = 50;

// Crear la imagen
$imagen = imagecreate($ancho, $alto);

// Colores
$amarillo = imagecolorallocate($imagen, 255, 255, 0); // Fondo amarillo
$rojo = imagecolorallocate($imagen, 255, 0, 0); // Texto y líneas rojas

// Llenar el fondo de la imagen
imagefill($imagen, 0, 0, $amarillo);

// Generar el valor aleatorio
$valoraleatorio = rand(100000, 999999);

// Iniciar sesión para guardar el valor aleatorio
session_start();
$_SESSION['valoraleatorio'] = $valoraleatorio;

// Agregar el valor aleatorio a la imagen
imagestring($imagen, 5, 25, 5, $valoraleatorio, $rojo);

// Dibujar líneas de ruido
for ($c = 0; $c <= 5; $c++) {
  $x1 = rand(0, $ancho);
  $y1 = rand(0, $alto);
  $x2 = rand(0, $ancho);
  $y2 = rand(0, $alto);
  imageline($imagen, $x1, $y1, $x2, $y2, $rojo);
}

// Establecer la cabecera para la imagen
header("Content-type: image/jpeg");

// Generar y mostrar la imagen
imagejpeg($imagen);

// Liberar la memoria
imagedestroy($imagen);
