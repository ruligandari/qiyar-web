<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use DateTime;

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
        return redirect()->to('/dashboard/advertiser/pengeluaran-kantor/pengeluaran-kantor');
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
            return redirect()->to('/dashboard/advertiser/pengeluaran-kantor/pengeluaran-kantor');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/dashboard/advertiser/pengeluaran-kantor/pengeluaran-kantor');
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
