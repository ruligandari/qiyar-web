<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class AdvertiserController extends BaseController
{
    function __construct()
    {
        $this->produk = new \App\Models\ProdukModel();
        $this->advertiser = new \App\Models\AdvertiserModel();
    }
    public function index()
    {
        $produk = $this->produk->findAll();
        $advertiser = $this->advertiser->findAll();
        $data = [
            'title' => 'Data Advertiser',
            'produk' => $produk ,
            'advertiser' => $advertiser
        ];
        return view('dashboard/dataadvertiser', $data);
    }
    public function tambahdata()
    {
        $produk = $this->produk->findAll();
        $data = [
            'title' => 'Data Advertiser',
            'produk' => $produk
        ];
        return view('dashboard/tambahdataadvertiser', $data);
    }
}
