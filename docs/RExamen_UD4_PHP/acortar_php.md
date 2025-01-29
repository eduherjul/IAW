```php
<?php
session_start();
require 'conexion.php';

// Conectar a la base de datos
$conexion = Connection();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuarioId = $_SESSION['usuario_id'];
  $url_original = $_POST['url_original'];

  
  // Generamos un hash único de 6 caracteres
  $hash = substr(md5($url_original . time()), 0, 6); 
  $url_corta = "http://localhost/" . $hash;

  $consulta = $conexion->prepare("INSERT INTO urls (url_original, url_corta, usuario_id) VALUES (?, ?, ?)");
  $consulta->execute([$url_original, $url_corta, $usuarioId]);
  
  //Almacenamos la url generada
  $_SESSION["url_corta"] = $url_corta;

  //Mostramos la URL corta generada
  echo "URL corta generada: <a href='$url_corta'>$url_corta</a>";
  echo '<meta http-equiv="refresh" content="5;url=/examen_IAW/menu.html">';
  exit;
}
```
