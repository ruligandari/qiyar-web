<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home/index');
    }

    public function lamaran()
    {
        $data = [
            'title' => 'Lamaran',
        ];
        return view('home/lamaran', $data);
    }
}
