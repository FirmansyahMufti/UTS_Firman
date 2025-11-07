<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        helper('jwt');
        $userModel = new UserModel();

        // Gunakan getJSON() dengan validasi fallback agar gak error di editor
        $json = $this->request->getJSON();
        $input = json_decode(json_encode($json), true);

        if (!$input || !isset($input['username'], $input['password'])) {
            return $this->respond(['message' => 'Data login tidak lengkap'], 400);
        }

        $user = $userModel->getUserByUsername($input['username']);

        if (!$user || !password_verify($input['password'], $user['password'])) {
            return $this->respond(['message' => 'Username atau password salah'], 401);
        }

        $token = createJWT($user);

        return $this->respond([
            'message' => 'Login sukses',
            'token' => $token,
            'expired_in' => '5 hari'
        ]);
    }
}
