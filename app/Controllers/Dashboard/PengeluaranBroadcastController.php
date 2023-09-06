<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use DateTime;

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

        $jumlah = str_replace(',', '', $jumlah);
        $data = [
            'tanggal' => $tanggal,
            'waktu' => $waktu,
            'jenis_pengeluaran' => $jenis_pengeluaran,
            'bank_tujuan' => $bank_tujuan,
            'nama_penerima' => $nama_penerima,
            'upload_bukti' => $upload_bukti->getName(),
            'jumlah' => $jumlah
        ];
        $this->pengeluaranbroadcast->insert($data);
        $upload_bukti->move('bukti_pengeluaran_broadcast');
        session()->setFlashdata('success', 'Data berhasil ditambahkan');
        return redirect()->to('/dashboard/pengeluaran-broadcast');
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
            'upload_bukti' => ($upload_bukti->getName() != null) ? $upload_bukti->getName() : $bukti_transfer_lama,
            'jumlah' => $jumlah,
        ];

        // hapus file lama
        if ($upload_bukti->getName() != null) {
            unlink('bukti_pengeluaran_broadcast/' . $bukti_transfer_lama);
            // upload file baru
            $upload_bukti->move('bukti_pengeluaran_broadcast');
        }


        // update data
        $pengeluaranbroadcast = $this->pengeluaranbroadcast->update($id, $data);
        if ($pengeluaranbroadcast) {
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/pengeluaran-broadcast');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/pengeluaran-broadcast');
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
}
