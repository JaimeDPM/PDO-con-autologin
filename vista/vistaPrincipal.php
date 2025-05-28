<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: autologueado.php"); // Redirige al login si no está autenticado
    exit;
}

include "../config/conexionPDO.php";

$conexion = conexion();
$sql = "SELECT idProyecto, nombreProyecto, prioridad, urgente, foto FROM proyecto";
$stmt = $conexion->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Proyectos</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        img { max-width: 100px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header a { text-decoration: none; color: #007BFF; }
        .header a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenido, <?= isset($_SESSION['usuario']) && is_string($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Invitado' ?></h1>
        <a href="../controlador/logout.php">Cerrar sesión</a>
    </div>

    <a href="formulario_agregar_proyecto.php">
        <button type="button">Crear Nuevo Proyecto</button>
    </a>

    <h1>Proyectos</h1>
    <table>
        <tr>
            <th>idProyecto</th>
            <th>nombreProyecto</th>
            <th>Prioridad</th>
            <th>urgente</th>
            <th>foto</th>
            <th>Acciones</th>
        </tr>
        <?php while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($fila['idProyecto']) ?></td>
                <td><?= htmlspecialchars($fila['nombreProyecto']) ?></td>
                <td><?= htmlspecialchars($fila['prioridad']) ?></td>
                <td><?= $fila['urgente'] ? 'Sí' : 'No' ?></td>
                <td>
                    <img src="data:image/jpeg;base64,<?= base64_encode($fila['foto']) ?>" 
                         alt="<?= htmlspecialchars($fila['nombreProyecto']) ?>">
                </td>
                <td>
                    <a href="formulario_modificar_proyectos.php?id=<?= $fila['idProyecto'] ?>">Editar</a> |
                    <a href="../controlador/eliminar_proyectos.php?id=<?= $fila['idProyecto'] ?>" 
                       onclick="return confirm('¿Estás seguro de eliminar este proyecto?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="listaAlumnos.php">
        <button type="button">Ver Otra Tabla</button>
    </a>
</body>