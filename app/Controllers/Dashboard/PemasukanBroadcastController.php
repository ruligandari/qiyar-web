<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use DateTime;

class PemasukanBroadcastController extends BaseController
{
    function __construct()
    {
        $this->pemasukanbroadcast = new \App\Models\PemasukanBroadcastModel();
    }
    public function index()
    {
        $pemasukanbroadcast = $this->pemasukanbroadcast->findAll();
        $data = [
            'title' => 'Pemasukan Broadcast',
            'pemasukanbroadcast' => $pemasukanbroadcast
        ];
        return view('dashboard/pemasukan-broadcast/pemasukanbroadcast', $data);
    }

    public function tambahdatapemasukanbroadcast()
    {
        $pemasukanbroadcast = $this->pemasukanbroadcast->findAll();
        $data = [
            'title' => 'Pemasukan Broadcast',
            'pemasukanbroadcast' => $pemasukanbroadcast
        ];
        return view('dashboard/pemasukan-broadcast/tambahdatapemasukanbroadcast', $data);
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
        $bank_tujuan = $this->request->getPost('bank_tujuan');
        $penerima = $this->request->getPost('penerima');
        $jumlah = $this->request->getPost('jumlah');
        $upload_bukti = $this->request->getFile('upload_bukti');

        // convert 140,000 to 140000
        $jumlah = str_replace(',', '', $jumlah);

        $data = [
            'tanggal' => $tanggal,
            'waktu' => $waktu,
            'expedisi' => $expedisi,
            'bank_tujuan' => $bank_tujuan,
            'penerima' => $penerima,
            'jumlah' => $jumlah,
            'upload_bukti' => $upload_bukti->getName()
        ];
        $this->pemasukanbroadcast->insert($data);
        $upload_bukti->move('bukti_pemasukan_broadcast');
        session()->setFlashdata('success', 'Data berhasil ditambahkan');
        return redirect()->to('/dashboard/pemasukan-broadcast/');
    }

    public  function edit($id)
    {
        $pemasukanbroadcast = $this->pemasukanbroadcast->find($id);
        $data = [
            'title' => 'Pemasukan Broadcast',
            'data' => $pemasukanbroadcast,
        ];
        return view('dashboard/pemasukan-broadcast/editdatapemasukanbroadcast', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $expedisi = $this->request->getPost('expedisi');
        $jumlah = $this->request->getPost('jumlah');
        $penerima = $this->request->getPost('penerima');
        $bank_tujuan = $this->request->getPost('bank_tujuan');
        $upload_bukti = $this->request->getFile('upload_bukti');
        $bukti_transfer_lama = $this->request->getPost('bukti_transfer_lama');

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
            'upload_bukti' => ($upload_bukti->getName() != null) ? $upload_bukti->getName() : $bukti_transfer_lama,
        ];

        // hapus file lama
        if ($upload_bukti->getName() != null) {
            unlink('bukti_pemasukan_broadcast/' . $bukti_transfer_lama);
            // upload file baru
            $upload_bukti->move('bukti_pemasukan_broadcast');
        }


        // update data
        $pemasukanbroadcast = $this->pemasukanbroadcast->update($id, $data);
        if ($pemasukanbroadcast) {
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/pemasukan-broadcast');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/pemasukan-broadcast/edit/' . $id);
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $pemasukanbroadcast = $this->pemasukanbroadcast->delete($id);
        if ($pemasukanbroadcast) {
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
