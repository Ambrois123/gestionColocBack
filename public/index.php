<?php

// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Gestion des requêtes OPTIONS pour les pré-vols CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

use App\controllers\AuthController;
use App\controllers\TaskController;

// Connexion à la base de données
$db = new PDO("mysql:host=localhost;dbname=gestion_coloc;charset=utf8", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Controllers
$authController = new AuthController($db);
$taskController = new TaskController($db);

$basePath = '/GestionColocBack/public';

$request = str_replace(
    $basePath,
    '',
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

$method = $_SERVER['REQUEST_METHOD'];

// Routes Auth
if ($request === '/api/register' && $method === 'POST') {
    $authController->register();
    exit;
}

if ($request === '/api/login' && $method === 'POST') {
    $authController->login();
    exit;
}

// Routes Tasks
if ($request === '/api/tasks' && $method === 'GET') {
    $taskController->index();
    exit;
}

if ($request === '/api/tasks' && $method === 'POST') {
    $taskController->create();
    exit;
}

// Route non trouvée
http_response_code(404);
echo json_encode([
    "error" => "Route non trouvée"
]);