<?php
require_once("globals.php");
require_once(CONTROLLER_PATH."Controller.php");
require_once(CONTROLLER_PATH."PageController.php");
require_once(CONTROLLER_PATH."UserController.php");

session_start();

$controller = $_GET['controller']??null;
$action = $_GET['action']??null;

try {
    $controller = Controller::getController($controller);
    $controller->$action();
} catch (\Throwable $th) {
    error_log($th->getMessage());
    $controller = new PageController();
    $controller->land_page();
}