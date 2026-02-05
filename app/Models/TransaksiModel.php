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
        'koperasi_id', 'kode_transaksi', 'jenis', 'kategori',
        'sumber', 'nominal', 'tanggal', 'keterangan'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedAtField = 'updated_at';

    public function generateCode()
    {
        $builder = $this->db->table($this->table);
        $count = $builder->countAllResults();
        return 'TRX-' . date('Ymd') . '-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }


    
}
