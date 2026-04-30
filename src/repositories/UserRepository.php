<?php

namespace App\repositories;
use PDO;
class UserRepository {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $email, $password) {
        $stmt = $this->db->prepare("
            INSERT INTO users (user_name, user_email, user_password)
            VALUES (:name, :email, :password)
        ");

        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        return $this->db->lastInsertId();
    }
}