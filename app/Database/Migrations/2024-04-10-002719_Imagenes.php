<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// php sparke make:migration Imagenes (v107)
// "php spark migrate" para correr las migraciones
class Imagenes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 5,  
                "unsigned" => TRUE, 
                "auto_increment" => TRUE,
            ],
            "imagen" => [
                "type" => "VARCHAR",
                "constraint" => 40,
            ],
            "extension" => [
                "type" => "VARCHAR",
                "constraint" => 10,
            ],
            "data" => [
                "type" => "VARCHAR",
                "constraint" => "255"
            ],
        ]);

        $this->forge->addKey("id", TRUE); 

        $this->forge->createTable("imagenes");
        
    }
    
    public function down()
    {
        $this->forge->dropTable("imagenes");
    }
}
