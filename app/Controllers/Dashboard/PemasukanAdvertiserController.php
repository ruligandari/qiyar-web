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
            'title' => 'Pemasukan Advertiser',
            'data' => $pemasukanadv,
        ];
        return view('dashboard/editdatapemasukanadv', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $expedisi = $this->request->getPost('expedisi');
        $jumlah = $this->request->getPost('jumlah');
        $penerima = $this->request->getPost('penerima');
        $bank_tujuan = $this->request->getPost('bank_tujuan');
        $upload_bukti = $this->request->getFile('upload_bukti');

        // convert 140,000 or 140.000 to 140000
        if (strpos($jumlah, ',') !== false) {
            $jumlah = str_replace(',', '', $jumlah);
        } else if (strpos($jumlah, '.') !== false) {
            $jumlah = str_replace('.', '', $jumlah);
        }

        $data = [
            'expedisi' => $expedisi,
            'jumlah' => $jumlah,
            'penerima' => $penerima,
            'bank_tujuan' => $bank_tujuan,
            'upload_bukti' => $upload_bukti->getName()
        ];

        // hapus file lama
        $pemasukanadv = $this->pemasukanadv->find($id);
        if ($pemasukanadv['upload_bukti'] != "") {
            unlink('bukti_pemasukan_advertiser/' . $pemasukanadv['upload_bukti']);
        }
        // upload file baru
        $upload_bukti->move('bukti_pemasukan_advertiser');


        // update data
        $pengeluaranadv = $this->pemasukanadv->update($id, $data);
        if ($pengeluaranadv) {
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/pemasukan-advertiser');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/pemasukan-advertiser');
        }
    }

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
}
