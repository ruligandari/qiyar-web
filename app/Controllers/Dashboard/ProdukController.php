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

    public  function edit($id)
    {
        $produk = $this->produk->find($id);
        $data = [
            'title' => 'Data Produk',
            'produk' => $produk,
        ];
        return view('dashboard/editdataproduk', $data);
    }

    public function update()
    {
        $id_produk = $this->request->getPost('id_produk');
        $nama_produk = $this->request->getPost('nama_produk');
        $stock = $this->request->getPost('stock');
        $harga = $this->request->getPost('harga');

        // convert 140,000 to 140000
        $harga = str_replace(',', '', $harga);

        $data = [
            'nama_produk' => $nama_produk,
            'stock' => $stock,
            'harga' => $harga,
        ];

        // update data
        $produk = $this->produk->update($id_produk, $data);
        if ($produk) {
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/data-produk');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/data-produk');
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $produk = $this->produk->delete($id);
        if ($produk) {
            $data = [
                'success' => true,
            ];
        } else {
            $data = [
                'success' => false,
            ];
        }
        echo json_encode($data);
    }
}
