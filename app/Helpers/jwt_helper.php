<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('createJWT')) {
    function createJWT($user)
    {
        $key = getenv('JWT_SECRET_KEY');
        $issuedAt = time();
        $expire = $issuedAt + (60 * 60 * 24 * 5); // 5 hari

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expire,
            'data' => [
                'id' => $user['id'],
                'username' => $user['username']
            ]
        ];

        return JWT::encode($payload, $key, 'HS256');
    }
}

if (!function_exists('verifyJWT')) {
    function verifyJWT($token)
    {
        $key = getenv('JWT_SECRET_KEY');
        return JWT::decode($token, new Key($key, 'HS256'));
    }
}
