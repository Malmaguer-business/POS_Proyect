<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>POS - Login</title>
</head>
<body>

<h1>Iniciar sesión</h1>

<?php if (isset($error)): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="POST" action="index.php?c=auth&a=authenticate">

    <label>Correo</label><br>
    <input type="email" name="correo" required><br><br>

    <label>Contraseña</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Entrar</button>

</form>

</body>
</html>