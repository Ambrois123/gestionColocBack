<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\controllers\AuthController;

$db = new PDO("mysql:host=localhost;dbname=gestion_coloc", "root", "");

$authController = new AuthController($db);

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($request === '/api/register' && $method === 'POST') {
    $authController->register();
}

if ($request === '/api/login' && $method === 'POST') {
    $authController->login();
}