<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: autologueado.php"); // Redirige al login si no está autenticado
    exit;
}

include "../config/conexionPDO.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $nombreProyecto = $_POST['nombreProyecto'];
        $prioridad = $_POST['prioridad'];
        $urgente = $_POST['urgente'];

        try {
            $conexion = conexion();

            // Si se sube una nueva imagen, la procesamos
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $foto = file_get_contents($_FILES['foto']['tmp_name']);
                $sql = "UPDATE proyecto 
                        SET nombreProyecto = :nombreProyecto, 
                            prioridad = :prioridad, 
                            urgente = :urgente, 
                            foto = :foto 
                        WHERE idProyecto = :id";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
            } else {
                // Si no se sube una nueva imagen, dejamos la actual
                $sql = "UPDATE proyecto 
                        SET nombreProyecto = :nombreProyecto, 
                            prioridad = :prioridad, 
                            urgente = :urgente 
                        WHERE idProyecto = :id";
                $stmt = $conexion->prepare($sql);
            }

            // Vincular parámetros
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombreProyecto', $nombreProyecto, PDO::PARAM_STR);
            $stmt->bindParam(':prioridad', $prioridad, PDO::PARAM_INT);
            $stmt->bindParam(':urgente', $urgente, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Redirigir a la página principal con un mensaje de éxito
            header("Location: ../vista/vistaPrincipal.php?mensaje=proyecto_actualizado");
            exit();
        } catch (Exception $e) {
            // Manejar errores
            die("Error al actualizar el proyecto: " . $e->getMessage());
        }
    } else {
        die("ID del proyecto no especificado.");
    }
} else {
    header("Location: ../vista/vistaPrincipal.php");
    exit;
}
?>