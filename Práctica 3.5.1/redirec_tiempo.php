<?php
function redireccionConContador($mensaje, $tiempoTotal, $urlRedireccion)
{
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirección con Contador</title>
    <meta http-equiv="refresh" content="<?= $tiempoTotal ?>;url=<?= $urlRedireccion ?>">
  </head>

  <body>
    <h1><?= $mensaje ?></h1>
    <h2>Redirigiendo en <span id="contador"><?= $tiempoTotal ?></span> segundos...</h2>

    <script>
      // Temporizador visual
      let tiempoRestante = <?= $tiempoTotal ?>;
      const contador = document.getElementById('contador');

      const intervalo = setInterval(() => {
        tiempoRestante--;
        contador.textContent = tiempoRestante;

        if (tiempoRestante <= 0) {
          clearInterval(intervalo);
        }
      }, 1000);
    </script>
  </body>

  </html>
<?php
  exit(); // Asegura que el script termine después de generar la página
}
?>