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
             <form class="form">
                <label>
                    <input type ="text"placeholder="Ingrese su Nombre Completo">
                </label>
                <label> 
                    <input type="email" placeholder="Ingrese su Correo Electronico">
                </label>
                <label>
                    <input type="password" placeholder="Ingrese su contraseña">
                </label>
                <input type="submit" value="Registrar">
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
                    <input type="email" placeholder="Ingrese su Correo Electronico">
                </label>
                <label>
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