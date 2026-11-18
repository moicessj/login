const btnShowLogin = document.getElementById("show-login");
const btnShowRegister = document.getElementById("show-register");
const formRegister = document.querySelector(".register");
const formLogin = document.querySelector(".login");

document.addEventListener("keydown", (event) => {
    if (event.key === "Tab") {
        document.body.classList.add("keyboard-navigation");
    }
});

document.addEventListener("pointerdown", () => {
    document.body.classList.remove("keyboard-navigation");
});

btnShowLogin.addEventListener("click", () => {
    formRegister.classList.add("hide");
    formLogin.classList.remove("hide");
});

btnShowRegister.addEventListener("click", () => {
    formLogin.classList.add("hide");
    formRegister.classList.remove("hide");
});

// =====================================
// VALIDACIÓN DEL CORREO EN REGISTRO
// =====================================

const correoRegistro = document.getElementById("correoRegistro");

const dominioCorreoRegistro = document.getElementById("dominioCorreoRegistro");

const mensajeCorreo = document.getElementById("mensajeCorreo");

if (correoRegistro && dominioCorreoRegistro && mensajeCorreo) {

    // Construir el correo completo
    function obtenerCorreoCompleto() {

        return correoRegistro.value.trim() +
               dominioCorreoRegistro.value;

    }

    // Comprobar el formato del correo completo
    function verificarFormatoCorreo(correo) {

        const comprobador = document.createElement("input");

        comprobador.type = "email";

        comprobador.value = correo;

        return comprobador.checkValidity();

    }

    // Consultar si el correo ya existe
    async function comprobarCorreoRegistro() {

        const parteLocal = correoRegistro.value.trim();

        // Si está vacío, limpiar el mensaje
        if (parteLocal === "") {

            mensajeCorreo.textContent = "";
            mensajeCorreo.className = "mensaje-correo";

            return;

        }

        // Validar la parte escrita
        if (!correoRegistro.checkValidity()) {

            mensajeCorreo.textContent =
                "Ingresa una parte válida del correo.";

            mensajeCorreo.className =
                "mensaje-correo error";

            return;

        }

        // Obtener el correo completo
        const correo = obtenerCorreoCompleto();

        // Validar el correo completo
        if (!verificarFormatoCorreo(correo)) {

            mensajeCorreo.textContent =
                "Ingresa un correo válido.";

            mensajeCorreo.className =
                "mensaje-correo error";

            return;

        }

        // Preparar información para PHP
        const datos = new FormData();

        datos.append("correo", correo);

        try {

            const response = await fetch("validar_correo.php", {

                method: "POST",

                body: datos

            });

            if (!response.ok) {

                throw new Error("Error del servidor");

            }

            const data = await response.json();

            mensajeCorreo.textContent = data.mensaje;

            if (data.existe) {

                mensajeCorreo.className =
                    "mensaje-correo error";

            } else {

                mensajeCorreo.className =
                    "mensaje-correo success";

            }

        } catch (error) {

            mensajeCorreo.textContent =
                "No se pudo comprobar el correo.";

            mensajeCorreo.className =
                "mensaje-correo error";

            console.error(error);

        }

    }

    // Validar cuando el usuario sale del campo
    correoRegistro.addEventListener(
        "blur",
        comprobarCorreoRegistro
    );

    // Volver a validar cuando cambia el dominio
    dominioCorreoRegistro.addEventListener(
        "change",
        comprobarCorreoRegistro
    );

    // Limpiar mensajes mientras escribe
    correoRegistro.addEventListener("input", function () {

        mensajeCorreo.textContent = "";

        mensajeCorreo.className = "mensaje-correo";

    });

}

document.addEventListener("DOMContentLoaded", function () {

    const formulario = document.getElementById("formRegistro");

  // =====================================
// MOSTRAR Y OCULTAR CONTRASEÑAS
// =====================================

const botonesMostrar = document.querySelectorAll(".toggle-password");

botonesMostrar.forEach(function (boton) {

    boton.addEventListener("click", function () {

        // Obtener el identificador del campo
        const idCampo = boton.dataset.target;

        // Buscar el campo correspondiente
        const campo = document.getElementById(idCampo);

        if (!campo) return;

        // Comprobar si está oculto
        const mostrar = campo.type === "password";

        // Mostrar u ocultar la contraseña
        campo.type = mostrar ? "text" : "password";

        // Cambiar el icono
        boton.classList.toggle("is-visible", mostrar);

        // Actualizar accesibilidad
        boton.setAttribute(
            "aria-label",
            mostrar ? "Ocultar contraseña" : "Mostrar contraseña"
        );

        boton.setAttribute("aria-pressed", String(mostrar));

    });

});
  



    const campos = [
        {
            input: document.getElementById("nombreCompleto"),
            error: document.getElementById("errorNombre")
        },
        {
            input: document.getElementById("correoRegistro"),
            error: document.getElementById("errorCorreo")
        },
        {
            input: document.getElementById("contrasenaRegistro"),
            error: document.getElementById("errorContrasena")
        },
        {
    input: document.getElementById("confirmarContrasenaRegistro"),
    error: document.getElementById("errorConfirmarContrasena")
}
    ];

    if (!formulario) return;

    const contrasena = document.getElementById("contrasenaRegistro");

const confirmarContrasena = document.getElementById("confirmarContrasenaRegistro");

const errorConfirmarContrasena = document.getElementById("errorConfirmarContrasena");

function validarConfirmacion() {

   if (confirmarContrasena.value === "") {

    confirmarContrasena.setCustomValidity("Confirma tu contraseña.");

} else if (contrasena.value === "") {

    confirmarContrasena.setCustomValidity("Escribe primero una contraseña.");

} else if (confirmarContrasena.value !== contrasena.value) {

    confirmarContrasena.setCustomValidity("Las contraseñas no coinciden.");

} else {

    confirmarContrasena.setCustomValidity("");

}
    errorConfirmarContrasena.textContent =
        confirmarContrasena.validationMessage;

        if (confirmarContrasena.value !== "") {
    errorConfirmarContrasena.classList.toggle(
        "visible",
        !confirmarContrasena.checkValidity()
    );
}

}

confirmarContrasena.addEventListener("input", validarConfirmacion);

confirmarContrasena.addEventListener("blur", validarConfirmacion);

contrasena.addEventListener("input", validarConfirmacion);

    // Comprobar que cada campo tenga su mensaje
    campos.forEach(function (campo) {

        if (!campo.input || !campo.error) return;

        // Mostrar error cuando se sale de un campo incorrecto
        campo.input.addEventListener("blur", function () {

            if (!campo.input.checkValidity()) {
                campo.error.classList.add("visible");
            }

        });

        // Ocultar error cuando el campo ya es correcto
        campo.input.addEventListener("input", function () {

            if (campo.input.checkValidity()) {
                campo.error.classList.remove("visible");
            }

        });

    });

    // Comprobar todos los campos al intentar registrarse
    formulario.addEventListener("submit", function (event) {

        validarConfirmacion();

        let formularioValido = true;

        campos.forEach(function (campo) {

            if (!campo.input || !campo.error) return;

            if (!campo.input.checkValidity()) {

                campo.error.classList.add("visible");
                formularioValido = false;

            } else {

                campo.error.classList.remove("visible");

            }

        });

        if (!formularioValido) {
            event.preventDefault();
        }

    });

});

