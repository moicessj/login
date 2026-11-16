
<?php

header('Content-Type: application/json; charset=utf-8');

// Utilizar la misma conexión de tu proyecto
require_once __DIR__ . "/conexion.php";

// Recibir el correo desde JavaScript
$correo = trim($_POST['correo'] ?? '');

// Verificar que el correo tenga formato válido
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'existe' => false,
        'mensaje' => 'Ingresa un correo válido.'
    ]);
    exit;
}

try {

    // Buscar el correo en tu tabla usuario
    $consulta = $conexion->prepare(
        "SELECT 1
         FROM public.usuario
         WHERE LOWER(BTRIM(correo)) = LOWER(:correo)
         LIMIT 1"
    );

    $consulta->execute([
        'correo' => $correo
    ]);

    // Comprobar si existe
    $existe = $consulta->fetchColumn() !== false;

    if ($existe) {

        echo json_encode([
            'existe' => true,
            'mensaje' => 'Este correo ya está registrado.'
        ]);

    } else {

        echo json_encode([
            'existe' => false,
            'mensaje' => 'Correo disponible.'
        ]);

    }

} catch (PDOException $e) {

    error_log("Error al validar correo: " . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        'error' => 'No se pudo consultar la base de datos.'
    ]);
}
