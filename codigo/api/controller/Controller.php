<?php
include_once("UsuarioController.php");
include_once("AnuncioController.php");
include_once("MensajeController.php");
// include_once("ValoracionController.php");

/**
 * Definicion de los nombres asociados a cada controlador en la URI.
 */
define("CONTROLLER_USUARIO", "usuarios");
define("CONTROLLER_ANUNCIO", "anuncios");
define("CONTROLLER_VALORACION", "valoraciones");
define("CONTROLLER_MENSAJE", "mensajes");

class ControllerException extends Exception{
    function __construct() {
        parent::__construct("Error obteniendo el controlador solicitado.");
    }
}

abstract class Controller
{

    public static function sendNotFound($mensaje)
    {
        error_log($mensaje);
        header("HTTP/1.1 404 Not Found");
        $mensaje = ["error" => $mensaje];
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
    }

    public static function getController($nombre): Controller
    {
        $controller = null;
        switch ($nombre) {
            case CONTROLLER_USUARIO:
                $controller = new UsuarioController();
                break;
            case CONTROLLER_ANUNCIO:
                $controller = new AnuncioController();
                break;
            case CONTROLLER_VALORACION:
                $controller = new ValoracionController();
                break;
            case CONTROLLER_MENSAJE:
                $controller = new MensajeController();
                break;
            default:
                throw new ControllerException();
        }
        return $controller;
    }

    public abstract function get($id);
    public abstract function getAll();
    public abstract function delete($id);
    public abstract function update($id, $object);
    public abstract function insert($object);


}