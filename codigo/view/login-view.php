<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ProHive</title>
    <link rel="icon" type="image/x-icon" href="./view/src/assets/img/favicon.png">
    <link rel="stylesheet" href="./view/src/css/style.css">
</head>
<body class="login_body">
    <main class="login_main">
        <h1 class="login_title">Inicia sesión</h1>
        <?php
            if(isset($data['registered']) && $data['registered'] == true):
        ?>
            <p class="register_true">El usuario ha sido registrado. Por favor, inicia sesión</p>
        <?php endif; ?>

        <?php
            if(isset($data['error']) && $data['error'] == true):
        ?>
            <p class="login_false">El email y/o la contraseña es incorrecto. Vuelve a intentarlo.</p>
        <?php endif; ?>
        <form class="login_form" action="?controller=user&action=checkLogin" method="POST">
            <p>
                <label for="email">Correo electrónico</label>
                <input type="text" name="email" id="email" placeholder="johndoe@youremail.com">
            </p>

            <p>
                <label for="pass1">Contraseña</label>
                <input type="password" name="pass" id="pass" placeholder="***********">
            </p>

            <button type="submit" class="btn login__btn">Entrar</button>
        </form>
        <p class="login__linkto__register">¿No tienes cuenta? <a href="?controller=user&action=registrar">Regístrate</a></p>
    </main>    
</body>
</html>