<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// php spark make:migration PeliculaImagen (v107)
// tabla pivote entre las tablas peliculas e imagenes (relacion muchos a muchos)
// "php spark migrate" para correr las migraciones
class PeliculaImagen extends Migration
{
    public function up()
    {
        /* 
        CREATE TABLE `pelicula_imagen` (
        `pelicula_id` int unsigned NOT NULL,
        `imagen_id` int unsigned NOT NULL,
        KEY `pelicula_imagen_pelicula_id_foreign` (`pelicula_id`),
        KEY `pelicula_imagen_imagen_id_foreign` (`imagen_id`),
        CONSTRAINT `pelicula_imagen_imagen_id_foreign` FOREIGN KEY (`imagen_id`) REFERENCES `imagenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `pelicula_imagen_pelicula_id_foreign` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3
        */
        $this->forge->addField([
            "pelicula_id" => [
                "type" => "INT",
                "constraint" => 5,  
                "unsigned" => TRUE, 
            ],
            "imagen_id" => [
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
            "imagen_id", // FK
            "imagenes",   // tabla relacionada
            "id",          // referencia de la FK en la tabla relacionada 
            "CASCADE",     // para el UPDATE
            "CASCADE"      // para el DELETE
        ); 

        $this->forge->createTable("pelicula_imagen");
    }
    
    public function down()
    {
        $this->forge->dropTable("pelicula_imagen");
    }
}
