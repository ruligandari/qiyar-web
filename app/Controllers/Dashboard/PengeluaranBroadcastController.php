<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use DateTime;
use \Hermawan\DataTables\DataTable;

class PengeluaranBroadcastController extends BaseController
{
    function __construct()
    {
        $this->pengeluaranbroadcast = new \App\Models\PengeluaranBroadcastModel();
    }
    public function index()
    {
        $pengeluaranbroadcast = $this->pengeluaranbroadcast->findAll();
        $data = [
            'title' => 'Pengeluaran Broadcast',
            'pengeluaranbroadcast' => $pengeluaranbroadcast
        ];
        return view('dashboard/pengeluaran-broadcast/pengeluaranbroadcast', $data);
    }
    public function tambahdatapengeluaranbroadcast()
    {
        $pengeluaranbroadcast = $this->pengeluaranbroadcast->findAll();
        $data = [
            'title' => 'Pengeluaran Broadcast',
            'pengeluaranbroadcast' => $pengeluaranbroadcast
        ];
        return view('dashboard/pengeluaran-broadcast/tambahdatapengeluaranbroadcast', $data);
    }
    public function add()
    {
        $tanggal = $this->request->getPost('tanggal');
        $waktu = $this->request->getPost('waktu');
        $jenis_pengeluaran = $this->request->getPost('jenis_pengeluaran');
        $bank_tujuan = $this->request->getPost('bank_tujuan');
        $nama_penerima = $this->request->getPost('nama_penerima');
        $upload_bukti = $this->request->getFile('upload_bukti');
        $jumlah = $this->request->getPost('jumlah');

        if ($upload_bukti) {
            // generate nama file random
            $nama_file = $upload_bukti->getRandomName();
            // pindahkan file ke folder public/img
            $upload_bukti->move('bukti_pengeluaran_broadcast', $nama_file);
        } else {
            return redirect()->to('/dashboard/broadcast/pengeluaran-broadcast')->with('error', 'Upload bukti transfer gagal');
        }

        $jumlah = str_replace(',', '', $jumlah);
        $data = [
            'tanggal' => $tanggal,
            'waktu' => $waktu,
            'jenis_pengeluaran' => $jenis_pengeluaran,
            'bank_tujuan' => $bank_tujuan,
            'nama_penerima' => $nama_penerima,
            'upload_bukti' => $nama_file,
            'jumlah' => $jumlah
        ];
        $this->pengeluaranbroadcast->insert($data);
        session()->setFlashdata('success', 'Data berhasil ditambahkan');
        return json_encode(['status' => true, 'message' => 'Data berhasil ditambahkan!']);
    }
    public  function edit($id)
    {
        $pengeluaranbroadcast = $this->pengeluaranbroadcast->find($id);
        $data = [
            'title' => 'Pengeluaran Broadcast',
            'data' => $pengeluaranbroadcast,
        ];
        return view('dashboard/pengeluaran-broadcast/editdatapengeluaranbroadcast', $data);
    }
    public function update()
    {
        $id = $this->request->getPost('id');
        $jenis_pengeluaran = $this->request->getPost('jenis_pengeluaran');
        $bank_tujuan = $this->request->getPost('bank_tujuan');
        $nama_penerima = $this->request->getPost('nama_penerima');
        $upload_bukti = $this->request->getFile('upload_bukti');
        $jumlah = $this->request->getPost('jumlah');
        $bukti_transfer_lama = $this->request->getPost('bukti_transfer_lama');

        if ($upload_bukti) {
            $file_name = $upload_bukti->getRandomName();
            // move file
            $upload_bukti->move('bukti_pengeluaran_broadcast', $file_name);
            unlink('bukti_pengeluaran_broadcast/' . $bukti_transfer_lama);
        } else {
            $file_name = $bukti_transfer_lama;
        }

        // convert 140,000 or 140.000 to 140000
        if (strpos($jumlah, ',') !== false) {
            $jumlah = str_replace(',', '', $jumlah);
        } else if (strpos($jumlah, '.') !== false) {
            $jumlah = str_replace('.', '', $jumlah);
        }

        $data = [
            'jenis_pengeluaran' => $jenis_pengeluaran,
            'bank_tujuan' => $bank_tujuan,
            'nama_penerima' => $nama_penerima,
            'upload_bukti' => $file_name,
            'jumlah' => $jumlah,
        ];

        // update data
        $pengeluaranbroadcast = $this->pengeluaranbroadcast->update($id, $data);
        if ($pengeluaranbroadcast) {
            if ($upload_bukti) {
                return json_encode(['status' => true, 'message' => 'Data berhasil diupdate!']);
            }
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/broadcast/pengeluaran-broadcast');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/broadcast/pengeluaran-broadcast');
        }
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $pengeluaranbroadcast = $this->pengeluaranbroadcast->delete($id);
        if ($pengeluaranbroadcast) {
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

    public function listPengeluaranBc()
    {
        $db = db_connect();
        $builder = $db->table('pengeluaran_broadcast')->select('id, tanggal, waktu, jenis_pengeluaran, bank_tujuan, nama_penerima, jumlah, upload_bukti');
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
            return '<a class="btn btn-success" title="Edit Bray" href="' . base_url('dashboard/broadcast/pengeluaran-broadcast/edit/') . $row->id . '" role="button"><i class="fas fa-sm fa-pen"></i></a>
            <button class="btn btn-danger delete-pengeluaran" title="Hapus Bray" onclick="deleteRecord(' . $row->id . ')" role="button"><i class="fas fa-sm fa-trash"></i></button>';
        }, 'last')->format('jumlah', function ($value) {
            return number_format($value, 0, ',', '.');
        })->format('upload_bukti', function ($value) {
            return '<a href="' . base_url('bukti_pengeluaran_broadcast/') . $value . '" target="_blank">
            <img src="' . base_url('bukti_pengeluaran_broadcast/') . $value . '" alt="" style="height:50px; width:50px"></a>';
        })->toJson(true);
    }
}
