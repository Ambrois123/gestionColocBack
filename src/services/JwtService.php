<?php

namespace App\services;

use Firebase\JWT\JWT;

class JwtService
{
    private string $key;

    public function __construct()
    {
        $this->key = "ma_cle_secrete_tres_longue_pour_gestion_coloc_2026";
    }

    public function generate(array $user): string
    {
        $payload = [
            "iss" => "coloc-app",
            "aud" => "coloc-users",
            "iat" => time(),
            "exp" => time() + 3600,
            "data" => [
                "id" => $user['user_id'],
                "email" => $user['user_email']
            ]
        ];

        return JWT::encode($payload, $this->key, 'HS256');
    }
}