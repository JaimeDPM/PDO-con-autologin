<?php
/* Si va bien redirige a principal.php, si va mal, muestra un mensaje de error */
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") { // Verifica si el formulario fue enviado
    if (isset($_POST['usuario']) && isset($_POST['clave'])) { // Verifica si las claves existen
        if ($_POST['usuario'] === "usuario" && $_POST["clave"] === "1234") {
            $_SESSION['usuario'] = $_POST['usuario']; // Guarda el nombre del usuario como string
            header("Location: vistaPrincipal.php"); // Redirige a esta página
            exit;
        } else {
            $err = true; // Credenciales incorrectas
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de login</title>        
    <meta charset="UTF-8">
</head>
<body>            
    <?php if (isset($err)): ?>
        <p>Revise usuario y contraseña</p>
    <?php endif; ?>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <label for="usuario">Usuario</label> 
        <input id="usuario" name="usuario" type="text" required>                
        <label for="clave">Clave</label> 
        <input id="clave" name="clave" type="password" required>            
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>