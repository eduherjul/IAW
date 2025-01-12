```php
<?php
session_start(); // Inicia la sesión para acceder a $_SESSION
$usuario = isset($_SESSION["username"]) ? $_SESSION["username"] : "Usuario";
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Protegida - Todomovil</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      text-align: center;
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .logo img {
      max-width: 200px;
    }

    h1 {
      color: #333;
    }

    p {
      color: #666;
    }

    .button {
      font-size: 18px;
      padding: 10px 20px;
      margin: 20px 0;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .button:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="logo">
      <img src="/practica3.4/7883511.jpg" alt="Logo de Todomovil">
    </div>
    <h1>Bienvenido
      <?php echo $usuario; ?> a Todomovil
    </h1>
    <p>Esta es una página protegida. Solo los usuarios autenticados pueden acceder.</p>
    <button class="button" onclick="location.href='/practica3.4/operacionesBBDD.html'">Ir a la página de inicio</button>
  </div>
</body>

</html>
```
