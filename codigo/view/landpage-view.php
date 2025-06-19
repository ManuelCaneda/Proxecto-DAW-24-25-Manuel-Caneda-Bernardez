<?php
    if(isset($_SESSION['logged'])){
        header("Location: inicio");
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
    <main class="main landing_main">
        <section class="portada">
            <article class="portada__text">
                <h2>Bienvenido a ProHive</h2>
                <p>ProHive es una plataforma que nace del deseo de brindar la oportunidad a toda aquella persona o empresa de anunciar sus servicios a una comunidad amplia de personas.</p>
                <p>¿Quieres anunciarte en ProHive?</p>
                <a href="#contacto"><button class="portada__btn btn">Contáctanos</button></a>
            </article>
        </section>
        <section class="nosotros" id="quienes_somos">
            <article data-aos="fade-up" class="nosotros__info">
                <h2>¿Quiénes somos?</h2>
                <p>Somos un equipo consciente de las complicaciones a la hora de conseguir visibilidad en el mercado. Por ese motivo decidimos crear esta plataforma para quienes quieran destacar sus servicios de forma rápida y sencilla.</p>

                <p>Nuestro objetivo es ofrecer una herramienta útil, accesible y en constante mejora.</p>

                <p>No dudes en contactar con nosotros.</p>
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
                    <h3 class="stat"><span id="stat-empresas">+200</span> empresas</h3>
                </li>
                <li class="stats__autonomos" data-aos="fade-up">
                    <figure class="autonomos__img">
                        <img src="./view/src/assets/img/autonomo.svg" alt="">
                    </figure>
                    <h3 class="stat"><span id="stat-autonomos">+500</span> autónomos</h3>
                </li>
                <li class="stats__asesores" data-aos="fade-left">
                    <figure class="asesores__img">
                        <img src="./view/src/assets/img/asesor.svg" alt="">
                    </figure>
                    <h3 class="stat"><span id="stat-asesores">+150</span> asesores</h3>
                </li>
            </ul>
        </section>
        <section class="contacto" id="contacto">
            <article class="contacto__body">
                <h2>Contacta con nosotros</h2>
                <form action="" class="contacto__form">
                    <label for="name">Nombre: <span class="form-required">*</span></label>
                    <input type="text" name="name" id="name" placeholder="John" required>

                    <label for="email">Correo: <span class="form-required">*</span></label>
                    <input type="email" name="email" id="email" placeholder="Doe" required>

                    <label for="motivo">Motivo por el que nos contactas: <span class="form-required">*</span></label>
                    <select name="motivo" id="motivo">
                        <option value="Motivo 0" selected disabled>Selecciona una opción</option>
                        <option value="Quiero anunciarme en ProHive">Quiero anunciarme en ProHive</option>
                        <option value="Otro">Otro</option>
                    </select>

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
    <script>
        AOS.init({ once:true })
    </script>
</html>