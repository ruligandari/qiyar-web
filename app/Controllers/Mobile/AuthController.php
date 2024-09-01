<?php

namespace App\Controllers\Mobile;

use App\Controllers\BaseController;
use App\Models\Admin\UserModel;

class AuthController extends BaseController
{
    public function index()
    {
        if (session()->get('isLogin')) {
            session()->setFlashdata('loged', 'Anda sudah login');
            return redirect()->to('stok-opname');
        }
        $data = [
            'title' => 'Login'
        ];
        return view('mobile/login/login', $data);
    }

    public function login()
    {
        $UserModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getVar('password');
        $user = $UserModel->where('email', $email)->first();

        // cek apakah ada sesi
        if (session()->get('isLogin')) {
            session()->setFlashdata('loged', 'Anda sudah login');
            return redirect()->to('stok-opname/login');
        }

        if ($user) {
            if (password_verify($password, $user['password'])) {

                $data = [
                    'id' => $user['id'],
                    'nama' => $user['nama'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'isLogin' => TRUE
                ];
                session()->set($data);
                session()->setFlashdata('success', 'Selamat Datang, ' . $user['nama']);
                return redirect()->to(base_url('stok-opname'));
            } else {
                session()->setFlashdata('gagal', 'Password salah');
                return redirect()->to('m/login');
            }
        } else {
            session()->setFlashdata('gagal', 'Email tidak terdaftar');
            return redirect()->to('m/login');
        }
    }

    public function logout()
    {
        // logout
        session()->destroy();
        session()->setFlashdata('success-logout', 'Logout Berhasil');
        return redirect()->to('m/login');
    }
    public function logout_session()
    {
        // logout
        session()->destroy();
        return json_encode(array("success" => true,));
    }
}
