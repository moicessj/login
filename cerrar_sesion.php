<?php

session_start();

// Eliminar todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

if (ini_get("session.use_cookies")) {
    $parametrosCookie = session_get_cookie_params();
    setcookie(
        session_name(),
        "",
        time() - 42000,
        $parametrosCookie["path"],
        $parametrosCookie["domain"],
        $parametrosCookie["secure"],
        $parametrosCookie["httponly"]
    );
}

// Regresar al login
header("Location: index.php");
exit();

?>