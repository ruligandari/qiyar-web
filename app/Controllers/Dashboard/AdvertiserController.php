<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use DateTime;

class AdvertiserController extends BaseController
{
    function __construct()
    {
        $this->produk = new \App\Models\ProdukModel();
        $this->advertiser = new \App\Models\AdvertiserModel();
        $this->pengeluaranadv = new \App\Models\PengeluaranadvertiserModel();
    }
    public function index()
    {
        if (session()->get('role') == 1) {

            $advertiser = $this->advertiser->findAll();
        } else {
            $advertiser = $this->advertiser->where('nama_advertiser', session()->get('nama'))->findAll();
        }
        $data = [
            'title' => 'Data Advertiser',
            'advertiser' => $advertiser
        ];
        return view('dashboard/dataadvertiser', $data);
    }
    public function pengeluaranadv()
    {
        $pengeluaranadv = $this->pengeluaranadv->findAll();
        $getTotal = $this->pengeluaranadv->getTotal();
        $data = [
            'title' => 'Pengeluaran Advertiser',
            'pengeluaranadv' => $pengeluaranadv,
            'total' => $getTotal
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
            'title' => 'Pengeluaran Advertiser',
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
        $nama_advertiser = $this->request->getPost('nama_advertiser');
        $total_harga = $this->request->getPost('total_harga');
        //    menambahkan validasi  
        $validation =  \Config\Services::validation();
        $validate = $this->validate([
            'nama_advertiser' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Advertiser harus diisi',
                ],
            ],
            'total_harga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'total harga harus diisi',
                ],
            ],

        ]);
        // convert 140,000 to 140000
        $total_harga = str_replace(',', '', $total_harga);
        if (!$validate) {
            session()->setFlashdata('error', 'error nih');
            return redirect()->to('/dashboard/tambah-data-advertiser')->withInput();
        } else {
            $data = [
                'tanggal_pembelian' => $tanggal,
                'nama_advertiser' => $nama_advertiser,
                'total_harga' => $total_harga,
            ];
            $this->advertiser->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('/dashboard/data-advertiser');
        }
    }

    public  function edit($id)
    {
        $advertiser = $this->advertiser->find($id);
        $data = [
            'title' => 'Data Advertiser',
            'data' => $advertiser,
        ];
        return view('dashboard/editdataadvertiser', $data);
    }

    public function update()
    {
        $id_advertiser = $this->request->getPost('id_advertiser');
        $tanggal = $this->request->getPost('tanggal');
        $nama_advertiser = $this->request->getPost('nama_advertiser');
        $total_harga = $this->request->getPost('total_harga');

        // convert 140,000 to 140000
        $total_harga = str_replace(',', '', $total_harga);


        $data = [
            'tanggal_pembelian' => $tanggal,
            'nama_advertiser' => $nama_advertiser,
            'total_harga' => $total_harga,
        ];

        // update data
        $advertiser = $this->advertiser->update($id_advertiser, $data);
        if ($advertiser) {
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/data-advertiser');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/data-advertiser/edit/' . $id_advertiser);
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $advertiser = $this->advertiser->delete($id);
        if ($advertiser) {
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
    public function addpengeluaranadv()
    {
        $tanggal = $this->request->getPost('tanggal');
        $waktu = $this->request->getPost('waktu');
        $nama_advertiser = $this->request->getPost('nama_advertiser');
        $banktujuan = $this->request->getPost('banktujuan');
        $jumlah = $this->request->getPost('jumlah');
        $keterangan = $this->request->getPost('keterangan');
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
            ];
            $this->pengeluaranadv->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('/dashboard/tambah-data-pengeluaran-advertiser');
        }
    }
    public  function editpengeluaran($id)
    {
        $pengeluaranadv = $this->pengeluaranadv->find($id);
        $data = [
            'title' => 'Pengeluaran Advertiser',
            'data' => $pengeluaranadv,
        ];
        return view('dashboard/editdatapengeluaranadv', $data);
    }

    public function updatepengeluaran()
    {
        $id_pengeluaran = $this->request->getPost('id_pengeluaran');
        $nama_advertiser = $this->request->getPost('nama_advertiser');
        $jumlah = $this->request->getPost('jumlah');
        $keterangan = $this->request->getPost('keterangan');
        $bank_tujuan = $this->request->getPost('bank_tujuan');

        // convert 140,000 to 140000
        $jumlah = str_replace(',', '', $jumlah);


        $data = [
            'nama_advertiser' => $nama_advertiser,
            'jumlah' => $jumlah,
            'keterangan' => $keterangan,
            'bank_tujuan' => $bank_tujuan,
        ];

        // update data
        $pengeluaranadv = $this->pengeluaranadv->update($id_pengeluaran, $data);
        if ($pengeluaranadv) {
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/pengeluaran-advertiser');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/pengeluaran-advertiser');
        }
    }

    public function deletepengeluaran()
    {
        $id = $this->request->getPost('id');
        $pengeluaranadv = $this->pengeluaranadv->delete($id);
        if ($pengeluaranadv) {
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

    // public function generateReport()
    // {
    //     $min = $this->request->getVar('min');
    //     $max = $this->request->getVar('max');

    //     // mengubah data ke format tanggal Tue Aug 01 2023 07:00:00 GMT+0700 (Indochina Time) ke 2023-08-01
    //     $min = substr($min, 0, 33);
    //     $max = substr($max, 0, 33);
    //     $date_awal = new DateTime($min);
    //     $date_akhir = new DateTime($max);
    //     $min = $date_awal->format('Y-m-d');
    //     $max = $date_akhir->format('Y-m-d');

    //     dd($min, $max);

    //     if ($min && $max == null) {
    //         $pengeluaranadv = $this->pengeluaranadv->findAll();
    //         dd($pengeluaranadv);
    //     }

    //     $pengeluaranadv = $this->pengeluaranadv->where('tanggal >=', $min)->where('tanggal <=', $max)->findAll();
    //     $data = [
    //         'title' => 'Pengeluaran Advertiser',
    //         'pengeluaranadv' => $pengeluaranadv
    //     ];
    //     dd($data);
    //     return view('dashboard/pengeluaranadvertiser', $data);
    // }
}
