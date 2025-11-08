<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use Firebase\JWT\ExpiredException;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine('Authorization');

        if (!$header) {
            return Services::response()
                ->setJSON(['message' => 'Token tidak ditemukan'])
                ->setStatusCode(401);
        }

        $token = explode(' ', $header)[1] ?? null;
        if (!$token) {
            return Services::response()
                ->setJSON(['message' => 'Format token salah'])
                ->setStatusCode(401);
        }

        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'), 'HS256'));
            $request->userData = $decoded->data;
        } catch (ExpiredException $e) {
            return Services::response()
                ->setJSON(['message' => 'Token kadaluarsa'])
                ->setStatusCode(401);
        } catch (Exception $e) {
            return Services::response()
                ->setJSON(['message' => 'Token tidak valid'])
                ->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak digunakan
    }
}
