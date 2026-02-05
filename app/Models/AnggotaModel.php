<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'koperasi_id', 'nomor_anggota', 'nik', 'nama', 
        'jenis_kelamin', 'alamat', 'no_hp', 'tanggal_lahir', 
        'tanggal_daftar', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedAtField = 'updated_at';

    public function getAnggotaWithKoperasi()
    {
        return $this->select('anggota.*, koperasi.nama as nama_koperasi')
                    ->join('koperasi', 'koperasi.id = anggota.koperasi_id')
                    ->findAll();
    }

    public function getListKoperasi()
    {
        $koperasiModel = new \App\Models\KoperasiModel();
        return $koperasiModel->findAll();
    }
}
