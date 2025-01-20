```php
<?php
// Iniciar la sesión si aún no está iniciada
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Limpiar todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a Google
require_once 'redirec_tiempo.php';

// Llamar a la función
redireccionConContador("CIERRO LA SESION Y TE MANDO A GOOGLE", 3, "https://www.google.es");
exit();
```
