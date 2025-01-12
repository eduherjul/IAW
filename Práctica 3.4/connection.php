<?php
function Connection()
{
  // Configuración de conexión
  $servidor = "localhost:3306";
  $usuario = "alumne";
  $password = "alumne";
  $nomBBDD = "todomovil";

  // Conexion a la base de datos
  $conexion = new mysqli($servidor, $usuario, $password, $nomBBDD) or
    die("Problemas con la conexión");

  //Verificamos si hay errores en la conexión
  if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
  }

  // Retornar el objeto de conexión
  return $conexion;
}
