<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// php spark make:migration Etiquetas (v109)
// "php spark migrate" para correr las migraciones
class Etiquetas extends Migration
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
            "titulo" => [
                "type" => "VARCHAR",
                "constraint" => 255,
            ],
            "categoria_id" => [
                "type" => "INT",
                "constraint" => 5, 
                "unsigned" => TRUE, 
            ],
        ]);
        
        //defino la clave primaria de la tabla
        $this->forge->addKey("id", TRUE); 
        
        // defino al campo categoria_id como FK, referenciando a categorias.id (v106)
        $this->forge->addForeignKey(
            "categoria_id", // FK
            "categorias",   // tabla relacionada
            "id",           // referencia de la FK en la tabla relacionada
            "CASCADE",
            "CASCADE"
        ); 
        
        $this->forge->createTable("etiquetas");
    }

    public function down()
    {
        $this->forge->dropTable("etiquetas");
    }
}
