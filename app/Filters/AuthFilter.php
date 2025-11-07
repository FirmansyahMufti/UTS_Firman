<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\ExpiredException;
use Exception;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine('Authorization');
        if (!$header) {
            return Services::response()->setJSON(['message' => 'Token tidak ditemukan'])->setStatusCode(401);
        }

        $token = explode(' ', $header)[1];

        try {
            helper('jwt');
            verifyJWT($token);
        } catch (ExpiredException $e) {
            return Services::response()->setJSON(['message' => 'Token kadaluarsa'])->setStatusCode(401);
        } catch (Exception $e) {
            return Services::response()->setJSON(['message' => 'Token tidak valid'])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak perlu diisi
    }
}
