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
  $consulta = "SELECT id, nombre, edad FROM $nomtabla";
  $registros = mysqli_query($conexion, $consulta);

  //Mostrar resultados
  while ($reg = mysqli_fetch_array($registros)) {
    echo "Codigo: " . $reg['id'] . "<br>";
    echo "Nombre: " . $reg['nombre'] . "<br>";
    echo "Edad: " . $reg['edad'] . "<br><br>";

    // Botón para eliminar el registro
    echo "<form method='post' action='eliminar.php'>
            <input type='hidden' name='id' value='" . $reg['id'] . "' />
            <button type='submit' name='eliminar'>Eliminar</button>
          </form>";

    // Botón para modificar el registro
    echo "<form method='post' action='modificar.php'>
            <input type='hidden' name='id' value='" . $reg['id'] . "' />
            <button type='submit' name='modificar'>Modificar</button>
          </form>";

    echo "<br>";
    echo "<hr>";
  }

  // Cerrar la conexion
  mysqli_close($conexion);
  ?>
```  
