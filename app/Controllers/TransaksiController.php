<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\KoperasiModel;
use App\Models\AnggotaModel;
class TransaksiController extends BaseController
{
    protected $transaksiModel;
    protected $koperasiModel;

    protected $anggotaModel;

    public function __construct() {
        $this->transaksiModel = new TransaksiModel();
        $this->koperasiModel = new KoperasiModel();
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Riwayat Transaksi Kas',
            'transaksi' => $this->transaksiModel->getTransaksiFull(),
            'auto_code' => $this->transaksiModel->generateCode(),
            'list_koperasi' => $this->koperasiModel->findAll(),
            'list_anggota' => $this->anggotaModel->getAnggotaWithKoperasi(),
        ];
        return view('transaksi/index', $data);
    }

    public function save()
    {
        // Validasi sederhana
        $rules =[
            'sumber'         => 'required',
            'koperasi_id'    => 'required',
            'jenis'          => 'required',
            'kategori'       => 'required',
            'nominal'        => 'required|numeric',
            'tanggal'        => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->transaksiModel->save([
            'koperasi_id'    => $this->request->getVar('koperasi_id'),
            'anggota_id'     => $this->request->getVar('anggota_id'),
            'kode_transaksi' => $this->request->getVar('kode_transaksi'),
            'jenis'          => $this->request->getVar('jenis'),
            'kategori'       => $this->request->getVar('kategori'),
            'sumber'         => $this->request->getVar('sumber'),
            'nominal'        => $this->request->getVar('nominal'),
            'tanggal'        => $this->request->getVar('tanggal'),
            'keterangan'     => $this->request->getVar('keterangan'),
        ]);

        return redirect()->to('/transaksi')->with('pesan', 'Transaksi Berhasil Dicatat!');
    }

    public function update($id)
    {
        // Validasi sederhana
        $rules =[
            'sumber'         => 'required',
            'koperasi_id'    => 'required',
            'jenis'          => 'required',
            'kategori'       => 'required',
            'nominal'        => 'required|numeric',
            'tanggal'        => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->transaksiModel->update($id, [
            'koperasi_id'    => $this->request->getVar('koperasi_id'),
            'anggota_id'     => $this->request->getVar('anggota_id'),
            'jenis'          => $this->request->getVar('jenis'),

            'kategori'       => $this->request->getVar('kategori'),
            'sumber'         => $this->request->getVar('sumber'),
            'nominal'        => $this->request->getVar('nominal'),
            'tanggal'        => $this->request->getVar('tanggal'),
            'keterangan'     => $this->request->getVar('keterangan'),
        ]);

        return redirect()->to('/transaksi')->with('pesan', 'Transaksi Berhasil Diperbarui!');
    }

    public function delete($id)
    {
        $this->transaksiModel->delete($id);
        return redirect()->to('/transaksi')->with('pesan', 'Transaksi Berhasil Dihapus!');
    }
}