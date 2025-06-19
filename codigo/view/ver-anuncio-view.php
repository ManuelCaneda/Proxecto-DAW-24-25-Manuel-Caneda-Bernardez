<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Anuncio - ProHive</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="./view/src/assets/img/favicon.png">
    <link rel="stylesheet" href="./view/src/css/style.css">
    <script>
        let id = <?php echo $data['id_anuncio'] ?>
    </script>
    <script src="./view/src/js/ver-anuncio.js" defer></script>
</head>
<body>
    <?php include_once('header.php'); ?>
    <main class="main main_pag_anuncio">
        <section class="pag_anuncio_info" style="padding-top:3rem">
        <article class="pag_anuncio_img">
            <figure>
                <img src="" alt="Imagen del anuncio">
            </figure>
            <h3>Información:</h3>
            <ul>
                <li>Dirección: ${cliente.direccion}</li>
                <li>Precio Base: ${anuncio.precio}&euro;</li>
                <li>Horario de invierno: ${cliente.horario_invierno}</li>
                <li>Horario de verano: ${cliente.horario_verano}</li>
            </ul>
        </article>
        <article class="pag_anuncio_texto">
            <h2>${anuncio.nombre}</h2>
            <p>${anuncio.texto}</p>
            <a href="">Términos y condiciones de servicio</a>
            <button class="btn contactar_empresa_btn">Contactar</button>
        </article>
        </section>
        <section class="pag_anuncio_valoraciones" style="padding-bottom:1rem">
            <article class="escribir_valoraciones">
                <hgroup style="text-align:center">
                    <h2>Valoraciones</h2>
                    <h3>Escribe una valoración</h3>
                </hgroup>
                <p style="text-align:center;margin-top:5px">Tu valoración es importante para nosotros, por favor, escribe una valoración constructiva.</p>
                <form class="form_valoracion">
                    <textarea name="valoracion_propia" id="valoracion_propia" placeholder="Escribe tu valoración..."></textarea>
                    <select name="select_puntuacion" id="select_puntuacion">
                        <option value="1">1 estrella</option>
                        <option value="2">2 estrellas</option>
                        <option value="3">3 estrellas</option>
                        <option value="4">4 estrellas</option>
                        <option value="5">5 estrellas</option>
                    </select>
                    <button class="btn">Enviar</button>
                </form>
            </article>
        </section>
    </main>
</body>
</html>