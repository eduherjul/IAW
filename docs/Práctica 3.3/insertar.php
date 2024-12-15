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

  mysqli_query($conexion, "insert into $nomtabla(nombre,edad) values 
                        ('$_REQUEST[nombre]','$_REQUEST[edad]')")
    or die("Problemas en el select" . mysqli_error($conexion));

  mysqli_close($conexion);

  echo "El estudiante '$_REQUEST[nombre]' fue dado de alta.";
  ?>