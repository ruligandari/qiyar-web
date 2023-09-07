<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    function __construct()
    {
        $this->user = new \App\Models\Admin\UserModel;
    }
    public function index()
    {
        // mendapatkan session id
        $id = session()->get('id');
        $user = $this->user->find($id);
        $data = [
            'title' => 'Profile',
            'data' => $user
        ];
        return view('dashboard/profile/profile', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $email = $this->request->getPost('email');
        $nama = $this->request->getPost('nama');
        $password1 = $this->request->getVar('password1');
        $password2 = $this->request->getVar('password2');

        // validasi password1 dan password2
        if ($password1 != $password2) {
            session()->setFlashdata('gagal', 'Password tidak sama');
            return redirect()->to(base_url('dashboard/profile'));
        }

        // insert update data
        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => password_hash($password1, PASSWORD_DEFAULT)
        ];

        if ($data) {
            $this->user->update($id, $data);
            session()->setFlashdata('success', 'Data User berhasil diupdate');
            return redirect()->to(base_url('dashboard/profile'));
        } else {
            session()->setFlashdata('gagal', 'Data gagal diupdate');
            return redirect()->to(base_url('dashboard/profile'));
        }
    }
}
