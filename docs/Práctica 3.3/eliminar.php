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

  //Mostrar los resultados
  if ($reg = mysqli_fetch_array($registros)) {
    mysqli_query($conexion, "delete from $nomtabla where id='$_REQUEST[id]'") or
      die("Problemas en el select:" . mysqli_error($conexion));
    echo "Se efectuó el borrado del estudiante con identificador '$_REQUEST[id]'";
  } else {
    echo "No existe un estudiante con ese identificador.";
  }
  mysqli_close($conexion);
  ?>