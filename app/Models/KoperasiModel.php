<?php

namespace App\Models;

use CodeIgniter\Model;

class KoperasiModel extends Model
{
    protected $table = 'koperasi';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'kode', 'nama', 'alamat', 'latitude', 'longitude', 'no_telepon', 'email', 'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField = 'updated_at';

    public function generateCode()
    {
        $prefix = "KOP-" . date('Ymd') . "-";

        $lastKop = $this->like('kode', $prefix, 'after')
            ->orderBy('id', 'DESC') 
            ->first();

        if ($lastKop) {
            $lastNumber = (int) substr($lastKop['kode'], -4);
            $number = $lastNumber + 1;
        } else {
            $number = 1;
        }

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }


    
}
