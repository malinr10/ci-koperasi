<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KoperasiSeeder extends Seeder
{
    public function run()
    {
        // --- 1. SEED KOPERASI (20 Data) ---
        $daerah = ['Dago', 'Cibaduyut', 'Lembang', 'Antapani', 'Ujung Berung', 'Pasteur', 'Gedebage', 'Kopo', 'Setiabudi', 'Cicadas', 'Buah Batu', 'Cileunyi', 'Padalarang', 'Batununggal', 'Sarijadi', 'Sukajadi', 'Cikutra', 'Arcamanik', 'Cibiru', 'Panyileukan'];
        
        for ($i = 0; $i < 20; $i++) {
            $namaKoperasi = "KSP " . $daerah[$i] . " Mandiri";
            $this->db->table('koperasi')->insert([
                'kode'       => "KOP-" . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama'       => $namaKoperasi,
                'alamat'     => "Jl. " . $daerah[$i] . " No. " . rand(1, 150),
                'kota'       => 'Bandung',
                'provinsi'   => 'Jawa Barat',
                'latitude'   => -6.900000 + (rand(-50, 50) / 1000),
                'longitude'  => 107.610000 + (rand(-50, 50) / 1000),
                'no_telepon' => "022" . rand(1000000, 9999999), // Tidak Null
                'email'      => strtolower(str_replace(' ', '', $namaKoperasi)) . "@koperasi.id",
                'status'     => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // --- 2. SEED ANGGOTA (20 Data) ---
        $namaDepan = ['Ahmad', 'Siti', 'Budi', 'Dewi', 'Eko', 'Rina', 'Andi', 'Maya', 'Heri', 'Sari', 'Agus', 'Ani', 'Indra', 'Fitri', 'Dani', 'Lusi', 'Roni', 'Indah', 'Fajar', 'Wati'];
        $namaBelakang = ['Saputra', 'Lestari', 'Kurniawan', 'Hidayah', 'Pratama', 'Purnama', 'Wibowo', 'Utami', 'Nugroho', 'Rahayu', 'Setiawan', 'Susanti', 'Gunawan', 'Amalia', 'Mulyana', 'Siska', 'Arifin', 'Kusuma', 'Santoso', 'Zahra'];

        for ($i = 1; $i <= 20; $i++) {
            $this->db->table('anggota')->insert([
                'koperasi_id'    => rand(1, 20), // Relasi ke Koperasi
                'nomor_anggota'  => "ANG-" . date('Y') . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nik'            => "3273" . rand(100000, 999999) . "000" . $i,
                'nama'           => $namaDepan[array_rand($namaDepan)] . " " . $namaBelakang[array_rand($namaBelakang)],
                'jenis_kelamin'  => ($i % 2 == 0) ? 'L' : 'P',
                'alamat'         => "Perumahan " . $daerah[array_rand($daerah)] . " No. " . rand(1, 100),
                'no_hp'          => "08" . rand(11, 19) . rand(1000000, 9999999),
                'tanggal_lahir'  => rand(1975, 2000) . "-" . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . "-" . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                'tanggal_daftar' => date('Y-m-d', strtotime('-' . rand(1, 30) . ' days')),
                'status'         => 'aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
        }

        // --- 3. SEED SIMPANAN (20 Data) ---
        $jenisSimpanan = ['pokok', 'wajib', 'sukarela'];
        for ($i = 1; $i <= 20; $i++) {
            $this->db->table('simpanan')->insert([
                'anggota_id' => $i, // Relasi ke Anggota
                'jenis'      => $jenisSimpanan[array_rand($jenisSimpanan)],
                'nominal'    => rand(1, 10) * 50000,
                'tanggal'    => date('Y-m-d'),
                'keterangan' => "Setoran tunai simpanan oleh anggota ID $i", // Tidak Null
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // --- 4. SEED PINJAMAN (20 Data) ---
        for ($i = 1; $i <= 20; $i++) {
            $this->db->table('pinjaman')->insert([
                'anggota_id'      => $i,
                'kode_pinjaman'   => "PJM-" . time() . $i,
                'jumlah_pinjaman' => rand(5, 20) * 1000000,
                'bunga'           => rand(1, 2) . ".5",
                'tenor'           => rand(6, 12),
                'tanggal_pinjam'  => date('Y-m-d', strtotime('-' . rand(30, 60) . ' days')),
                'tanggal_jatuh_tempo' => date('Y-m-d', strtotime('+' . rand(1, 12) . ' months')),
                'status'          => 'aktif',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
        }

        // --- 5. SEED ANGSURAN (20 Data) ---
        for ($i = 1; $i <= 20; $i++) {
            $this->db->table('angsuran')->insert([
                'pinjaman_id'   => $i, // Relasi ke Pinjaman
                'nominal'       => 500000 + (rand(1, 5) * 10000),
                'tanggal_bayar' => date('Y-m-d'),
                'keterangan'    => "Pembayaran angsuran rutin via teller", // Tidak Null
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }

        // --- 6. SEED TRANSAKSI (20 Data) ---
        $katMasuk = ['Bunga Pinjaman', 'Provisi', 'Simpanan Pokok'];
        $katKeluar = ['Biaya Listrik', 'Gaji Karyawan', 'Biaya ATK'];
        for ($i = 1; $i <= 20; $i++) {
            $jenis = ($i % 2 == 0) ? 'pemasukan' : 'pengeluaran';
            $this->db->table('transaksi')->insert([
                'koperasi_id'    => rand(1, 20),
                'kode_transaksi' => "TRX-" . rand(1000, 9999) . $i,
                'jenis'          => $jenis,
                'kategori'       => ($jenis == 'pemasukan') ? $katMasuk[array_rand($katMasuk)] : $katKeluar[array_rand($katKeluar)],
                'sumber'         => ($jenis == 'pemasukan') ? "Anggota ID " . rand(1, 20) : "Kas Kantor",
                'nominal'        => rand(100, 1000) * 1000,
                'tanggal'        => "2026-" . str_pad(rand(1, 2), 2, '0', STR_PAD_LEFT) . "-" . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                'keterangan'     => "Transaksi otomatis sistem periode " . date('M Y'), // Tidak Null
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
        }
    }
}