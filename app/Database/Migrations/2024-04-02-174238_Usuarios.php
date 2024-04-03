<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usuarios extends Migration
{
    public function up()
    {
        // defino los campos de la tabla usuarios en la DB (v85)
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 5, 
                "unsigned" => TRUE, // campo con valores solo positivos
                "auto_increment" => TRUE,
            ],
            "usuario" => [
                "type" => "VARCHAR",
                "constraint" => 20, 
                "unique" => TRUE, // para que sea unico
            ],
            "email" => [
                "type" => "VARCHAR",
                "constraint" => 100, 
                "unique" => TRUE, // para que sea unico
            ],
            "contrasena" => [
                "type" => "VARCHAR",
                "constraint" => 255, 
            ],
            "tipo" => [
                "type" => "ENUM",
                "constraint" => ["admin", "regular"], 
                "default" => "regular",
            ],
        ]);

        //defino la clave primaria de la tabla
        $this->forge->addKey("id", TRUE); 

        // definio el nombre de la tabla a crear
        $this->forge->createTable("usuarios");
    }

    public function down()
    {
        $this->forge->dropTable("usuarios");
    }
}
