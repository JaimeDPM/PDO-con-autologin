<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../vista/autologueado.php"); // Redirige al login si no está autenticado
    exit;
}

include "../config/conexionPDO.php";

if (isset($_GET['id'])) {
    $idProyecto = $_GET['id'];
    $conexion = conexion();

    try {
        // Eliminar el proyecto de la base de datos
        $sql = "DELETE FROM proyecto WHERE idProyecto = :idProyecto";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idProyecto', $idProyecto, PDO::PARAM_INT);
        $stmt->execute();

        // Redirige con un mensaje de éxito
        header("Location: ../vista/vistaPrincipal.php?mensaje=proyecto_eliminado");
        exit;
    } catch (Exception $e) {
        // Redirige con un mensaje de error
        header("Location: ../vista/vistaPrincipal.php?mensaje=error_eliminar");
        exit;
    }
} else {
    // Redirige si no se especifica un ID
    header("Location: ../vista/vistaPrincipal.php?mensaje=error_id");
    exit;
}
?>