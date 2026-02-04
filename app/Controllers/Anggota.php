<?php

namespace App\Controllers;

use App\Models\AnggotaModel;


class Anggota extends BaseController
{
    protected $anggotaModel;
    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        $anggota = $this->anggotaModel->findAll();
        $data = [
            'title' => 'Daftar Anggota',
            'anggota' => $anggota
        ];

        return view('anggota/index', $data);
    }
}
