<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use DateTime;
use \Hermawan\DataTables\DataTable;

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

        if ($upload_bukti) {
            $file_name = $upload_bukti->getRandomName();
            // move file
            $upload_bukti->move('bukti_pemasukan_broadcast', $file_name);
        } else {
            return redirect()->to('/dashboard/broadcast/pemasukan-broadcast/tambah')->with('error', 'Upload bukti gagal');
        }

        // convert 140,000 to 140000
        $jumlah = str_replace(',', '', $jumlah);

        $data = [
            'tanggal' => $tanggal,
            'waktu' => $waktu,
            'expedisi' => $expedisi,
            'bank_tujuan' => $bank_tujuan,
            'penerima' => $penerima,
            'jumlah' => $jumlah,
            'upload_bukti' => $file_name
        ];
        $this->pemasukanbroadcast->insert($data);
        return json_encode(['status' => true, 'message' => 'Data berhasil ditambahkan!']);
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

        if ($upload_bukti) {
            $file_name = $upload_bukti->getRandomName();
            // move file
            $upload_bukti->move('bukti_pemasukan_broadcast', $file_name);
        } else {
            $file_name = $bukti_transfer_lama;
        }

        $data = [
            'expedisi' => $expedisi,
            'jumlah' => $jumlah,
            'penerima' => $penerima,
            'bank_tujuan' => $bank_tujuan,
            'upload_bukti' => $file_name,
        ];

        // update data
        $pemasukanbroadcast = $this->pemasukanbroadcast->update($id, $data);
        if ($pemasukanbroadcast) {
            if ($upload_bukti) {
                return json_encode(['status' => true, 'message' => 'Data berhasil diupdate!']);
            }
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/broadcast/pemasukan-broadcast');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/broadcast/pemasukan-broadcast/edit/' . $id);
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

    public function listPemasukanBc()
    {
        $db = db_connect();
        $builder = $db->table('pemasukan_broadcast')->select('id, tanggal, waktu, expedisi, bank_tujuan, penerima, jumlah, upload_bukti');
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
            return '<a class="btn btn-success" title="Edit Bray" href="' . base_url('dashboard/broadcast/pemasukan-broadcast/edit/') . $row->id . '" role="button"><i class="fas fa-sm fa-pen"></i></a>
            <button class="btn btn-danger delete-pengeluaran" title="Hapus Bray" onclick="deleteRecord(' . $row->id . ')" role="button"><i class="fas fa-sm fa-trash"></i></button>';
        }, 'last')->format('jumlah', function ($value) {
            return number_format($value, 0, ',', '.');
        })->format('upload_bukti', function ($value) {
            return '<a href="' . base_url('bukti_pemasukan_broadcast/') . $value . '" target="_blank">
            <img src="' . base_url('bukti_pemasukan_broadcast/') . $value . '" alt="" style="height:50px; width:50px"></a>';
        })->toJson(true);
    }
}
