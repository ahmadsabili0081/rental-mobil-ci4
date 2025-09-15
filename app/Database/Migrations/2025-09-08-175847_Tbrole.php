<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tbrole extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_role' => [
                'type' => "INT",
                'unsigned' => true,
                'auto_increment' => true
            ],
            'role' => [
                'type' => "VARCHAR",
                'constraint' => '50'
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('id_role', true);
        $this->forge->createTable('tb_role');
    }

    public function down()
    {
        $this->forge->dropTable('tb_role');
    }
}
