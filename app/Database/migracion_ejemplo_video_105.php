<?php

/* 
esta es una migracion de ejemplo del video 105 ("Relaciones uno a muchos: Migración")
esta migracion añade la columna "categoria_id" a la tabla peliculas 
esta es una alternativa, para no tener que hacer un rollback de todas las migraciones
*/
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AgregarCampoCategoriaATablaPelicula extends Migration
{
    public function up()
    {

        $column = [
            "COLUMN categoria_id INT(10) UNSIGNED",
            "CONSTRAINT products_categoria_id_foreign FOREIGN KEY(categoria_id) REFERENCES categorias(id)"
        ];
        $this->forge->addColumn("peliculas", $column);
    }

    public function down()
    {
        $this->forge->dropForeignKey("peliculas", "products_categoria_id_foreign");
        $this->forge->dropColumn("peliculas", "categoria_id");
    }
}
