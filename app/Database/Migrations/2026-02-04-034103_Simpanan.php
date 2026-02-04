<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Simpanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'anggota_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jenis'       => ['type' => 'ENUM', 'constraint' => ['pokok', 'wajib', 'sukarela']],
            'nominal'     => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'tanggal'     => ['type' => 'DATE'],
            'keterangan'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('anggota_id', 'anggota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('simpanan');
    }

    public function down()
    {
        $this->forge->dropTable('simpanan');
    }
}
