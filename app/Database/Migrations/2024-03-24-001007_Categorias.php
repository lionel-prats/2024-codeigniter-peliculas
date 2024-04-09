<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categorias extends Migration
{
    public function up()
    {
        // defino los campos de la tabla usuarios en la DB
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 5,  // para indicar la longitud (v27)
                "unsigned" => TRUE, // campo con valores solo positivos
                "auto_increment" => TRUE,
            ],
            "titulo" => [
                "type" => "VARCHAR",
                "constraint" => 255,
            ],
        ]);
        
        //defino la clave primaria de la tabla
        $this->forge->addKey("id", TRUE); 
        
        $this->forge->createTable("categorias");
    }

    public function down()
    {
        $this->forge->dropTable("categorias");
    }
}
