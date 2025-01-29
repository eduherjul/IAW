```php
<?php
require 'conexion.php';

// Conectamos a la base de datos
$conexion = Connection();

// Verificamos si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Obtenemos la URL corta desde el formulario
  $url_corta = $_POST['url_corta'];

  // Validamos que no esté vacío
  if (!empty($url_corta)) {

    // Usamos una consulta preparada para evitar inyección SQL
    $consulta = $conexion->prepare("SELECT id, url_original, url_corta FROM urls WHERE url_corta = ?");
    $consulta->bind_param("s", $url_corta);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verificamos si se encontraron resultados
    if ($resultado->num_rows > 0) {
      while ($reg = $resultado->fetch_assoc()) {
        echo "url-original: " . $reg['url_original'] . "<br>";
        echo "url-corta: " . $reg['url_corta'] . "<br>";
        $url_destino = $reg['url_original'];

        // Redirigir al usuario a la URL completa
        header("Location: ". $url_destino);
        exit;
      }
    } else {
      echo "No se encontró ninguna URL con ese código.";
      echo '<meta http-equiv="refresh" content="5;url=/examen_IAW/redirect1.php">';
      exit;
    }

    // Cerramos la consulta
    $consulta->close();
  } else {
    echo "Por favor, ingresa una URL corta.";
    echo '<meta http-equiv="refresh" content="5;url=/examen_IAW/redirect1.php">';
  }
}

// Cerramos la conexión
$conexion->close();
```
