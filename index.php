
<?php

session_start();
$mensajeContrasena = $_SESSION["mensaje_contrasena"] ?? "";

unset($_SESSION["mensaje_contrasena"]);
require_once __DIR__ . "/conexion.php";

// Recuperar mensajes temporales
$mensajeRegistro = $_SESSION["mensaje_registro"] ?? "";
$tipoMensajeRegistro = $_SESSION["tipo_mensaje_registro"] ?? "";

unset($_SESSION["mensaje_registro"], $_SESSION["tipo_mensaje_registro"]);

// Errores individuales del registro
$erroresRegistroVacios = [
    "usuario" => "",
    "correo" => "",
    "contrasena" => ""
];
$erroresRegistro = $_SESSION["errores_registro"] ?? $erroresRegistroVacios;
unset($_SESSION["errores_registro"]);

// Errores individuales del inicio de sesión
$erroresLoginVacios = [
    "correo" => "",
    "contrasena" => ""
];
$erroresLogin = $_SESSION["errores_login"] ?? $erroresLoginVacios;
unset($_SESSION["errores_login"]);

$valoresRegistro = $_SESSION["valores_registro"] ?? [];
unset($_SESSION["valores_registro"]);
$valoresLogin = $_SESSION["valores_login"] ?? [];
unset($_SESSION["valores_login"]);

$nombreCompleto = $valoresRegistro["nombre_completo"] ?? "";
$correo = $valoresRegistro["correo"] ?? "";
$contrasena = "";
$mensajeLogin = "";

// Conservar los valores del inicio de sesión
$correoLogin = $valoresLogin["correo"] ?? "";
$contrasenaLogin = "";

// ==========================================
// PROCESAR REGISTRO
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registrar"])) {

    $erroresRegistro = $erroresRegistroVacios;

    $nombreCompleto = isset($_POST["nombre_completo"]) && is_string($_POST["nombre_completo"])
        ? trim($_POST["nombre_completo"])
        : "";

    $correo = isset($_POST["correo"]) && is_string($_POST["correo"])
        ? trim($_POST["correo"])
        : "";

    $contrasena = isset($_POST["contrasena"]) && is_string($_POST["contrasena"])
        ? trim($_POST["contrasena"])
        : "";

    // ==========================================
// VALIDAR CAMPOS DEL REGISTRO
// ==========================================

// Validar usuario
if ($nombreCompleto === "") {

    $erroresRegistro["usuario"] = "Escribe tu nombre completo.";

} elseif (!preg_match("/^[\p{L}\p{M} .'-]{2,100}$/u", $nombreCompleto)) {

    $erroresRegistro["usuario"] = "Introduce un nombre válido. Utiliza solamente letras, espacios y caracteres permitidos.";
}


// Validar correo
if ($correo === "") {

    $erroresRegistro["correo"] = "Escribe tu correo electrónico.";

} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

    $erroresRegistro["correo"] = "El formato del correo no es válido.";

}


// Validar contraseña
$patron = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9\s]).{8,}$/';

if ($contrasena === "") {

    $erroresRegistro["contrasena"] = "Escribe una contraseña.";

} elseif (strlen($contrasena) < 8) {

    $erroresRegistro["contrasena"] = "La contraseña debe tener al menos 8 caracteres.";

} elseif (!preg_match($patron, $contrasena)) {

    $erroresRegistro["contrasena"] = "La contraseña debe tener una mayúscula, una minúscula, un número y un símbolo.";

}


// ==========================================
// GUARDAR REGISTRO SI TODO ESTÁ CORRECTO
// ==========================================

if (
    $erroresRegistro["usuario"] === "" &&
    $erroresRegistro["correo"] === "" &&
    $erroresRegistro["contrasena"] === ""
) {

    try {

        // Comprobar si el correo ya existe
        $verificar = $conexion->prepare(
            "SELECT 1
             FROM public.usuario
             WHERE LOWER(BTRIM(correo)) = LOWER(:correo)
             LIMIT 1"
        );

        $verificar->execute([
            "correo" => $correo
        ]);

        if ($verificar->fetchColumn() !== false) {

            $erroresRegistro["correo"] = "Este correo ya está registrado.";

        } else {

            // Insertar nuevo usuario
            $consulta = $conexion->prepare(
                "INSERT INTO public.usuario
                (\"nombre_Completo\", correo, contrasena)
                VALUES (:nombre_completo, :correo, :contrasena)"
            );

            $consulta->execute([
                "nombre_completo" => $nombreCompleto,
                "correo" => $correo,
                "contrasena" => password_hash($contrasena, PASSWORD_DEFAULT)
            ]);

            // Registro exitoso
            $_SESSION["mensaje_registro"] = "Registro guardado correctamente.";
            $_SESSION["tipo_mensaje_registro"] = "success";

            header("Location: index.php");
            exit;

        }

    } catch (PDOException $e) {

        error_log("Error al registrar usuario: " . $e->getMessage());

        // Error por correo duplicado en PostgreSQL
        if ($e->getCode() === "23505") {

            $erroresRegistro["correo"] = "Este correo ya está registrado.";

        } else {

            $mensajeRegistro = "No se pudo guardar el registro. Inténtalo nuevamente.";
            $tipoMensajeRegistro = "error";

        }

    }

}

}



