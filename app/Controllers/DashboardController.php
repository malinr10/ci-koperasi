<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // 1. Hitung Total Anggota
        $totalAnggota = $db->table('anggota')->countAllResults();

        // 2. Hitung Total Transaksi (Semua record di tabel transaksi)
        $totalTransaksi = $db->table('transaksi')->countAllResults();

        // 3. Hitung Total Omzet (Pemasukan kategori selain Simpanan)
        $omzetQuery = $db->query("SELECT SUM(nominal) as total FROM transaksi 
                                  WHERE jenis = 'pemasukan' 
                                  AND kategori NOT LIKE 'Simpanan%'")->getRow();
        $totalOmzet = $omzetQuery->total ?? 0;

        // 4. Data untuk Chart (Omzet per Bulan di tahun 2026)
        $chartQuery = $db->query("
            SELECT 
                MONTH(tanggal) as bulan_num,
                SUM(nominal) as total
            FROM transaksi 
            WHERE jenis = 'pemasukan' 
              AND kategori NOT LIKE 'Simpanan%'
              AND YEAR(tanggal) = 2026
            GROUP BY MONTH(tanggal)
            ORDER BY MONTH(tanggal) ASC
        ")->getResultArray();

        // Mapping hasil query ke array 12 bulan untuk Chart.js
        $monthlyData = array_fill(0, 12, 0);
        foreach ($chartQuery as $row) {
            $monthlyData[$row['bulan_num'] - 1] = (float)$row['total'];
        }

        // 5. Data Lokasi Koperasi untuk Maps
        $lokasiKoperasi = $db->table('koperasi')->select('nama, alamat, latitude, longitude')->get()->getResultArray();

        $data = [
            'title'          => 'Dashboard Koperasi',
            'totalAnggota'   => $totalAnggota,
            'totalTransaksi' => $totalTransaksi,
            'totalOmzet'     => $totalOmzet,
            'chartData'      => $monthlyData,
            'lokasiKoperasi' => $lokasiKoperasi,
            'google_maps_key' => env('GOOGLE_MAPS_API_KEY')
        ];

        return view('pages/dashboard', $data);
    }
}