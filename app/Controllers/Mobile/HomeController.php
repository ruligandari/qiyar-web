<?php

namespace App\Controllers\Mobile;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        // Note: StokBarangJktModel is actually the Log for Barang Masuk in this project structure
        $barangMasukLogModel = new \App\Models\StokBarangJktModel(); 
        $barangKeluarModel = new \App\Models\BarangKeluarJktModel();
        
        $today = date('Y-m-d');

        // Stats Default (Today)
        $totalMasukBeli = $barangMasukLogModel->where('jenis_barang_masuk', 'Barang Beli')->where('tanggal', $today)->selectSum('qty')->first()['qty'] ?? 0;
        $totalMasukReturn = $barangMasukLogModel->where('jenis_barang_masuk', 'Barang Return')->where('tanggal', $today)->selectSum('qty')->first()['qty'] ?? 0;
        $totalKeluar = $barangKeluarModel->where('tanggal', $today)->selectSum('qty')->first()['qty'] ?? 0;
        $totalResi = $barangKeluarModel->where('tanggal', $today)->groupBy('resi')->countAllResults();

        $data = [
            'title' => 'Beranda',
            'stats' => [
                'masuk_beli' => $totalMasukBeli,
                'masuk_return' => $totalMasukReturn,
                'keluar' => $totalKeluar,
                'resi' => $totalResi
            ]
        ];
        return view('mobile/home/home', $data);
    }

    public function profile()
    {
        $data = [
            'title' => 'Profil',
        ];
        return view('mobile/profile/profile', $data);
    }

    public function update()
    {
        $user = new \App\Models\Admin\UserModel();
        $nama = $this->request->getPOST('nama');
        $email = $this->request->getPOST('email');
        $password_1 = $this->request->getPOST('password_1');
        $password_2 = $this->request->getPOST('password_2');

        // cek password 1 dan 2 harus sama
        if ($password_1 != $password_2) {
            return redirect()->to('/mobile/profile')->with('error', 'Password tidak sama');
        }
        // enkripsi password
        $password_1 = password_hash($password_1, PASSWORD_DEFAULT);
        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => $password_1,
        ];

        // update data
        $this->$user->update($data);

        return redirect()->to('/mobile/profile')->with('success', 'Data berhasil diupdate');
    }
    public function getStats()
    {
        $start = $this->request->getPost('start_date');
        $end = $this->request->getPost('end_date');

        if(!$start || !$end) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tanggal tidak valid']);
        }

        $barangMasukLogModel = new \App\Models\StokBarangJktModel(); 
        $barangKeluarModel = new \App\Models\BarangKeluarJktModel();

        // Calculate Stats with Range
        $totalMasukBeli = $barangMasukLogModel->where('jenis_barang_masuk', 'Barang Beli')
                            ->where("tanggal >=", $start)->where("tanggal <=", $end)
                            ->selectSum('qty')->first()['qty'] ?? 0;
                            
        $totalMasukReturn = $barangMasukLogModel->where('jenis_barang_masuk', 'Barang Return')
                            ->where("tanggal >=", $start)->where("tanggal <=", $end)
                            ->selectSum('qty')->first()['qty'] ?? 0;

        $totalKeluar = $barangKeluarModel->where("tanggal >=", $start)->where("tanggal <=", $end)
                            ->selectSum('qty')->first()['qty'] ?? 0;

        $totalResi = $barangKeluarModel->where("tanggal >=", $start)->where("tanggal <=", $end)
                            ->groupBy('resi')->countAllResults();

        return $this->response->setJSON([
            'status' => 'success',
            'stats' => [
                'masuk_beli' => (int)$totalMasukBeli,
                'masuk_return' => (int)$totalMasukReturn,
                'keluar' => (int)$totalKeluar,
                'resi' => (int)$totalResi
            ]
        ]);
    }
}
