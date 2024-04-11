<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// php spark make:migration peliculaEtiqueta (v109)
// "php spark migrate" para correr las migraciones
class PeliculaEtiqueta extends Migration
{
    public function up()
    {
        /* 
        CREATE TABLE `pelicula_etiqueta` (
            `pelicula_id` int unsigned NOT NULL,
            `etiqueta_id` int unsigned NOT NULL,
            KEY `pelicula_etiqueta_pelicula_id_foreign` (`pelicula_id`),
            KEY `pelicula_etiqueta_etiqueta_id_foreign` (`etiqueta_id`),
            CONSTRAINT `pelicula_etiqueta_etiqueta_id_foreign` FOREIGN KEY (`etiqueta_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `pelicula_etiqueta_pelicula_id_foreign` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3
        */
        $this->forge->addField([
            "pelicula_id" => [
                "type" => "INT",
                "constraint" => 5,  
                "unsigned" => TRUE, 
            ],
            "etiqueta_id" => [
                "type" => "INT",
                "constraint" => 5,  
                "unsigned" => TRUE, 
            ],
        ]);

        $this->forge->addForeignKey(
            "pelicula_id", // FK
            "peliculas",   // tabla relacionada
            "id",          // referencia de la FK en la tabla relacionada 
            "CASCADE",     // para el UPDATE
            "CASCADE"      // para el DELETE
        ); 
        $this->forge->addForeignKey(
            "etiqueta_id", // FK
            "etiquetas",   // tabla relacionada
            "id",          // referencia de la FK en la tabla relacionada 
            "CASCADE",     // para el UPDATE
            "CASCADE"      // para el DELETE
        ); 

        $this->forge->createTable("pelicula_etiqueta");
    }
    
    public function down()
    {
        $this->forge->dropTable("pelicula_etiqueta");
    }
}
