<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use DateTime;
use \Hermawan\DataTables\DataTable;

class PengeluaranKantorController extends BaseController
{
    function __construct()
    {
        $this->pengeluarankantor = new \App\Models\PengeluaranKantorModel();
    }
    public function index()
    {
        $pengeluarankantor = $this->pengeluarankantor->findAll();
        $data = [
            'title' => 'Pengeluaran Kantor',
            'pengeluarankantor' => $pengeluarankantor
        ];
        return view('dashboard/pengeluaran-kantor/pengeluarankantor', $data);
    }
    public function tambahdatapengeluarankantor()
    {
        $pengeluarankantor = $this->pengeluarankantor->findAll();
        $data = [
            'title' => 'Pengeluaran Kantor',
            'pengeluarankantor' => $pengeluarankantor
        ];
        return view('dashboard/pengeluaran-kantor/tambahdatapengeluarankantor', $data);
    }
    public function add()
    {
        $tanggal = $this->request->getPost('tanggal');
        $waktu = $this->request->getPost('waktu');
        $jenispengeluaran = $this->request->getPost('jenis_pengeluaran');
        $keterangan = $this->request->getPost('keterangan');
        $banktujuan = $this->request->getPost('banktujuan');
        $penerima = $this->request->getPost('penerima');
        $jumlah = $this->request->getPost('jumlah');
        $upload_bukti = $this->request->getFile('upload_bukti');

        if ($upload_bukti) {
            $file_name = $upload_bukti->getRandomName();
            $upload_bukti->move('bukti_pengeluaran_kantor', $file_name);
        } else {
            return redirect()->to('/dashboard/advertiser/tambah-data-pengeluaran-kantor')->withInput()->with('error', 'Upload Bukti harus diisi.');
        }


        // Jika validasi berhasil
        $jumlah = str_replace(',', '', $jumlah);
        $data = [
            'tanggal' => $tanggal,
            'waktu' => $waktu,
            'bank_tujuan' => $banktujuan,
            'nama_penerima' => $penerima,
            'jenis_pengeluaran' => $jenispengeluaran,
            'keterangan' => $keterangan,
            'jumlah' => $jumlah,
            'bukti_transfer' => $file_name
        ];

        $this->pengeluarankantor->insert($data);
        return json_encode(['status' => true, 'message' => 'Data Pengeluaran berhasil ditambahkan']);
    }

    public  function edit($id)
    {
        $pengeluarankantor = $this->pengeluarankantor->find($id);
        $data = [
            'title' => 'Pengeluaran Kantor',
            'data' => $pengeluarankantor,
        ];
        return view('dashboard/pengeluaran-kantor/editdatapengeluarankantor', $data);
    }

    public function update()
    {
        $id_pengeluaran = $this->request->getPost('id_pengeluaran_kantor');
        $jenis_pengeluaran = $this->request->getPost('jenis_pengeluaran');
        $bank_tujuan = $this->request->getPost('bank_tujuan');
        $jumlah = $this->request->getPost('jumlah');
        $keterangan = $this->request->getPost('keterangan');
        $nama_penerima = $this->request->getPost('nama_penerima');
        $bukti_transfer = $this->request->getFile('upload_bukti');
        $bukti_transfer_lama = $this->request->getPost('bukti_transfer_lama');

        // convert 140,000 or 140.000 to 140000
        if (strpos($jumlah, ',') !== false) {
            $jumlah = str_replace(',', '', $jumlah);
        } else if (strpos($jumlah, '.') !== false) {
            $jumlah = str_replace('.', '', $jumlah);
        }

        if ($bukti_transfer) {
            $file_name = $bukti_transfer->getRandomName();
            // hapus file lama
            // cek apakah file ada
            if (file_exists('bukti_pengeluaran_kantor/' . $bukti_transfer_lama)) {
                unlink('bukti_pengeluaran_kantor/' . $bukti_transfer_lama);
            } else {
                session()->setFlashdata('error', 'File tidak ditemukan');
                return redirect()->to('/dashboard/advertiser/pengeluaran-kantor/edit/' . $id_pengeluaran)->withInput();
            }
            $bukti_transfer->move('bukti_pengeluaran_kantor', $file_name);
        } else {
            $file_name = $bukti_transfer_lama;
        }

        $data = [
            'jumlah' => $jumlah,
            'nama_penerima' => $nama_penerima,
            'bank_tujuan' => $bank_tujuan,
            'jenis_pengeluaran' => $jenis_pengeluaran,
            'keterangan' => $keterangan,
            'bukti_transfer' => $file_name,
        ];

        // update data
        $pengeluarankantor = $this->pengeluarankantor->update($id_pengeluaran, $data);
        if ($pengeluarankantor) {
            if ($bukti_transfer) {
                return json_encode(['status' => true, 'message' => 'Data Pengeluaran berhasil diupdate']);
            }
            return redirect()->to('/dashboard/advertiser/pengeluaran-kantor')->with('success', 'Data Pengeluaran berhasil diupdate');
        } else {
            return json_encode(['status' => false, 'message' => 'Data Pengeluaran gagal diupdate']);
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $pengeluarankantor = $this->pengeluarankantor->delete($id);
        if ($pengeluarankantor) {
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
    public function listPengeluaranKantor()
    {
        $db = db_connect();
        $builder = $db->table('pengeluaran_kantor')->select('id_pengeluaran_kantor, tanggal, waktu, jenis_pengeluaran, keterangan, bank_tujuan, nama_penerima, jumlah, bukti_transfer');
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
            return '<a class="btn btn-success" title="Edit Bray" href="' . base_url('dashboard/advertiser/pengeluaran-kantor/edit/') . $row->id_pengeluaran_kantor . '" role="button"><i class="fas fa-sm fa-pen"></i></a>
            <button class="btn btn-danger delete-pengeluaran" title="Hapus Bray" onclick="deleteRecord(' . $row->id_pengeluaran_kantor . ')" role="button"><i class="fas fa-sm fa-trash"></i></button>';
        }, 'last')->format('jumlah', function ($value) {
            return number_format($value, 0, ',', '.');
        })->format('bukti_transfer', function ($value) {
            return '<a href="' . base_url('bukti_pengeluaran_kantor/') . $value . '" target="_blank">
            <img src="' . base_url('bukti_pengeluaran_kantor/') . $value . '" alt="" style="height:50px; width:50px"></a>';
        })->toJson(true);
    }
}
