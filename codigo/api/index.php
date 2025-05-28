<?php
include_once("globals.php");
include_once("controller/Controller.php");

session_start();

function getIds(array $uri):array{
    $ids = [];
    for($i=count($uri)-1;$i>=0;$i--){
        if(intval($uri[$i])){
            $ids[] = $uri[$i];
        }
    }

    return array_reverse($ids);
}

/**
 * Este fichero captura todas la peticiones a nuestra aplicación.
 * Aqui se parsea la uri para decidir el controlador y la acción que debemos ejecutar.
 */
$metodo = $_SERVER["REQUEST_METHOD"];
$uri = $_SERVER["REQUEST_URI"];
$uri = explode("/", $uri);
$elemento = $uri[2];
$endpoint = (count($uri) >= 4 && !intval($uri[3]))? $uri[3] : null;
$id = null;

if (count($uri) >= 4) {
    try {
        $id = getIds($uri);
    } catch (Throwable $th) {
        Controller::sendNotFound("Error en la peticion. El parámetro debe ser un id correcto.");
        die();
    }
}

try {
    $controlador = Controller::getController($elemento);
} catch (ControllerException $th) {
    Controller::sendNotFound("Error obteniendo el elemento " . $elemento);
    die();
}



$headers = getallheaders();
$tokenCliente = $headers['X-CSRF-Token'] ?? '';

// echo("Token recibido: " . $tokenCliente . "\n");
// echo("Token de sesión: " . (isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : 'No establecido') . "\n");
// die();

if (!isset($_SESSION['csrf_token']) || $tokenCliente !== $_SESSION['csrf_token']) {
    Controller::sendNotFound("No tienes permiso para acceder a este recurso.");
    exit;
}

switch ($metodo) {
    case 'POST':
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $controlador->insert($json);
    break;
    case 'GET':
        if (isset($id)) {
            if(isset($endpoint)){
                switch ($endpoint) {
                    case "contactos":
                        $controlador->getContactos($id);        
                    break;

                    case "busqueda":
                        $controlador->getBySearch($uri[4]);
                    break;

                    case "cliente":
                        $controlador->getByCliente($id);
                    break;

                    case "publicados":
                        $limit = (isset($_GET['limit']))? $_GET['limit'] : 5;
                        $controlador->getPublicados($limit);
                    break;

                    case "conversacion":
                        $controlador->getConversaciones($id);
                    break;

                    case "ultimomsg":
                        $controlador->getUltimoMsg($id);
                    break;

                    case "anuncio":
                        $controlador->getByAnuncio($id);
                    break;

                    case "autor":
                        $controlador->getByAutor($id);
                    break;
                }
            } else {
                $controlador->get($id);
            }
        } else {
            $controlador->getAll();
        }
    break;
    case 'DELETE':
        if (isset($id)) {
            $controlador->delete($id);
        } else {
            Controller::sendNotFound("Es necesario indicar el id correcto de la banda a eliminar.");
        }
        break;
    case 'PUT':
        if (isset($id)) {
            $json = file_get_contents('php://input');
            $controlador->update($id, $json);
        } else {
            Controller::sendNotFound("Es necesario indicar el id correcto de la banda a actualizar.");
        }

        break;
    default:
        Controller::sendNotFound("Método HTTP no disponible.");
}