<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'koperasi_id',
        'anggota_id',
        'kode_transaksi',
        'jenis',
        'kategori',
        'sumber',
        'nominal',
        'tanggal',
        'keterangan'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField = 'updated_at';

    public function generateCode()
    {
        $today = date('Ymd');
        $prefix = "TRX-" . $today . "-";

        // CARA SIMPLE:
        // Ambil 1 transaksi terakhir hari ini (urutkan dari ID terbesar)
        $lastTrx = $this->like('kode_transaksi', $prefix, 'after')
            ->orderBy('id', 'DESC') // Urutkan berdasarkan ID terakhir
            ->first();

        if ($lastTrx) {
            // Ambil 4 angka belakang, ubah jadi integer, tambah 1
            // Contoh: TRX-20260205-0005 => Ambil '0005' => jadi 5 + 1 = 6
            $lastNumber = (int) substr($lastTrx['kode_transaksi'], -4);
            $number = $lastNumber + 1;
        } else {
            // Jika belum ada transaksi hari ini, mulai dari 1
            $number = 1;
        }

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function getOmzetPerMonth($year)
    {
        $builder = $this->db->table($this->table);
        // FIX: Menggunakan alias 'bulan_num' agar cocok dengan Controller
        $builder->select('MONTH(tanggal) as bulan_num, SUM(nominal) as total');
        $builder->where('jenis', 'pemasukan');
        $builder->where('kategori NOT LIKE', 'Simpanan%');
        $builder->where('YEAR(tanggal)', $year);
        $builder->groupBy('MONTH(tanggal)');
        $builder->orderBy('MONTH(tanggal)', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function getTotalOmzet($year)
    {
        $builder = $this->db->table($this->table);
        $builder->select('SUM(nominal) as total');
        $builder->where('jenis', 'pemasukan');
        $builder->where('kategori NOT LIKE', 'Simpanan%');
        $builder->where('YEAR(tanggal)', $year);

        $result = $builder->get()->getRowArray();
        return $result['total'] ?? 0;
    }

    public function getTransaksiWithKoperasi()
    {
        return $this->select('transaksi.*, koperasi.nama as nama_koperasi')
            ->join('koperasi', 'koperasi.id = transaksi.koperasi_id')
            ->orderBy('transaksi.tanggal', 'DESC')
            ->findAll();
    }

    public function getTransaksiFull()
    {
        return $this->select('transaksi.*, 
                          koperasi.nama as nama_koperasi,
                          anggota.nama as nama_anggota')
            ->join('koperasi', 'koperasi.id = transaksi.koperasi_id', 'left')
            ->join('anggota', 'anggota.id = transaksi.anggota_id', 'left')
            ->orderBy('transaksi.tanggal', 'DESC')
            ->findAll();
    }


    public function getAvailableYears()
    {
        $query = $this->db->query("SELECT DISTINCT YEAR(tanggal) as tahun FROM transaksi ORDER BY tahun DESC");
        $result = $query->getResultArray();

        // Jika kosong (belum ada transaksi), default ke tahun ini
        if (empty($result)) {
            return [['tahun' => date('Y')]];
        }

        return $result;
    }
}
