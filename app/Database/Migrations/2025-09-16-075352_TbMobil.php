<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbMobil extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mobil' => [
                'type' => "INT",
                'unsigned' => true,
                'auto_increment' => true
            ],

            'id_merek' => [
                'type' => "INT",
                'unsigned' => true,
                'constraint' => "11"
            ],
            'nama' => [
                'type' => "VARCHAR",
                'constraint' => "255",
                'null' => true
            ],
            'no_plat' => [
                'type' => "VARCHAR",
                'constraint' => '12',
                'null' => true
            ],
            'harga_sewa' => [
                'type' => "DOUBLE",
                "default" => 0
            ],
            'gambar' => [
                'type' => "VARCHAR",
                'constraint' => "255"
            ],
            'status' => [
                'type' => 'ENUM("Tersedia","Disewa")',
                'default' => "Tersedia"
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('id_mobil', true);
        $this->forge->createTable('tb_mobil');
    }

    public function down()
    {
        $this->forge->dropTable('tb_mobil');
    }
}
