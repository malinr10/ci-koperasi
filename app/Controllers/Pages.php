<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | Web'
        ];

        return view('pages/home', $data);
    }

    public function about() 
    {
        $data = [
            'title' => 'About Me'
        ];
        
        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Me',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jl. Merpati No. 23, Jakarta Selatan'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jl. Sudirman No. 45, Jakarta Pusat'
                ]
            ]
        ];
        
        return view('pages/contact', $data);
    }

    
}