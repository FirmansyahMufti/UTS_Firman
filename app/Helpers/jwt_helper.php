<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('createJWT')) {
    function createJWT($user)
    {
        // Ambil key dari .env atau fallback ke default
        $key = getenv('JWT_SECRET_KEY') ?: 'default_secret_key';
        $issuedAt = time();
        $expire = $issuedAt + (60 * 60 * 24 * 5); // Token berlaku 5 hari

        $payload = [
            'iss' => 'UTS_Firman_API',  // issuer
            'aud' => 'UTS_Firman_Client', // audience
            'iat' => $issuedAt,
            'exp' => $expire,
            'data' => [
                'id' => $user['id'],
                'username' => $user['username'],
            ]
        ];

        return JWT::encode($payload, $key, 'HS256');
    }
}

if (!function_exists('verifyJWT')) {
    function verifyJWT($token)
    {
        $key = getenv('JWT_SECRET_KEY') ?: 'default_secret_key';
        return JWT::decode($token, new Key($key, 'HS256'));
    }
}
