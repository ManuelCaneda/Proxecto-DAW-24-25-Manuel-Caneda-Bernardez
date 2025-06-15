<?php
require_once("globals.php");
require_once(CONTROLLER_PATH."Controller.php");
require_once(CONTROLLER_PATH."PageController.php");
require_once(CONTROLLER_PATH."UserController.php");

session_start();

function checkLoggedIn($action) {
    $sitio = '';

    $actionsPublicos = [
        'land_page',
        'avisoLegal',
        'rgpd',
        'login',
        'checkLogin',
        'registrar',
        'checkRegistro'
    ];

    if(!isset($_SESSION['logged']) && !in_array($action, $actionsPublicos)) {
        $sitio = '?controller=page&action=land_page';
    } else if(isset($_SESSION['logged']) && in_array($action, $actionsPublicos)) {
        $sitio = '?controller=page&action=main';
    }

    return $sitio;
}

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

// Generar un token CSRF nuevo cada vez que entremos en una página y almacenarlo en la sesión
if(isset($_SESSION['logged'])): // Si el usuario está logueado, lo generamos y lo pasamos al frontend para usarlo con ajax
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $csrf = $_SESSION['csrf_token'];

?>

<script>window.csrfToken = '<?php echo htmlspecialchars($csrf) ?>';
        function ajax(options){
            const {url,method,fsuccess,ferror,data} = options
        
            fetch(url,{
            method: method || "GET",
            headers:{
                "Content-type":"application/json;charset=utf-8",
                'X-CSRF-Token': window.csrfToken
            },
            body:JSON.stringify(data)
            })
            .then(resp=>resp.ok?resp.json():Promise.reject(resp))
            .then(json=>fsuccess(json))
            .catch(error=>ferror(error))
        }
</script>

<?php

    endif;

$controller = $_GET['controller']??null;
$action = $_GET['action']??null;


$redirect = checkLoggedIn($action);
if (!empty($redirect)) {
    header("Location: $redirect");
    exit;
}


try {
    $controller = Controller::getController($controller);
    $controller->$action();
} catch (\Throwable $th) {
    error_log($th->getMessage());
    $controller = new PageController();
    $controller->land_page();
}