<?php
require_once 'connection.php';
require_once 'redirec_tiempo.php';

// Conectar a la base de datos
$conexion = Connection();

// Obtener las contraseñas del formulario
$password1 = $_REQUEST['password1'];
$password2 = $_REQUEST['password2'];
$nombre = $_REQUEST['nombre']; // Capturamos el nombre para reutilizarlo

// Verificar que las contraseñas coincidan
if ($password1 === $password2) {
    // Verificar si el usuario ya existe
    $tria = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
    $haz = $conexion->prepare($tria);
    $haz->bind_param("s", $nombre);
    $haz->execute();
    $resultado = $haz->get_result();

    if ($resultado->num_rows > 0) {
        // El usuario ya existe
        redireccionConContador("El usuario con el nombre '$nombre' ya está registrado. Por favor, utiliza otro nombre.", 3, "/practica3.5.1/registro.html");
    } else {
        // El usuario no existe, generar el hash de la contraseña
        $hash_password = password_hash($password1, PASSWORD_BCRYPT);

        // Insertar el nuevo usuario en la BBDD
        $insertar= "INSERT INTO usuarios (nombre_usuario, password) VALUES (?, ?)";
        $realiza = $conexion->prepare($insertar);
        $realiza->bind_param("ss", $nombre, $hash_password);

        // Ejecutar la consulta
        if ($realiza->execute()) {
            // Redirigir al usuario en caso de éxito
            redireccionConContador("El usuario '$nombre' se ha registrado correctamente.", 3, "/practica3.5.1/operacionesBBDD.html");
        } else {
            // Error al insertar
            redireccionConContador("Error al registrar el usuario. Por favor, inténtalo de nuevo.", 3, "/practica3.5.1/registro.html");
        }

        // Cerrar la sentencia de inserción
        $realiza->close();
    }

    // Cerrar la sentencia de selección
    $tria->close();
} else {
    // Las contraseñas no coinciden
    redireccionConContador("Las contraseñas no coinciden. Por favor, inténtalo de nuevo.", 3, "/practica3.5.1/registro.html");
}

// Cerrar la conexión
$conexion->close();
?>
