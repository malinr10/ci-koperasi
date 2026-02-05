<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'anggota_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],  
            'koperasi_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kode_transaksi' => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'jenis'          => ['type' => 'ENUM', 'constraint' => ['pemasukan', 'pengeluaran']],
            'kategori'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'sumber'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'nominal'        => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'tanggal'        => ['type' => 'DATE'],
            'keterangan'     => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('koperasi_id', 'koperasi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('anggota_id', 'anggota', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addKey('tanggal');
        $this->forge->addKey('jenis');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
