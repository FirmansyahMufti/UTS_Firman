<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

    // 👉 Tampilkan halaman login
    public function showLogin()
    {
        return view('auth/login');
    }

    // 👉 Proses login
    public function login()
    {
        helper('jwt');
        $userModel = new UserModel();

        // Ambil input (JSON atau form)
        $input = $this->request->getJSON(true);
        if (!$input) {
            $input = $this->request->getPost();
        }

        if (empty($input['username']) || empty($input['password'])) {
            return $this->respond(['message' => 'Username dan password wajib diisi'], 400);
        }

        $user = $userModel->where('username', $input['username'])->first();
        if (!$user) {
            return $this->respond(['message' => 'Username tidak ditemukan'], 401);
        }

        if (!password_verify($input['password'], $user['password'])) {
            return $this->respond(['message' => 'Password salah'], 401);
        }

        $token = createJWT($user);

        return $this->respond([
            'message' => 'Login sukses!',
            'token' => $token,
            'expired_in' => '5 hari'
        ], 200);
    }
}
