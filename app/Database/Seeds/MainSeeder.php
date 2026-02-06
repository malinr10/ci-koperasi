<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use CodeIgniter\CLI\CLI;

class MainSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $db = \Config\Database::connect();

        // ==========================================
        // 1. SEED KOPERASI (25 Data)
        // ==========================================
        CLI::write("🌱 Seeding 25 Koperasi (Bandung Raya & Sekitarnya)...", 'green');
        
        $koperasiData = [];
        $jenisKoperasi = ['Simpan Pinjam', 'Serba Usaha', 'Unit Desa', 'Tani Makmur', 'Pegawai Negeri', 'Karyawan', 'Syariah'];
        $namaDaerah = ['Bandung', 'Cimahi', 'Lembang', 'Soreang', 'Padalarang', 'Cileunyi', 'Dago', 'Buah Batu', 'Cibiru', 'Bojongsoang'];

        for ($i = 1; $i <= 25; $i++) {
            // Generate Nama Koperasi yang terlihat Asli
            $jenis = $faker->randomElement($jenisKoperasi);
            $daerah = $faker->randomElement($namaDaerah);
            $namaKoperasi = "Koperasi " . $jenis . " " . $faker->companySuffix . " " . $daerah;
            
            // Koordinat disebar di sekitar Bandung (Lat: -6.8 s/d -7.0, Long: 107.5 s/d 107.7)
            $lat = $faker->latitude(-7.05, -6.85); 
            $lng = $faker->longitude(107.50, 107.75);

            $koperasiData[] = [
                'kode'        => 'KOP-' . strtoupper(substr($daerah, 0, 3)) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama'        => $namaKoperasi,
                'alamat'      => $faker->streetAddress . ', ' . $daerah . ', Jawa Barat',
                'latitude'    => $lat,
                'longitude'   => $lng,
                'no_telepon'  => '022-' . $faker->numberBetween(2000000, 9999999),
                'email'       => 'admin.' . strtolower(str_replace(' ', '', substr($namaKoperasi, 0, 10))) . $i . '@koperasi.id',
                'status'      => 'aktif',
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ];
        }

        // Insert Batch Koperasi
        $db->table('koperasi')->ignore(true)->insertBatch($koperasiData);
        
        // Ambil ID Koperasi Manual (Fix Error findColumn)
        $koperasiResult = $db->table('koperasi')->select('id')->get()->getResultArray();
        $koperasiIds = array_column($koperasiResult, 'id');

        // ==========================================
        // 2. SEED ANGGOTA (100 Data - Ditambah biar rame)
        // ==========================================
        CLI::write("🌱 Seeding 100 Anggota...", 'green');
        
        $anggotaData = [];
        // Tambah jumlah anggota jadi 100 biar sebaran per koperasi lebih merata
        for ($i = 1; $i <= 100; $i++) { 
            $gender = $faker->randomElement(['L', 'P']);
            $nama = $gender == 'L' ? $faker->name('male') : $faker->name('female');
            $nomorAnggota = 'ANG-' . str_pad($i, 5, '0', STR_PAD_LEFT);

            $anggotaData[] = [
                'koperasi_id'    => $faker->randomElement($koperasiIds),
                'nomor_anggota'  => $nomorAnggota,
                'nik'            => $faker->nik(),
                'nama'           => $nama,
                'jenis_kelamin'  => $gender,
                'email'          => $faker->unique()->email,
                'alamat'         => $faker->address,
                'no_hp'          => $faker->phoneNumber,
                'tanggal_lahir'  => $faker->date('Y-m-d', '-20 years'),
                'tanggal_daftar' => $faker->dateTimeBetween('-4 years', '-1 month')->format('Y-m-d'),
                'status'         => 'aktif',
                'created_at'     => Time::now(),
                'updated_at'     => Time::now(),
            ];
        }
        
        foreach(array_chunk($anggotaData, 50) as $chunk) {
            $db->table('anggota')->ignore(true)->insertBatch($chunk);
        }

        $anggotaResult = $db->table('anggota')->select('id')->get()->getResultArray();
        $anggotaIds = array_column($anggotaResult, 'id');

        // ==========================================
        // 3. SEED TRANSAKSI (2023 - 2026)
        // ==========================================
        CLI::write("🌱 Seeding Transaksi (2023-2026)...", 'yellow');

        $transaksiData = [];
        
        $categoriesPemasukan = [
            'Simpanan Wajib', 'Simpanan Pokok', 'Simpanan Sukarela', 
            'Bunga Pinjaman', 'Angsuran Pokok', 'Penjualan Toko'
        ];
        
        $categoriesPengeluaran = [
            'Gaji Karyawan', 'Listrik & Air', 'Internet & Wifi', 
            'Biaya Rapat', 'Pembelian ATK', 'Maintenance Gedung', 'Pencairan Pinjaman'
        ];

        for ($year = 2023; $year <= 2026; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                
                // Transaksi dibuat agak banyak (15-30 per bulan) agar grafik naik turunnya kelihatan
                $trxCount = rand(15, 30); 

                for ($t = 1; $t <= $trxCount; $t++) {
                    $day = rand(1, 28);
                    $dateStr = sprintf('%d-%02d-%02d', $year, $month, $day);
                    
                    $isPemasukan = $faker->boolean(60); 
                    $jenis = $isPemasukan ? 'pemasukan' : 'pengeluaran';
                    
                    if ($isPemasukan) {
                        $kategori = $faker->randomElement($categoriesPemasukan);
                        $nominal = $faker->numberBetween(50000, 3000000);
                        $idAnggotaTrx = $faker->randomElement($anggotaIds);
                    } else {
                        $kategori = $faker->randomElement($categoriesPengeluaran);
                        $nominal = $faker->numberBetween(200000, 7000000);
                        
                        if ($kategori == 'Pencairan Pinjaman') {
                            $idAnggotaTrx = $faker->randomElement($anggotaIds);
                        } else {
                            $idAnggotaTrx = null; 
                        }
                    }

                    $kodeTrx = 'TRX-' . str_replace('-', '', $dateStr) . '-' . str_pad($t . rand(100, 999), 5, '0', STR_PAD_LEFT);

                    $transaksiData[] = [
                        'anggota_id'     => $idAnggotaTrx,
                        'koperasi_id'    => $faker->randomElement($koperasiIds),
                        'kode_transaksi' => $kodeTrx,
                        'jenis'          => $jenis,
                        'kategori'       => $kategori,
                        'sumber'         => $faker->randomElement(['Transfer Bank', 'Cash', 'E-Wallet', 'QRIS']),
                        'nominal'        => $nominal,
                        'tanggal'        => $dateStr,
                        'keterangan'     => $faker->sentence(4),
                        'created_at'     => $dateStr . ' 09:00:00',
                        'updated_at'     => $dateStr . ' 09:00:00',
                    ];
                }
            }
        }

        $totalTrx = count($transaksiData);
        CLI::write("   Total Transaksi yang akan dibuat: $totalTrx baris.", 'yellow');

        foreach(array_chunk($transaksiData, 100) as $chunk) {
            $db->table('transaksi')->ignore(true)->insertBatch($chunk);
        }

        CLI::write("✅ SEEDING SELESAI! 25 Koperasi, 100 Anggota, dan Ribuan Transaksi siap!", 'green');
    }
}