<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: autologueado.php"); // Redirige al login si no está autenticado
    exit;
}

include "../config/conexionPDO.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conexion = conexion();

    $sql = "SELECT * FROM proyecto WHERE idProyecto = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $proyecto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$proyecto) {
        die("Proyecto no encontrado.");
    }
} else {
    die("ID del proyecto no especificado.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
</head>
<body>
    <h1>Editar Proyecto</h1>
    <form action="../controlador/modificar_proyecto.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($proyecto['idProyecto']); ?>">

        <label for="nombreProyecto">Nombre del Proyecto:</label>
        <input type="text" id="nombreProyecto" name="nombreProyecto" value="<?php echo htmlspecialchars($proyecto['nombreProyecto']); ?>" required><br>

        <label for="prioridad">Prioridad:</label>
        <input type="number" id="prioridad" name="prioridad" value="<?php echo htmlspecialchars($proyecto['prioridad']); ?>" min="1" max="10" required><br>

        <label for="urgente">¿Es urgente?</label>
        <select id="urgente" name="urgente" required>
            <option value="1" <?php echo $proyecto['urgente'] == 1 ? 'selected' : ''; ?>>Sí</option>
            <option value="0" <?php echo $proyecto['urgente'] == 0 ? 'selected' : ''; ?>>No</option>
        </select><br>

        <label for="foto">Foto del Proyecto (deja en blanco para mantener la actual):</label>
        <input type="file" id="foto" name="foto" accept="image/*"><br>

        <button type="submit">Actualizar Proyecto</button>
    </form>

    <!-- Botón de volver -->
    <br>
    <a href="vistaPrincipal.php">
        <button type="button">Volver</button>
    </a>
</body>
</html>