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
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            $user = $this->authService->register(
                $data['name'],
                $data['email'],
                $data['password']
            );

            echo json_encode($user);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            $result = $this->authService->login(
                $data['email'],
                $data['password']
            );

            echo json_encode($result);

        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}