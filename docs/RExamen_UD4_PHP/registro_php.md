```php
<?php
require 'conexion.php';

// Conectar a la base de datos
$conexion = Connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['nombre'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $consulta = $conexion->prepare("INSERT INTO usuarios (nombre, password) VALUES (?, ?)");
  $consulta->execute([$username, $password]);
  echo "El usuario '$username' se ha registrado correctamente.";
  echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/menu.html">';
}
```
