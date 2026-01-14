<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class SettingController extends BaseController
{
    function __construct()
    {
        $this->user = new \App\Models\Admin\UserModel();
    }
    public function index()
    {
        $user = $this->user->findAll();
        // mengganti $user['role'] yang isinya 1-7 menjadi super admin, manager broadcast, dst
        foreach ($user as $key => $value) {
            switch ($value['role']) {
                case 1:
                    $user[$key]['role'] = 'Super Admin';
                    break;
                case 2:
                    $user[$key]['role'] = 'Manager Broadcast';
                    break;
                case 3:
                    $user[$key]['role'] = 'Manager Advertiser';
                    break;
                case 4:
                    $user[$key]['role'] = 'Admin Advertiser';
                    break;
                case 5:
                    $user[$key]['role'] = 'Karyawan Advertiser';
                    break;
                case 6:
                    $user[$key]['role'] = 'Gudang Kuningan';
                    break;
                case 7:
                    $user[$key]['role'] = 'Gudang Jakarta';
                    break;
            }
        }
        $data = [
            'title' => 'Setting',
            'user' => $user
        ];
        return view('dashboard/setting/setting', $data);
    }

    public function add()
    {
        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $password = $this->request->getVar('password');
        $role = $this->request->getPost('role');

        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role
        ];
        if ($data) {
            $this->user->insert($data);
            return redirect()->to(base_url('dashboard/setting'))->with('success', 'Akun berhasil ditambahkan');
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->user->delete($id);
        return json_encode(['success' => true]);
    }
}
