<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function register()
    {
        helper(['form']);
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]',
            'password' => 'required|min_length[5]|max_length[255]'
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $userModel->save([
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ]);
            return redirect()->to('/login')->with('success', 'Registrasi berhasil!');
        } else {
            return view('auth/register', [
                'validation' => $this->validator
            ]);
        }
    }

    public function login()
    {
        helper(['form']);
        $session = session();
        $userModel = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $userModel->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            if (password_verify($password, $pass)) {
                $sessionData = [
                    'id' => $data['id'],
                    'username' => $data['username'],
                    'logged_in' => TRUE
                ];
                $session->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah!');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan!');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
