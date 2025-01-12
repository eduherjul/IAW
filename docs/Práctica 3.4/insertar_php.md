```php
  <?php
  require_once 'connection.php';
  require_once 'redirec_tiempo.php';

  // Conectar a la base de datos
  $conexion = Connection();

  // Obtener las contraseñas del formulario 
  $password1 = $_REQUEST['password1'];
  $password2 = $_REQUEST['password2'];

  // Verificar que las contraseñas coincidan 
  if ($password1 === $password2) {

    // Verificar si el usuario ya existe
    $consulta = "SELECT * FROM usuarios WHERE email='$_REQUEST[email]'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado->num_rows > 0) {

      // El usuario ya existe
      require_once 'redirec_tiempo.php';
      // Llamar a la función
      redireccionConContador("El usuario con el correo '$_REQUEST[email]' ya está registrado. Por favor, utiliza otro correo.", 3, "/practica3.4/registro.html");
    } else {
      // El usuario no existe, insertar en la base de datos
      // Continuar con la inserción en la base de datos si las contraseñas coinciden
      mysqli_query($conexion, "insert into usuarios(nombre,apellidos,email,password) values 
                        ('$_REQUEST[nombre]','$_REQUEST[apellidos]','$_REQUEST[email]','$_REQUEST[password1]')")
        or die("Problemas en el select" . mysqli_error($conexion));
      mysqli_close($conexion);
    }
    // Redirigir al usuario
    require_once 'redirec_tiempo.php';
    // Llamar a la función
    redireccionConContador("El usuario '$_REQUEST[nombre]' registrado corectamente", 3, "/practica3.4/operacionesBBDD.html");
  } else {
    require_once 'redirec_tiempo.php';
    // Llamar a la función
    redireccionConContador("Las contraseñas no coinciden. Por favor, inténtalo de nuevo", 3, "/practica3.4/registro.html");
  }
  ?>
```  
