<?php
namespace App\controllers;
use App\services\AuthService;
use Exception;

class AuthController {

    private AuthService $authService;

    public function __construct($db) {
        $this->authService = new AuthService($db);
    }

    public function register() {
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents("php://input"), true);

    try {
        if (
            empty($data['user_name']) ||
            empty($data['user_email']) ||
            empty($data['user_password'])
        ) {
            throw new \Exception("Tous les champs sont obligatoires");
        }

        $user = $this->authService->register(
            $data['user_name'],
            $data['user_email'],
            $data['user_password']
        );

        http_response_code(201);
        echo json_encode([
            "message" => "Utilisateur créé avec succès",
            "user" => $user
        ]);

    } catch (\Exception $e) {
        http_response_code(400);
        echo json_encode([
            "error" => $e->getMessage()
        ]);
    }
}

    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            $result = $this->authService->login(
                $data['user_email'],
                $data['user_password']
            );

            echo json_encode($result);

        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}