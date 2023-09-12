<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use DateTime;
use \Hermawan\DataTables\DataTable;

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
        return view('dashboard/pemasukan-advertiser/pemasukanadvertiser', $data);
    }

    public function tambahdatapemasukanadv()
    {
        $pemasukanadv = $this->pemasukanadv->findAll();
        $data = [
            'title' => 'Pemasukan Advertiser',
            'pemasukanadv' => $pemasukanadv
        ];
        return view('dashboard/pemasukan-advertiser/tambahdatapemasukanadv', $data);
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
        return redirect()->to('/dashboard/advertiser/tambah-data-pemasukan-advertiser');
    }

    public  function edit($id)
    {
        $pemasukanadv = $this->pemasukanadv->find($id);
        $data = [
            'title' => 'Pemasukan Advertiser',
            'data' => $pemasukanadv,
        ];
        return view('dashboard/pemasukan-advertiser/editdatapemasukanadv', $data);
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
            unlink('bukti_pemasukan_advertiser/' . $bukti_transfer_lama);
            // upload file baru
            $upload_bukti->move('bukti_pemasukan_advertiser');
        }


        // update data
        $pengeluaranadv = $this->pemasukanadv->update($id, $data);
        if ($pengeluaranadv) {
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/advertiser/pemasukan-advertiser/pemasukan-advertiser');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/advertiser/pemasukan-advertiser/pemasukan-advertiser');
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

    public function listPemasukanAdv()
    {
        $db = db_connect();
        $builder = $db->table('pemasukan_advertiser')->select('id, tanggal, waktu, expedisi, bank_tujuan, penerima, jumlah, upload_bukti');
        return DataTable::of($builder)->addNumbering('no')->filter(function ($builder, $request) {
            // cek data diterima atau tidak
            if ($request->dates) {
                // ambil rentang tanggal 09/01/2023 - 09/01/2023
                $dates = explode(' - ', $request->dates);
                $min = DateTime::createFromFormat('m/d/Y', $dates[0])->format('Y-m-d');
                $max = DateTime::createFromFormat('m/d/Y', $dates[1])->format('Y-m-d');
                $builder->where('tanggal >=', $min)->where('tanggal <=', $max);
            }
        })->add('action', function ($row) {
            return '<a class="btn btn-success" title="Edit Bray" href="' . base_url('dashboard/advertiser/pemasukan-advertiser/edit/') . $row->id . '" role="button"><i class="fas fa-sm fa-pen"></i></a>
            <button class="btn btn-danger delete-pengeluaran" title="Hapus Bray" onclick="deleteRecord(' . $row->id . ')" role="button"><i class="fas fa-sm fa-trash"></i></button>';
        }, 'last')->format('jumlah', function ($value) {
            return number_format($value, 0, ',', '.');
        })->format('upload_bukti', function ($value) {
            return '<a href="' . base_url('bukti_pemasukan_advertiser/') . $value . '" target="_blank">
            <img src="' . base_url('bukti_pemasukan_advertiser/') . $value . '" alt="" style="height:50px; width:50px"></a>';
        })->toJson(true);
    }
}
