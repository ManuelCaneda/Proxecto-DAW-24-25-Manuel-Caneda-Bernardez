<?php 
require_once(VENDOR_PATH.'autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(PATH_ROOT);
$dotenv->load();

return [
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
];
