<?php

namespace App\services;

use App\repositories\UserRepository;

class AuthService {

    private UserRepository $userRepository;

    public function __construct($db) {
        $this->userRepository = new UserRepository($db);
    }

    public function register($name, $email, $password) {
        return $this->userRepository->createUser($name, $email, password_hash($password, PASSWORD_BCRYPT));
    }

    public function login($email, $password) {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            throw new \Exception("Invalid credentials");
        }

        return $user;
    }
}