<?php
session_start(); // Inicia la sesión

// Destruye todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Redirige al usuario al formulario de login
header("Location: ../vista/autologueado.php");
exit;
?>