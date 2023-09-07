<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;


class KaryawanAdvertiserController extends BaseController
{
    function __construct()
    {
        $this->karyawan = new \App\Models\Admin\UserModel();
    }

    public function index()
    {
        $karyawan = $this->karyawan->where('role', '5')->findAll();
        $data = [
            'title' => 'Karyawan Advertiser',
            'karyawan' => $karyawan
        ];
        return view('dashboard/karyawan-advertiser/karyawanadvertiser', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Karyawan Advertiser'
        ];
        return view('dashboard/karyawan-advertiser/tambahdatakaryawanadvertiser', $data);
    }

    public function add()
    {
        $nama = $this->request->getPost('nama');
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $role = '5';

        $password = password_hash($password, PASSWORD_DEFAULT);
        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ];

        $inputdata = $this->karyawan->insert($data);
        if ($inputdata) {
            session()->setFlashdata('success', 'Data Karyawan Advertiser berhasil ditambahkan!');
            return redirect()->to(base_url('dashboard/karyawan-advertiser/karyawan-advertiser'));
        } else {
            session()->setFlashdata('error', 'Data Karyawan Advertiser Gagal ditambahkan!');
            return redirect()->to(base_url('dashboard/karyawan-advertiser/karyawan-advertiser'));
        }
    }

    public function edit($id)
    {
        $karyawan = $this->karyawan->where('id', $id)->first();
        $data = [
            'title' => 'Karyawan Advertiser',
            'data' => $karyawan
        ];
        return view('dashboard/karyawan-advertiser/editdatakaryawanadvertiser', $data);
    }

    public function update()
    {
        // mendapatkan id dari url terakhir
        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $password = $this->request->getVar('password');

        $password = password_hash($password, PASSWORD_DEFAULT);
        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => $password,
            'role' => '5'
        ];

        $updatedata = $this->karyawan->update($id, $data);
        if ($updatedata) {
            session()->setFlashdata('success', 'Data Karyawan Advertiser berhasil diupdate!');
            return redirect()->to(base_url('dashboard/karyawan-advertiser/karyawan-advertiser'));
        } else {
            session()->setFlashdata('error', 'Data Karyawan Advertiser Gagal diupdate!');
            return redirect()->to(base_url('dashboard/karyawan-advertiser/karyawan-advertiser'));
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $delete = $this->karyawan->delete($id);
        if ($delete) {
            $data = ['success' => true, 'message' => 'Data Karyawan Advertiser berhasil dihapus!'];
            echo json_encode($data);
        } else {
            $data = ['error' => true, 'message' => 'Data Karyawan Advertiser gagal dihapus!'];
            echo json_encode($data);
        }
    }
}
