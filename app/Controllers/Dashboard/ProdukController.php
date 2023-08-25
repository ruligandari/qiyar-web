<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class ProdukController extends BaseController
{
    function __construct()
    {
        $this->produk = new \App\Models\ProdukModel();
    }
    public function index()
    {
        $produk = $this->produk->findAll();
        $data = [
            'title' => 'Data Produk',
            'produk' => $produk,
        ];
        return view('dashboard/dataproduk', $data);
    }
    public function tambahdata()
    {
        $data = [
            'title' => 'Data Produk',
        ];
        return view('dashboard/tambahdataproduk', $data);
    }

    public function add()
    {
        $nama = $this->request->getPost('nama_produk');
        $stock = $this->request->getPost('stock');
        $harga = $this->request->getPost('harga');
        //    menambahkan validasi
        $validation =  \Config\Services::validation();
        $validate = $this->validate([
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi',
                ],
            ],
            'stock' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Stock harus diisi',
                ],
            ],
            'harga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga harus diisi',
                ],
            ],
        ]);

        // convert 140,000 to 140000
        $harga = str_replace(',', '', $harga);
        if (!$validate) {
            session()->setFlashdata('error', 'error nih');
            return redirect()->to('/dashboard/tambah-data-produk')->withInput();
        } else {
            $data = [
                'nama_produk' => $nama,
                'stock' => $stock,
                'harga' => $harga,
            ];
            $this->produk->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('/dashboard/tambah-data-produk');
        }
    }
}
