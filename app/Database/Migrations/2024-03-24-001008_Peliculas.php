<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Peliculas extends Migration
{
    public function up()
    {

        // defino los campos de la tabla peliculas en la DB (v27)
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
            "descripcion" => [
                "type" => "TEXT",
                "null" => TRUE,
            ],
            "categoria_id" => [
                "type" => "INT",
                "constraint" => 5,  // para indicar la longitud (v27)
                "unsigned" => TRUE, // campo con valores solo positivos
            ],
        ]);
        
        //defino la clave primaria de la tabla
        $this->forge->addKey("id", TRUE); 
        
        // defino al campo categoria_id como FK, referenciando a categorias.id
        $this->forge->addForeignKey(
            "categoria_id", 
            "categorias", 
            "id", 
            "CASCADE",
            "CASCADE"
        ); 
        
        // definio el nombre de la tabla a crear
        $this->forge->createTable("peliculas");
    }

    public function down()
    {
        $this->forge->dropTable("peliculas");
    }
}