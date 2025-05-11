<?php
$config = require PATH_CONFIG . 'db.php';
class Model {
    public static function getConnection() {
        $config = require PATH_CONFIG.'db.php';
        $pdo = false;

        try{
            $pdo = new PDO('mysql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['database'], $config['username'],$config['password']);
        } catch (PDOException $e) {
            error_log("Error conectándose a la base de datos: ".$e->getMessage());
            die();
        }
        
        return $pdo;
    }
}