<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    use ResponseTrait;

    // 🧩 Tampilkan halaman login
    public function showLogin()
    {
        return view('auth/login');
    }

    // 🔐 Proses login user + JWT
    public function login()
    {
        helper('jwt');
        $userModel = new UserModel();

        // Ambil data dari JSON body
        $input = json_decode(file_get_contents('php://input'), true);

        // Kalau JSON kosong, ambil dari POST biasa
        if (!is_array($input)) {
            $input = [
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password'),
            ];
        }

        // Validasi input
        if (empty($input['username']) || empty($input['password'])) {
            return $this->respond(['message' => 'Username dan password wajib diisi'], 400);
        }

        // Cek user di database
        $user = $userModel->where('username', $input['username'])->first();

        if (!$user) {
            return $this->respond(['message' => 'Username tidak ditemukan'], 401);
        }

        // Verifikasi password
        if (!password_verify($input['password'], $user['password'])) {
            return $this->respond(['message' => 'Password salah'], 401);
        }

        // Buat token JWT
        $token = createJWT($user);

        return $this->respond([
            'message'    => 'Login sukses!',
            'token'      => $token,
            'expired_in' => '5 hari'
        ], 200);
    }
}
