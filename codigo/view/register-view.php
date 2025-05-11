<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ProHive</title>
    <link rel="icon" type="image/x-icon" href="./view/src/assets/img/favicon.png">
    <link rel="stylesheet" href="./view/src/css/style.css">
</head>
<body class="register_body">
    <main class="register_main">
        <h1 class="register_title">Registrarse</h1>
        <?php 
            if(isset($data['registered']) && $data['registered'] == false):
        ?>
            <p class="register_false">No se ha podido registrar el usuario. Por favor, inténtalo de nuevo.</p>
        <?php endif; ?>

        <?php 
            if(isset($data['check_pass']) && $data['check_pass'] == false):
        ?>
            <p class="register_false">Las contraseñas no coinciden</p>
        <?php endif; ?>
        <form class="register_form" action="?controller=user&action=checkRegistro" method="POST">
            <p>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="John">
            </p>

            <p>
                <label for="aps">Apellidos</label>
                <input type="text" name="aps" id="aps" placeholder="Doe">
            </p>

            <p>
                <label for="email">Correo electrónico</label>
                <input type="text" name="email" id="email" placeholder="johndoe@youremail.com">
            </p>

            <p>
                <label for="pass1">Contraseña</label>
                <input type="password" name="pass1" id="pass1" placeholder="***********">
            </p>

            <p>
                <label for="pass2">Confirmar contraseña</label>
                <input type="password" name="pass2" id="pass2" placeholder="***********">
            </p>
            <button type="submit" class="btn registrar__btn">Registrarse</button>
        </form>
        <p class="register__linkto__login">¿Ya tienes una cuenta? <a href="?controller=user&action=login">Inicia sesión</a></p>
    </main>
    
</body>
</html>