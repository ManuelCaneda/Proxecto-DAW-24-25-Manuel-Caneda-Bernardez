<?php 
require_once(MODEL_PATH.'UsuarioModel.php');

    if(!isset($_SESSION['logged'])){
        header("Location: .");
    }

    $userId = $_SESSION['logged'];

    $model = new UsuarioModel();
    $user = $model->getById($userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - ProHive</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="./view/src/assets/img/favicon.png">
    <script src="./view/src/js/anuncios<?php echo $user->getTipo()==3?'-propios':'' ?>.js" defer></script>
    <link rel="stylesheet" href="./view/src/css/style.css">
</head>
<body>
    <?php include_once('header.php') ?>
    <main class="main">
        <?php if($user->getTipo() == 2): ?>
        <h1>Destacados</h1>
        
        <ul class="anuncios_destacados">
            <!-- <li class="card_anuncio">
                <figure class="anuncio_img">
                    <img src="https:\/\/www.aislamos.com\/wp-content\/uploads\/2024\/08\/facebook.jpg" alt="">
                </figure>
                <section class="anuncio_info">
                    <hgroup>
                        <h2 class="anuncio_title">Aislamientos</h2>
                        <h4 class="anuncio_owner">Por Aislamos</h4>
                    </hgroup>
                    <p class="anuncio_price">200&euro;</p>
                </section>
                <p class="anuncio_desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam officia provident nam, amet est pariatur ducimus hic mollitia quos libero quisquam vitae eum labore doloribus. Libero enim esse soluta ad.</p>
                <button class="anuncio_btn btn">Más información</button>
            </li> -->
        </ul>
        <?php elseif($user->getTipo() == 3): ?>
            <h1 class="anuncios_propios_title">Gestionar Anuncios</h1>
            <ul class="anuncios_propios">
                <li class="card_anuncio">
                    <figure class="anuncio_img">
                        <img src="https:\/\/www.aislamos.com\/wp-content\/uploads\/2024\/08\/facebook.jpg" alt="">
                    </figure>
                    <section class="anuncio_info">
                        <hgroup>
                            <h2 class="anuncio_title">Aislamientos</h2>
                            <h4 class="anuncio_owner">Por Aislamos</h4>
                        </hgroup>
                        <p class="anuncio_price">200&euro;</p>
                    </section>
                    <p class="anuncio_desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam officia provident nam, amet est pariatur ducimus hic mollitia quos libero quisquam vitae eum labore doloribus. Libero enim esse soluta ad.</p>
                    <section class="anuncio_estado">
                        <p class="anuncio_estado_texto">Publicado</p>
                        <figure class="anuncio_estado_icon">
                            <img src="./view/src/assets/img/check.png" alt="Icono de check verde">
                        </figure>
                    </section>
                    <button class="anuncio_btn btn">Editar información</button>
                </li>
                <li class="card_anuncio add_card">
                    <figure class="add_card_icon">
                        <img src="./view/src/assets/img/plus.png" alt="">
                    </figure>
                </li>
            </ul>
        <?php endif; ?>
    </main>
    <footer class="footer"></footer>
</body>
</html>