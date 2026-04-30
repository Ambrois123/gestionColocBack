<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "SECRET_KEY_CHANGE_ME";

function generateJWT($user) {
    global $key;

    $payload = [
        "iss" => "coloc-app",
        "aud" => "coloc-users",
        "iat" => time(),
        "exp" => time() + (60 * 60), // 1h
        "data" => [
            "id" => $user['user_id'],
            "email" => $user['user_email']
        ]
    ];

    return JWT::encode($payload, $key, 'HS256');
}