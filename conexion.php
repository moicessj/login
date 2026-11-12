<?php

$host = "localhost";
$port = "5432";
$dbname = "pasantes";
$user = "postgres";
$password = "1234567";

try {
    $conexion = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
    die("No se pudo conectar con la base de datos PostgreSQL.");
}

?>