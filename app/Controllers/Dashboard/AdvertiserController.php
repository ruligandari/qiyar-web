<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class AdvertiserController extends BaseController
{
    function __construct()
    {
        $this->produk = new \App\Models\ProdukModel();
        $this->pengeluaranadv = new \App\Models\PengeluaranadvertiserModel();
    }
    public function index()
    {
        $produk = $this->produk->findAll();
        $advertiser = $this->advertiser->findAll();
        $data = [
            'title' => 'Data Advertiser',
            'produk' => $produk,
            'advertiser' => $advertiser
        ];
        return view('dashboard/dataadvertiser', $data);
    }
    public function pengeluaranadv()
    {
        $pengeluaranadv = $this->pengeluaranadv->findAll();
        $data = [
            'title' => 'Pengeluaran Advertiser',
            'pengeluaranadv' => $pengeluaranadv
        ];
        return view('dashboard/pengeluaranadvertiser', $data);
    }
    public function pengeluaranadvertiser()
    {
        $advertiser = $this->advertiser->findAll();
        $data = [
            'title' => 'Pengeluaran Advertiser',
            'advertiser' => $advertiser
        ];
        return view('dashboard/pengeluaranadvertiser', $data);
    }
    public function tambahdatapengeluaranadv()
    {
        $pengeluaranadv = $this->pengeluaranadv->findAll();
        $data = [
            'title' => 'Data Advertiser',
            'pengeluaranadv' => $pengeluaranadv
        ];
        return view('dashboard/tambahdatapengeluaranadv', $data);
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
    public function add()
    {
        $tanggal = $this->request->getPost('tanggal');
        $waktu = $this->request->getPost('waktu');
        $nama_advertiser = $this->request->getPost('nama_advertiser');
        $banktujuan = $this->request->getPost('banktujuan');
        $jumlah = $this->request->getPost('jumlah');
        $keterangan = $this->request->getPost('keterangan');
        $total = $this->request->getPost('total');
        //    menambahkan validasi
        $validation =  \Config\Services::validation();
        $validate = $this->validate([
            'waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Waktu harus diisi',
                ],
            ],
            'nama_advertiser' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Advertiser harus diisi',
                ],
            ],
            'banktujuan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bank Tujuan harus diisi',
                ],
            ],
            'jumlah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jumlah harus diisi',
                ],
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'keterangan harus diisi',
                ],
            ],
            'total' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'total harus diisi',
                ],
            ],
        ]);

        // convert 140,000 to 140000
        $jumlah = str_replace(',', '', $jumlah);
        if (!$validate) {
            session()->setFlashdata('error', 'error nih');
            return redirect()->to('/dashboard/tambah-data-pengeluaran-advertiser')->withInput();
        } else {
            $data = [
                'tanggal' => $tanggal,
                'waktu' => $waktu,
                'nama_advertiser' => $nama_advertiser,
                'bank_tujuan' => $banktujuan,
                'jumlah' => $jumlah,
                'keterangan' => $keterangan,
                'total' => $total,
            ];
            $this->pengeluaranadv->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('/dashboard/tambah-data-pengeluaran-advertiser');
        }
    }

    public function filterTanggal()
    {
        $id = $this->request->getPost('tanggal');
    }
}
