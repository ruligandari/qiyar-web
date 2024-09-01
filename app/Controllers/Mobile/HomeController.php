<?php

namespace App\Controllers\Mobile;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Beranda',
        ];
        return view('mobile/home/home', $data);
    }

    public function profile()
    {
        $data = [
            'title' => 'Profil',
        ];
        return view('mobile/profile/profile', $data);
    }

    public function update()
    {
        $user = new \App\Models\Admin\UserModel();
        $nama = $this->request->getPOST('nama');
        $email = $this->request->getPOST('email');
        $password_1 = $this->request->getPOST('password_1');
        $password_2 = $this->request->getPOST('password_2');

        // cek password 1 dan 2 harus sama
        if ($password_1 != $password_2) {
            return redirect()->to('/mobile/profile')->with('error', 'Password tidak sama');
        }
        // enkripsi password
        $password_1 = password_hash($password_1, PASSWORD_DEFAULT);
        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => $password_1,
        ];

        // update data
        $this->$user->update($data);

        return redirect()->to('/mobile/profile')->with('success', 'Data berhasil diupdate');
    }
}
