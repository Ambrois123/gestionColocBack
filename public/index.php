<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\controllers\AuthController;

$db = new PDO("mysql:host=localhost;dbname=gestion_coloc", "root", "");

$authController = new AuthController($db);

$basePath = '/GestionColocBack/public';

$request = str_replace(
    $basePath, 
    '', 
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    );

    /*echo "REQUEST: " . $request;
    exit;*/
$method = $_SERVER['REQUEST_METHOD'];

if ($request === '/api/register' && $method === 'POST') {
    $authController->register();
}

if ($request === '/api/login' && $method === 'POST') {
    $authController->login();
}

