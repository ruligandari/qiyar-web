<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class AdvertiserController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Data Advertiser',
        ];
        return view('dashboard/dataadvertiser', $data);
    }
    public function tambahdata()
    {
        $data = [
            'title' => 'Data Advertiser',
        ];
        return view('dashboard/tambahdataadvertiser', $data);
    }
}
