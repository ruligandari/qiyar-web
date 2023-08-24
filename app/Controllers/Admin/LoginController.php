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
            if ($password == $user['password']) {
                $data = [
                    'nama' => $user['nama'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'logged_in' => TRUE
                ];
                session()->set($data);
                session()->setFlashdata('success', 'Sukses Bro');
                return redirect()->to(base_url('login'));
            } else {
                session()->setFlashdata('gagal', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            session()->setFlashdata('gagal', 'Email tidak terdaftar');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
