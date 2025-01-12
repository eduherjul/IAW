```php
<?php
session_start(); // Inicia la sesión para acceder a $_SESSION
$ultimo_usuario = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Basic HTML CSS Login Form</title>
  <link rel="stylesheet" href="inicio.css">
</head>

<body>
  <div class="login">
    <div class="login-screen">
      <div class="app-title">
        <h1>Bienvenido</h1>
      </div>

      <div class="login-form">
        <form action="login.php" method="POST">
          <div class="control-group">
            <input type="text" name="usuario" class="login-field" placeholder="usuario" value="<?php echo $ultimo_usuario; ?>">
            <label class="login-field-icon fui-user" for="login-name"></label>
          </div>

          <div class="control-group">
            <input type="password" name="contraseña" class="login-field" placeholder="contraseña" id="login-pass"
              required>
            <label class="login-field-icon fui-lock" for="login-pass"></label>
          </div>

          <button type="submit" class="btn btn-primary btn-large btn-block">Login</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
```
