<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{

    function __construct()
    {
        $this->pemasukanadv = new \App\Models\PemasukanAdvertiserModel();
        $this->pemasukanbc = new \App\Models\PemasukanBroadcastModel();

        $this->pengeluaranbroadcast = new \App\Models\PengeluaranBroadcastModel();
        $this->pengeluaranadv = new \App\Models\PengeluaranadvertiserModel();

        $this->uangtransferadvertiser = new \App\Models\BroadcastModel();

        $this->pengeluarankantor = new \App\Models\PengeluaranKantorModel();

        $this->laba = new \App\Models\DashboardModel();
        $this->laba_bc = new \App\Models\LabaBroadcastModel();
    }
    public function index()
    {

        $data = [
            'title' => 'Dashboard',
        ];
        return view('dashboard/index', $data);
    }

    public function listPendapatanAdv()
    {
        $startDate = $this->request->getPost('start_date');
        $enddata = $this->request->getPost('end_date');
        // cari data dari model pengeluaranadv
        $pengeluaranadv = $this->pengeluaranadv->select('tanggal, jumlah')->where('tanggal >=', $startDate)->where('tanggal <=', $enddata)->findAll();
        $pemasukanadv = $this->pemasukanadv->select('tanggal, jumlah')->where('tanggal >=', $startDate)->where('tanggal <=', $enddata)->findAll();
        $pengeluaranKantor = $this->pengeluarankantor->select('tanggal, jumlah')->where('tanggal >=', $startDate)->where('tanggal <=', $enddata)->findAll();
        $pemasukanTransfer = $this->uangtransferadvertiser->where('jenis_transfer', 'Iklan')->select('tanggal, harga_total')->where('tanggal >=', $startDate)->where('tanggal <=', $enddata)->findAll();
        $transferIklanBroadcast = $this->uangtransferadvertiser->where('jenis_transfer', 'Broadcast Iklan')->select('tanggal, harga_total')->where('tanggal >=', $startDate)->where('tanggal <=', $enddata)->findAll();

        $pemasukanBroadcast = $this->pemasukanbc->select('tanggal, jumlah')->where('tanggal >=', $startDate)->where('tanggal <=', $enddata)->findAll();
        $uangtransferBc = $this->uangtransferadvertiser->where('jenis_transfer', 'Broadcast')->select('tanggal, harga_total')->where('tanggal >=', $startDate)->where('tanggal <=', $enddata)->findAll();
        $uangtransferBcAdv = $this->uangtransferadvertiser->where('jenis_transfer', 'Iklan')->select('tanggal, harga_total')->where('tanggal >=', $startDate)->where('tanggal <=', $enddata)->findAll();
        $pengeluaranBc = $this->pengeluaranbroadcast->select('tanggal, jumlah')->where('tanggal >=', $startDate)->where('tanggal <=', $enddata)->findAll();
        $data = [
            'pengeluaran' => $pengeluaranadv,
            'pemasukan' => $pemasukanadv,
            'pengeluaranKantor' => $pengeluaranKantor,
            'pemasukanTransfer' => $pemasukanTransfer,
            'pemasukanBroadcast' => $pemasukanBroadcast,
            'uangTransferBc' => $uangtransferBc,
            'uangTransferAdv' => $uangtransferBcAdv,
            'pengeluaranBc' => $pengeluaranBc,
            'transferIklanBroadcast' => $transferIklanBroadcast,
        ];
        return json_encode($data);
    }
}
