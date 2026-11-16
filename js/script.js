const btnShowLogin = document.getElementById("show-login");
const btnShowRegister = document.getElementById("show-register");
const formRegister = document.querySelector(".register");
const formLogin = document.querySelector(".login");

btnShowLogin.addEventListener("click", () => {
    formRegister.classList.add("hide");
    formLogin.classList.remove("hide");
});

btnShowRegister.addEventListener("click", () => {
    formLogin.classList.add("hide");
    formRegister.classList.remove("hide");
});

// VALIDACIÓN DEL CORREO EN REGISTRO

const correoRegistro = document.getElementById("correoRegistro");
const mensajeCorreo = document.getElementById("mensajeCorreo");

if (correoRegistro && mensajeCorreo) {

    correoRegistro.addEventListener("blur", function () {

        const correo = correoRegistro.value.trim();

        // Limpiar mensaje si está vacío
        if (correo === "") {
            mensajeCorreo.textContent = "";
            return;
        }

        // Comprobar formato del correo
        if (!correoRegistro.checkValidity()) {
            mensajeCorreo.textContent =
                "Ingresa un correo válido.";

            mensajeCorreo.className =
                "mensaje-correo error";

            return;
        }

        // Preparar información para PHP
        const datos = new FormData();

        datos.append("correo", correo);

        // Consultar la base de datos mediante PHP
        fetch("validar_correo.php", {
            method: "POST",
            body: datos
        })

        .then(response => {
            if (!response.ok) {
                throw new Error("Error del servidor");
            }

            return response.json();
        })

        .then(data => {

            mensajeCorreo.textContent = data.mensaje;

            if (data.existe) {

                mensajeCorreo.className =
                    "mensaje-correo error";

            } else {

                mensajeCorreo.className =
                    "mensaje-correo success";

            }

        })

        .catch(error => {

            mensajeCorreo.textContent =
                "No se pudo comprobar el correo.";

            mensajeCorreo.className =
                "mensaje-correo error";

            console.error(error);

        });

    });

}
document.addEventListener("DOMContentLoaded", function () {

    const formulario = document.getElementById("formRegistro");

    const campos = [
        {
            input: document.getElementById("nombreCompleto"),
            error: document.getElementById("errorNombre")
        },
        {
            input: document.getElementById("correo"),
            error: document.getElementById("errorCorreo")
        },
        {
            input: document.getElementById("contrasenaRegistro"),
            error: document.getElementById("errorContrasena")
        }
    ];

    if (!formulario) return;

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
