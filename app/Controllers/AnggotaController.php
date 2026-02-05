<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class AnggotaController extends BaseController
{
    protected $anggotaModel;
    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Anggota',
            'anggota' => $this->anggotaModel->getAnggotaWithKoperasi(),
            'list_koperasi' => $this->anggotaModel->getListKoperasi()
        ];

        return view('anggota/index', $data);
    }

    public function save()
    {
        $rules = [
            'koperasi_id'   => 'required',
            'nik'           => 'required|numeric|exact_length[16]|is_unique[anggota.nik]',
            'nama'          => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'no_hp'         => 'required|numeric|min_length[12]',
            'alamat'        => 'required',
            'tanggal_lahir' => 'required|valid_date[Y-m-d]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $generateNomorAnggota = 'ANG' . str_pad($this->anggotaModel->countAllResults() + 1, 5, '0', STR_PAD_LEFT);
        $this->anggotaModel->save([
            'koperasi_id'    => $this->request->getVar('koperasi_id'),
            'nomor_anggota'  => $generateNomorAnggota,
            'nik'            => $this->request->getVar('nik'),
            'nama'           => $this->request->getVar('nama'),
            'jenis_kelamin'  => $this->request->getVar('jenis_kelamin'),
            'no_hp'          => $this->request->getVar('no_hp'),
            'alamat'         => $this->request->getVar('alamat'),
            'tanggal_lahir'  => $this->request->getVar('tanggal_lahir'),
            'tanggal_daftar' => date('Y-m-d'),
            'status'         => 'aktif'
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to('/anggota');
    }

    public function update($id)
    {   
        $rules = [
            'nama'   => 'required|min_length[3]',
            'no_hp'  => 'required|numeric|min_length[12]',
            'status' => 'required|in_list[aktif,nonaktif]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'alamat'        => 'required',
            'tanggal_lahir' => 'required|valid_date[Y-m-d]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->anggotaModel->update($id, [
            'koperasi_id' => $this->request->getVar('koperasi_id'),
            'nama'   => $this->request->getVar('nama'),
            'no_hp'  => $this->request->getVar('no_hp'),
            'status' => $this->request->getVar('status'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'alamat' => $this->request->getVar('alamat'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir')
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to('/anggota');
    }

    public function delete($id)
    {
        $this->anggotaModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/anggota');
    }
}
