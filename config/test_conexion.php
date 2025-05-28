<?php
require_once 'conexionPDO.php';

$conexion = conexion();

if ($conexion) {
    echo "Conexión establecida correctamente.";
}
?>