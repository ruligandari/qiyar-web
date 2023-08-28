<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use DateTime;

class PemasukanAdvertiserController extends BaseController
{
    function __construct()
    {
        $this->pemasukanadv = new \App\Models\PemasukanAdvertiserModel();
    }

    public function index()
    {
        $pemasukanadv = $this->pemasukanadv->findAll();
        $data = [
            'title' => 'Pemasukan Advertiser',
            'pemasukanadv' => $pemasukanadv
        ];
        return view('dashboard/pemasukanadvertiser', $data);
    }

    public function tambahdatapemasukanadv()
    {
        $pemasukanadv = $this->pemasukanadv->findAll();
        $data = [
            'title' => 'Pemasukan Advertiser',
            'pemasukanadv' => $pemasukanadv
        ];
        return view('dashboard/tambahdatapemasukanadv', $data);
    }
    // public function pengeluaranadvertiser()
    // {
    //     $advertiser = $this->advertiser->findAll();
    //     $data = [
    //         'title' => 'Pengeluaran Advertiser',
    //         'advertiser' => $advertiser
    //     ];
    //     return view('dashboard/pengeluaranadvertiser', $data);
    // }
    // public function tambahdatapengeluaranadv()
    // {
    //     $pengeluaranadv = $this->pengeluaranadv->findAll();
    //     $data = [
    //         'title' => 'Pengeluaran Advertiser',
    //         'pengeluaranadv' => $pengeluaranadv
    //     ];
    //     return view('dashboard/tambahdatapengeluaranadv', $data);
    // }
    // public function tambahdata()
    // {
    //     $produk = $this->produk->findAll();
    //     $data = [
    //         'title' => 'Data Advertiser',
    //         'produk' => $produk
    //     ];
    //     return view('dashboard/tambahdataadvertiser', $data);
    // }
    public function add()
    {
        $tanggal = $this->request->getPost('tanggal');
        $waktu = $this->request->getPost('waktu');
        $expedisi = $this->request->getPost('expedisi');
        $banktujuan = $this->request->getPost('banktujuan');
        $penerima = $this->request->getPost('penerima');
        $jumlah = $this->request->getPost('jumlah');
        $upload_bukti = $this->request->getFile('upload_bukti');

        // convert 140,000 to 140000
        $jumlah = str_replace(',', '', $jumlah);

        $data = [
            'tanggal' => $tanggal,
            'waktu' => $waktu,
            'expedisi' => $expedisi,
            'bank_tujuan' => $banktujuan,
            'penerima' => $penerima,
            'jumlah' => $jumlah,
            'upload_bukti' => $upload_bukti->getName()
        ];
        $this->pemasukanadv->insert($data);
        $upload_bukti->move('bukti_pemasukan_advertiser');
        session()->setFlashdata('success', 'Data berhasil ditambahkan');
        return redirect()->to('/dashboard/tambah-data-pemasukan-advertiser');
    }

    public  function edit($id)
    {
        $pemasukanadv = $this->pemasukanadv->find($id);
        $data = [
            'title' => 'Pengeluaran Advertiser',
            'data' => $pemasukanadv,
        ];
        return view('dashboard/editdatapeadv', $data);
    }

    // public function update()
    // {
    //     $id_pengeluaran = $this->request->getPost('id_pengeluaran');
    //     $nama_advertiser = $this->request->getPost('nama_advertiser');
    //     $jumlah = $this->request->getPost('jumlah');
    //     $keterangan = $this->request->getPost('keterangan');
    //     $bank_tujuan = $this->request->getPost('bank_tujuan');

    //     // convert 140,000 to 140000
    //     $jumlah = str_replace(',', '', $jumlah);


    //     $data = [
    //         'nama_advertiser' => $nama_advertiser,
    //         'jumlah' => $jumlah,
    //         'keterangan' => $keterangan,
    //         'bank_tujuan' => $bank_tujuan,
    //     ];

    //     // update data
    //     $pengeluaranadv = $this->pengeluaranadv->update($id_pengeluaran, $data);
    //     if ($pengeluaranadv) {
    //         session()->setFlashdata('success', 'Data berhasil diupdate');
    //         return redirect()->to('/dashboard/pengeluaran-advertiser');
    //     } else {
    //         session()->setFlashdata('error', 'Data gagal diupdate');
    //         return redirect()->to('/dashboard/pengeluaran-advertiser');
    //     }
    // }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $pemasukanadv = $this->pemasukanadv->delete($id);
        if ($pemasukanadv) {
            $data = [
                'success' => true,
                'msg' => 'Data berhasil dihapus nih!'
            ];
        } else {
            $data = [
                'success' => false,
                'msg' => 'Data Gagal dihapus nih!'
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