// ==========================================
// PROCESAR INICIO DE SESIÓN
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["iniciar_sesion"])) {

    $erroresLogin = $erroresLoginVacios;
    $correoLogin = trim($_POST["correo"] ?? "");
    $contrasenaLogin = $_POST["contrasena"] ?? "";

    // Validar correo
    if ($correoLogin === "") {

        $erroresLogin["correo"] = "Escribe tu correo electrónico.";

    } elseif (!filter_var($correoLogin, FILTER_VALIDATE_EMAIL)) {

        $erroresLogin["correo"] = "El formato del correo no es válido.";

    }

    // Validar contraseña
    if ($contrasenaLogin === "") {

        $erroresLogin["contrasena"] = "Escribe tu contraseña.";

    }


    // Consultar solamente si los campos están completos
    if (
        $erroresLogin["correo"] === "" &&
        $erroresLogin["contrasena"] === ""
    ) {

        $consulta = $conexion->prepare(
            "SELECT id_usuario, correo, contrasena
             FROM public.usuario
             WHERE correo = :correo"
        );

        $consulta->execute([
            "correo" => $correoLogin
        ]);

        $usuario = $consulta->fetch();


        // Comprobar si existe el correo
        if (!$usuario) {

            $erroresLogin["correo"] = "No existe una cuenta registrada con este correo.";

        } elseif (!password_verify($contrasenaLogin, $usuario["contrasena"])) {

            $erroresLogin["contrasena"] = "La contraseña es incorrecta.";

        } else {

            // Inicio de sesión exitoso
            session_regenerate_id(true);

            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["correo"] = $usuario["correo"];

            header("Location: inicio.php");
            exit;

        }

    }

}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registrar"])) {
    $_SESSION["errores_registro"] = $erroresRegistro;
    $_SESSION["valores_registro"] = [
        "nombre_completo" => $nombreCompleto,
        "correo" => $correo
    ];

    if ($mensajeRegistro !== "") {
        $_SESSION["mensaje_registro"] = $mensajeRegistro;
        $_SESSION["tipo_mensaje_registro"] = $tipoMensajeRegistro;
    }

    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["iniciar_sesion"])) {
    $_SESSION["errores_login"] = $erroresLogin;
    $_SESSION["valores_login"] = [
        "correo" => $correoLogin
    ];

    header("Location: index.php?form=login");
    exit;
}

$mostrarFormularioLogin = (
    ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["iniciar_sesion"])) ||
    (isset($_GET["form"]) && $_GET["form"] === "login")
);

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

    <!-- ==================================
         FORMULARIO DE REGISTRO
    =================================== -->

    <div class="container-form register <?= $mostrarFormularioLogin ? 'hide' : '' ?>">
        <div class="information">

            <div class="info-childs">

                <h2>Bienvenidos</h2>

                <p>
                    <strong>
                        Para unirte a nuestra comunidad por favor inicia sesion con tus datos
                    </strong>
                </p>

                <input type="button" value="Iniciar sesión" id="show-login">

            </div>

        </div>

        <div class="form-information">

            <div class="form-information-childs">

                <h2>Crear una cuenta</h2>

                <div class="icons">
                </div>

                <p><strong>Usa tu email para registrarte</strong></p>

                <!-- Mensaje del registro -->
                <?php if ($mensajeRegistro !== ""): ?>

                    <p class="form-message <?= $tipoMensajeRegistro === "success" ? "success" : "error" ?>"
                       role="<?= $tipoMensajeRegistro === "error" ? "alert" : "status" ?>">

                        <?= htmlspecialchars($mensajeRegistro, ENT_QUOTES, "UTF-8") ?>

                    </p>

                <?php endif; ?>

                <form class="form" method="POST" action="index.php" novalidate id="formRegistro">

                    <div class="campo">

                        <h4>Usuario:</h4>

                        <label>
                            



                            <img src="imagenes/usuario.png" alt="" aria-hidden="true">

                            <input
                                type="text"
                                id="nombreCompleto"
                                name="nombre_completo"
                                placeholder="Ingrese su Nombre Completo"
                                maxlength="100"
                                required
                                minlength="2"
                                pattern="[\p{L}\p{M} .'-]{2,100}"
                                value="<?= htmlspecialchars($nombreCompleto, ENT_QUOTES, "UTF-8") ?>"
                            >

                        </label>
                        <?php if ($erroresRegistro["usuario"] !== ""): ?>
                            <span class="mensaje-campo error" role="alert">
                             <?= htmlspecialchars($erroresRegistro["usuario"], ENT_QUOTES, "UTF-8") ?>
                            </span>

                        <?php endif; ?>
                        <small id="errorNombre" class="error-campo">
                         Escribe tu nombre completo.
                          </small>

                    </div>

                    <div class="campo">

                        <h4>Correo:</h4>

                        <label>

                            <img src="imagenes/email.png" alt="" aria-hidden="true">

                            <input
                                type="email"
                                id="correoRegistro"
                                name="correo"
                                placeholder="Ingrese su Correo Electronico"
                                maxlength="100"
                                required
                                value="<?= htmlspecialchars($correo, ENT_QUOTES, "UTF-8") ?>"
                            >
                            <small id="errorCorreo" class="error-campo">
                            Escribe tu correo electrónico.
                            </small>
                        </label>

                        <?php if ($erroresRegistro["correo"] !== ""): ?>

                           <span class="mensaje-campo error" role="alert">
                      <?= htmlspecialchars($erroresRegistro["correo"], ENT_QUOTES, "UTF-8") ?>
                         </span>

                        <?php endif; ?>

                        <!-- Aquí aparecerá el mensaje de validación -->
                        <span id="mensajeCorreo" class="mensaje-correo"></span>

                    </div>

                    <div class="campo">

                        <h4>Contraseña:</h4>

                        <label>

                            <img src="imagenes/candado.png" alt="" aria-hidden="true">

                            <input
                                type="password"
                                name="contrasena"
                                placeholder="Ingrese su contraseña"
                                id="contrasenaRegistro"
                                minlength="8"
                                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9\s]).{8,}"
                                required
                            >
                        </label>
                        <small id="errorContrasena" class="error-campo">
                            Escribe una contraseña con al menos 8 caracteres, incluyendo una letra mayúscula, una letra minúscula, un número y un carácter especial.
                        </small>

                        <?php if ($erroresRegistro["contrasena"] !== ""): ?>

    <span class="mensaje-campo error" role="alert">
        <?= htmlspecialchars($erroresRegistro["contrasena"], ENT_QUOTES, "UTF-8") ?>
    </span>

