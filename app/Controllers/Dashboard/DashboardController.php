<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{

    function __construct()
    {
        $this->pemasukanadv = new \App\Models\PemasukanAdvertiserModel();
        $this->uangtransferadvertiser = new \App\Models\BroadcastModel();
        $this->pengeluaranbroadcast = new \App\Models\PengeluaranBroadcastModel();
        $this->pengeluaranadv = new \App\Models\PengeluaranAdvertiserModel();
        $this->pengeluarankantor = new \App\Models\PengeluaranKantorModel();
        $this->laba = new \App\Models\DashboardModel();
        $this->laba_bc = new \App\Models\LabaBroadcastModel();
    }
    public function index()
    {
        // count data from pemasukan adv and sum jumlah
        $totalPemasukan =  $this->pemasukanadv->selectSum('jumlah')->get()->getRowArray();
        $totalPemasukan =  $this->pemasukanadv->selectSum('jumlah')->get()->getRowArray();
        $uangtransferAdvertiser =  $this->uangtransferadvertiser->WHERE('jenis_transfer', 'Iklan')->selectSum('harga_total')->get()->getRowArray();
        $uangtransferBroadcast =  $this->uangtransferadvertiser->WHERE('jenis_transfer', 'Broadcast')->selectSum('harga_total')->get()->getRowArray();
        $totalPengeluaran =  $this->pengeluaranadv->selectSum('jumlah')->get()->getRowArray();
        $totalPengeluaranBC =  $this->pengeluaranbroadcast->selectSum('jumlah')->get()->getRowArray();
        $totalPengeluaranKantor =  $this->pengeluarankantor->selectSum('jumlah')->get()->getRowArray();

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

        // chart laba broadcast
        $bulan_bc = $this->laba_bc->select('tanggal')->get()->getResultArray();
        foreach ($bulan_bc as $key => $value) {
            $bulan_bc[$key]['tanggal'] = date('F', strtotime($value['tanggal']));
        }
        $bulan_bc_conv = json_encode(array_column($bulan_bc, 'tanggal'));
        $total_bc = $this->laba_bc->select('total')->get()->getResultArray();
        $total_bc_conv = json_encode(array_column($total_bc, 'total'));

        $data = [
            'title' => 'Dashboard',
            'totalPemasukan' => $totalPemasukan['jumlah'] ?? '0',
            'uangtransferAdvertiser' => $uangtransferAdvertiser['harga_total'] ?? '0',
            'uangtransferBroadcast' => $uangtransferBroadcast['harga_total'] ?? '0',
            'totalPengeluaran' => $totalPengeluaran['jumlah'] ?? '0',
            'totalPengeluaranBC' => $totalPengeluaranBC['jumlah'] ?? '0',
            'totalPengeluaranKantor' => $totalPengeluaranKantor['jumlah'] ?? '0',
            'bulan' => $bulanconv,
            'total' => $totalconv,
            'bulan_bc' => $bulan_bc_conv,
            'total_bc' => $total_bc_conv,
        ];
        return view('dashboard/index', $data);
    }
}
