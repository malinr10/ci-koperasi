<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pinjaman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'anggota_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kode_pinjaman'       => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'jumlah_pinjaman'     => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'bunga'               => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
            'tenor'               => ['type' => 'INT', 'constraint' => 11],
            'tanggal_pinjam'      => ['type' => 'DATE'],
            'tanggal_jatuh_tempo' => ['type' => 'DATE', 'null' => true],
            'status'              => ['type' => 'ENUM', 'constraint' => ['aktif', 'lunas', 'macet'], 'default' => 'aktif'],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('anggota_id', 'anggota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pinjaman');
    }

    public function down()
    {
        $this->forge->dropTable('pinjaman');
    }
}
