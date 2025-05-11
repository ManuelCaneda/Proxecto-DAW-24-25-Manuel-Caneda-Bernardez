<?php
include_once("globals.php");
include_once("controller/Controller.php");
include_once("controller/AuthController.php");

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

// $token = $_SERVER["HTTP_X_API_KEY"];
// $auth = AuthController::checkAccess($elemento,$metodo,$token);
// if(!$auth){
//     Controller::sendNotFound("No tienes permisos.");
//     die();
// }

switch ($metodo) {
    case 'POST':
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (isset($data['_method']) && strtoupper($data['_method']) === 'PUT') {
            if (isset($id)) {
                $controlador->update($id, $json);
            } else {
                Controller::sendNotFound("Falta el ID de la banda.");
            }
            exit;
        }

        $controlador->insert($json);
    break;
    case 'GET':
        if (isset($id)) {
            if(isset($endpoint) && !intval($endpoint)){
                switch ($endpoint) {
                    case "contactos":
                        $controlador->getContactos($id);        
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