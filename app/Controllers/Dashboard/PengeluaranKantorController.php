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
        $banktujuan = $this->request->getPost('banktujuan');
        $penerima = $this->request->getPost('penerima');
        $jumlah = $this->request->getPost('jumlah');
        $upload_bukti = $this->request->getFile('upload_bukti');

        // Validasi data
        $validation = \Config\Services::validation();
        $validate = $this->validate([
            'waktu' => 'required',
            'banktujuan' => 'required',
            'penerima' => 'required',
            'jumlah' => 'required',
            'upload_bukti' => 'uploaded[upload_bukti]|max_size[upload_bukti,1024]|is_image[upload_bukti]',
        ], [
            'waktu' => ['required' => 'Waktu harus diisi.'],
            'banktujuan' => ['required' => 'Bank Tujuan harus diisi.'],
            'penerima' => ['required' => 'Penerima harus diisi.'],
            'jumlah' => ['required' => 'Jumlah harus diisi.'],
            'upload_bukti' => [
                'uploaded' => 'Upload Bukti harus diisi.',
                'max_size' => 'Ukuran file terlalu besar. Maksimum 1MB.',
                'is_image' => 'File harus berupa gambar.'
            ],
        ]);

        // Jika validasi gagal
        if (!$validate) {
            session()->setFlashdata('error', $validation->getErrors());
            return redirect()->to('/dashboard/advertiser/pengeluaran-kantor/tambah-data-pengeluaran-kantor')->withInput();
        }

        // Jika validasi berhasil
        $jumlah = str_replace(',', '', $jumlah);
        $data = [
            'tanggal' => $tanggal,
            'waktu' => $waktu,
            'bank_tujuan' => $banktujuan,
            'nama_penerima' => $penerima,
            'jenis_pengeluaran' => $jenispengeluaran,
            'jumlah' => $jumlah,
            'bukti_transfer' => $upload_bukti->getName()
        ];

        $this->pengeluarankantor->insert($data);
        $upload_bukti->move('bukti_pengeluaran_kantor');

        session()->setFlashdata('success', 'Data Pengeluaran berhasil ditambahkan');
        return redirect()->to('/dashboard/advertiser/pengeluaran-kantor');
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
        $nama_penerima = $this->request->getPost('nama_penerima');
        $bukti_transfer = $this->request->getFile('bukti_transfer');
        $bukti_transfer_lama = $this->request->getPost('bukti_transfer_lama');

        // convert 140,000 or 140.000 to 140000
        if (strpos($jumlah, ',') !== false) {
            $jumlah = str_replace(',', '', $jumlah);
        } else if (strpos($jumlah, '.') !== false) {
            $jumlah = str_replace('.', '', $jumlah);
        }

        $data = [
            'jumlah' => $jumlah,
            'nama_penerima' => $nama_penerima,
            'bank_tujuan' => $bank_tujuan,
            'jenis_pengeluaran' => $jenis_pengeluaran,
            'bukti_transfer' => $bukti_transfer->getName() ? $bukti_transfer->getName() : $bukti_transfer_lama,
        ];

        if ($bukti_transfer->getName() != null) {
            // hapus file lama
            unlink('bukti_pengeluaran_kantor/' . $bukti_transfer_lama);
            $bukti_transfer->move('bukti_pengeluaran_kantor');
        }
        // update data
        $pengeluarankantor = $this->pengeluarankantor->update($id_pengeluaran, $data);
        if ($pengeluarankantor) {
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/dashboard/advertiser/pengeluaran-kantor');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/advertiser/pengeluaran-kantor/edit/' . $id_pengeluaran)->withInput();
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
        $builder = $db->table('pengeluaran_kantor')->select('id_pengeluaran_kantor, tanggal, waktu, jenis_pengeluaran, bank_tujuan, nama_penerima, jumlah, bukti_transfer');
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
