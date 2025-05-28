<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: autologueado.php"); // Redirige al login si no está autenticado
    exit;
}

include "../config/conexionPDO.php";

$conexion = conexion();
$sql = "SELECT idAlumno, nombre, apellidos, idProyecto FROM alumnos ORDER BY nombre ASC";
$stmt = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alumnos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .volver { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Lista de Alumnos</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>ID Proyecto</th>
        </tr>
        <?php while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($fila['idAlumno']) ?></td>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['apellidos']) ?></td>
                <td><?= htmlspecialchars($fila['idProyecto']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <div class="volver">
        <a href="vistaPrincipal.php">
            <button type="button">Volver a Vista Principal</button>
        </a>
    </div>
</body>
</html>


<!-- Notas PARA CLAVE FORANEA-->
<!-- $sql = "SELECT alumnos.idAlumno, alumnos.nombre, alumnos.apellidos, alumnos.idProyecto, proyecto.nombreProyecto 
        FROM alumnos 
        LEFT JOIN proyecto ON alumnos.idProyecto = proyecto.idProyecto 
        ORDER BY alumnos.nombre ASC";-->

         <!-- <td><?= htmlspecialchars($fila['nombreProyecto'] ?? 'Sin Proyecto') ?></td>  -->