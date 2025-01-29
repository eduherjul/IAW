```php
<?php
session_start();
$valor = isset($_SESSION['url_corta']) ? $_SESSION['url_corta'] : '';
?>

<!DOCTYPE html>
<html lang="es">
  
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Redirigir URL</title>
</head>
<body>
  <h1>Redirigir URL</h1>
  <p>URL_corta: <?php echo htmlspecialchars($valor); ?></p>
  <form action="redirect2.php" method="POST">
    <input type="text" name="url_corta" placeholder="Introduce la URL corta" required>
    <button type="submit">Redirigir</button>
  </form>
</body>
</html>
```
