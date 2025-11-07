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

        $input = $this->request->getJSON(true);
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
