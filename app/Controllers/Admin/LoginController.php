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

        // cek apakah ada sesi
        if (session()->get('isLogin')) {
            session()->setFlashdata('loged', 'Anda sudah login');
            return redirect()->to('/login');
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
        // logout
        session()->destroy();
        session()->setFlashdata('success-logout', 'Logout Berhasil');
        return redirect()->to('/login');
    }
    public function logout_session()
    {
        // logout
        session()->destroy();
        return json_encode(array("success" => true,));
    }

    public function restrictedpage()
    {
        return view('login/restrictedpage');
    }
}
