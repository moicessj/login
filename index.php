
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
    "contrasena" => "",
    "confirmar_contrasena" => ""
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

// Dominios permitidos
$dominiosCorreoPermitidos = [
    "@gmail.com",
    "@hotmail.com"
];

// Separar correo del registro
$correoRegistroLocal = $correo;
$dominioRegistro = "@gmail.com";

foreach ($dominiosCorreoPermitidos as $dominio) {

    if (
        $correo !== "" &&
        strtolower(substr($correo, -strlen($dominio))) === $dominio
    ) {

        $correoRegistroLocal = substr(
            $correo,
            0,
            -strlen($dominio)
        );

        $dominioRegistro = $dominio;
        break;
    }
}

// Separar correo del inicio de sesión
$correoLoginLocal = $correoLogin;
$dominioLogin = "@gmail.com";

foreach ($dominiosCorreoPermitidos as $dominio) {

    if (
        $correoLogin !== "" &&
        strtolower(substr($correoLogin, -strlen($dominio))) === $dominio
    ) {

        $correoLoginLocal = substr(
            $correoLogin,
            0,
            -strlen($dominio)
        );

        $dominioLogin = $dominio;
        break;
    }
}

// ==========================================
// PROCESAR REGISTRO
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registrar"])) {

    $erroresRegistro = $erroresRegistroVacios;

    $nombreCompleto = isset($_POST["nombre_completo"]) && is_string($_POST["nombre_completo"])
        ? trim($_POST["nombre_completo"])
        : "";

    // Obtener la parte escrita del correo
$correoLocal = isset($_POST["correo_local"]) && is_string($_POST["correo_local"])
    ? trim($_POST["correo_local"])
    : "";

// Obtener el dominio seleccionado
$dominioCorreo = isset($_POST["dominio_correo"]) && is_string($_POST["dominio_correo"])
    ? strtolower(trim($_POST["dominio_correo"]))
    : "";

// Comprobar que el dominio esté permitido
if (!in_array($dominioCorreo, $dominiosCorreoPermitidos, true)) {
    $dominioCorreo = "";
}

