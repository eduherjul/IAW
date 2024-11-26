```php

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Enviar un fichero por formulario</title>
</head>

<body>
  <h2>Enviar un fichero de texto o imagen</h2>
  <form action="" method="post" enctype="multipart/form-data">
    Seleccione un archivo de (texto o imagen):
    <input type="file" name="fileToUpload" accept=".txt,image/*" required>
    <br><br>
    <input type="submit" value="Subir archivo">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $directorioDestino = "subidas/"; // Directorio donde se guardarán los archivos subidos
    $ficheroDestino = $directorioDestino . basename($_FILES["archivoAsubir"]["name"]);
    $uploadOk = 1; // Variable para controlar si la subida es correcta
    $tipoFichero = strtolower(pathinfo($ficheroDestino, PATHINFO_EXTENSION));
    $nombre = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));

    // Comprobar si el archivo es de tipo permitido
    if (!in_array($tipoFichero, ["txt", "jpg", "jpeg", "png", "gif"])) {
      echo "<p style='color: red;'>Solo se permiten archivos de texto (.txt) o de imagen (.jpg, .jpeg, .png, .gif.</p>";
      $uploadOk = 0;
    }

    // Comprobar si $uploadOk está a 0 por un error
    if ($uploadOk == 0) {
      echo "<p style='color: red;'>Lo sentimos, su archivo no fue subido.</p>";

      // Si todo está bien, intentar subir el archivo
    } else {
      if (move_uploaded_file($_FILES["archivoAsubir"]["tmp_name"], $ficheroDestino)) {
        echo "<p style='color: green;'>El archivo " . $nombre . " ha sido subido.</p>";

        // Mostrar el contenido del archivo
        if ($tipoFichero == "txt") {
          echo "<h3>Contenido del archivo de texto:</h3>";
          echo "<pre>";
          echo htmlspecialchars(file_get_contents($ficheroDestino));
          echo "</pre>";
        } else {
          echo "<h3>Vista previa de la imagen:</h3>";
          echo "<img src='$ficheroDestino' alt='Imagen subida' style='max-width: 300px; max-height: 300px;'>";
        }
      } else {
        echo "<p style='color: red;'>Lo sentimos, hubo un error al subir su archivo.</p>";
      }
    }
  }
  ?>
</body>

</html>
```
