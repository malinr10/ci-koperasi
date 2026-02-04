<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    public function index(): string
    {
        $data = [
            'title' => 'Dashboard | Koperasi'
        ];
        
        return view('pages/dashboard', $data);
    }
}
