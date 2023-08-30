<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{

    function __construct()
    {
        $this->pemasukanadv = new \App\Models\PemasukanAdvertiserModel();
        $this->pengeluaranadv = new \App\Models\PengeluaranAdvertiserModel();
    }
    public function index()
    {
        // count data from pemasukan adv and sum jumlah
        $totalPemasukan =  $this->pemasukanadv->selectSum('jumlah')->get()->getRowArray();
        $totalPengeluaran =  $this->pengeluaranadv->selectSum('jumlah')->get()->getRowArray();

        $data = [
            'title' => 'Dashboard',
            'totalPemasukan' => $totalPemasukan['jumlah'] ?? '0',
            'totalPengeluaran' => $totalPengeluaran['jumlah'] ?? '0',
        ];
        return view('dashboard/index', $data);
    }
}
