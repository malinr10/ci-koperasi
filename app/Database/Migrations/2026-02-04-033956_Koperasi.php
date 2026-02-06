<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Koperasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode'        => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nama'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'alamat'      => ['type' => 'TEXT'],
            'latitude'    => ['type' => 'DECIMAL', 'constraint' => '10,8'],
            'longitude'   => ['type' => 'DECIMAL', 'constraint' => '11,8'],
            'no_telepon'  => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status'      => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->createTable('koperasi');
    }

    public function down()
    {
        $this->forge->dropTable('koperasi');
    }
}
