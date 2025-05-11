<?php
    require_once('globals.php');
    require_once(MODEL_PATH.'UsuarioModel.php');

    $model = new UsuarioModel();
    $user = $model->getById($_SESSION['logged']);

    $controller = $_GET['controller']??null;
    $action = $_GET['action']??null;
?>

<?php if($controller == 'user' && $action == 'editarPerfil'): ?>

    <header class="header header_perfil">
        <a class="header__logo" href=".">
            <img src="./view/src/assets/img/logo.png" alt="">
        </a>
    </header>

<?php else: ?>

    <header class="header header_home">
        <a class="header__logo" href=".">
            <img src="./view/src/assets/img/logo.png" alt="">
        </a>

        <form action="" class="header__buscador">
            <input type="text" placeholder="Buscar">
            <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
        
        <section class="header__opciones">
            <a href="?controller=user&action=chat" class="header__chat">
                <i class="fa-solid fa-comments fa-2x"></i>
            </a>
            <a href="?controller=user&action=editarPerfil" class="header__perfil" data-id="<?php echo $user->getId() ?>">
                <i class="fa-solid fa-user fa-2x"></i>
            </a>
        </section>
    </header>

<?php endif; ?>