<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Anuncio - ProHive</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="./view/src/assets/img/favicon.png">
    <link rel="stylesheet" href="./view/src/css/style.css">
    <script>
        let idAnuncio = <?php echo $_GET['id'];?>
    </script>
    <script src="./view/src/js/editar-anuncio.js" defer></script>
</head>
<body>
    <?php include_once('header.php'); ?>
    <main class="main crear_anuncio_main">
        <h1>Editar anuncio</h1>
        <p class="submit_msg hidden"></p>
        <form action="" class="form_crear_anuncio">
            <p>
                <label for="imagen">URL de la imagen:</label>
                <input type="text" name="imagen" id="imagen">
            </p>
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre">
            </p>
            <p>
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion"></textarea>
            </p>
            <p>
                <label for="precio">Precio base:</label>
                <input type="number" name="precio" id="precio">
            </p>
            <button class="btn" type="submit">Publicar</button>
        </form>
        <p class="editar__btns">
            <button class="btn-light editar__btn" type="submit">Guardar borrador</button>
            <a href=".">
                <button class="btn cancelar__btn">Volver</button>
            </a>
        </p>
    </main>
</body>
</html>