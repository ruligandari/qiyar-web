<?php

namespace App\Controllers\Mobile;

use App\Controllers\BaseController;
use App\Models\BarangKeluarJktModel;
use App\Models\BarangMasukJktModel;
use App\Models\StokBarangJktModel;

class MasterBarangController extends BaseController
{
    protected $barang_masuk_jkt;
    protected $barang_keluar_jkt;
    protected $stok_barang_jkt;
    public function __construct()
    {
        $this->barang_masuk_jkt = new BarangMasukJktModel();
        $this->barang_keluar_jkt = new BarangKeluarJktModel();
        $this->stok_barang_jkt = new StokBarangJktModel();
    }
    public function index()
    {
        // Ambil query pencarian dari input
        $search = $this->request->getGet('q');

        // Inisialisasi model
        $stokModel = $this->barang_masuk_jkt;

        if ($search) {
            // Jika ada pencarian, filter data berdasarkan pencarian
            $stokModel->like('nama_barang', $search);
        }

        // Pagination dengan pencarian
        $stok = $stokModel->orderBy('id', 'DESC')
            ->paginate(30, 'stok_barang');

        $data = [
            'title' => 'Master Barang',
            'data' => $stok,
            'pager' => $stokModel->pager,  // Untuk pagination
            'search' => $search            // Untuk mempertahankan input pencarian di view
        ];

        return view('mobile/master_barang/index', $data);
    }

    public function generateQr($id)
    {
        // cari ke barang_masuk_jkt
        $data = $this->barang_masuk_jkt->find($id);
        // dapatkan nama barang
        $nama_barang = $data['nama_barang'];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://qrcode3.p.rapidapi.com/qrcode/text",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'data' => $id,
                'style' => [
                    'module' => [
                        'color' => '#000',
                        'shape' => 'default'
                    ],
                    'inner_eye' => [
                        'shape' => 'default'
                    ],
                    'outer_eye' => [
                        'shape' => 'default'
                    ],
                    'background' => [
                        'color' => '#ffffff'
                    ]
                ],
                'size' => [
                    'width' => 500,
                    'quiet_zone' => 4,
                    'error_correction' => 'L'
                ],
                'output' => [
                    'filename' => 'qrcode',
                    'format' => 'png'
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Key: 786cd29387mshe57fa6c62f1f168p131b6cjsn01d22f04844a",
                "accept: application/postscript",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $filePath = FCPATH . 'qrcodes/' . $nama_barang . '.png';
            file_put_contents($filePath, $response);

            // Pastikan tidak ada output sebelum header, atau header tidak akan dikirim dengan benar
            header('Content-Type: image/png'); // Menggunakan MIME type yang tepat untuk file PNG
            header('Content-Disposition: attachment; filename="' . $nama_barang . '.png"');
            header('Content-Length: ' . filesize($filePath)); // Menambahkan panjang file untuk membantu penanganan browser
            readfile($filePath);
        }
    }

    public function add()
    {
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');

        // cek validasi
        $validation = \Config\Services::validation();
        $isDataValid = $this->validate([
            'tanggal' => 'required',
            'nama_barang' => 'required',
            'qty' => 'required'
        ]);

        // jika data tidak valid
        if (!$isDataValid) {
            session()->setFlashdata('error', $validation->listErrors());
            return redirect()->to(base_url('stok-opname/master-barang'));
        }

        // Cek apakah nama barang sudah ada di database
        $existingBarang = $this->barang_masuk_jkt->where('nama_barang', $nama_barang)->first();

        if ($existingBarang) {
            // Jika nama barang sudah ada, munculkan pesan error
            session()->setFlashdata('error', 'Nama barang sudah ada, silakan masukkan nama barang yang berbeda.');
            return redirect()->to(base_url('stok-opname/master-barang'));
        }

        // Data valid dan nama barang belum ada, lanjutkan proses insert
        $data = [
            'tanggal' => $tanggal,
            'nama_barang' => $nama_barang,
            'qty' => $qty
        ];

        $this->barang_masuk_jkt->insert($data);
        session()->setFlashdata('success', 'Data berhasil ditambahkan');
        return redirect()->to(base_url('stok-opname/master-barang'));
    }


    public function delete()
    {
        // tangkap data id dengan method delete
        $id = $this->request->getPost('id');

        // hapus data dengan data id
        $this->barang_masuk_jkt->delete($id);
        // kirim response json dengan status sukses
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus', 'data', $id]);
    }

    public function edit()
    {
        $id = $this->request->getPost('id');
        // cari data berdasarkan id
        $data = $this->barang_masuk_jkt->find($id);
        // kirim data ke json
        return $this->response->setJSON($data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');

        // cek valkidasi
        $validation = \Config\Services::validation();
        $isDataValid = $this->validate([
            'tanggal' => 'required',
            'nama_barang' => 'required',
            'qty' => 'required'
        ]);

        // jika data tidak valid
        if (!$isDataValid) {
            session()->setFlashdata('error', $validation->listErrors());
            return redirect()->to(base_url('stok-opname/master-barang'));
        }
        $data = [
            'tanggal' => $tanggal,
            'nama_barang' => $nama_barang,
            'qty' => $qty
        ];

        $this->barang_masuk_jkt->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate');
        return redirect()->to(base_url('stok-opname/master-barang'));
    }
}
