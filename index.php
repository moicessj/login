<?php

session_start();

require_once __DIR__ . "/conexion.php";

// Recupera el aviso tras la redirección y lo elimina para que sea temporal.
$mensajeRegistro = $_SESSION["mensaje_registro"] ?? "";
$tipoMensajeRegistro = $_SESSION["tipo_mensaje_registro"] ?? "";
unset($_SESSION["mensaje_registro"], $_SESSION["tipo_mensaje_registro"]);

$nombreCompleto = "";
$correo = "";
$contrasena = "";

// Procesa únicamente el envío del formulario de registro.
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registrar"])) {
    $nombreCompleto = isset($_POST["nombre_completo"]) && is_string($_POST["nombre_completo"])
        ? trim($_POST["nombre_completo"])
        : "";
    $correo = isset($_POST["correo"]) && is_string($_POST["correo"])
        ? trim($_POST["correo"])
        : "";
    $contrasena = isset($_POST["contrasena"]) && is_string($_POST["contrasena"])
        ? $_POST["contrasena"]
        : "";

    // Valida los campos antes de intentar guardar el usuario.
    if ($nombreCompleto === "" || $correo === "" || $contrasena === "") {
        $mensajeRegistro = "Completa todos los campos para registrarte.";
        $tipoMensajeRegistro = "error";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensajeRegistro = "Ingresa un correo electrónico válido.";
        $tipoMensajeRegistro = "error";
    } else {
        try {
            // Usa parámetros para guardar los datos y almacena la contraseña como hash.
            $consulta = $conexion->prepare(
                "INSERT INTO public.usuario (\"nombre_Completo\", correo, contrasena)
                 VALUES (:nombre_completo, :correo, :contrasena)"
            );
            $consulta->execute([
                "nombre_completo" => $nombreCompleto,
                "correo" => $correo,
                "contrasena" => password_hash($contrasena, PASSWORD_DEFAULT),
            ]);

            // Redirige tras el registro para evitar duplicarlo al actualizar la página.
            $_SESSION["mensaje_registro"] = "Registro guardado correctamente.";
            $_SESSION["tipo_mensaje_registro"] = "success";
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            error_log("Error al registrar usuario: " . $e->getMessage());
            $mensajeRegistro = "No se pudo guardar el registro. Revisa los datos e inténtalo de nuevo.";
            $tipoMensajeRegistro = "error";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/style.css">


    <title>Login</title>
</head>
<body>
    <div class="container-form register">
        <div class="information">
            <div class="info-childs">
            <h2>Bienvenidos</h2>
            <p>Para unirte a nuestra comunidad por favor inicia sesion con tus datos</p>
            <input type="button" value="Iniciar sesión" id="show-login">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Crear una cuenta</h2>
                <div class="icons">
                    
                </div>
                <p>Usa tu email para registrarte</P>
                <!-- El aviso muestra el resultado del último intento de registro. -->
                <?php if ($mensajeRegistro !== ""): ?>
                    <p class="form-message <?= $tipoMensajeRegistro === "success" ? "success" : "error" ?>" role="<?= $tipoMensajeRegistro === "error" ? "alert" : "status" ?>">
                        <?= htmlspecialchars($mensajeRegistro, ENT_QUOTES, "UTF-8") ?>
                    </p>
                <?php endif; ?>
             <!-- Los nombres de los campos corresponden a las claves leídas en $_POST. -->
             <form class="form" method="post" action="index.php">
                <label>
                    <img src="imagenes/usuario.png" alt="" aria-hidden="true">
                    <input type="text" name="nombre_completo" placeholder="Ingrese su Nombre Completo" maxlength="100" required value="<?= htmlspecialchars($nombreCompleto, ENT_QUOTES, "UTF-8") ?>">
                </label>
                <label>
                    <img src="imagenes/email.png" alt="" aria-hidden="true">
                    <input type="email" name="correo" placeholder="Ingrese su Correo Electronico" maxlength="100" required value="<?= htmlspecialchars($correo, ENT_QUOTES, "UTF-8") ?>">
                </label>
                <label>
                    <img src="imagenes/candado.png" alt="" aria-hidden="true">
                    <input type="password" name="contrasena" placeholder="Ingrese su contraseña" required>
                </label>
                <input type="submit" name="registrar" value="Registrar">
             </form>
            </div>
        </div>
    </div>




    <div class="container-form login hide">
        <div class="information">
            <div class="info-childs">
            <h2>¡Bienvenido de nuevo!</h2>
            <p>Si aun no tienes una cuenta por favor registrese aqui</p>
            <input type="button" value="Registrarse" id="show-register">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Inicio de sesion</h2>
                <div class="icons">
                    
                </div>
                <p>Iniciar sesion con una cuenta</P>
             <form class="form">
                <label>
                    <img src="imagenes/email.png" alt="" aria-hidden="true">
                    <input type="email" placeholder="Ingrese su Correo Electronico">
                </label>
                <label>
                    <img src="imagenes/candado.png" alt="" aria-hidden="true">
                    <input type="password" placeholder="Ingrese su contraseña">
                </label>
                <input type="submit" value="Iniciar sesion">
             </form>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>