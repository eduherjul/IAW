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
$consulta = "SELECT id, nombre, edad FROM $nomtabla WHERE id='$_REQUEST[id]'";
$registros = mysqli_query($conexion, $consulta);
$datos = mysqli_fetch_array($registros);

// Cerrar la conexión
mysqli_close($conexion);
?>


<html>
<!-- Mostrar formulario con los datos actuales para actualizar -->

<head>
  <title>Insert datos</title>
</head>

<body>
  <h1>Modificar Estudiante</h1>
  <form action="guardarcambios.php" method="post">
    <!--Campo oculto para el id -->
    <input type="hidden" name="id" value="<?php echo $datos['id']; ?>" />
    <br />

    <!-- Campos con los valores actuales -->
    Modifique nombre:
    <input type=" text" name="nombre" value="<?php echo $datos['nombre']; ?>" required /><br /><br />

    Modifique edad:
    <input type="text" name="edad" value="<?php echo $datos['edad']; ?>" min="1" required /><br /><br />

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Guardar cambios" />
  </form>
</body>

</html>