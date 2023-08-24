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
            'produk' => $produk ,
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
}
