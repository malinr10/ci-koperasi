<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class TransaksiController extends BaseController
{
    protected $transaksiModel;

    public function __construct() {
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Riwayat Transaksi Kas',
            'transaksi' => $this->transaksiModel->orderBy('tanggal', 'DESC')->findAll(),
            'auto_code' => $this->transaksiModel->generateCode() // Generate kode otomatis
        ];
        return view('transaksi/index', $data);
    }

    public function save()
    {
        // Validasi sederhana
        if (!$this->validate(['nominal' => 'required', 'kategori' => 'required'])) {
            return redirect()->back()->withInput();
        }

        $this->transaksiModel->save([
            'koperasi_id'    => 1, // Default ID Koperasi Anda
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

    public function delete($id)
    {
        $this->transaksiModel->delete($id);
        return redirect()->to('/transaksi')->with('pesan', 'Data berhasil dihapus.');
    }
}