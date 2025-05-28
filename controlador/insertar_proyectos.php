<?php
include "../config/conexionPDO.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = conexion();

    // Recoger datos del formulario
    $nombreProyecto = $_POST['nombreProyecto'];
    $prioridad = $_POST['prioridad'];
    $urgente = $_POST['urgente'];

    // Validar y procesar la imagen
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $foto = file_get_contents($_FILES['foto']['tmp_name']); // Contenido de la imagen

        // Comprobamos el tamaño del archivo
        if ($_FILES['foto']['size'] > 2 * 1024 * 1024) { // 2 MB
            die("El tamaño del archivo es demasiado grande. Máximo 2 MB.");
        }
    } else {
        die("Error al subir la foto.");
    }

    try {
        // Insertar los datos en la base de datos
        $sql = "INSERT INTO proyecto (nombreProyecto, prioridad, urgente, foto)
                VALUES (:nombreProyecto, :prioridad, :urgente, :foto)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':nombreProyecto', $nombreProyecto, PDO::PARAM_STR);
        $stmt->bindParam(':prioridad', $prioridad, PDO::PARAM_INT);
        $stmt->bindParam(':urgente', $urgente, PDO::PARAM_INT);
        $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);

        $stmt->execute();
        header("Location: ../vista/vistaPrincipal.php"); // Redirige a la vista principal
        exit;
    } catch (Exception $e) {
        die("Error al guardar el proyecto: " . $e->getMessage());
    }
}
?>