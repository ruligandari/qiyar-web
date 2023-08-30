<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{

    function __construct()
    {
        $this->pemasukanadv = new \App\Models\PemasukanAdvertiserModel();
        $this->pengeluaranadv = new \App\Models\PengeluaranAdvertiserModel();
        $this->laba = new \App\Models\DashboardModel();
    }
    public function index()
    {
        // count data from pemasukan adv and sum jumlah
        $totalPemasukan =  $this->pemasukanadv->selectSum('jumlah')->get()->getRowArray();
        $totalPengeluaran =  $this->pengeluaranadv->selectSum('jumlah')->get()->getRowArray();

        // select daru data laba kemudia pilih field tanggal
        $bulan = $this->laba->select('tanggal')->get()->getResultArray();

        // konversi dari DATE 2023-06-01 menjadi Bulan Juni format indonesia
        foreach ($bulan as $key => $value) {
            $bulan[$key]['tanggal'] = date('F', strtotime($value['tanggal']));
        }
        // CONVERT array ke json, dengan format [date1, date2, date3], tanpa key tanggal dan isi menjadi nilai string
        $bulanconv = json_encode(array_column($bulan, 'tanggal'));

        $total = $this->laba->select('total')->get()->getResultArray();
        $totalconv = json_encode(array_column($total, 'total'));

        $data = [
            'title' => 'Dashboard',
            'totalPemasukan' => $totalPemasukan['jumlah'] ?? '0',
            'totalPengeluaran' => $totalPengeluaran['jumlah'] ?? '0',
            'bulan' => $bulanconv,
            'total' => $totalconv,
        ];
        return view('dashboard/index', $data);
    }
}
