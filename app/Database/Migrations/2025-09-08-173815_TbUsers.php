<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nama' => [
                'type' => "VARCHAR",
                'constraint' => '255'
            ],
            'username_email' => [
                'type' => "VARCHAR",
                'constraint' => "255"
            ],
            'password' => [
                'type' => "VARCHAR",
                'constraint' => '255'
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => "13"
            ],
            'alamat' => [
                'type' => "TEXT",
                'null' => true
            ],
            'id_role' => [
                'type' => 'INT',
                'unsigned' => true,
                'constraint' => '11'
            ],
            'jenis_kel' => [
                'type' => 'INT',
                'constraint' => '2'
            ],
            'no_ktp' => [
                'type' => "VARCHAR",
                'constraint' => '16',
                'null' => true
            ],
            'no_sim' => [
                'type' => "VARCHAR",
                'constraint' => '16',
                'null' => true
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('id_user', true);
        $this->forge->createTable('tb_users');
    }

    public function down()
    {
        $this->forge->dropTable('tb_users');
    }
}
