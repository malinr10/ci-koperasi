<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $transaksiModel = new TransaksiModel();
        
        // 1. TANGKAP INPUT TAHUN DARI URL 
        $tahunDipilih = $this->request->getVar('tahun') ?? date('Y');

        // 2. Data Statistik (Anggota & Transaksi sifatnya akumulasi total, tidak per tahun)
        $totalAnggota = $db->table('anggota')->where('status', 'aktif')->countAllResults();
        $totalTransaksi = $db->table('transaksi')->countAllResults();

        // 3. Hitung Total Omzet (SESUAI TAHUN DIPILIH)
        $totalOmzet = $transaksiModel->getTotalOmzet($tahunDipilih);

        // 4. Data untuk Chart (SESUAI TAHUN DIPILIH)
        $chartQuery = $transaksiModel->getOmzetPerMonth($tahunDipilih);
        $monthlyData = array_fill(0, 12, 0);
        foreach ($chartQuery as $row) {
            $monthlyData[$row['bulan_num'] - 1] = (float)$row['total'];
        }

        // 5. Ambil Daftar Tahun untuk Dropdown
        $availableYears = $transaksiModel->getAvailableYears();

        // 6. Data Lokasi
        $lokasiKoperasi = $db->table('koperasi')
                             ->select('nama, alamat, latitude, longitude')
                             ->get()
                             ->getResultArray();

        $data = [
            'title'           => 'Dashboard Koperasi',
            'tahunDipilih'    => $tahunDipilih, // Kirim tahun ke view
            'availableYears'  => $availableYears, // Kirim list tahun ke view
            'totalAnggota'    => $totalAnggota,
            'totalTransaksi'  => $totalTransaksi,
            'totalOmzet'      => $totalOmzet,
            'chartData'       => $monthlyData,
            'lokasiKoperasi'  => $lokasiKoperasi,
            'google_maps_key' => env('GOOGLE_MAPS_API_KEY')
        ];

        return view('pages/dashboard', $data);
    }
}