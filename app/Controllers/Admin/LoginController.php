<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\Admin\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        return view('login/index');
    }

    public function login()
    {
        $UserModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getVar('password');
        $user = $UserModel->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'nama' => $user['nama'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'logged_in' => TRUE
                ];
                session()->set($data);
                return redirect()->to('/dashboard');
            } else {
                session()->setFlashdata('pesan', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            session()->setFlashdata('pesan', 'Email tidak terdaftar');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
