<?php
// conexionPDO.php
function conexion() {
    $host = "localhost";
    $dbname = "proyecto_jaime"; // Cambia por el nombre de tu base de datos
    $username = "root"; // Cambia si tu usuario es diferente
    $password = ""; // Cambia si tu contraseña no está vacía

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
        echo "Conexión exitosa a la base de datos.";
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
?>
