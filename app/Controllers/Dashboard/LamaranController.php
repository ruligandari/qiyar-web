<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class LamaranController extends BaseController
{
    function __construct()
    {
        $this->lamaran = new \App\Models\LamaranModel();
    }
    public function index()
    {
        $lamaran = $this->lamaran->findAll();
        $data = [
            'title' => 'Lamaran',
            'lamaran' => $lamaran
        ];
        return view('dashboard/datalamaran', $data);
    }

    public function tambahdata()
    {
        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $nomor = $this->request->getPost('nomor');
        $cv = $this->request->getFile('cv');

        //    menambahkan validasi
        $validation =  \Config\Services::validation();
        $validate = $this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email harus diisi'
                ]
            ],
            'nomor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor harus diisi'
                ]
            ],
            'cv' => [
                'rules' => 'uploaded[cv]|mime_in[cv,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                'errors' => [
                    'uploaded' => 'CV harus diisi',
                    'mime_in' => 'CV harus berformat pdf atau docx'
                ]
            ]
        ]);
        if (!$validate) {
            session()->setFlashdata('error', $validation->getErrors());
            return redirect()->to(base_url('lamaran'));
        }
        $cv->move('cv');

        $this->lamaran->insert([
            'nama_lengkap' => $nama,
            'email' => $email,
            'nomor' => $nomor,
            'cv' => $cv->getName()
        ]);

        session()->setFlashdata('success', 'Terimakasih ' . $nama . ', anda akan segera dihubungi oleh HRD kami');
        return redirect()->to(base_url('lamaran'));
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        // hapus data cv di folder
        $lamaran = $this->lamaran->find($id);
        if ($lamaran) {
            unlink('cv/' . $lamaran['cv']);
        }
        // hapus data di database
        $this->lamaran->delete($id);
        return json_encode(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
