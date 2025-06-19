<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Anuncio - ProHive</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="./view/src/assets/img/favicon.png">
    <link rel="stylesheet" href="./view/src/css/style.css">
    <script src="./view/src/js/crear-anuncio.js" defer></script>
</head>
<body>
    <?php include_once('header.php'); ?>
    <main class="main crear_anuncio_main">
        <h1>Crear anuncio</h1>
        <p class="submit_msg hidden"></p>
        <form action="" class="form_crear_anuncio" enctype="multipart/form-data">
            <p>
                <label for="imagen">Imagen:</label>
                <input type="file" name="imagen" id="imagen" accept="image/*">
            </p>
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre..." required>
            </p>
            <p>
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" placeholder="Descripción..." required></textarea>
            </p>
            <p>
                <label for="precio">Precio base:</label>
                <input type="number" name="precio" id="precio" placeholder="XXX.XX" required>
            </p>
            <button class="btn-light editar__btn" type="submit">Guardar Borrador</button>
        </form>
        <p class="editar__btns">
            <a href="."><button class="btn cancelar__btn">Cancelar</button></a>
        </p>
    </main>
</body>
</html>