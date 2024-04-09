<?php

namespace App\Database\Seeds;

use App\Models\CategoriaModel;
use CodeIgniter\Database\Seeder;

class PeliculaSeeder extends Seeder
{

    public function run()
    {
        $this->db->table("peliculas")->where("id >=", 1)->delete();

        // Restablecer el autoincremental a 1
        $this->db->query("ALTER TABLE peliculas AUTO_INCREMENT = 1");

        $categoriaModel = new CategoriaModel;
        $categorias = $categoriaModel->select("id")->find();

        // Crear 50 nuevos peliculas
        for ($i = 0; $i < 50; $i++) { 
            $index_categorias = array_rand($categorias);
            $this->db->table("peliculas")->insert([
                "titulo" => "Pelicula " . $i + 1,
                "descripcion" => "Descripción de la película " . $i + 1,
                "categoria_id" => $categorias[$index_categorias]->id
            ]);
        }
    }

    /* public function run()
    {        
        // Eliminar todos los registros de la tabla
        $this->db->table("peliculas")->truncate();

        // Crear 20 nuevos registros
        for ($i = 0; $i < 60; $i++) { 
            $this->db->table("peliculas")->insert([
                "titulo" => "Pelicula " . $i + 1,
                "descripcion" => "Descripción de la película " . $i + 1
            ]);
        }
    } */
}