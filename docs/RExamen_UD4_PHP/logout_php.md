```php
<?php
// Iniciar la sesión si aún no está iniciada
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Limpiar todas las variables de sesión
session_unset();

// Mostrar mensaje y redirigir al usuario a Google
echo "CIERRO LA SESIÓN Y TE MANDO A GOOGLE. Redirigiendo en 3 segundos...";
echo '<meta http-equiv="refresh" content="3;url=https://www.google.es">';
exit();
```
