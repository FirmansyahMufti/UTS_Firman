<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

/**
 * AuthController
 *
 * Supports JSON body or form-data login.
 */
/** @property \CodeIgniter\HTTP\IncomingRequest $request */
class AuthController extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        helper('jwt'); // pastikan helper jwt_helper.php ada di app/Helpers
        $userModel = new UserModel();

        // Ambil JSON body jika ada, fallback ke getVar() agar aman untuk form post
        $raw = $this->request->getBody();
        $input = null;

        if (!empty($raw)) {
            // coba decode JSON -> array
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $input = $decoded;
            }
        }

        if (!$input) {
            // fallback: ambil dari x-www-form-urlencoded atau query params
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $input = [
                'username' => $username,
                'password' => $password
            ];
        }

        if (empty($input['username']) || empty($input['password'])) {
            return $this->respond(['message' => 'username & password required'], 400);
        }

        $user = $userModel->getUserByUsername($input['username']);
        if (!$user) {
            return $this->respond(['message' => 'Username atau password salah'], 401);
        }

        // Pastikan password di DB sudah hash (password_hash). Jika belum, sesuaikan.
        if (!password_verify($input['password'], $user['password'])) {
            return $this->respond(['message' => 'Username atau password salah'], 401);
        }

        $token = createJWT($user); // helper function

        return $this->respond([
            'message'    => 'Login sukses',
            'token'      => $token,
            'expired_in' => '5 hari'
        ], 200);
    }
}
