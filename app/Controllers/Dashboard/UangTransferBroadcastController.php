<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use DateTime;
use \Hermawan\DataTables\DataTable;

class UangTransferBroadcastController extends BaseController
{
    function __construct()
    {
        $this->uangtransferbroadcast = new \App\Models\BroadcastModel();
    }

    public function index()
    {
        $uangtransferbroadcast = $this->uangtransferbroadcast->findAll();
        $data = [
            'title' => 'Uang Transfer Broadcast',
            'uangtransferbroadcast' => $uangtransferbroadcast
        ];
        return view('dashboard/uang-transfer-broadcast/uangtransferbroadcast', $data);
    }
    public function tambahdatauangtransferbc()
    {
        $uangtransferbroadcast = $this->uangtransferbroadcast->findAll();
        $data = [
            'title' => 'Uang Transfer Broadcast',
            'uangtransferbroadcast' => $uangtransferbroadcast
        ];
        return view('dashboard/uang-transfer-broadcast/tambahdatauangtransferbc', $data);
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
        $nama_konsumen = $this->request->getPost('nama_konsumen');
        $bank_penerima = $this->request->getPost('bank_penerima');
        $jenis_transfer = $this->request->getPost('jenis_transfer');
        $harga_total = $this->request->getPost('harga_total');
        $upload_bukti = $this->request->getFile('upload_bukti');

        // convert 140,000 to 140000
        $harga_total = str_replace(',', '', $harga_total);
        $data = [
            'tanggal' => $tanggal,
            'nama_konsumen' => $nama_konsumen,
            'bank_penerima' => $bank_penerima,
            'jenis_transfer' => $jenis_transfer,
            'harga_total' => $harga_total,
            'upload_bukti' => $upload_bukti->getName()
        ];
        $this->uangtransferbroadcast->insert($data);
        $upload_bukti->move('bukti_pemasukan_broadcast');
        session()->setFlashdata('success', 'Data berhasil ditambahkan');
        return redirect()->to('/dashboard/broadcast/uang-transfer-broadcast');
    }

    public  function edit($id)
    {
        $uangtransferbroadcast = $this->uangtransferbroadcast->find($id);
        $data = [
            'title' => 'Uang Transfer Broadcast',
            'data' => $uangtransferbroadcast,
        ];
        return view('dashboard/uang-transfer-broadcast/editdatauangtransferbroadcast', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $nama_konsumen = $this->request->getPost('nama_konsumen');
        $bank_penerima = $this->request->getPost('bank_penerima');
        $jenis_transfer = $this->request->getPost('jenis_transfer');
        $harga_total = $this->request->getPost('harga_total');
        $upload_bukti = $this->request->getFile('upload_bukti');
        $bukti_transfer_lama = $this->request->getPost('bukti_transfer_lama');

        // convert 140,000 or 140.000 to 140000
        if (strpos($harga_total, ',') !== false) {
            $harga_total = str_replace(',', '', $harga_total);
        } else if (strpos($harga_total, '.') !== false) {
            $harga_total = str_replace('.', '', $harga_total);
        }

        $data = [
            'nama_konsumen' => $nama_konsumen,
            'bank_penerima' => $bank_penerima,
            'jenis_transfer' => $jenis_transfer,
            'harga_total' => $harga_total,
            'upload_bukti' => ($upload_bukti->getName() != null) ? $upload_bukti->getName() : $bukti_transfer_lama,
        ];

        // hapus file lama
        if ($upload_bukti->getName() != null) {
            unlink('bukti_pemasukan_broadcast/' . $bukti_transfer_lama);
            // upload file baru
            $upload_bukti->move('bukti_pemasukan_broadcast');
        }


        // update data
        $uangtransferbroadcast = $this->uangtransferbroadcast->update($id, $data);
        if ($uangtransferbroadcast) {
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/broadcast/pemasukan-broadcast');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/broadcast/pemasukan-broadcast');
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $uangtransferbroadcast = $this->pemasukanbroadcast->delete($id);
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

    public function uangtransferadvertiser()
    {
        $uangtransferbroadcast = $this->uangtransferbroadcast->WHERE('jenis_transfer', 'Iklan')->get()->getResultArray();
        $data = [
            'title' => 'Uang Transfer',
            'uangtransferbroadcast' => $uangtransferbroadcast
        ];
        return view('dashboard/uang-transfer-advertiser/uang-transfer-advertiser', $data);
    }

    public function listUangTransferAdv()
    {
        $db = db_connect();
        $builder = $db->table('uang_transfer_broadcast')->where('jenis_transfer', 'Iklan')->select('id, tanggal, nama_konsumen, bank_penerima, jenis_transfer, harga_total, upload_bukti');
        return DataTable::of($builder)->addNumbering('no')->filter(function ($builder, $request) {
            // cek data diterima atau tidak
            if ($request->dates) {
                // ambil rentang tanggal 09/01/2023 - 09/01/2023
                $dates = explode(' - ', $request->dates);
                $min = DateTime::createFromFormat('m/d/Y', $dates[0])->format('Y-m-d');
                $max = DateTime::createFromFormat('m/d/Y', $dates[1])->format('Y-m-d');
                $builder->where('tanggal >=', $min)->where('tanggal <=', $max);
            }
        })->format('harga_total', function ($value) {
            return number_format($value, 0, ',', '.');
        })->format('upload_bukti', function ($value) {
            return '<a href="' . base_url('bukti_pemasukan_broadcast/') . $value . '" target="_blank">
            <img src="' . base_url('bukti_pemasukan_broadcast/') . $value . '" alt="" style="height:50px; width:50px"></a>';
        })->toJson(true);
    }

    public function listUangTransferBc()
    {
        $db = db_connect();
        $builder = $db->table('uang_transfer_broadcast')->select('id, tanggal, nama_konsumen, bank_penerima, jenis_transfer, harga_total, upload_bukti');
        return DataTable::of($builder)->addNumbering('no')->filter(function ($builder, $request) {
            // cek data diterima atau tidak
            if ($request->dates) {
                // ambil rentang tanggal 09/01/2023 - 09/01/2023
                $dates = explode(' - ', $request->dates);
                $min = DateTime::createFromFormat('m/d/Y', $dates[0])->format('Y-m-d');
                $max = DateTime::createFromFormat('m/d/Y', $dates[1])->format('Y-m-d');
                $builder->where('tanggal >=', $min)->where('tanggal <=', $max);
            }
        })->format('harga_total', function ($value) {
            return number_format($value, 0, ',', '.');
        })->add('action', function ($row) {
            return '<a class="btn btn-success" title="Edit Bray" href="' . base_url('dashboard/broadcast/uang-transfer-broadcast/edit/') . $row->id . '" role="button"><i class="fas fa-sm fa-pen"></i></a>
            <button class="btn btn-danger delete-pengeluaran" title="Hapus Bray" onclick="deleteRecord(' . $row->id . ')" role="button"><i class="fas fa-sm fa-trash"></i></button>';
        }, 'last')->format('upload_bukti', function ($value) {
            return '<a href="' . base_url('bukti_pemasukan_broadcast/') . $value . '" target="_blank">
            <img src="' . base_url('bukti_pemasukan_broadcast/') . $value . '" alt="" style="height:50px; width:50px"></a>';
        })->toJson(true);
    }
}
