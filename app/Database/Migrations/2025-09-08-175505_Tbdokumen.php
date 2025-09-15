<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tbdokumen extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_doc' => [
                'type' => "INT",
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => "INT",
                'unsigned' => true,
                'constraint' => "11"
            ],
            'files' => [
                'type' => "VARCHAR",
                'constraint' => "255"
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('id_doc', true);
        $this->forge->createTable('tb_doc');
    }

    public function down()
    {
        $this->forge->dropTable('tb_doc');
    }
}
