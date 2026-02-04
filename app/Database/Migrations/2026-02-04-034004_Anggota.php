<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anggota extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'koperasi_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nomor_anggota'  => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'nik'            => ['type' => 'VARCHAR', 'constraint' => 20],
            'nama'           => ['type' => 'VARCHAR', 'constraint' => 150],
            'jenis_kelamin'  => ['type' => 'ENUM', 'constraint' => ['L', 'P']],
            'alamat'         => ['type' => 'TEXT', 'null' => true],
            'no_hp'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'tanggal_lahir'  => ['type' => 'DATE', 'null' => true],
            'tanggal_daftar' => ['type' => 'DATE'],
            'status'         => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('koperasi_id', 'koperasi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey('status');
        $this->forge->createTable('anggota');
    }

    public function down()
    {
        $this->forge->dropTable('anggota');
    }
}
