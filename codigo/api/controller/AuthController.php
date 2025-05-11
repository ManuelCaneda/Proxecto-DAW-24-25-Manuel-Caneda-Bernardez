<?php
include_once("Controller.php");
include_once(PATH_MODEL."AuthModel.php");
class AuthController{

    public static function checkAccess($endpoint,$method,$token){
        $auth = false;

        if(isset($endpoint) && isset($method) && isset($token)){
            $auth = AuthModel::hasAccess($endpoint,$method,$token);
        }

        return $auth;
    }

}