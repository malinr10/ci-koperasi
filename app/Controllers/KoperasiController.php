<?php

namespace App\Controllers;

use App\Models\KoperasiModel;

class KoperasiController extends BaseController
{
    protected $koperasiModel;

    public function __construct()
    {
        $this->koperasiModel = new KoperasiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Koperasi',
            'koperasi' => $this->koperasiModel->findAll(),
            'google_maps_api_key' => getenv('GOOGLE_MAPS_API_KEY')
        ];
        return view('koperasi/index', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->koperasiModel->save([
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'email' => $this->request->getVar('email'),
            'no_telepon' => $this->request->getVar('no_telepon'),
            'latitude' => $this->request->getVar('latitude'),
            'longitude' => $this->request->getVar('longitude'),
            'kode' => $this->koperasiModel->generateCode(),
            'status' => 'aktif'
        ]);

        return redirect()->to('/koperasi')->with('pesan', 'Data Koperasi Berhasil Ditambahkan');
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->koperasiModel->update($id, [
            'nama'        => $this->request->getVar('nama'),
            'email'       => $this->request->getVar('email'),
            'no_telepon'  => $this->request->getVar('no_telepon'),
            'alamat'      => $this->request->getVar('alamat'),
            'latitude'    => $this->request->getVar('latitude'),
            'longitude'   => $this->request->getVar('longitude'),
        ]);

        return redirect()->to('/koperasi')->with('pesan', 'Data Koperasi Berhasil Diperbarui');
    }


    public function delete($id)
    {
        $this->koperasiModel->delete($id);
        return redirect()->to('/koperasi')->with('pesan', 'Data Koperasi Berhasil Dihapus');
    }
}