<?php endif; ?>

                    </div>

                    <input type="submit" name="registrar" value="Registrar">

                </form>

            </div>

        </div>

    </div>


    <!-- ==================================
         FORMULARIO DE INICIO DE SESIÓN
    =================================== -->

    <div class="container-form login <?= $mostrarFormularioLogin ? '' : 'hide' ?>">

        <div class="information">

            <div class="info-childs">

                <h2>¡Bienvenido de nuevo!</h2>

                <p>
                    <strong>
                        Si aun no tienes una cuenta por favor registrese aqui
                    </strong>
                </p>

                <input type="button" value="Registrarse" id="show-register">

            </div>

        </div>

        <div class="form-information">

            <div class="form-information-childs">

                <h2>Inicio de sesion</h2>

                <div class="icons">
                </div>

                <p><strong>Iniciar sesion con una cuenta</strong></p>

                <?php if ($mensajeLogin !== ""): ?>

                    <p class="form-message error" role="alert">
                        <?= htmlspecialchars($mensajeLogin, ENT_QUOTES, "UTF-8") ?>
                    </p>

                <?php endif; ?>

                <form class="form" method="POST" action="index.php" novalidate>

                    <div class="campo">

                        <h4>Correo:</h4>

                        <label>

                            <img src="imagenes/email.png" alt="" aria-hidden="true">

                            <input
                                type="email"
                                name="correo"
                                placeholder="Ingrese su Correo Electronico"
                                maxlength="100"
                                required
                                value="<?= htmlspecialchars($correoLogin, ENT_QUOTES, "UTF-8") ?>"
                            >

                        </label>
                        <?php if ($erroresLogin["correo"] !== ""): ?>

    <span class="mensaje-campo error" role="alert">
        <?= htmlspecialchars($erroresLogin["correo"], ENT_QUOTES, "UTF-8") ?>
    </span>

<?php endif; ?>

                    </div>

                    <div class="campo">

                        <h4>Contraseña:</h4>

                        <label>

                            <img src="imagenes/candado.png" alt="" aria-hidden="true">

                            <input
                            type="password"
                            name="contrasena"
                            id="contrasena"
                            minlength="8"
                            pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9\s]).{8,}"
                            title="La contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula, un número y un símbolo."
                            placeholder="Ingrese una contraseña"
                            required>


                        </label>

                        <?php if ($erroresLogin["contrasena"] !== ""): ?>

    <span class="mensaje-campo error" role="alert">
        <?= htmlspecialchars($erroresLogin["contrasena"], ENT_QUOTES, "UTF-8") ?>
    </span>

<?php endif; ?>

                    </div>

                    <input
                        type="submit"
                        name="iniciar_sesion"
                        value="Iniciar sesion"
                    >

                </form>

            </div>

        </div>

    </div>

    <script src="js/script.js"></script>

</body>

</html>
