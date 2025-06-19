<?php 
    include_once(MODEL_PATH.'UsuarioModel.php');

    $model = new UsuarioModel();
    $user = $model->getById($_SESSION['logged']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - ProHive</title>
    <link rel="stylesheet" href="./view/src/css/style.css">
    <link rel="icon" type="image/x-icon" href="./view/src/assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        let id = <?php echo $_SESSION['logged'];?>
    </script>
    <script src="./view/src/js/editar-perfil.js" defer></script>
</head>
<body>
   <?php include_once('header.php') ?>
   <main class="main editar_perfil_main">
        <h1>Editar Perfil</h1>
        <p class="submit_msg hidden"></p>
        <form action="" class="form_perfil">
            <p>
                <label for="nombre">Nombre:</label>
                <article class="input_perfil">
                    <input type="text" name="nombre" id="nombre" value="<?php echo $user->getNombre() ?>" disabled>
                    <i class="fa-solid fa-pencil editar_campo_btn"></i>
                </article>
            </p>
            <p>
                <label for="aps">Apellidos:</label>
                <article class="input_perfil">
                    <input type="text" name="aps" id="aps" value="<?php echo $user->getAps() ?>" disabled>
                    <i class="fa-solid fa-pencil editar_campo_btn"></i>
                </article>
            </p>
            <p>
                <label for="email">Correo electrónico:</label>
                <article class="input_perfil">
                    <input type="email" name="email" id="email" value="<?php echo $user->getEmail() ?>" disabled>
                    <i class="fa-solid fa-pencil editar_campo_btn"></i>
                </article>
            </p>
            <?php if($user->getTipo()==3): ?>
                <p>
                    <label for="direccion">Dirección:</label>
                    <article class="input_perfil">
                        <input type="text" name="direccion" id="direccion" value="<?php echo $user->getDireccion() ?>" disabled>
                        <i class="fa-solid fa-pencil editar_campo_btn"></i>
                    </article>
                </p>
                <p>
                    <label for="horario_invierno">Horario de Invierno:</label>
                    <article class="input_perfil">
                        <input type="text" name="horario_invierno" id="horario_invierno" value="<?php echo $user->getHorario_invierno() ?>" disabled>
                        <i class="fa-solid fa-pencil editar_campo_btn"></i>
                    </article>
                </p>
                <p>
                    <label for="horario_verano">Horario de Verano:</label>
                    <article class="input_perfil">
                        <input type="text" name="horario_verano" id="horario_verano" value="<?php echo $user->getHorario_verano() ?>" disabled>
                        <i class="fa-solid fa-pencil editar_campo_btn"></i>
                    </article>
                </p>
            <?php endif; ?>
        </form>
        <p class="editar__btns">
            <button class="btn editar__btn" data-id="<?php echo $user->getId() ?>" type="submit">Guardar</button>
            <a href=".">
                <button class="btn cancelar__btn">Cancelar</button>
            </a>
        </p>
        <a href="/logout">
            <button class="btn logout__btn">Cerrar Sesión</button>
        </a>
   </main>
   <footer></footer>
</body>
</html>