// Construir el correo completo
$correo = $correoLocal . $dominioCorreo;

    $contrasena = isset($_POST["contrasena"]) && is_string($_POST["contrasena"])
        ? $_POST["contrasena"]
        : "";

    $confirmarContrasena = isset($_POST["confirmar_contrasena"]) && is_string($_POST["confirmar_contrasena"])
        ? $_POST["confirmar_contrasena"]
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
if ($correoLocal === "" || $dominioCorreo === "") {

    $erroresRegistro["correo"] = "Escribe tu correo electrónico.";

} elseif (strlen($correoLocal) > 64 || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {

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

// Validar confirmación de contraseña

if ($confirmarContrasena === "") {

    $erroresRegistro["confirmar_contrasena"] = "Confirma tu contraseña.";

} elseif ($contrasena === "") {

    $erroresRegistro["confirmar_contrasena"] = "Escribe primero una contraseña.";

} elseif ($contrasena !== $confirmarContrasena) {

    $erroresRegistro["confirmar_contrasena"] = "Las contraseñas no coinciden.";

}
// ==========================================
// GUARDAR REGISTRO SI TODO ESTÁ CORRECTO
// ==========================================

if (
    $erroresRegistro["usuario"] === "" &&
    $erroresRegistro["correo"] === "" &&
    $erroresRegistro["contrasena"] === ""
    && $erroresRegistro["confirmar_contrasena"] === ""
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

            header("Location: index.php?form=login");
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
   $correoLocalLogin = isset($_POST["correo_local"]) && is_string($_POST["correo_local"])
    ? trim($_POST["correo_local"])
    : "";

$dominioCorreoLogin = isset($_POST["dominio_correo"]) && is_string($_POST["dominio_correo"])
    ? strtolower(trim($_POST["dominio_correo"]))
    : "";

if (!in_array($dominioCorreoLogin, $dominiosCorreoPermitidos, true)) {
    $dominioCorreoLogin = "";
}

// Construir el correo completo
$correoLogin = $correoLocalLogin . $dominioCorreoLogin;

    $contrasenaLogin = $_POST["contrasena"] ?? "";

    // Validar correo
    if ($correoLocalLogin === "" || $dominioCorreoLogin === "") {

    $erroresLogin["correo"] = "Escribe tu correo electrónico.";

} elseif (strlen($correoLocalLogin) > 64 || !filter_var($correoLogin, FILTER_VALIDATE_EMAIL)) {

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

                       

                            <div class="correo-control">

    <img src="imagenes/email.png" alt="" aria-hidden="true">

    <input
        type="text"
        id="correoRegistro"
        name="correo_local"
        class="correo-local"
        placeholder="Ingrese su correo"
        maxlength="64"
        pattern="[A-Za-z0-9.!#$%&'*+/=?^_`{|}~-]+"
        autocomplete="username"
        aria-label="Nombre del correo electrónico"
        required
        value="<?= htmlspecialchars($correoRegistroLocal, ENT_QUOTES, "UTF-8") ?>"
    >

    <select
        id="dominioCorreoRegistro"
        name="dominio_correo"
        class="dominio-correo"
        aria-label="Dominio del correo"
    >

        <option value="@gmail.com" <?= $dominioRegistro === "@gmail.com" ? "selected" : "" ?>>
            @gmail.com
        </option>

        <option value="@hotmail.com" <?= $dominioRegistro === "@hotmail.com" ? "selected" : "" ?>>
            @hotmail.com
        </option>

    </select>

</div>
<small id="errorCorreo" class="error-campo">
    Escribe tu correo electrónico.
</small>
                        

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
                            <div class="password-control">
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
                        

<button
    type="button"
    class="toggle-password"
    data-target="contrasenaRegistro"
    aria-label="Mostrar contraseña"
    aria-pressed="false"
>
    <svg class="icon-eye" viewBox="0 0 24 24"
         fill="none" stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round"
         aria-hidden="true">

        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
        <circle cx="12" cy="12" r="3"/>

    </svg>

    <svg class="icon-eye-off" viewBox="0 0 24 24"
         fill="none" stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round"
         aria-hidden="true">

        <path d="m3 3 18 18"/>
        <path d="M10.58 10.58a2 2 0 0 0 2.83 2.83"/>
        <path d="M9.88 5.2A10.8 10.8 0 0 1 12 5c6.2 0 9.5 7 9.5 7a16 16 0 0 1-4.1 4.8"/>
        <path d="M6.6 6.6A16 16 0 0 0 2.5 12s3.3 7 9.5 7a10.8 10.8 0 0 0 2.1-.2"/>

    </svg>
</button>
</div>

                        <small id="errorContrasena" class="error-campo">
                            Escribe una contraseña con al menos 8 caracteres, incluyendo una letra mayúscula, una letra minúscula, un número y un carácter especial.
                        </small>

                        <?php if ($erroresRegistro["contrasena"] !== ""): ?>

    <span class="mensaje-campo error" role="alert">
        <?= htmlspecialchars($erroresRegistro["contrasena"], ENT_QUOTES, "UTF-8") ?>
    </span>

<?php endif; ?>

                    </div>

<div class="campo">

    <h4>Confirmar contraseña:</h4>

    <label>
        <img src="imagenes/candado.png" alt="" aria-hidden="true">

        <input
            type="password"
            id="confirmarContrasenaRegistro"
            name="confirmar_contrasena"
            placeholder="Repita su contraseña"
            autocomplete="new-password"
            required
        >
    </label>

    <small id="errorConfirmarContrasena" class="error-campo">
        Las contraseñas no coinciden.
    </small>

    <?php if ($erroresRegistro["confirmar_contrasena"] !== ""): ?>

    <span class="mensaje-campo error" role="alert">
        <?= htmlspecialchars($erroresRegistro["confirmar_contrasena"], ENT_QUOTES, "UTF-8") ?>
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

                <?php if ($tipoMensajeRegistro === "success"): ?>

                    <p class="form-message success" role="status">
                        <?= htmlspecialchars($mensajeRegistro, ENT_QUOTES, "UTF-8") ?>
                    </p>

                <?php endif; ?>

                <?php if ($mensajeLogin !== ""): ?>

                    <p class="form-message error" role="alert">
                        <?= htmlspecialchars($mensajeLogin, ENT_QUOTES, "UTF-8") ?>
                    </p>

                <?php endif; ?>

                <form class="form" method="POST" action="index.php" novalidate>

                    <div class="campo">

                        <h4>Correo:</h4>

                       

                            <div class="correo-control">

    <img src="imagenes/email.png" alt="" aria-hidden="true">

    <input
        type="text"
        id="correoLogin"
        name="correo_local"
        class="correo-local"
        placeholder="Ingrese su correo"
        maxlength="64"
        pattern="[A-Za-z0-9.!#$%&'*+/=?^_`{|}~-]+"
        autocomplete="username"
        aria-label="Nombre del correo electrónico"
        required
        value="<?= htmlspecialchars($correoLoginLocal, ENT_QUOTES, "UTF-8") ?>"
    >

    <select
        id="dominioCorreoLogin"
        name="dominio_correo"
        class="dominio-correo"
        aria-label="Dominio del correo"
    >

        <option value="@gmail.com" <?= $dominioLogin === "@gmail.com" ? "selected" : "" ?>>
            @gmail.com
        </option>

        <option value="@hotmail.com" <?= $dominioLogin === "@hotmail.com" ? "selected" : "" ?>>
            @hotmail.com
        </option>

    </select>

</div>

                        
                        <?php if ($erroresLogin["correo"] !== ""): ?>

    <span class="mensaje-campo error" role="alert">
        <?= htmlspecialchars($erroresLogin["correo"], ENT_QUOTES, "UTF-8") ?>
    </span>

<?php endif; ?>

                    </div>

                    <div class="campo">

                        <h4>Contraseña:</h4>
                        <div class="password-control">

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
                        

                        <button
    type="button"
    class="toggle-password"
    data-target="contrasena"
    aria-label="Mostrar contraseña"
    aria-pressed="false"
>
    <svg class="icon-eye" viewBox="0 0 24 24"
         fill="none" stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round"
         aria-hidden="true">

        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
        <circle cx="12" cy="12" r="3"/>

    </svg>

    <svg class="icon-eye-off" viewBox="0 0 24 24"
         fill="none" stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round"
         aria-hidden="true">

        <path d="m3 3 18 18"/>
        <path d="M10.58 10.58a2 2 0 0 0 2.83 2.83"/>
        <path d="M9.88 5.2A10.8 10.8 0 0 1 12 5c6.2 0 9.5 7 9.5 7a16 16 0 0 1-4.1 4.8"/>
        <path d="M6.6 6.6A16 16 0 0 0 2.5 12s3.3 7 9.5 7a10.8 10.8 0 0 0 2.1-.2"/>

    </svg>
</button>
</div>
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
