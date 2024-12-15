```php
<?php
// Configuración de conexión
$servidor = "localhost:3306";
$usuario = "alumne";
$password = "alumne";
$nomBBDD = "instituto";
$nomtabla = "estudiantes";

// Conectar a la base de datos
$conexion = new mysqli($servidor, $usuario, $password, $nomBBDD) or
  die("Problemas con la conexión");

// Recuperar los datos enviados desde el formulario
$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
$edad = $_REQUEST['edad'];

// Consulta para actualizar el registro
$consulta = "UPDATE $nomtabla SET nombre = '$nombre', edad = '$edad' WHERE id = $id";

if (mysqli_query($conexion, $consulta)) {
  echo "Registro actualizado con éxito.";
} else {
  echo "Error al actualizar el registro: " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
```