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
        $sitio = '.';
    } else if(isset($_SESSION['logged']) && in_array($action, $actionsPublicos)) {
        $sitio = '/inicio';
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

$uri = $_SERVER["REQUEST_URI"];
$uri = explode("/", $uri);
$pagina = $uri[1]??"/";
$id = $_GET["id"]??null;

// Leyenda del valor de cada elemento = [controller,action]
$paginas = [
    "" => ["page","land_page"],
    "inicio" => ["page","main"],
    "login" => ["user","login"],
    "registrar" => ["user","registrar"],
    "editar-perfil" => ["user","editarPerfil"],
    "logout" => ["user","logout"],
    "chat" => ["user","chat"],
    "ver-anuncio" => ["page","verAnuncio"],
    "crear-anuncio" => ["page","crearAnuncio"],
    "editar-anuncio" => ["page","editarAnuncio"],
    "aviso-legal" => ["page","avisoLegal"],
    "rgpd" => ["page","rgpd"],
    "404" => ["page","notFound"],
    "check-login" => ["user","checkLogin"],
    "check-registro" => ["user","checkRegistro"]
];


if(!isset($paginas[$pagina]) &&
!str_contains($pagina, "editar-anuncio") && !str_contains($pagina, "ver-anuncio")) {
    header("Location: 404");
    exit;
}

if(str_contains($pagina, "editar-anuncio"))
    $pagina = "editar-anuncio";

if(str_contains($pagina, "ver-anuncio"))
    $pagina = "ver-anuncio";

$controller = $paginas[$pagina][0];
$action = $paginas[$pagina][1];

$redirect = checkLoggedIn($action);
if (!empty($redirect)) {
    header("Location: $redirect");
    exit;
}

try {
    $controller = Controller::getController($controller);
    if($id!=null)
        $controller->$action($id);
    else
        $controller->$action();
} catch (\Throwable $th) {
    error_log($th->getMessage());
    header("Location: /404");
    exit;
}