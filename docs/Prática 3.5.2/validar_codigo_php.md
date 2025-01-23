```php
<?php
require_once 'redirec_tiempo.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $codigo_ingresado = $_POST['codigo'];

  // Verificar si el código ingresado coincide con el generado
  if (isset($_SESSION['codigo_verificacion']) && $_SESSION['codigo_verificacion'] == $codigo_ingresado) {
    redireccionConContador("Código verificado correctamente.", 3, "/practica3.5.2/registro.html");

  } else {
    redireccionConContador("Código incorrecto. Intenta de nuevo.", 3, "/practica3.5.2/inicio.html");
  
  }
} else {
  echo "Acceso no permitido.";
}
```
