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
       
    }
}
