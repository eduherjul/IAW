```php
<?php
session_start();
require 'conexion.php';

// Conectar a la base de datos
$conexion = Connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['nombre'];
    $password = $_POST['password'];

    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE nombre = ?");
    
    //Vincular el parámetro
    $consulta->bind_param("s", $username);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verificar si se encontró el usuario
    if ($usuario = $resultado->fetch_assoc()) {
        // Validar la contraseña
        if (password_verify($password, $usuario['password'])) {
            // Iniciar sesión y redirigir
            $_SESSION['usuario_id'] = $usuario['id'];
            echo "LOGIN CORRECTO";
            echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/acortar.html">';
            exit;
        } else {
            // Contraseña incorrecta
            echo "Usuario o contraseña incorrectos.";
            echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/menu.html">';
            exit;
        }
    } else {
        // Usuario no encontrado
        echo "Usuario o contraseña incorrectos.";
        echo '<meta http-equiv="refresh" content="3;url=/examen_IAW/menu.html">';
        exit;
    }
}
```
