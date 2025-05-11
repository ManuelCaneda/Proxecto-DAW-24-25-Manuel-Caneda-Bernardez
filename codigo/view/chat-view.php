<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - ProHive</title>
    <link rel="stylesheet" href="./view/src/css/style.css">
    <link rel="icon" type="image/x-icon" href="./view/src/assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="./view/src/js/chats.js" defer></script>
</head>
<body>
    <?php include_once('header.php') ?>
    <main class="main_chat">
        <section class="chats_disponibles">
            <h1>Mensajes</h1>
            <ul class="lista_chats">
                <!-- <li class="chat" data-id="12">
                    <figure class="chat_img">
                        <img src="./view/src/assets/img/favicon.png" alt="Imagen de perfil del contacto">
                    </figure>
                    <section class="chat_texto">
                        <article class="info_chat">
                            <p class="chat_nombre">Aislamos</p>
                            <p class="chat_msg_hora">17:57</p>
                        </article>
                        <p class="chat_lastMsg">Mensajería de ProHive</p>
                    </section>
                </li> -->
            </ul>
        </section>
        <section class="chat_abierto">
            <figure class="chat_noabierto_img">
                <img src="./view/src/assets/img/favicon.png" alt="">
            </figure>
            <p class="chat_noabierto_texto">Mensajería de ProHive</p>
        </section>
    </main>
</body>
</html>