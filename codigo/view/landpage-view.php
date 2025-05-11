<?php
if(isset($_SESSION['logged'])){
    header("Location: ?controller=page&action=main");
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProHive</title>
    <link rel="stylesheet" href="./view/src/css/style.css">
    <link rel="icon" type="image/x-icon" href="./view/src/assets/img/favicon.png">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
    <?php include_once('header_land.php') ?>
    <main class="main">
        <section class="portada">
            <article class="portada__text">
                <h2>Bienvenido a ProHive</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc posuere nulla metus, sed finibus ex facilisis sit amet. Mauris condimentum lacus risus. Morbi tristique, risus eu mollis aliquet, tellus neque tristique lacus.</p>
                <p>¿Quieres saber más?</p>
                <a href="?controller=user&action=login"><button class="portada__btn btn">Iniciar Sesión</button></a>
            </article>
        </section>
        <section class="nosotros" id="quienes_somos">
            <article data-aos="fade-up" class="nosotros__info">
                <h2>¿Quiénes somos?</h2>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Inventore at vero voluptates nihil vel deserunt sunt voluptate architecto saepe fuga, quis aliquam sequi veniam eaque blanditiis. Quidem sunt mollitia perferendis?</p>
                <a href="#"><button class="nosotros__btn btn">Saber más</button></a>
            </article>
            <figure class="nosotros__img" data-aos="fade-right">
                <img src="./view/src/assets/img/stock.jpg" alt="">
            </figure>
        </section>
        <section class="stats" id="estadisticas">
            <h2 data-aos="fade-up">Nuestras estadísticas</h2>
            <ul class="stats__list">
                <li class="stats__empresas" data-aos="fade-right">
                    <figure class="empresas__img">
                        <img src="./view/src/assets/img/empresa.svg" alt="">
                    </figure>
                    <h3 class="stat"><span id="stat-empresas"></span> empresas</h3>
                </li>
                <li class="stats__autonomos" data-aos="fade-up">
                    <figure class="autonomos__img">
                        <img src="./view/src/assets/img/autonomo.svg" alt="">
                    </figure>
                    <h3 class="stat"><span id="stat-autonomos"></span> autónomos</h3>
                </li>
                <li class="stats__asesores" data-aos="fade-left">
                    <figure class="asesores__img">
                        <img src="./view/src/assets/img/asesor.svg" alt="">
                    </figure>
                    <h3 class="stat"><span id="stat-asesores"></span> asesores</h3>
                </li>
            </ul>
        </section>
        <section class="contacto">
            <article class="contacto__body">
                <h2>Contacta con nosotros</h2>
                <form action="" class="contacto__form">
                    <label for="name">Nombre: <span class="form-required">*</span></label>
                    <input type="text" name="name" id="name" placeholder="John" required>

                    <label for="email">Correo: <span class="form-required">*</span></label>
                    <input type="email" name="email" id="email" placeholder="Doe" required>

                    <label for="message">Mensaje: <span class="form-required">*</span></label>
                    <textarea name="message" id="message" placeholder="Contenido del mensaje..." cols="30" rows="10" required></textarea>

                    <button type="submit" class="btn contacto__btn">Enviar</button>
                </form>
            </article>
        </section>
    </main>
    <?php include_once('footer.php') ?>
</body>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/countup@1.8.2/countUp.js"></script>
    <script>
        AOS.init({ once:true })

        let empresas = new CountUp('stat-empresas', 0, 8094),
            autonomos = new CountUp('stat-autonomos', 0, 8094),
            asesores = new CountUp('stat-asesores', 0, 8094)

        const $statsEmpresas = document.querySelector(".stats__empresas");

        empresas.start()
        autonomos.start()
        asesores.start()
    </script>
</html>