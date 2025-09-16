<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbMerek extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_merek' => [
                'type' => "INT",
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => "128"
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('id_merek', true);
        $this->forge->createTable('tb_merek');
    }

    public function down()
    {
        $this->forge->dropTable('tb_merek');
        //
    }
}
