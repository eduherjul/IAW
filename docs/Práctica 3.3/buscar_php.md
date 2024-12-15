```php

  <?php
  // Configuración de conexión
  $servidor = "localhost:3306";
  $usuario = "alumne";
  $password = "alumne";
  $nomBBDD = "instituto";
  $nomtabla = "estudiantes";

  // Conexion a la base de datos
  $conexion = new mysqli($servidor, $usuario, $password, $nomBBDD) or
    die("Problemas con la conexión");

  // Recuperar datos desde MySQL 
  $consulta = "SELECT id,nombre,edad FROM $nomtabla WHERE id='$_REQUEST[id]'";
  $registros = mysqli_query($conexion, $consulta);

  //Mostrar resultados
  while ($reg = mysqli_fetch_array($registros)) {
    echo "DATOS OBTENIDOS:<br><br>";
    echo "Identificador: " . $reg['id'] . "<br>";
    echo "Nombre: " . $reg['nombre'] . "<br>";
    echo "Edad: " . $reg['edad'] . "<br>";
  }
  // Cerrar la conexion
  mysqli_close($conexion);
  ?>
```
