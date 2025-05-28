<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: autologueado.php"); // Redirige al login si no está autenticado
    exit;
}
include "../config/conexionPDO.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Proyecto</title>
</head>
<body>
    <h1>Añadir Proyecto</h1>
    <form action="../controlador/insertar_proyectos.php" method="POST" enctype="multipart/form-data">
        <label for="nombreProyecto">Nombre del Proyecto:</label>
        <input type="text" id="nombreProyecto" name="nombreProyecto" required><br>

        <label for="prioridad">Prioridad:</label>
        <input type="number" id="prioridad" name="prioridad" min="1" max="10" required><br>

        <label for="urgente">¿Es urgente?</label>
        <select id="urgente" name="urgente" required>
            <option value="1">Sí</option>
            <option value="0">No</option>
        </select><br>

        <label for="foto">Foto del Proyecto:</label>
        <input type="file" id="foto" name="foto" accept="image/*" required><br>

        <button type="submit">Guardar Proyecto</button>
    </form>

    <!-- Botón de volver -->
    <a href="../vista/vistaPrincipal.php">
        <button type="button">Volver</button>
    </a>
</body>
</html>