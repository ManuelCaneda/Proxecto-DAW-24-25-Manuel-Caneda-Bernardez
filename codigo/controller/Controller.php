<?php
require_once("globals.php");
require_once(CONTROLLER_PATH."PageController.php");

class Controller{

    static $controllers = [
        'page'=>'PageController',
        'user'=>'UserController'
    ];
    public static function getController($nombre){
        if(array_key_exists($nombre,self::$controllers)){
            $object = self::$controllers[$nombre];
            return new $object();
        }
        return null;
    }
}