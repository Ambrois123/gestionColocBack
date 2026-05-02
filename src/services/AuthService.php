<?php

namespace App\services;

use App\repositories\UserRepository;

class AuthService
{
    private UserRepository $userRepository;
    private JwtService $jwtService;

    public function __construct($db)
    {
        $this->userRepository = new UserRepository($db);
        $this->jwtService = new JwtService();
    }

    public function register($name, $email, $password)
    {
        return $this->userRepository->createUser(
            $name,
            $email,
            password_hash($password, PASSWORD_BCRYPT)
        );
    }

    public function login($email, $password)
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user['user_password'])) {
            throw new \Exception("Identifiants invalides");
        }

        $token = $this->jwtService->generate($user);

        return [
            "token" => $token,
            "user" => [
                "id" => $user['user_id'],
                "name" => $user['user_name'],
                "email" => $user['user_email']
            ]
        ];
    }
}