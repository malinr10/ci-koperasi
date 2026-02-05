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
        'kode', 'nama', 'alamat', 'kota', 'provinsi',
        'latitude', 'longitude', 'no_telepon', 'email', 'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedAtField = 'updated_at';


    
}
