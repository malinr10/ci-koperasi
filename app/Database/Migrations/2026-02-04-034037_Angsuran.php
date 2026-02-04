<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Angsuran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pinjaman_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nominal'       => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'tanggal_bayar' => ['type' => 'DATE'],
            'keterangan'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pinjaman_id', 'pinjaman', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('angsuran');
    }

    public function down()
    {
        $this->forge->dropTable('pinjaman');
    }
}
